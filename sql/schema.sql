-- Database Schema for CD Riohacha Web App

-- Crear la base de datos si no existe
CREATE DATABASE IF NOT EXISTS cd_riohacha_db;
USE cd_riohacha_db;

-- Tabla de Usuarios (users)
CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    role ENUM('admin', 'user') DEFAULT 'user',
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_login TIMESTAMP NULL,
    INDEX idx_email (email),
    INDEX idx_role (role)
);

-- Insertar usuario admin inicial
-- Password: password (hash generado con PASSWORD_DEFAULT)
INSERT INTO users (email, password_hash, full_name, role) 
VALUES ('admin@cdriohacha.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrador CD Riohacha', 'admin')
ON DUPLICATE KEY UPDATE last_login = CURRENT_TIMESTAMP;

-- Tabla de Carrusel (carousel_items)
CREATE TABLE IF NOT EXISTS carousel_items (
    id INT PRIMARY KEY AUTO_INCREMENT,
    uploaded_by INT NOT NULL,
    file_path VARCHAR(500) NOT NULL,
    file_type ENUM('image', 'video') DEFAULT 'image',
    title VARCHAR(200),
    description TEXT,
    display_order INT DEFAULT 0,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (uploaded_by) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_active_order (is_active, display_order)
);

-- Tabla de Contenido (content_pages)
CREATE TABLE IF NOT EXISTS content_pages (
    id INT PRIMARY KEY AUTO_INCREMENT,
    page_name VARCHAR(50) UNIQUE NOT NULL,
    title VARCHAR(200),
    content TEXT,
    image_path VARCHAR(500),
    last_edited_by INT NOT NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (last_edited_by) REFERENCES users(id) ON DELETE CASCADE
);

-- Insertar páginas iniciales
INSERT INTO content_pages (page_name, title, content, last_edited_by) VALUES
('nosotros', 'Nosotros', 'Soluciones logísticas integrales para mejorar la eficiencia de tu operación. Monitorea, analiza y optimiza procesos clave para una gestión logística más ágil y efectiva.', 1),
('pilares', 'Nuestros Pilares', 'Conoce nuestros pilares fundamentales que garantizan una operación logística eficiente y segura.', 1)
ON DUPLICATE KEY UPDATE updated_at = CURRENT_TIMESTAMP;

-- Tabla de Pilares (pillar_info)
CREATE TABLE IF NOT EXISTS pillar_info (
    id INT PRIMARY KEY AUTO_INCREMENT,
    pillar_name VARCHAR(50) UNIQUE NOT NULL,
    title VARCHAR(100),
    description TEXT,
    icon_path VARCHAR(500),
    last_edited_by INT NOT NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (last_edited_by) REFERENCES users(id) ON DELETE CASCADE
);

-- Insertar pilares iniciales
INSERT INTO pillar_info (pillar_name, title, description, last_edited_by) VALUES
('flota', 'Flota', 'Gestión y monitoreo de la flota de transporte.', 1),
('warehouse', 'Warehouse', 'Control de inventario y almacenamiento.', 1),
('people', 'People', 'Gestión del talento humano.', 1),
('seguridad', 'Seguridad', 'Protocolos y KPIs de seguridad operativa.', 1),
('reparto', 'Reparto', 'Eficiencia en la distribución y entregas.', 1)
ON DUPLICATE KEY UPDATE updated_at = CURRENT_TIMESTAMP;

-- Tabla de KPIs (kpi_data)
CREATE TABLE IF NOT EXISTS kpi_data (
    id INT PRIMARY KEY AUTO_INCREMENT,
    kpi_name VARCHAR(100) NOT NULL,
    indicator VARCHAR(100),
    unit VARCHAR(20),
    trigger_condition VARCHAR(50),
    mtd_value DECIMAL(10,2),
    daily_values JSON,
    report_date DATE NOT NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_kpi_date (kpi_name, report_date)
);
