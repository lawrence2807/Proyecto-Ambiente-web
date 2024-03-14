<?php
session_start();

// Verificar si el usuario está autenticado y tiene rol de administrador
if (!isset($_SESSION["ID_usuario"]) || !isset($_SESSION["Nombre"]) || $_SESSION["Rol"] !== 'admin') {
    header("Location: IniciarSesion.php"); // Redirigir si no es un administrador autenticado
    exit();
}

// Verificar si se recibió el ID del producto
if (!isset($_GET['id_producto'])) {
    header("Location: CentroControl.php"); // Redirigir si no se proporcionó el ID del producto
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

// Obtener el producto con el ID proporcionado
$id_producto = $_GET['id_producto'];
$stmt = $conn->prepare("SELECT * FROM Productos WHERE ID_producto = ?");
$stmt->bind_param("i", $id_producto);
$stmt->execute();
$result = $stmt->get_result();

// Verificar si se encontró el producto
if ($result->num_rows === 0) {
    echo "No se encontró el producto.";
    exit();
}

// Mostrar el formulario para editar el producto
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto - Tu Calzado</title>
    <!-- Agrega aquí tus enlaces a estilos CSS si es necesario -->
</head>

<body>
    <!-- Botón para retroceder al menú -->
    <a href="CentroControl.php">Volver al Menú</a>

    <!-- Formulario para editar el producto -->
    <h2>Editar Producto</h2>
    <form action="actualizar_producto.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id_producto" value="<?php echo $row['ID_producto']; ?>">
        <label for="nombreProducto">Nombre:</label>
        <input type="text" name="nombreProducto" value="<?php echo $row['Nombre']; ?>" required><br>

        <label for="descripcionProducto">Descripción:</label>
        <textarea name="descripcionProducto" required><?php echo $row['Descripcion']; ?></textarea><br>

        <label for="precioProducto">Precio (₡):</label>
        <input type="number" name="precioProducto" value="<?php echo $row['Precio']; ?>" required><br>

        <label for="stockProducto">Stock:</label>
        <input type="number" name="stockProducto" value="<?php echo $row['Stock']; ?>" required><br>

        <label for="imagenProducto">Imagen:</label>
        <img src="<?php echo $row['Imagen']; ?>" alt="Imagen de Producto" style="width: 200px;"><br>
        <input type="file" name="imagenProducto"><br>

        <!-- Lista de marcas -->
        <label for="marcaProducto">Marca:</label>
        <select name="marcaProducto" required>
            <option value="1" <?php if ($row['ID_marca'] == 1) echo "selected"; ?>>Nike</option>
            <option value="2" <?php if ($row['ID_marca'] == 2) echo "selected"; ?>>Adidas</option>
            <option value="3" <?php if ($row['ID_marca'] == 3) echo "selected"; ?>>Puma</option>
            <option value="4" <?php if ($row['ID_marca'] == 4) echo "selected"; ?>>New Balance</option>
            <option value="5" <?php if ($row['ID_marca'] == 5) echo "selected"; ?>>Reebok</option>
        </select><br>

 <!-- Lista de tipo de producto -->
<label for="tipoProducto">Tipo de Producto:</label>
<select name="tipoProducto" required>
    <?php
    $tiposProducto = ['High-Top', 'Running', 'Urban', 'Skate', 'Exclusivas'];
    foreach ($tiposProducto as $tipo) {
        $selected = ($row['TipoProducto'] === $tipo) ? 'selected' : '';
        echo "<option value='$tipo' $selected>$tipo</option>";
    }
    ?>
</select><br>

        <button type="submit">Actualizar Producto</button>
    </form>
</body>

</html>

<?php
$stmt->close();
$conn->close();
?>
