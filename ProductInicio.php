<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuestros productos - Tu Calzado</title>
    <!-- Agrega aquí tus enlaces a estilos CSS si es necesario -->
    <style>
        /* Estilos CSS para la página de productos */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }

        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 0 15px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .search-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .search-input {
            padding: 10px;
            width: 60%;
            border-radius: 5px;
            border: 1px solid #ccc;
            margin-right: 10px;
        }

        .products-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .product-card {
            flex: 0 0 calc(25% - 20px);
            margin-bottom: 20px;
            background-color: black;
            color: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(255, 0, 0, 0.5); /* Shadow rojo */
            overflow: hidden;
            transition: transform 0.3s ease-in-out;
        }

        .product-card:hover {
            transform: translateY(-5px);
        }

        .product-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .product-details {
            padding: 15px;
        }

        .product-title {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .product-description {
            margin-bottom: 10px;
        }

        .product-price {
            font-weight: bold;
        }

        .add-to-cart-btn {
            display: block;
            width: 100%;
            padding: 10px;
            text-align: center;
            background-color: transparent;
            color: #ff0000; /* Letra roja */
            text-decoration: none;
            border: 1px solid #ff0000; /* Borde rojo */
            border-radius: 5px;
            transition: background-color 0.3s ease-in-out;
        }

        .add-to-cart-btn:hover {
            background-color: #ff0000; /* Relleno rojo al pasar el mouse */
            color: white;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <?php include 'navbar.php'; ?>

    <!-- Contenedor principal -->
    <div class="container">
        <!-- Título de la página -->
        <h1>Nuestros productos</h1>

        <!-- Barra de búsqueda -->
        <div class="search-container">
            <input type="text" class="search-input" id="searchInput" placeholder="Buscar por nombre o precio">
            <button onclick="searchProducts()" class="search-btn">Buscar</button>
        </div>

        <!-- Contenedor de productos -->
        <div class="products-container">
            <?php
            // Incluye el archivo de la clase de conexión a la base de datos
            include 'DBConnection.php';

            // Instancia la clase de conexión a la base de datos
            $dbConnection = new DBConnection();
            $conn = $dbConnection->getConnection();

            // Verifica la conexión
            if ($conn->connect_error) {
                die("La conexión falló: " . $conn->connect_error);
            }

            // Consulta a la base de datos para obtener los productos
            $sql = "SELECT ID_producto, Nombre, Descripcion, Precio, Imagen FROM Productos";
            $result = $conn->query($sql);

            // Si hay resultados, muestra los productos en tarjetas
            if ($result->num_rows > 0) {
                // Bucle PHP modificado para incluir el ID_producto en el botón "Agregar al carrito"
                while ($row = $result->fetch_assoc()) {
                  echo '<div class="col-md-3">';
                  echo '<div class="product-card">';
                  echo '<img class="product-image" src="' . $row['Imagen'] . '" alt="' . $row['Nombre'] . '">';
                  echo '<div class="product-details">';
                  echo '<h3 class="product-title">' . $row['Nombre'] . '</h3>';
                  echo '<p class="product-description">' . $row['Descripcion'] . '</p>';
                  echo '<p class="product-price">Precio: ' . $row['Precio'] . ' CRC</p>';
                  echo '<form method="post" action="carrito.php">';
                  echo '<input type="hidden" name="id_producto" value="' . $row['ID_producto'] . '">';
                  echo '<input type="hidden" name="nombre" value="' . $row['Nombre'] . '">';
                  echo '<input type="hidden" name="descripcion" value="' . $row['Descripcion'] . '">';
                  echo '<input type="hidden" name="precio" value="' . $row['Precio'] . '">';
                  echo '<button type="submit" class="add-to-cart-btn">Agregar al carrito</button>';
                  echo '</form>';
                  echo '</div></div></div>';
              }
            } else {
                echo "No se encontraron productos.";
            }

            $conn->close();
            ?>
        </div>
    </div>

    <!-- Footer -->
    <?php include 'footer.php'; ?>

    <!-- Agrega aquí tus scripts JavaScript si es necesario -->
    <script>
        function searchProducts() {
            // Obtiene el valor del input de búsqueda
            var searchInput = document.getElementById("searchInput").value.toUpperCase();
            var products = document.getElementsByClassName("product-card");

            // Itera sobre los productos y muestra u oculta según la búsqueda
            for (var i = 0; i < products.length; i++) {
                var title = products[i].getElementsByClassName("product-title")[0];
                var description = products[i].getElementsByClassName("product-description")[0];
                var price = products[i].getElementsByClassName("product-price")[0];
                var titleText = title.textContent || title.innerText;
                var descriptionText = description.textContent || description.innerText;
                var priceText = price.textContent || price.innerText;

                if (titleText.toUpperCase().indexOf(searchInput) > -1 ||
                    descriptionText.toUpperCase().indexOf(searchInput) > -1 ||
                    priceText.toUpperCase().indexOf(searchInput) > -1) {
                    products[i].style.display = "";
                } else {
                    products[i].style.display = "none";
                }
            }
        }
    </script>
</body>

</html>
