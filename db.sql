-- Crear la base de datos y seleccionarla
CREATE DATABASE IF NOT EXISTS magic_shop_db;
USE magic_shop_db;

-- ==========================================
-- 1. CREACIÓN DE TABLAS CATÁLOGO (PADRES)
-- ==========================================

-- Tabla: ROLES
CREATE TABLE roles (
    id_rol INT AUTO_INCREMENT,
    nombre_rol VARCHAR(50) NOT NULL UNIQUE,
    PRIMARY KEY (id_rol)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insertar roles por defecto para que la BD sea funcional de inmediato
INSERT INTO roles (nombre_rol) VALUES ('usuario'), ('admin');

-- Tabla: PRODUCTOS
CREATE TABLE productos (
    id_producto INT AUTO_INCREMENT,
    nombre_producto VARCHAR(100) NOT NULL,
    categoria VARCHAR(50),
    precio DECIMAL(10,2) NOT NULL,
    stock INT NOT NULL,
    imagen_url VARCHAR(255) NOT NULL,
    PRIMARY KEY (id_producto)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ==========================================
-- 2. CREACIÓN DE TABLAS TRANSACCIONALES
-- ==========================================

-- Tabla: USUARIOS
CREATE TABLE IF NOT EXISTS usuarios (
    id_usuario INT AUTO_INCREMENT,
    id_rol INT NOT NULL DEFAULT 1, -- Por defecto será 'usuario' (id=1)
    correo_electronico VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    nombre VARCHAR(50) NOT NULL,
    apellido VARCHAR(50) NOT NULL,
    edad TINYINT UNSIGNED,
    telefono VARCHAR(15) NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id_usuario),
    CONSTRAINT fk_usuario_rol 
        FOREIGN KEY (id_rol) REFERENCES roles(id_rol) 
        ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla: PEDIDOS
CREATE TABLE IF NOT EXISTS pedidos (
    id_pedido INT AUTO_INCREMENT,
    id_usuario INT NOT NULL,
    fecha_pedido TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    total DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    estado VARCHAR(50) DEFAULT 'Pendiente',
    PRIMARY KEY (id_pedido),
    CONSTRAINT fk_pedido_usuario 
        FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario) 
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla: DETALLES_PEDIDO (Tabla puente/transitiva)
CREATE TABLE IF NOT EXISTS detalles_pedido (
    id_detalle INT AUTO_INCREMENT,
    id_pedido INT NOT NULL,
    id_producto INT NOT NULL,
    cantidad INT NOT NULL,
    precio_unitario DECIMAL(10,2) NOT NULL,
    PRIMARY KEY (id_detalle),
    CONSTRAINT fk_detalle_pedido 
        FOREIGN KEY (id_pedido) REFERENCES pedidos(id_pedido) 
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_detalle_producto 
        FOREIGN KEY (id_producto) REFERENCES productos(id_producto) 
        ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;