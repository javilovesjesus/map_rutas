<?php 
    $parametros = $_POST['location'];
    require_once("models/mapas_model.php");

    $guardar = new mapas_model;
    $guardar->guarda($parametros,"nuevo");
?>