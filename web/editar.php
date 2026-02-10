<?php
// web/editar.php
//$api_url = "http://[::1]/proyecto_lamp_desacoplado/src/faseA/api/personas.php";
$api_url = "http://api_web/personas.php";

// 1. Obtener los datos actuales para mostrar en el formulario
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $ch = curl_init($api_url . "?id=" . $id);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $respuesta = curl_exec($ch);
    $datos = json_decode($respuesta, true);
    curl_close($ch);

    // Si la API no devolvió nada, regresamos al index
    if (empty($datos)) {
        header("Location: index.php");
        exit;
    }
    $persona = $datos[0]; // La API devuelve un array, tomamos el primer elemento
}

// 2. Procesar la actualización (cuando el usuario da clic en Guardar)
if (isset($_POST['actualizar'])) {
    $datos_update = [
        "id" => $_POST['id'],
        "nombre" => $_POST['nombre']
    ];

    $ch = curl_init($api_url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT"); // Método PUT para actualizar
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($datos_update));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    curl_exec($ch);
    curl_close($ch);
    
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Registro</title>
</head>
<body>
    <h2>Editar Nombre</h2>
    <form method="POST" action="editar.php">
        <input type="hidden" name="id" value="<?php echo $persona['id']; ?>">
        
        <input type="text" name="nombre" value="<?php echo $persona['nombre']; ?>" required>
        <button type="submit" name="actualizar">Guardar Cambios</button>
        <a href="index.php">Cancelar</a>
    </form>
</body>
</html>