<?php
// web/borrar.php

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    //$api_url = "http://[::1]/proyecto_lamp_desacoplado/src/faseA/api/personas.php?id=" . $id;
    $api_url = "http://api_web/personas.php?id=" . $id;

    $ch = curl_init($api_url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE"); // Especificamos que es un borrado
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    $respuesta = curl_exec($ch);
    curl_close($ch);

    // Una vez procesado, volvemos a la lista
    header("Location: index.php");
} else {
    header("Location: index.php");
}
?>