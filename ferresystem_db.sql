-- ================================
--   BASE COMPLETA FerreSystem
-- ================================

CREATE DATABASE IF NOT EXISTS ferresystem_db
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE ferresystem_db;

---------------------------------------------------
-- TABLAS DE USUARIOS / ROLES / FUNCIONES
---------------------------------------------------

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(120) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) UNIQUE NOT NULL,
    active TINYINT(1) DEFAULT 1
);

CREATE TABLE functions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) UNIQUE NOT NULL,
    active TINYINT(1) DEFAULT 1
);

CREATE TABLE user_role (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    role_id INT NOT NULL,
    active TINYINT(1) DEFAULT 1,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE
);

CREATE TABLE role_function (
    id INT AUTO_INCREMENT PRIMARY KEY,
    role_id INT NOT NULL,
    function_id INT NOT NULL,
    active TINYINT(1) DEFAULT 1,
    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE,
    FOREIGN KEY (function_id) REFERENCES functions(id) ON DELETE CASCADE
);

---------------------------------------------------
-- TABLAS DE FERRETERÍA
---------------------------------------------------

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    active TINYINT(1) DEFAULT 1
);

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT,
    name VARCHAR(150) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    description TEXT,
    image_url VARCHAR(255),
    active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
);

CREATE TABLE inventory (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 0,
    last_update TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

---------------------------------------------------
-- NUEVA TABLA: KARDEX
---------------------------------------------------

CREATE TABLE kardex (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    tipo ENUM('Entrada','Salida','Ajuste') NOT NULL,
    cantidad INT NOT NULL,
    stock_anterior INT NOT NULL,
    stock_nuevo INT NOT NULL,
    descripcion VARCHAR(255),
    usuario VARCHAR(100) NOT NULL,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id)
);

---------------------------------------------------
-- TABLAS DE CARRITO Y VENTAS
---------------------------------------------------

