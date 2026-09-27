CREATE DATABASE db_banco_adso;
USE db_banco_adso;

-- 1. Clientes
CREATE TABLE clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 2. Cuentas
CREATE TABLE cuentas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    numero_cuenta VARCHAR(50) NOT NULL UNIQUE,
    saldo DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    cliente_id INT NOT NULL,
    FOREIGN KEY (cliente_id) REFERENCES clientes(id) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 3. Usuarios (Acceso)
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cuenta_id INT NOT NULL UNIQUE,
    clave_hash VARCHAR(255) NOT NULL,
    FOREIGN KEY (cuenta_id) REFERENCES cuentas(id) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 4. Retiros
CREATE TABLE retiros (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cuenta_id INT NOT NULL,
    valor DECIMAL(12,2) NOT NULL,
    fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (cuenta_id) REFERENCES cuentas(id) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 5. Transferencias
CREATE TABLE transferencias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cuenta_origen_id INT NOT NULL,
    cuenta_destino_id INT NOT NULL,
    valor DECIMAL(12,2) NOT NULL,
    fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (cuenta_origen_id) REFERENCES cuentas(id) ON DELETE RESTRICT,
    FOREIGN KEY (cuenta_destino_id) REFERENCES cuentas(id) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



