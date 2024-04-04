<?php
session_start();

if (!isset($_SESSION["ID_usuario"])) {
    header("Location: iniciarsesion.php");
    exit();
}

include 'DBConnection.php';

$dbConnection = new DBConnection();
$conexion = $dbConnection->getConnection();

// Función para agregar un producto al carrito
function agregarAlCarrito($producto) {
    $_SESSION['carrito'][] = $producto;
}

// Función para eliminar un producto del carrito
function eliminarDelCarrito($indice) {
    if (isset($_SESSION['carrito'][$indice])) {
        unset($_SESSION['carrito'][$indice]);
    }
}

// Función para calcular el total de la compra
function calcularTotal() {
    $total = 0;
    if (isset($_SESSION['carrito'])) {
        foreach ($_SESSION['carrito'] as $producto) {
            if (isset($producto['precio'])) {
                $total += $producto['precio'];
            }
        }
    }
    return $total;
}

// Función para vaciar el carrito
function vaciarCarrito() {
    $_SESSION['carrito'] = array();
}

// Función para finalizar la compra y guardar el pedido en la base de datos
function finalizarCompra() {
    global $conexion;

    // Insertar el pedido en la tabla Pedidos
    $sql = "INSERT INTO Pedidos (ID_usuario, Fecha) VALUES (?, NOW())";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $_SESSION["ID_usuario"]);
    $stmt->execute();
    $id_pedido = $stmt->insert_id;
    $stmt->close();

    // Insertar los detalles del pedido en la tabla DetallesPedido
    foreach ($_SESSION['carrito'] as $producto) {
        $sql = "INSERT INTO DetallesPedido (ID_pedido, ID_producto, Cantidad, PrecioUnitario) VALUES (?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("iiid", $id_pedido, $producto['id_producto'], $producto['cantidad'], $producto['precio']);
        $stmt->execute();
        $stmt->close();
    }

    // Limpiar el carrito después de finalizar la compra
    vaciarCarrito();

    // Redirigir a la página de pedidos
    header("Location: pedidos.php");
    exit;
}

// Verificar si se ha enviado un formulario para agregar un producto al carrito
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nombre']) && isset($_POST['descripcion']) && isset($_POST['precio'])) {
    // Creamos un array con los datos del producto
    $producto = array(
        'nombre' => $_POST['nombre'],
        'descripcion' => $_POST['descripcion'],
        'precio' => $_POST['precio'],
        'id_producto' => $_POST['id_producto'], // Agregar el ID del producto
        'cantidad' => $_POST['cantidad'] // Agregar la cantidad del producto
    );

    // Agregamos el producto al carrito
    agregarAlCarrito($producto);

    // Redireccionamos de nuevo a la página de inicio de productos
    header("Location: ProductInicio.php");
    exit;
}

// Verificar si se ha enviado un formulario para eliminar un producto del carrito
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['eliminarProducto'])) {
    eliminarDelCarrito($_POST['indice']);
    // Redireccionamos de nuevo a la página del carrito
    header("Location: carrito.php");
    exit;
}

// Verificar si se ha enviado un formulario para vaciar el carrito
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['vaciarCarrito'])) {
    vaciarCarrito();
    // Redireccionamos de nuevo a la página del carrito
    header("Location: carrito.php");
    exit;
}

// Verificar si se ha enviado un formulario para finalizar la compra
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['finalizarCompra'])) {
    finalizarCompra();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras - Tu Calzado</title>
    <!-- Agrega aquí tus enlaces a estilos CSS si es necesario -->
    <style>
        /* Estilos CSS para la página del carrito */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333; /* Color de texto predeterminado */
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 0 15px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333; /* Color de texto para el título */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #333;
            color: white;
        }

        tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .total {
            font-weight: bold;
            margin-bottom: 10px;
            color: #333;  
        }

        .actions {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .actions button {
            padding: 10px 20px;
            background-color: #333;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .actions button:hover {
            background-color: #555;
        }
    </style>
</head>

<body>
    <?php include 'navbar.php'; ?>

    <div class="container">
        <h1>Carrito de Compras</h1>

        <?php if (!empty($_SESSION['carrito'])) : ?>
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($_SESSION['carrito'] as $indice => $producto) : ?>
                        <tr>
                            <td><?php echo isset($producto['nombre']) ? $producto['nombre'] : ''; ?></td>
                            <td><?php echo isset($producto['descripcion']) ? $producto['descripcion'] : ''; ?></td>
                            <td><?php echo isset($producto['precio']) ? $producto['precio'] : ''; ?></td>
                            <td>
                                <form method="post" action="carrito.php">
                                    <input type="hidden" name="indice" value="<?php echo $indice; ?>">
                                    <button type="submit" name="eliminarProducto">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <p class="total">Total: <?php echo calcularTotal(); ?></p>

            <div class="actions">
                <form method="post" action="carrito.php">
                    <button type="submit" name="vaciarCarrito">Vaciar Carrito</button>
                </form>
                <form method="post" action="carrito.php">
                    <button type="submit" name="finalizarCompra">Finalizar Compra</button>
                </form>
            </div>
        <?php else : ?>
            <p>No hay productos en el carrito.</p>
        <?php endif; ?>
    </div>

    <?php include 'footer.php'; ?>

    <script>
    </script>
</body>

</html>
