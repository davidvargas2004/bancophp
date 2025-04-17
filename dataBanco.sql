
-- mysql -u root -p 
-- password es enter

-- o simplemente importo la copia que esta en la carpeta

CREATE DATABASE banco_hbc;
USE banco_hbc;

CREATE TABLE cuentas (
    id INT PRIMARY KEY AUTO_INCREMENT,
    numero_cuenta BIGINT NOT NULL,
    nombre_cliente VARCHAR(100) NOT NULL,
    tipo_cuenta ENUM('ahorros', 'corriente') NOT NULL,
    saldo DECIMAL(12,2) NOT NULL,
    interes_mensual DECIMAL(5,2) DEFAULT NULL
);