CREATE TABLE cart (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('active','completed') DEFAULT 'active',
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE cart_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cart_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (cart_id) REFERENCES cart(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

CREATE TABLE sales (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE sale_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sale_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (sale_id) REFERENCES sales(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

---------------------------------------------------
-- TABLAS NUEVAS: MÓDULO DE COMPRAS
---------------------------------------------------

CREATE TABLE purchases (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    total DECIMAL(10,2),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE purchase_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    purchase_id INT NOT NULL,
    product_id INT NOT NULL,
    qty INT NOT NULL,
    price DECIMAL(10,2),
    FOREIGN KEY (purchase_id) REFERENCES purchases(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

---------------------------------------------------
-- INSERTS INICIALES DEL SISTEMA
---------------------------------------------------

INSERT INTO roles (name) VALUES
('Administrador'),
('Vendedor'),
('Bodeguero');

INSERT INTO functions (name) VALUES
('Ver inventario'),
('Crear productos'),
('Editar productos'),
('Eliminar productos'),
('Ver usuarios'),
('Asignar roles'),
('Asignar funciones');

INSERT INTO users (name, email, password_hash) VALUES
('Admin Principal', 'admin@ferre.com', MD5('admin123'));

INSERT INTO user_role (user_id, role_id) VALUES (1, 1);

INSERT INTO role_function (role_id, function_id) VALUES
(1,1),(1,2),(1,3),(1,4),(1,5),(1,6),(1,7),
(2,1),(2,5),
(3,1);

---------------------------------------------------
-- INSERTS DE CATEGORÍAS
---------------------------------------------------

INSERT INTO categories (name) VALUES 
('Herramientas'),
('Electricidad'),
('Construcción'),
('Pinturas');

---------------------------------------------------
-- INSERTS DE PRODUCTOS
---------------------------------------------------

-- Herramientas
INSERT INTO products (category_id, name, price, description, image_url) VALUES
(1, 'Martillo de acero 16oz', 150.00, 'Cabeza reforzada y mango ergonómico', 'img/herr_martillo.jpg'),
(1, 'Destornillador Phillips #2', 75.00, 'Punta imantada de alta precisión', 'img/herr_destornillador.jpg'),
(1, 'Alicate universal 8"', 95.00, 'Fabricado en acero de alto carbono', 'img/herr_alicate.jpg'),
(1, 'Llave inglesa 10"', 120.00, 'Llave ajustable profesional', 'img/herr_llave.jpg'),

-- Electricidad
(2, 'Foco LED 12W', 55.00, 'Luz blanca 6500K, bajo consumo', 'img/elec_foco.jpg'),
(2, 'Interruptor sencillo', 35.00, 'Placa blanca estándar', 'img/elec_interruptor.jpg'),
(2, 'Tomacorriente doble', 45.00, 'Salida dual reforzada', 'img/elec_tomacorriente.jpg'),
(2, 'Cable eléctrico #12', 320.00, 'Rollo de 20 metros, aislado', 'img/elec_cable.jpg'),

-- Construcción
(3, 'Cemento gris 42kg', 240.00, 'Uso general para estructura', 'img/cons_cemento.jpg'),
(3, 'Arena fina 1m³', 550.00, 'Ideal para mezcla y repello', 'img/cons_arena.jpg'),
(3, 'Block sólido 15x20x40', 18.00, 'Block estructural reforzado', 'img/cons_block.jpg'),
(3, 'Varilla 3/8”', 145.00, 'Acero de refuerzo de alta resistencia', 'img/cons_varilla.jpg'),

-- Pinturas
(4, 'Pintura blanca 1 galón', 350.00, 'Acrílica, secado rápido', 'img/pint_blanca.jpg'),
(4, 'Pintura negra 1 galón', 360.00, 'Acabado mate profesional', 'img/pint_negra.jpg'),
(4, 'Thinner industrial', 120.00, 'Disolvente de alta pureza', 'img/pint_thinner.jpg'),
(4, 'Rodillo de pintura 9”', 85.00, 'Esponja premium para paredes', 'img/pint_rodillo.jpg');

---------------------------------------------------
-- INVENTARIO (1 A 16)
---------------------------------------------------

INSERT INTO inventory (product_id, quantity) VALUES
(1, 50),(2, 80),(3, 60),(4, 45),
(5, 120),(6, 150),(7, 90),(8, 40),
(9, 100),(10, 30),(11, 500),(12, 250),
(13, 25),(14, 20),(15, 75),(16, 60);











-- ================================
--   BASE COMPLETA FerreSystem
-- ================================

CREATE DATABASE IF NOT EXISTS ferresystem_db
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE ferresystem_db;

---------------------------------------------------
-- TABLAS DE USUARIOS / ROLES / FUNCIONES
---------------------------------------------------

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(120) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) UNIQUE NOT NULL,
    active TINYINT(1) DEFAULT 1
);

CREATE TABLE functions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) UNIQUE NOT NULL,
    active TINYINT(1) DEFAULT 1
);

CREATE TABLE user_role (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    role_id INT NOT NULL,
    active TINYINT(1) DEFAULT 1,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE
);

CREATE TABLE role_function (
    id INT AUTO_INCREMENT PRIMARY KEY,
    role_id INT NOT NULL,
    function_id INT NOT NULL,
    active TINYINT(1) DEFAULT 1,
    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE,
    FOREIGN KEY (function_id) REFERENCES functions(id) ON DELETE CASCADE
);

---------------------------------------------------
-- TABLAS DE FERRETERÍA
---------------------------------------------------

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    active TINYINT(1) DEFAULT 1
);

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT,
    name VARCHAR(150) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    description TEXT,
    image_url VARCHAR(255),
    active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
);

