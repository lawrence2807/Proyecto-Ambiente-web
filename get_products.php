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
$sql = "SELECT Nombre, Descripcion, Precio, Imagen FROM Productos";
$result = $conn->query($sql);

// Si hay resultados, muestra los productos en tarjetas
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div class="col-md-3">';
        echo '<div class="card" style="width: 18rem;">';
        echo '<img class="card-img-top" src="' . $row['Imagen'] . '" alt="' . $row['Nombre'] . '">';
        echo '<div class="card-body">';
        echo '<h5 class="card-title">' . $row['Nombre'] . '</h5>';
        echo '<p class="card-text">' . $row['Descripcion'] . '</p>';
        echo '<p class="card-text">Precio: ' . $row['Precio'] . ' CRC</p>';
        echo '<a href="#" class="btn btn-primary">Agregar al carrito</a>'; // Botón para agregar al carrito
        echo '</div></div></div>';
    }
} else {
    echo "No se encontraron productos.";
}

 
$conn->close();
?>
