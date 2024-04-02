<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProductInicio</title>
    <link rel="stylesheet" href="styles.css">  
</head>
<body>
    <!-- Navbar -->
    <?php include 'navbar.php'; ?>

    <div class="container mt-4">
  <div class="row row-cols-1 row-cols-md-3 g-4">
    <?php include 'get_products.php'; ?> <!-- Obtener y mostrar los productos -->
  </div>
</div>


    <!-- Footer -->
    <?php include 'footer.php'; ?>

</body>
</html>