CREATE TABLE inventory (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 0,
    last_update TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

CREATE TABLE cart (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('active','completed') DEFAULT 'active',
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE cart_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cart_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (cart_id) REFERENCES cart(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

CREATE TABLE sales (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE sale_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sale_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (sale_id) REFERENCES sales(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

---------------------------------------------------
-- TABLAS NUEVAS: MÓDULO DE COMPRAS
---------------------------------------------------

CREATE TABLE purchases (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    total DECIMAL(10,2),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE purchase_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    purchase_id INT NOT NULL,
    product_id INT NOT NULL,
    qty INT NOT NULL,
    price DECIMAL(10,2),
    FOREIGN KEY (purchase_id) REFERENCES purchases(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

---------------------------------------------------
-- INSERTS INICIALES DEL SISTEMA
---------------------------------------------------

INSERT INTO roles (name) VALUES
('Administrador'),
('Vendedor'),
('Bodeguero');

INSERT INTO functions (name) VALUES
('Ver inventario'),
('Crear productos'),
('Editar productos'),
('Eliminar productos'),
('Ver usuarios'),
('Asignar roles'),
('Asignar funciones');

INSERT INTO users (name, email, password_hash) VALUES
('Admin Principal', 'admin@ferre.com', MD5('admin123'));

INSERT INTO user_role (user_id, role_id) VALUES (1, 1);

INSERT INTO role_function (role_id, function_id) VALUES
(1,1),(1,2),(1,3),(1,4),(1,5),(1,6),(1,7),
(2,1),(2,5),
(3,1);

---------------------------------------------------
-- INSERTS DE CATEGORÍAS
---------------------------------------------------

INSERT INTO categories (name) VALUES 
('Herramientas'),
('Electricidad'),
('Construcción'),
('Pinturas');

---------------------------------------------------
-- INSERTS DE PRODUCTOS
---------------------------------------------------

-- Herramientas
INSERT INTO products (category_id, name, price, description, image_url) VALUES
(1, 'Martillo de acero 16oz', 150.00, 'Cabeza reforzada y mango ergonómico', 'img/herr_martillo.jpg'),
(1, 'Destornillador Phillips #2', 75.00, 'Punta imantada de alta precisión', 'img/herr_destornillador.jpg'),
(1, 'Alicate universal 8"', 95.00, 'Fabricado en acero de alto carbono', 'img/herr_alicate.jpg'),
(1, 'Llave inglesa 10"', 120.00, 'Llave ajustable profesional', 'img/herr_llave.jpg'),

-- Electricidad
(2, 'Foco LED 12W', 55.00, 'Luz blanca 6500K, bajo consumo', 'img/elec_foco.jpg'),
(2, 'Interruptor sencillo', 35.00, 'Placa blanca estándar', 'img/elec_interruptor.jpg'),
(2, 'Tomacorriente doble', 45.00, 'Salida dual reforzada', 'img/elec_tomacorriente.jpg'),
(2, 'Cable eléctrico #12', 320.00, 'Rollo de 20 metros, aislado', 'img/elec_cable.jpg'),

-- Construcción
(3, 'Cemento gris 42kg', 240.00, 'Uso general para estructura', 'img/cons_cemento.jpg'),
(3, 'Arena fina 1m³', 550.00, 'Ideal para mezcla y repello', 'img/cons_arena.jpg'),
(3, 'Block sólido 15x20x40', 18.00, 'Block estructural reforzado', 'img/cons_block.jpg'),
(3, 'Varilla 3/8”', 145.00, 'Acero de refuerzo de alta resistencia', 'img/cons_varilla.jpg'),

-- Pinturas
(4, 'Pintura blanca 1 galón', 350.00, 'Acrílica, secado rápido', 'img/pint_blanca.jpg'),
(4, 'Pintura negra 1 galón', 360.00, 'Acabado mate profesional', 'img/pint_negra.jpg'),
(4, 'Thinner industrial', 120.00, 'Disolvente de alta pureza', 'img/pint_thinner.jpg'),
(4, 'Rodillo de pintura 9”', 85.00, 'Esponja premium para paredes', 'img/pint_rodillo.jpg');

---------------------------------------------------
-- INVENTARIO (1 A 16)
---------------------------------------------------

INSERT INTO inventory (product_id, quantity) VALUES
(1, 50),(2, 80),(3, 60),(4, 45),
(5, 120),(6, 150),(7, 90),(8, 40),
(9, 100),(10, 30),(11, 500),(12, 250),
(13, 25),(14, 20),(15, 75),(16, 60);
