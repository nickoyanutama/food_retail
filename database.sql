-- Active: 1686796371327@@127.0.0.1@3306@food_retail
CREATE DATABASE food_retail;
CREATE TABLE products (
    id INT NOT NULL AUTO_INCREMENT,
    qrcode VARCHAR(100) NOT NULL UNIQUE,
    name VARCHAR(255),
    price INT,
    discount FLOAT DEFAULT 0,
    is_expired BOOLEAN DEFAULT false,
    expired_at DATE,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at DATETIME,
    PRIMARY KEY (id)
    ) ENGINE = InnoDB;

INSERT INTO products(qrcode, name,price,expired_at)
VALUES('A0001','detergen',30000,'2024-08-05'),
('A0002','batrai',18000,'2024-08-05'),
('A0003','sabun cair',50000,'2024-08-05'),
('A0004','shampo',25000,'2024-08-05');

