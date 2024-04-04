<?php
include 'DBConnection.php';

// Verificar si se reciben los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_pedido']) && isset($_POST['nuevo_estado'])) {
    // Obtener los datos del formulario
    $id_pedido = $_POST['id_pedido'];
    $nuevo_estado = $_POST['nuevo_estado'];

     $dbConnection = new DBConnection();
    $conexion = $dbConnection->getConnection();

     if ($conexion === false) {
        die("Error de conexión a la base de datos: " . $dbConnection->getErrorMessage());
    }

     $sql = "UPDATE Pedidos SET Estado=? WHERE ID_pedido=?";

     $stmt = $conexion->prepare($sql);
    if ($stmt === false) {
        die("Error al preparar la consulta: " . $conexion->error);
    }

     $stmt->bind_param("si", $nuevo_estado, $id_pedido);

     if ($stmt->execute()) {
        echo "El estado del pedido se ha actualizado correctamente.";
    } else {
        echo "Error al ejecutar la consulta: " . $stmt->error;
    }

     $stmt->close();

     header("Location: pedidos.php");
    exit;
} else {
    echo "No se recibieron datos válidos del formulario.";
}
?>
