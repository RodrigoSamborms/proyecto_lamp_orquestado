<?php
// Configuración de las credenciales
$host = "db"; //antes "localhost";//IP del servidor de base de datos
$user = getenv('MYSQL_USER');      // El usuario que creamos
$pass = getenv('MYSQL_PASSWORD'); // La contraseña que asignaste
$db   = getenv('MYSQL_DATABASE'); // El nombre de la base de datos

// Crear la conexión usando la extensión mysqli
$conn = mysqli_connect($host, $user, $pass, $db);

// Verificar si la conexión falló
if (!$conn) {
    // En producción es mejor no mostrar el error detallado, pero para desarrollo es vital
    die("Fallo la conexión: " . mysqli_connect_error());
}

// Configurar el juego de caracteres a UTF-8 para evitar problemas con acentos o eñes
mysqli_set_charset($conn, "utf8");

// Si llegamos aquí, la conexión fue exitosa
// echo "Conexión establecida correctamente"; // Descomenta para probar
?>