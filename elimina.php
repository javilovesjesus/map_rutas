<?php 
    $idRuta = $_POST['idRuta'];
    require_once("models/mapas_model.php");

	$elimina = new mapas_model;
    $idDel = $elimina->elimina_rutas($idRuta);
    echo $idDel;

 ?>