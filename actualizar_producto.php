<?php
session_start();

// Verificar si el usuario está autenticado y tiene rol de administrador
if (!isset($_SESSION["ID_usuario"]) || !isset($_SESSION["Nombre"]) || $_SESSION["Rol"] !== 'admin') {
    header("Location: IniciarSesion.php"); // Redirigir si no es un administrador autenticado
    exit();
}

$servername = "localhost";
$username = "root";
$password = "Conexion";
$dbname = "tutienda";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("La conexión falló: " . $conn->connect_error);
}

// Obtener los datos del formulario
$id_producto = $_POST['id_producto'];
$nombreProducto = $_POST['nombreProducto'];
$descripcionProducto = $_POST['descripcionProducto'];
$precioProducto = $_POST['precioProducto'];
$stockProducto = $_POST['stockProducto'];
$marcaProducto = $_POST['marcaProducto'];
$tipoProducto = $_POST['tipoProducto'];

// Actualizar los datos del producto en la base de datos
$stmt = $conn->prepare("UPDATE Productos SET Nombre = ?, Descripcion = ?, Precio = ?, Stock = ?, ID_marca = ?, TipoProducto = ? WHERE ID_producto = ?");
$stmt->bind_param("ssdiiii", $nombreProducto, $descripcionProducto, $precioProducto, $stockProducto, $marcaProducto, $tipoProducto, $id_producto);
$stmt->execute();

// Manejar la actualización de la imagen del producto si se cargó una nueva
if ($_FILES['imagenProducto']['error'] === UPLOAD_ERR_OK) {
    $imagen_tmp = $_FILES['imagenProducto']['tmp_name'];
    $nombre_imagen = $_FILES['imagenProducto']['name'];
    $ruta_imagen = 'carpeta_donde_guardar_imagenes/' . $nombre_imagen;

    // Mover la imagen cargada al destino
    move_uploaded_file($imagen_tmp, $ruta_imagen);

    // Actualizar la ruta de la imagen en la base de datos
    $stmt = $conn->prepare("UPDATE Productos SET Imagen = ? WHERE ID_producto = ?");
    $stmt->bind_param("si", $ruta_imagen, $id_producto);
    $stmt->execute();
}

$stmt->close();
$conn->close();

// Redirigir de vuelta a la página de productos
header("Location: productos.php");
exit();
?>
