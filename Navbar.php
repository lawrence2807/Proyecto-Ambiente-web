
<style>
 
.navbar-nav .nav-link {
        color: white !important;
    }
    </style>
    <?php
// Verificar si el usuario ha iniciado sesión
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Definir variables con valores predeterminados
$nombreUsuario = "";
$usuarioValidado = false;

// Verificar si el usuario está autenticado
if (isset($_SESSION['ID_usuario'])) {
    $usuarioValidado = true;
    $nombreUsuario = $_SESSION['Nombre'];
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar personalizado</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="style.css">


</head>



<body>

    <div class="pos-f-t">
        <div class="collapse" id="navbarToggleExternalContent">
            <div class="bg-dark p-4">
                <h4 class="text-white">Tu calzado </h4>
                <span class="text-muted"><?php echo $nombreUsuario; ?></span>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Noticias</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="AcercaDeNosotros.php">Acerca de nosotros</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contacto</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="ProductInicio.php">Productos</a>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    <?php if ($usuarioValidado) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="cerrarsesion.php">Cerrar sesión</a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <nav class="navbar navbar-dark bg-dark">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                <span class="navbar-toggler-text">Menú</span>
            </button>
        </nav>
    </div>

    <!-- Navbar content when expanded -->
    <nav class="navbar navbar-dark bg-dark">
        <!-- Navbar content -->
    </nav>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
