<?php
    $parametros = $_POST['rutas'];
    require_once("models/mapas_model.php");

    $guardar = new mapas_model;
    $guardar->guarda($parametros,"actualiza");
    //print_r($parametros,"actualiza");
?>