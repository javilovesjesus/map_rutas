<?php
    //Llamada al modelo
    require_once("models/mapas_model.php");
    $mapas=new mapas_model();
    $mapa=$mapas->get_ciudades();
    
    //Llamada a la vista
    require_once("views/mapas_view.phtml");
?>
