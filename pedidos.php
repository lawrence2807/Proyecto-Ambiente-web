<?php
session_start();

if (!isset($_SESSION["ID_usuario"])) {
    header("Location: iniciarsesion.php");
    exit();
}

// Verificar si el usuario es administrador
if ($_SESSION["Rol"] != 'admin') {
    header("Location: index.php"); // Redirigir a la página de inicio si no es un administrador
    exit();
}

include 'DBConnection.php';

$dbConnection = new DBConnection();
$conexion = $dbConnection->getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id_detalle_pedido']) && isset($_POST['nuevo_estado'])) {
        $id_detalle_pedido = $_POST['id_detalle_pedido'];
        $nuevo_estado = $_POST['nuevo_estado'];
 
        $sql_update = "UPDATE DetallesPedido SET Estado = ? WHERE ID_detalle_pedido = ?";
        $stmt = $conexion->prepare($sql_update);
        $stmt->bind_param("si", $nuevo_estado, $id_detalle_pedido);
        $stmt->execute();
        $stmt->close();
    } else {
        echo "No se recibieron los parámetros necesarios para actualizar el estado del pedido.";
    }
}

 
$sql = "SELECT p.*, dp.ID_detalle_pedido, dp.Cantidad, dp.PrecioUnitario, dp.Estado, pr.Nombre, u.Nombre AS NombreUsuario
        FROM Pedidos p
        INNER JOIN DetallesPedido dp ON p.ID_pedido = dp.ID_pedido
        INNER JOIN Productos pr ON dp.ID_producto = pr.ID_producto
        INNER JOIN Usuarios u ON p.ID_usuario = u.ID_usuario
        WHERE p.Estado != 'Enviado'";
$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos - Administrador</title>
</head>

<body>
    <h1>Pedidos</h1>
    <table>
        <thead>
            <tr>
                <th>ID Pedido</th>
                <th>Fecha</th>
                <th>Usuario</th>
                <th>Estado</th>
                <th>Detalles del Pedido</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($pedido = $resultado->fetch_assoc()) : ?>
                <tr>
                    <td><?php echo $pedido['ID_pedido']; ?></td>
                    <td><?php echo $pedido['Fecha']; ?></td>
                    <td><?php echo $pedido['NombreUsuario']; ?></td>
                    <td>
                        <form method="post" action="">
                            <input type="hidden" name="id_detalle_pedido" value="<?php echo $pedido['ID_detalle_pedido']; ?>">
                            <select name="nuevo_estado">
                                <option value="Pendiente" <?php echo ($pedido['Estado'] == 'Pendiente') ? 'selected' : ''; ?>>Pendiente</option>
                                <option value="Entregado" <?php echo ($pedido['Estado'] == 'Entregado') ? 'selected' : ''; ?>>Entregado</option>
                                <option value="Listo" <?php echo ($pedido['Estado'] == 'Listo') ? 'selected' : ''; ?>>Listo</option>
                                <option value="Faltante" <?php echo ($pedido['Estado'] == 'Faltante') ? 'selected' : ''; ?>>Faltante</option>
                            </select>
                            <button type="submit">Actualizar Estado</button>
                        </form>
                    </td>
                    <td>
                        <?php echo $pedido['Cantidad'] . ' x ' . $pedido['Nombre'] . ' - Precio Unitario: $' . $pedido['PrecioUnitario']; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <a href="centrocontrol.php">Volver al Centro de Control</a>
</body>

</html>
