<?php
require_once 'DBConnection.php';

class Producto {
    private $conn;

    public function __construct() {
        $db = new DBConnection();
        $this->conn = $db->getConnection();
    }

    public function getAllProductos() {
        $sql = "SELECT p.ID_producto, p.Nombre, p.Descripcion, p.Precio, p.Stock, m.Nombre AS Marca, tp.Nombre AS Tipo, p.Imagen FROM Productos p JOIN Marcas m ON p.ID_marca = m.ID_marca JOIN TiposProducto tp ON p.ID_tipo = tp.ID_tipo";
        $result = $this->conn->query($sql);
        return $result;
    }
    public function getAllMarcas() {
        $sql = "SELECT ID_marca, Nombre FROM Marcas";
        $result = $this->conn->query($sql);
        return $result;
    }
    
    public function getAllTiposProducto() {
        $sql = "SELECT ID_tipo, Nombre FROM TiposProducto";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function agregarProducto($nombre, $descripcion, $precio, $stock, $id_marca, $id_tipo, $imagen) {
        $stmt = $this->conn->prepare("INSERT INTO Productos (Nombre, Descripcion, Precio, Stock, ID_marca, ID_tipo, Imagen) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdiiis", $nombre, $descripcion, $precio, $stock, $id_marca, $id_tipo, $imagen);
        return $stmt->execute();
    }

    public function actualizarProducto($id_producto, $nombre, $descripcion, $precio, $stock, $id_marca, $id_tipo, $imagen) {
        $stmt = $this->conn->prepare("UPDATE Productos SET Nombre=?, Descripcion=?, Precio=?, Stock=?, ID_marca=?, ID_tipo=?, Imagen=? WHERE ID_producto=?");
        $stmt->bind_param("ssdiiisi", $nombre, $descripcion, $precio, $stock, $id_marca, $id_tipo, $imagen, $id_producto);
        return $stmt->execute();
    }

    public function eliminarProducto($id_producto) {
        $stmt = $this->conn->prepare("DELETE FROM Productos WHERE ID_producto=?");
        $stmt->bind_param("i", $id_producto);
        return $stmt->execute();
    }


public function getProductoByID($id_producto) {
    $stmt = $this->conn->prepare("SELECT * FROM Productos WHERE ID_producto = ?");
    $stmt->bind_param("i", $id_producto);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

}

?>
