<?php
require_once 'Producto.php';

$producto = new Producto();
$marcas = $producto->getAllMarcas();
$tiposProducto = $producto->getAllTiposProducto();

// Verificar si se ha proporcionado el ID del producto a editar
if(isset($_GET['id_producto'])) {
    $id_producto = $_GET['id_producto'];
    $productoActual = $producto->getProductoByID($id_producto);

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["editar_producto"])) {
        $id_producto = $_POST["id_producto"];
        $nombreProducto = $_POST["nombreProducto"];
        $descripcionProducto = $_POST["descripcionProducto"];
        $precioProducto = $_POST["precioProducto"];
        $stockProducto = $_POST["stockProducto"];
        $marcaProducto = $_POST["marcaProducto"];
        $tipoProducto = $_POST["tipoProducto"];

         if ($_FILES["imagenProducto"]["name"] != '') {
            $imagenProducto = $_FILES["imagenProducto"];
            $nombreImagen = uniqid() . '_' . $imagenProducto['name']; // Generar un nombre único para la imagen
            $rutaImagen = 'uploads/' . $nombreImagen; // Ruta donde se guardará la imagen
            move_uploaded_file($imagenProducto['tmp_name'], $rutaImagen); // Mover la imagen al servidor
        } else {
             $productoActual = $producto->getProductoByID($id_producto);
            $rutaImagen = $productoActual['Imagen'];
        }

         $producto->actualizarProducto($id_producto, $nombreProducto, $descripcionProducto, $precioProducto, $stockProducto, $marcaProducto, $tipoProducto, $rutaImagen);

        // Redirigir después de la actualización
        header("Location: productos.php");
        exit();
    }
} else {
    // Redirigir a algún lugar si no se proporciona un ID válido
    header("Location: alguna_pagina.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto - Tu Calzado</title>
    <style>
     </style>
</head>

<body>
     <a href="CentroControl.php">Volver al Menú</a>

     <h2>Editar Producto</h2>
    <form action="" method="post" enctype="multipart/form-data">
         <input type="hidden" name="id_producto" value="<?php echo $productoActual['ID_producto']; ?>">

        <label for="nombreProducto">Nombre:</label>
        <input type="text" id="nombreProducto" name="nombreProducto" value="<?php echo $productoActual['Nombre']; ?>"><br>

        <label for="descripcionProducto">Descripción:</label>
        <textarea id="descripcionProducto" name="descripcionProducto"><?php echo $productoActual['Descripcion']; ?></textarea><br>

        <label for="precioProducto">Precio:</label>
        <input type="text" id="precioProducto" name="precioProducto" value="<?php echo $productoActual['Precio']; ?>"><br>

        <label for="stockProducto">Stock:</label>
        <input type="text" id="stockProducto" name="stockProducto" value="<?php echo $productoActual['Stock']; ?>"><br>

        <label for="marcaProducto">Marca:</label>
        <select id="marcaProducto" name="marcaProducto">
            <?php while ($marca = $marcas->fetch_assoc()) { ?>
                <option value="<?php echo $marca['ID_marca']; ?>" <?php if ($productoActual['ID_marca'] == $marca['ID_marca']) echo "selected"; ?>><?php echo $marca['Nombre']; ?></option>
            <?php } ?>
        </select><br>

        <label for="tipoProducto">Tipo:</label>
        <select id="tipoProducto" name="tipoProducto">
            <?php while ($tipoProducto = $tiposProducto->fetch_assoc()) { ?>
                <option value="<?php echo $tipoProducto['ID_tipo']; ?>" <?php if ($productoActual['ID_tipo'] == $tipoProducto['ID_tipo']) echo "selected"; ?>><?php echo $tipoProducto['Nombre']; ?></option>
            <?php } ?>
        </select><br>

         <label for="imagenProducto">Imagen:</label>
        <input type="file" id="imagenProducto" name="imagenProducto"><br>

        <button type="submit" name="editar_producto">Guardar Cambios</button>
    </form>

</body>

</html>
