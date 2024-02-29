-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS tutienda;

-- Usar la base de datos
USE tutienda;

-- Crear la tabla Usuarios
CREATE TABLE IF NOT EXISTS Usuarios (
    ID_usuario INT AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(255),
    CorreoElectronico VARCHAR(255),
    Contraseña VARCHAR(255)
);

-- Crear la tabla Marcas
CREATE TABLE IF NOT EXISTS Marcas (
    ID_marca INT AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(255)
);

-- Crear la tabla Productos
CREATE TABLE IF NOT EXISTS Productos (
    ID_producto INT AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(255),
    Descripcion TEXT,
    Precio DECIMAL(10, 2),
    Stock INT,
    ID_marca INT,
    FOREIGN KEY (ID_marca) REFERENCES Marcas(ID_marca)
);

-- Crear la tabla Pedidos
CREATE TABLE IF NOT EXISTS Pedidos (
    ID_pedido INT AUTO_INCREMENT PRIMARY KEY,
    ID_usuario INT,
    Fecha DATETIME,
    FOREIGN KEY (ID_usuario) REFERENCES Usuarios(ID_usuario)
);

-- Crear la tabla Detalles del Pedido
CREATE TABLE IF NOT EXISTS DetallesPedido (
    ID_detalle INT AUTO_INCREMENT PRIMARY KEY,
    ID_pedido INT,
    ID_producto INT,
    Cantidad INT,
    PrecioUnitario DECIMAL(10, 2),
    FOREIGN KEY (ID_pedido) REFERENCES Pedidos(ID_pedido),
    FOREIGN KEY (ID_producto) REFERENCES Productos(ID_producto)
);

-- Crear la tabla Cesta
CREATE TABLE IF NOT EXISTS Cesta (
    ID_cesta INT AUTO_INCREMENT PRIMARY KEY,
    ID_usuario INT,
    FechaCreacion DATETIME,
    FOREIGN KEY (ID_usuario) REFERENCES Usuarios(ID_usuario)
);

-- Crear la tabla Detalles de la Cesta
CREATE TABLE IF NOT EXISTS DetallesCesta (
    ID_detalle_cesta INT AUTO_INCREMENT PRIMARY KEY,
    ID_cesta INT,
    ID_producto INT,
    Cantidad INT,
    PrecioUnitario DECIMAL(10, 2),
    FOREIGN KEY (ID_cesta) REFERENCES Cesta(ID_cesta),
    FOREIGN KEY (ID_producto) REFERENCES Productos(ID_producto)
);
CREATE TABLE IF NOT EXISTS RecuperacionContrasena (
    ID_recuperacion INT AUTO_INCREMENT PRIMARY KEY,
    Correo VARCHAR(255),
    Token VARCHAR(64),
    Expiracion DATETIME
);
SELECT user()
SELECT @@hostname;

