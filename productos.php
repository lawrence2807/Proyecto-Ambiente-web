<style>
    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }
</style>
<?php
session_start();
require_once 'Producto.php';

// Verificar si el usuario está autenticado y tiene rol de administrador
if (!isset($_SESSION["ID_usuario"]) || !isset($_SESSION["Nombre"]) || $_SESSION["Rol"] !== 'admin') {
    header("Location: IniciarSesion.php"); // Redirigir si no es un administrador autenticado
    exit();
}

$producto = new Producto();

// Procesar el formulario de agregar producto
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["agregar_producto"])) {
    // Verificar si se reciben todos los datos esperados
    if (isset($_POST["nombreProducto"], $_POST["descripcionProducto"], $_POST["precioProducto"], $_POST["stockProducto"], $_POST["marcaProducto"], $_POST["tipoProducto"], $_FILES["imagenProducto"])) {
        $nombreProducto = $_POST["nombreProducto"];
        $descripcionProducto = $_POST["descripcionProducto"];
        $precioProducto = $_POST["precioProducto"];
        $stockProducto = $_POST["stockProducto"];
        $marcaProducto = $_POST["marcaProducto"];
        $tipoProducto = $_POST["tipoProducto"];

        // Procesar la carga de imagen
        $imagenProducto = $_FILES["imagenProducto"];
        $nombreImagen = uniqid() . '_' . $imagenProducto['name']; // Generar un nombre único para la imagen
        $rutaImagen = 'uploads/' . $nombreImagen; // Ruta donde se guardará la imagen
        move_uploaded_file($imagenProducto['tmp_name'], $rutaImagen); // Mover la imagen al servidor

        // Insertar producto en la base de datos junto con la ruta de la imagen
        $producto->agregarProducto($nombreProducto, $descripcionProducto, $precioProducto, $stockProducto, $marcaProducto, $tipoProducto, $rutaImagen);
    } else {
        // Redirigir a alguna página de error si no se reciben todos los datos esperados
        header("Location: error.php");
        exit();
    }
}

// Obtener todos los productos
$productos = $producto->getAllProductos();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos - Tu Calzado</title>
    <style>
        /* Estilos CSS aquí */
    </style>
</head>

<body>
    <!-- Botón para retroceder al menú -->
    <a href="CentroControl.php">Volver al Menú</a>

    <!-- Formulario para agregar un nuevo producto -->
    <h2>Agregar Producto</h2>
    <form action="" method="post" enctype="multipart/form-data">
        <!-- Campos del formulario aquí -->
        <label for="nombreProducto">Nombre:</label>
        <input type="text" id="nombreProducto" name="nombreProducto" required><br>

        <label for="descripcionProducto">Descripción:</label>
        <textarea id="descripcionProducto" name="descripcionProducto" required></textarea><br>

        <label for="precioProducto">Precio:</label>
        <input type="text" id="precioProducto" name="precioProducto" required><br>

        <label for="stockProducto">Stock:</label>
        <input type="text" id="stockProducto" name="stockProducto" required><br>

        <label for="marcaProducto">Marca:</label>
        <select id="marcaProducto" name="marcaProducto" required>
            <option value="1">Nike</option>
            <option value="2">Adidas</option>
            <option value="3">Puma</option>
            <option value="4">New Balance</option>
            <option value="5">Reebok</option>
        </select><br>

        <label for="tipoProducto">Tipo:</label>
        <select id="tipoProducto" name="tipoProducto" required>
            <option value="1">High-Top</option>
            <option value="2">Running</option>
            <option value="3">Urban</option>
            <option value="4">Skate</option>
            <option value="5">Exclusivas</option>
        </select><br>

        <!-- Campo para la imagen del producto -->
        <label for="imagenProducto">Imagen:</label>
        <input type="file" id="imagenProducto" name="imagenProducto" required><br>

        <button type="submit" name="agregar_producto">Agregar Producto</button>
    </form>

    <!-- Lista de productos existentes -->
    <h2>Productos</h2>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Marca</th>
                <th>Tipo</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($productos as $p) { ?>
                <tr>
                     <td><?php echo $p['Nombre']; ?></td>
                    <td><?php echo $p['Descripcion']; ?></td>
                    <td><?php echo $p['Precio']; ?></td>
                    <td><?php echo $p['Stock']; ?></td>
                    <td><?php echo $p['Marca']; ?></td>
                    <td><?php echo $p['Tipo']; ?></td>
                    <td>
    <form action="editar_producto.php" method="get">
        <input type="hidden" name="id_producto" value="<?php echo $p['ID_producto']; ?>">
        <button type="submit" style="background-color: transparent; border: none; cursor: pointer;">Editar</button>
    </form>
</td>
<td>
    <form action="eliminar_producto.php" method="post" onsubmit="return confirmarEliminar(<?php echo $p['ID_producto']; ?>)">
        <input type="hidden" name="id_producto" value="<?php echo $p['ID_producto']; ?>">
        <button type="submit" style="background-color: transparent; border: none; cursor: pointer;">Eliminar</button>
    </form>
</td>

<script>
    function confirmarEliminar(idProducto) {
        return confirm('¿Estás seguro de eliminar este producto?');
    }
</script>


</td>

                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>

</html>
