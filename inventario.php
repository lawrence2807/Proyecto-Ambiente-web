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

// Obtener todos los productos
$productosQuery = "SELECT p.ID_producto, p.Nombre, p.Descripcion, p.Precio, p.Stock, p.Imagen, m.Nombre AS Marca, 
                        CASE p.TipoProducto 
                            WHEN 'High-Top' THEN 'High-Top'
                            WHEN 'Running' THEN 'Running'
                            WHEN 'Urban' THEN 'Urban'
                            WHEN 'Skate' THEN 'Skate'
                            WHEN 'Exclusivas' THEN 'Exclusivas'
                            ELSE 'Desconocido'
                        END AS TipoProducto
                    FROM Productos p 
                    INNER JOIN Marcas m ON p.ID_marca = m.ID_marca";

// Filtrar por nombre de producto y/o tipo de producto si se envió una búsqueda
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $whereClause = "";
    
    if (isset($_GET["nombreProducto"])) {
        $nombreProducto = $_GET["nombreProducto"];
        $whereClause .= " WHERE p.Nombre LIKE '%$nombreProducto%'";
    }
    
    if (isset($_GET["tipoProducto"]) && !empty($_GET["tipoProducto"])) {
        $tipoProducto = $_GET["tipoProducto"];
        $whereClause .= ($whereClause ? " AND" : " WHERE") . " p.TipoProducto = '$tipoProducto'";
    }
    
    $productosQuery .= $whereClause;
}

$productosResult = $conn->query($productosQuery);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario - Tu Tienda</title>
    <!-- Agrega aquí tus enlaces a estilos CSS si es necesario -->
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
    <!-- Enlace para volver al menú anterior -->
    <a href="CentroControl.php">Volver al Menú Anterior</a>

    <!-- Formulario de búsqueda por nombre y tipo de producto -->
    <section>
        <h2>Buscar Producto</h2>
        <form action="" method="get">
            <label for="nombreProducto">Nombre del Producto:</label>
            <input type="text" name="nombreProducto">
            
            <label for="tipoProducto">Tipo de Producto:</label>
            <select name="tipoProducto">
                <option value="">Todos</option>
                <option value="High-Top">High-Top</option>
                <option value="Running">Running</option>
                <option value="Urban">Urban</option>
                <option value="Skate">Skate</option>
                <option value="Exclusivas">Exclusivas</option>
            </select>
            
            <button type="submit">Buscar</button>
        </form>
    </section>

    <!-- Tabla de productos -->
    <section>
        <h2>Inventario de Productos</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio (₡)</th>
                    <th>Stock</th>
                    <th>Marca</th>
                    <th>Tipo de Producto</th>
                    <th>Imagen</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Mostrar cada producto en una fila de la tabla
                while ($row = $productosResult->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['ID_producto'] . "</td>";
                    echo "<td>" . $row['Nombre'] . "</td>";
                    echo "<td>" . $row['Descripcion'] . "</td>";
                    echo "<td>" . $row['Precio'] . "</td>";
                    echo "<td>" . $row['Stock'] . "</td>";
                    echo "<td>" . $row['Marca'] . "</td>";
                    echo "<td>" . $row['TipoProducto'] . "</td>";
                    // Mostrar la imagen del producto
                    echo "<td><img src='" . $row['Imagen'] . "' alt='Imagen de Producto' style='width:100px;'></td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </section>

    <!-- Agrega aquí tus scripts JavaScript si es necesario -->
</body>

</html>
