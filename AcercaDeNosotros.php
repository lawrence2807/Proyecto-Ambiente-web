
<?php
session_start();

// Verificar si el usuario no ha iniciado sesión
if (!isset($_SESSION["ID_usuario"])) {
    // Si no ha iniciado sesión, redirigirlo a la página de inicio de sesión
    header("Location: iniciarsesion.php");
    exit(); // Detiene la ejecución del script
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - TuCalzado</title>
    <!-- Enlaces a los archivos CSS -->
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.2/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.3/components/abouts/about-1/assets/css/about-1.css" />
    <!-- Estilo personalizado -->
    <style>
        body {
            background-color: black !important; /* Fondo negro */
            color: white !important; /* Texto blanco */
        }
    </style>
    <!-- Enlace a la ruta de tu icono -->
    <link rel="icon" href="ruta_de_tu_icono.ico">
</head>
<body>

<!-- Navbar -->
<?php include 'navbar.php'; ?>

<!-- Contenido de la sección "Acerca de nosotros" -->
<section class="py-3 py-md-5 py-xl-8">
    <div class="container">
        <div class="row gy-3 gy-md-4 gy-lg-0 align-items-lg-center">
            <div class="col-12 col-lg-6 col-xl-5">
                <img class="img-fluid rounded" loading="lazy" src="/img/Logo.png" alt="TuCalzado Logo">
            </div>
            <div class="col-12 col-lg-6 col-xl-7">
                <div class="row justify-content-xl-center">
                    <div class="col-12 col-xl-11">
                        <h2 class="h1 mb-3">¿Quiénes somos?</h2>
                        <p class="lead fs-4 text-secondary mb-3">En TuCalzado nos dedicamos a ofrecerte calzado de la más alta calidad y estilo para satisfacer tus necesidades.</p>
                        <p class="mb-5">Somos reconocidos por nuestra dedicación a la calidad, la comodidad y el estilo. Nuestros zapatos no solo son populares por su elegancia, sino también por su durabilidad y diseño innovador.</p>
                        <div class="row gy-4 gy-md-0 gx-xxl-5X">
                            <div class="col-12 col-md-6">
                                <div class="d-flex">
                                    <div class="me-4 text-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-gear-fill" viewBox="0 0 16 16">
                                            <path d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872l-.1-.34zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="mb-3">Calidad Versátil</h4>
                                        <p class="text-secondary mb-0">Nuestro compromiso es ofrecerte calzado que se adapte a tu estilo de vida y te proporcione comodidad en cada paso.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="d-flex">
                                    <div class="me-4 text-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-fire" viewBox="0 0 16 16">
                                            <path d="M8 16c3.314 0 6-2 6-5.5 0-1.5-.5-4-2.5-6 .25 1.5-1.25 2-1.25 2C11 4 9 .5 6 0c.357 2 .5 4-2 6-1.25 1-2 2.729-2 4.5C2 14 4.686 16 8 16Zm0-1c-1.657 0-3-1-3-2.75 0-.75.25-2 1.25-3C6.125 10 7 10.5 7 10.5c-.375-1.25.5-3.25 2-3.5-.179 1-.25 2 1 3 .625.5 1 1.364 1 2.25C11 14 9.657 15 8 15Z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="mb-3">Popularidad Duradera</h4>
                                        <p class="text-secondary mb-0">Nuestros zapatos son populares entre los clientes que buscan calidad y estilo duradero.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<br>
<br>
<br>
<br>
<br>
<br>       
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<?php include 'footer.php'; ?>

</body>
</html>
