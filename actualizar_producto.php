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

 $stmt = $conn->prepare("UPDATE Productos SET Nombre = ?, Descripcion = ?, Precio = ?, Stock = ?, ID_marca = ?, ID_tipo = ? WHERE ID_producto = ?");
$stmt->bind_param("ssdiiii", $nombreProducto, $descripcionProducto, $precioProducto, $stockProducto, $marcaProducto, $tipoProducto, $id_producto);

if ($stmt->execute()) {
    echo "Producto actualizado correctamente.";
} else {
    echo "Error al actualizar el producto: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
