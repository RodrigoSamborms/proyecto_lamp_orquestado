<?php
// Ya NO incluimos conexion.php aquí. 
// La comunicación es exclusivamente por HTTP.

//$api_url = "http://[::1]/proyecto_lamp_desacoplado/src/faseA/api/personas.php";
$api_url = "http://api-service/personas.php";

// Función para centralizar las peticiones cURL
function consumir_api($url, $metodo, $datos = null) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $metodo);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Compatible; PHP-API-Client)');
    
    if ($datos) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($datos));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    }
    
    $respuesta = curl_exec($ch);
    curl_close($ch);
    
    return json_decode($respuesta, true);
}

// Lógica para Insertar (POST)
if (isset($_POST['agregar'])) {
    $nombre = $_POST['nombre'];
    if (!empty($nombre)) {
        consumir_api($api_url, "POST", ["nombre" => $nombre]);
        header("Location: index.php");
    }
}

// Lógica para Leer (GET)
$personas = consumir_api($api_url, "GET");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Personas - Frontend Desacoplado</title>
    <style>
        body { font-family: sans-serif; margin: 40px; }
        table { border-collapse: collapse; width: 400px; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 10px; }
        .btn-del { color: red; }
    </style>
</head>
<body>

    <h2>Agregar Nuevo Nombre (Vía API)</h2>
    <form method="POST">
        <input type="text" name="nombre" placeholder="Escribe un nombre..." required>
        <button type="submit" name="agregar">Agregar</button>
    </form>

    <hr>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($personas)): ?>
                <?php foreach ($personas as $p): ?>
                <tr>
                    <td><?php echo $p['id']; ?></td>
                    <td><?php echo $p['nombre']; ?></td>
                    <td>
                        <a href="editar.php?id=<?php echo $p['id']; ?>">Editar</a> | 
                        <a href="borrar.php?id=<?php echo $p['id']; ?>" class="btn-del">Eliminar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="3">No hay registros.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>