<?php
	include_once('db/db.php');
	class mapas_model extends Conectar{

		public function __construct(){ 
     	 	parent::__construct(); 
    	}

	    public function get_lat_lng($value){
	    	$sql = $this->db->query("SELECT ciuLatitud, ciuLongitud FROM andciudades WHERE ciuId = '$value' LIMIT 1");
	    	$lat = 0; 
	    	$lng = 0; 
	    	foreach ($sql as $key){
	    		$lat = $key['ciuLatitud'];
	    		$lng = $key['ciuLongitud'];
	    	}	
	    	$array = array('lat' => $lat, 'lng' => $lng);
	    	return $array;
	    }
		
		public function get_ciudades($ciu=0){
	    	$sql = $this->db->query("SELECT ciuId, ciuNombre, ciuLatitud, ciuLongitud
			FROM andciudades ORDER BY ciuNombre");
	    	$option = '';
	    	foreach ($sql as $key){
				$selected=' ';
				if($ciu<>0){
					if($ciu==$key['ciuId']){
						$selected=' selected ';
					}
					else{
						$selected=' ';
					}
				}
	    		$id = $key['ciuId'];
	    		$name = $key['ciuNombre'];
	    		$lat = $key['ciuLatitud'];
	    		$lng = $key['ciuLongitud'];
	    		$option .= '<option '. $selected .' value="'.$id."::".$lat."::".$lng."::".$name.'">'.$name.'</option>';
	    	}
	    	return $option;
		}
		
		public function guarda($parametros,$tipo){
			
			//print_r($puntos);

			switch ($tipo) {
				case "nuevo":
					$pnt="";
					foreach ($parametros as $par){
						$puntos[]=$par[4];
						$pnt.=$par[4];
					}
					$sql = $this->db->query("SELECT * FROM andrutas WHERE rutCodCiudad = '".$pnt."'");

					if($sql->num_rows==0){
						$this->db->query("INSERT INTO andrutas(rutCodCiudad) VALUES ($pnt)");

						$idRuta = $this->db->insert_id;
						$i = 1;
						$rutNom = "";
						foreach ($parametros as $par){
							$this->db->query("INSERT INTO andrutaciudad(rutCiuRutaId, rutCiuCiudadId, rutCiuOrden) VALUES ($idRuta,$par[4],$i)");
							if($i == count($parametros)){
								$rutNom.=$par[0];
							}
							else{
								$rutNom.=$par[0] . " - ";
							}					
							$i++;
						}

						$this->db->query("UPDATE andrutas 
						SET rutNombre = '".$rutNom."' WHERE rutId = ".$idRuta);
					}
					break;
				case "actualiza":

					/*$sql = $this->db->query("SELECT *
					FROM andrutaciudad 
					WHERE rutCiuRutaId = ".$parametros["ruta"]." 
					ORDER BY rutCiuRutaId, rutCiuOrden");
					foreach ($sql as $key){
						
					}*/
					
					
					$sql = $this->db->query("SELECT rutCiuRutaId, rutCiuCiudadId, rutCiuOrden
					FROM andrutaciudad 
					WHERE rutCiuRutaId = ".$parametros["ruta"]." 
					ORDER BY rutCiuRutaId, rutCiuOrden");
					$rutaNom="";
					foreach ($sql as $key){
						switch ($key["rutCiuOrden"]) {
							case 1:
								$datActua = explode("::",$parametros["punto1"]);
								//print_r($datActua);
								$this->db->query("UPDATE andrutaciudad 
								SET rutCiuCiudadId = ".$datActua[0]." WHERE rutCiuOrden = 1 AND rutCiuRutaId = ".$parametros["ruta"]);
								$rutaNom.=$datActua[3]." - ";
							break;
							case 2:
								$datActua = explode("::",$parametros["punto2"]);
								//print_r($datActua);
								$this->db->query("UPDATE andrutaciudad 
								SET rutCiuCiudadId = ".$datActua[0]." WHERE rutCiuOrden = 2 AND rutCiuRutaId = ".$parametros["ruta"]);
								$rutaNom.=$datActua[3]." - ";
							break;
							case 3:
								$datActua = explode("::",$parametros["punto3"]);
								//print_r($datActua);
								$this->db->query("UPDATE andrutaciudad 
								SET rutCiuCiudadId = ".$datActua[0]." WHERE rutCiuOrden = 3 AND rutCiuRutaId = ".$parametros["ruta"]);
								$rutaNom.=$datActua[3];
							break;
						}
						$this->db->query("UPDATE andrutas
						SET rutNombre = '".$rutaNom."' WHERE rutId = ".$parametros["ruta"]);

						//print_r($key);	
					}
					//print_r($parametros);
					break;
			}
			
			
		}

		public function get_rutas(){
	    	$sql = $this->db->query("SELECT rutNombre, ciuNombre, ciuId, rutCiuRutaId
			FROM andrutas 
			INNER JOIN andRutaCiudad ON rutId = rutCiuRutaId
			INNER JOIN andCiudades ON rutCiuCiudadId = ciuId
			ORDER BY rutId DESC,rutCiuOrden");
			$rutas = array();
			$i=0;
			
	    	foreach ($sql as $key){
				//$rutas[$key["rutNombre"]][$i] = $key["ciuNombre"];
				$rutas[$key["rutNombre"]][$i]["nomCiudad"] = $key["ciuNombre"];
				$rutas[$key["rutNombre"]][$i]["idCiudad"] = $key["ciuId"];
				$rutas[$key["rutNombre"]][$i]["rutCiuRutaId"] = $key["rutCiuRutaId"];
				
				$i++;
	    	}
	    	return $rutas;
		}

		public function elimina_rutas($idRuta){
	    	$sql = $this->db->query("DELETE FROM andrutas WHERE rutId = ".$idRuta);
			$sql = $this->db->query("DELETE FROM andrutaciudad WHERE rutCiuRutaId = ".$idRuta);
			return $sql;
		}
	}

	if(isset($_POST['value'])){
		$class = new Mapas;
		$run = $class->get_lat_lng($_POST['value']);
		exit(json_encode($run));
	}
?>