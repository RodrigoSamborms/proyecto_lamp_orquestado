<?php
include 'conexion.php'; // Aquí sí es necesario
header("Content-Type: application/json");

$metodo = $_SERVER['REQUEST_METHOD'];

switch($metodo) {
    case 'GET':
        if (isset($_GET['id'])) {
            // Escenario A: Obtener una sola persona por ID
            $id = mysqli_real_escape_string($conn, $_GET['id']);
            $query = "SELECT id, nombre FROM personas WHERE id = $id AND activo = 1 LIMIT 1";
        } else {
            // Escenario B: Obtener todos los activos (lo que ya tenías)
            $query = "SELECT id, nombre FROM personas WHERE activo = 1";
        }

        $result = mysqli_query($conn, $query);
        $registros = mysqli_fetch_all($result, MYSQLI_ASSOC);
        echo json_encode($registros);
        break;

    case 'POST':
        // Leer el cuerpo de la petición (JSON)
        $json = file_get_contents('php://input');
        $datos = json_decode($json, true);
        
        if (isset($datos['nombre'])) {
            $nombre = mysqli_real_escape_string($conn, $datos['nombre']);
            $sql = "INSERT INTO personas (nombre, activo) VALUES ('$nombre', 1)";
            if (mysqli_query($conn, $sql)) {
                echo json_encode(["status" => "ok"]);
            }
        }
        break;
        
    // Aquí podrías agregar CASE 'DELETE'para borrar logicamente y CASE 'PUT' para editar  

    // Dentro del switch($metodo) en api/personas.php
    case 'DELETE':
        // Capturamos el ID que viene en la URL (?id=5)
        if (isset($_GET['id'])) {
            $id = mysqli_real_escape_string($conn, $_GET['id']);
            $sql = "UPDATE personas SET activo = 0 WHERE id = $id"; // Borrado lógico
            
            if (mysqli_query($conn, $sql)) {
                echo json_encode(["status" => "deleted"]);
            } else {
                http_response_code(500);
                echo json_encode(["error" => "No se pudo eliminar"]);
            }
        }
        break;
        
        
    // En personas.php - Caso PUT
    case 'PUT':
        $json = file_get_contents('php://input');
        $datos = json_decode($json, true);
        
        if (isset($datos['id']) && isset($datos['nombre'])) {
            $id = mysqli_real_escape_string($conn, $datos['id']);
            $nombre = mysqli_real_escape_string($conn, $datos['nombre']);
            
            $sql = "UPDATE personas SET nombre = '$nombre' WHERE id = $id";
            if (mysqli_query($conn, $sql)) {
                echo json_encode(["status" => "updated"]);
            } else {
                http_response_code(500); // Esto ayuda al cliente cURL a detectar fallos
                echo json_encode(["error" => "Error al actualizar"]);
            }
        }
        break;

}
?>