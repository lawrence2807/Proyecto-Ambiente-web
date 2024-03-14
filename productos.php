<?php
session_start();

// Función para obtener el nombre de la marca a partir de su ID
function obtenerNombreMarca($conn, $id_marca) {
    $stmt = $conn->prepare("SELECT Nombre FROM Marcas WHERE ID_marca = ?");
    $stmt->bind_param("i", $id_marca);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $marca = $result->fetch_assoc();
        return $marca['Nombre'];
    } else {
        return "Marca no encontrada";
    }
}

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

// Definir $tipoProducto fuera del bloque POST para evitar el error de variable indefinida
$tipoProducto = "";

// Procesar el formulario de agregar producto
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombreProducto = $_POST["nombreProducto"];
    $descripcionProducto = $_POST["descripcionProducto"];
    $precioProducto = $_POST["precioProducto"];
    $stockProducto = $_POST["stockProducto"];
    $marcaProducto = $_POST["marcaProducto"];
    $tipoProducto = $_POST["tipoProducto"];

    // Depurar el valor de tipoProducto
    echo "Tipo de producto seleccionado: " . $tipoProducto . "<br>";

    // Mostrar el tipo de producto
    echo "<td>" . $row['TipoProducto'] . "</td>";

    // Procesar la carga de imagen
    $imagenProducto = $_FILES["imagenProducto"];
    $nombreImagen = uniqid() . '_' . $imagenProducto['name']; // Generar un nombre único para la imagen
    $rutaImagen = 'uploads/' . $nombreImagen; // Ruta donde se guardará la imagen
    move_uploaded_file($imagenProducto['tmp_name'], $rutaImagen); // Mover la imagen al servidor

    // Insertar producto en la base de datos junto con la ruta de la imagen
    $stmt = $conn->prepare("INSERT INTO Productos (Nombre, Descripcion, Precio, Stock, ID_marca, TipoProducto, Imagen) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdiiis", $nombreProducto, $descripcionProducto, $precioProducto, $stockProducto, $marcaProducto, $tipoProducto, $rutaImagen);
    if ($stmt->execute()) {
        echo "Producto agregado correctamente.";
    } else {
        echo "Error al agregar el producto: " . $conn->error;
    }

    $stmt->close();
}

// Obtener todos los productos
$productosQuery = "SELECT * FROM Productos";
$productosResult = $conn->query($productosQuery);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos - Tu Calzado</title>
     
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <!-- Botón para retroceder al menú -->
    <a href="CentroControl.php">Volver al Menú</a>

    <!-- Sección para agregar un nuevo producto -->
    <section>
        <h2>Agregar Producto</h2>
        <form action="" method="post" enctype="multipart/form-data">
            <label for="nombreProducto">Nombre:</label>
            <input type="text" name="nombreProducto" required>

            <label for="descripcionProducto">Descripción:</label>
            <textarea name="descripcionProducto" required></textarea>

            <label for="precioProducto">Precio (₡):</label>
            <input type="number" name="precioProducto" required>

            <label for="stockProducto">Stock:</label>
            <input type="number" name="stockProducto" required>

            <!-- Campo para cargar la imagen -->
            <label for="imagenProducto">Imagen:</label>
            <input type="file" name="imagenProducto" accept="image/*" required>

            <!-- Lista de marcas -->
            <label for="marcaProducto">Marca:</label>
            <select name="marcaProducto" required>
                <option value="1">Nike</option>
                <option value="2">Adidas</option>
                <option value="3">Puma</option>
                <option value="4">New Balance</option>
                <option value="5">Reebok</option>
            </select>

            <!-- Lista de tipo de producto -->
            <label for="tipoProducto">Tipo de Producto:</label>
            <select name="tipoProducto" required>
                <option value="High-Top">High-Top</option>
                <option value="Running">Running</option>
                <option value="Urban">Urban</option>
                <option value="Skate">Skate</option>
                <option value="Exclusivas">Exclusivas</option>
            </select>

            <button type="submit">Agregar Producto</button>
        </form>
    </section>

   
    <section>
        <h2>Productos</h2>
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio (₡)</th>
                    <th>Stock</th>
                    <th>Marca</th>
                    <th>Tipo de Producto</th>
<th>Imagen</th>
<th>Acciones</th>
</tr>
</thead>
<tbody>
<?php
             // Mostrar cada producto en una fila de la tabla
             while ($row = $productosResult->fetch_assoc()) {
                 echo "<tr>";
                 echo "<td>" . $row['Nombre'] . "</td>";
                 echo "<td>" . $row['Descripcion'] . "</td>";
                 echo "<td>" . $row['Precio'] . "</td>";
                 echo "<td>" . $row['Stock'] . "</td>";
                 echo "<td>" . obtenerNombreMarca($conn, $row['ID_marca']) . "</td>";  
                 echo "<td>" . $row['TipoProducto'] . "</td>";  
                  echo "<td><img src='" . $row['Imagen'] . "' alt='Imagen de Producto' style='width:100px;'></td>";
                 echo "<td>";
                  echo "<form action='ver_producto.php' method='get'>";
                 echo "<input type='hidden' name='id_producto' value='" . $row['ID_producto'] . "'>";
                 echo "<button type='submit'>Ver</button>";
                 echo "</form>";
                 echo "<form action='editar_producto.php' method='get'>";
                 echo "<input type='hidden' name='id_producto' value='" . $row['ID_producto'] . "'>";
                 echo "<button type='submit'>Editar</button>";
                 echo "</form>";
                 echo "<form action='eliminar_producto.php' method='post' onsubmit='return confirm(\"¿Estás seguro de eliminar este producto?\")'>";
                 echo "<input type='hidden' name='id_producto' value='" . $row['ID_producto'] . "'>";
                 echo "<button type='submit'>Eliminar</button>";
                 echo "</form>";
                 echo "</td>";
                 echo "</tr>";
             }
             ?>
</tbody>
</table>
</section>
</body>
</html>