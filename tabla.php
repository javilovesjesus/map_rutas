<?php
    //Llamada al modelo
    require_once("models/mapas_model.php");
    $mapas=new mapas_model();
?>
<table class="table table-hover">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Ruta</th>
            <th scope="col">Primer punto</th>
            <th scope="col">Segundo punto</th>
            <th scope="col">Tercer punto</th>
            <th scope="col"></th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
        <?php
            $i=1;
            //print_r($mapas->get_rutas());
            foreach($mapas->get_rutas() as $key=>$ruta){
        ?>
        <tr>
        
            <th scope="row"><?=$i;?></th>
            <td><?=$key;?></td>
            <?php
                $ciudades="";
                $j=1;
                $rutaId=0;
                foreach($ruta as $ciudad){
                    $rutaId = $ciudad["rutCiuRutaId"];
                    
            ?>
            <?php 
                $actua = 0;
                if(isset($_REQUEST["actualiza"])){
                    $actua = 1;
                    if(isset($_REQUEST["rutaId"])){
                        if($rutaId == $_REQUEST["rutaId"]){
                            switch ($j) {
                                case 1:
                                    $nomOpt="primeroU";
                                    break;
                                case 2:
                                    $nomOpt="segundoU";
                                    break;
                                case 3:
                                    $nomOpt="terceroU";
                                    break;
                            }
            ?>
                            <td>
                                <select class="form-control" id="<?=$nomOpt?>">
                                    <?=$mapas->get_ciudades($ciudad["idCiudad"]);?>
                                </select>
                            </td>
            <?php
                        }
                        else{
                            $actua=0;
                            ?>
                                <td><?=$ciudad["nomCiudad"];?></td>
                            <?php           
                        }

                    }
                }
                else{
                    $actua=0;
            ?>
                    <td><?=$ciudad["nomCiudad"];?></td>
            <?php
                }
            ?>
            
            <?php 
                    if($j==count($ruta)){
                        $ciudades.=$ciudad["idCiudad"];
                    }
                    else{
                        $ciudades.=$ciudad["idCiudad"]."||";
                    }
                    $j++;
                }
                $datos="";
                $par=1;
            ?>
            
            <?php

                if($actua==0){
            ?>
                    <td>
                        <button class="btn btn-warning glyphicon glyphicon-pencil" onClick="modificaRuta('<?=$rutaId;?>')"></button>
                    </td>
                    <td>
                        <button class="btn btn-danger glyphicon glyphicon-remove" onClick="preguntaSiNo('<?=$rutaId;?>')"></button>
                    </td>
            <?php
                }
                else{
                    if(isset($_REQUEST["actualiza"])){
                        $actua = 1;
                        if(isset($_REQUEST["rutaId"])){
                            if($rutaId == $_REQUEST["rutaId"]){
            ?>
                                <td>
                                    <button class="btn btn-success glyphicon glyphicon-floppy-disk" onClick="actualizaRuta('<?=$rutaId;?>');setTimeout('recargaTabla()',1000);"></button>
                                </td>
                                <td></td>
            <?php
                            }
                        }
                    }
                }
            ?>
            
            
        </tr>	
        <?php
                $i++;
            }
        ?>
    </tbody>
</table>