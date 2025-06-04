-- Base de datos para el sistema de portafolio
CREATE DATABASE IF NOT EXISTS portafolio_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE portafolio_db;

-- Tabla de usuarios
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabla de proyectos
CREATE TABLE IF NOT EXISTS proyectos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(100) NOT NULL,
    descripcion TEXT NOT NULL,
    url_github VARCHAR(255),
    url_produccion VARCHAR(255),
    imagen VARCHAR(255) NOT NULL,
    user_id INT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Usuario de ejemplo (usuario: camila, contraseña: 123)
INSERT INTO users (username, password, email) VALUES 
('camila', '202cb962ac59075b964b07152d234b70');

-- Proyectos de ejemplo
INSERT INTO proyectos (titulo, descripcion, url_github, url_produccion, imagen) VALUES 
(
    'Sistema de Gestión CRUD',
    'Sistema completo de gestión con operaciones CRUD desarrollado en PHP y MySQL. Incluye autenticación de usuarios, validación de formularios y interfaz responsive con Bootstrap.',
    'https://github.com/usuario/crud-system',
    'https://demo.crud-system.com',
    'ejemplo1.jpg'
),
(
    'E-commerce Moderno',
    'Plataforma de comercio electrónico desarrollada con tecnologías modernas. Incluye carrito de compras, sistema de pagos, panel administrativo y diseño responsive.',
    'https://github.com/usuario/ecommerce',
    'https://demo.ecommerce.com',
    'ejemplo2.jpg'
),
(
    'Dashboard Analytics',
    'Dashboard interactivo para análisis de datos con gráficos dinámicos, filtros avanzados y exportación de reportes. Desarrollado con JavaScript y Chart.js.',
    'https://github.com/usuario/dashboard',
    'https://demo.dashboard.com',
    'ejemplo3.jpg'
);

-- Índices para mejorar rendimiento
CREATE INDEX idx_proyectos_user_id ON proyectos(user_id);
CREATE INDEX idx_proyectos_created_at ON proyectos(created_at);
CREATE INDEX idx_users_username ON users(username);
