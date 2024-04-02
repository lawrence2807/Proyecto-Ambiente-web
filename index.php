<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tucalzado.com</title>
    
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="style.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">  
</head>
<?php include 'navbar.php'; ?> <!-- Aquí se incluye el archivo navbar.php -->


<style>
body {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
    background-color: #080808;
    background-image: url('img/backgg.jpg');
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
    min-height: 100vh; 
    background-color: black !important; /* Fondo negro */
            color: white !important; /* Texto blanco */
}
     
    </style>
<body>


    <div class="blurp container wide-container"> <!-- Agrega la clase 'wide-container' aquí -->
 
    <h1 class="text-center" style="color: white;">Bienvenido a TuCalzado   </h1>

        <!-- Texto principal -->
        <section class="section">
            <h2 class="section-title blurp-title">Acerca de Nosotros</h2>
            <p class="section-text blurp-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam hendrerit fringilla turpis, at viverra nisi vehicula nec. Sed congue leo sit amet elit ultricies, nec gravida eros fermentum. Vivamus lacinia augue eu tellus tempus, a aliquam lorem sollicitudin. Integer vel tellus et neque suscipit viverra vel id erat. Fusce id nisl eu tortor vestibulum placerat.</p>
            <a href="AcercaDeNosotros.php" class="btn btn-outline-primary section-button">Leer más</a>
        </section>

        <!-- Título de Productos -->
        <section class="section">
            <h2 class="section-title blurp-title">Productos</h2>
            <p class="section-text blurp-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam hendrerit fringilla turpis, at viverra nisi vehicula nec. Sed congue leo sit amet elit ultricies, nec gravida eros fermentum. Vivamus lacinia augue eu tellus tempus, a aliquam lorem sollicitudin. Integer vel tellus et neque suscipit viverra vel id erat. Fusce id nisl eu tortor vestibulum placerat.</p>
            <a href="ProductInicio.php" class="btn btn-outline-primary section-button">Ver productos</a>
        </section>

        <!-- Título de Promociones -->
        <section class="section">
            <h2 class="section-title blurp-title">Promociones</h2>
            <p class="section-text blurp-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam hendrerit fringilla turpis, at viverra nisi vehicula nec. Sed congue leo sit amet elit ultricies, nec gravida eros fermentum. Vivamus lacinia augue eu tellus tempus, a aliquam lorem sollicitudin. Integer vel tellus et neque suscipit viverra vel id erat. Fusce id nisl eu tortor vestibulum placerat.</p>
            <a href="#" class="btn btn-outline-primary section-button">Ver promociones</a>
        </section>

        <!-- Título de Clientes -->
        <section class="section">
            <h2 class="section-title blurp-title">Clientes</h2>
            <p class="section-text blurp-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam hendrerit fringilla turpis, at viverra nisi vehicula nec. Sed congue leo sit amet elit ultricies, nec gravida eros fermentum. Vivamus lacinia augue eu tellus tempus, a aliquam lorem sollicitudin. Integer vel tellus et neque suscipit viverra vel id erat. Fusce id nisl eu tortor vestibulum placerat.</p>
            <a href="#" class="btn btn-outline-primary section-button">Leer testimonios</a>
        </section>

        <!-- Título de Ubicación -->
        <section class="section">
            <h2 class="section-title blurp-title">Ubicación</h2>
            <p class="section-text blurp-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam hendrerit fringilla turpis, at viverra nisi vehicula nec. Sed congue leo sit amet elit ultricies, nec gravida eros fermentum. Vivamus lacinia augue eu tellus tempus, a aliquam lorem sollicitudin. Integer vel tellus et neque suscipit viverra vel id erat. Fusce id nisl eu tortor vestibulum placerat.</p>
            <a href="#" class="btn btn-outline-primary section-button">Ver ubicación</a>
        </section>
    </div>

    <?php include 'footer.php'; ?> <!-- Aquí se incluye el archivo navbar.php --></body>

</html>
