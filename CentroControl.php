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
    <!-- Agrega aquí tus enlaces a estilos CSS si es necesario -->
</head>

<body>
    <!-- Inicio del contenido de la página -->
    <div class="container-fluid">
        <!-- Nombre de la tienda -->
        <h1>Tu Calzado</h1>

        <!-- Barra de navegación y logo pequeño -->
        <div class="row">
            <!-- Logo pequeño -->
            <div class="col-md-2">
                <img src="ruta/al/logo_pequeno.png" alt="Logo pequeño">
            </div>
            <!-- Nombre del usuario registrado -->
            <div class="col-md-10 text-right">
                <p>Bienvenido, <?php echo $_SESSION['Nombre']; ?></p>
            </div>
        </div>

        <!-- Barra de navegación lateral -->
        <div class="row">
            <div class="col-md-2">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="inventario.php">Inventario</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="productos.php">Productos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="metricas.php">Métricas</a>
                    </li>
                </ul>
            </div>
            <!-- Contenido principal -->
            <div class="col-md-10">
                <!-- Contenido principal -->
            </div>
        </div>
    </div>
    <!-- Fin del contenido de la página -->

    <!-- Agrega aquí tus scripts JavaScript si es necesario -->
</body>

</html>
