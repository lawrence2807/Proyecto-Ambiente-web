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

// Obtener marcas disponibles
$marcasQuery = "SELECT Nombre FROM Marcas";
$marcasResult = $conn->query($marcasQuery);

// Procesar el formulario de agregar productos
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombreProducto = $_POST["nombreProducto"];
    $descripcionProducto = $_POST["descripcionProducto"];
    $precioProducto = $_POST["precioProducto"];
    $stockProducto = $_POST["stockProducto"];
    $marcaProducto = $_POST["marcaProducto"];
    $tipoProducto = $_POST["tipoProducto"];

    // Subir imagen si se selecciona un archivo
    $rutaImagen = "";
    if ($_FILES["imagenProducto"]["error"] == 0 && is_uploaded_file($_FILES["imagenProducto"]["tmp_name"])) {
        $uploadsDirectory = "uploads/";

        // Generar un nombre único para la imagen
        $nombreUnico = uniqid() . '_' . basename($_FILES["imagenProducto"]["name"]);
        $targetPath = $uploadsDirectory . $nombreUnico;

        if (move_uploaded_file($_FILES["imagenProducto"]["tmp_name"], $targetPath)) {
            $rutaImagen = $nombreUnico;
        } else {
            echo "Error al subir la imagen.";
        }
    } else {
        echo "No se ha seleccionado ninguna imagen.";
    }

    // Insertar producto en la base de datos si se proporcionó una imagen
    if ($rutaImagen !== "") {
        $stmt = $conn->prepare("INSERT INTO Productos (Nombre, Descripcion, Precio, Stock, ID_marca, TipoProducto) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdiss", $nombreProducto, $descripcionProducto, $precioProducto, $stockProducto, $marcaProducto, $tipoProducto);
        $stmt->execute();

        // Obtener el ID del producto recién insertado
        $idProducto = $stmt->insert_id;

        // Insertar la ruta de la imagen en la base de datos
        $stmtImagen = $conn->prepare("INSERT INTO ImagenesProductos (ID_producto, RutaImagen) VALUES (?, ?)");
        $stmtImagen->bind_param("is", $idProducto, $rutaImagen);
        $stmtImagen->execute();

        $stmt->close();
        $stmtImagen->close();
    }
}

// Obtener productos e imágenes después de la inserción
$productosQuery = "SELECT p.*, i.RutaImagen FROM Productos p LEFT JOIN ImagenesProductos i ON p.ID_producto = i.ID_producto";
$productosResult = $conn->query($productosQuery);

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Centro de Control - Tucalzado.com</title>
    <!-- Agrega aquí los enlaces a tus estilos y scripts si es necesario -->
</head>

<body>
    <h2>Bienvenido al Centro de Control, <?php echo $_SESSION["Nombre"]; ?>!</h2>

    <!-- Sección de Agregar Producto -->
    <section>
        <h3>Agregar Producto</h3>
        <form action="" method="post" enctype="multipart/form-data">
            <label for="nombreProducto">Nombre:</label>
            <input type="text" name="nombreProducto" required>

            <label for="descripcionProducto">Descripción:</label>
            <textarea name="descripcionProducto" required></textarea>

            <label for="precioProducto">Precio (₡):</label>
            <input type="number" name="precioProducto" required>

            <label for="stockProducto">Stock:</label>
            <input type="number" name="stockProducto" required>

            <label for="marcaProducto">Marca:</label>
            <select name="marcaProducto" required>
                <?php
                while ($marca = $marcasResult->fetch_assoc()) {
                    echo "<option value='" . $marca['Nombre'] . "'>" . $marca['Nombre'] . "</option>";
                }
                ?>
            </select>

            <label for="tipoProducto">Tipo de Producto:</label>
            <select name="tipoProducto" required>
                <option value="High-Top">High-Top</option>
                <option value="Running">Running</option>
                <option value="Urban">Urban</option>
                <option value="Skate">Skate</option>
                <option value="Exclusivas">Exclusivas</option>
            </select>

            <label for="imagenProducto">Imagen:</label>
            <input type="file" name="imagenProducto" accept="image/*">

            <button type="submit">Agregar Producto</button>
        </form>
    </section>

    <!-- Sección de Inventario -->
    <section>
        <h3>Inventario</h3>
        <?php
        if ($productosResult->num_rows > 0) {
            while ($row = $productosResult->fetch_assoc()) {
                echo "<div>";
                echo "<h4>" . $row['Nombre'] . "</h4>";
                echo "<p>Descripción: " . $row['Descripcion'] . "</p>";
                echo "<p>Precio: ₡" . $row['Precio'] . "</p>";
                echo "<p>Stock: " . $row['Stock'] . "</p>";
                echo "<p>Marca: " . $row['ID_marca'] . "</p>";
                echo "<p>Tipo de Producto: " . $row['TipoProducto'] . "</p>";
                echo "<img src='uploads/" . $row['RutaImagen'] . "' alt='Imagen del producto' style='width: 100px; height: auto;'>";
                echo "</div>";
            }
        } else {
            echo "<p>No hay productos en el inventario.</p>";
        }
        ?>
    </section>

    <p><a href="CerrarSesion.php">Cerrar Sesión</a></p>
    <!-- Agrega aquí otros elementos según tus necesidades -->

    <!-- Agrega aquí tus scripts si es necesario -->
</body>

</html>
