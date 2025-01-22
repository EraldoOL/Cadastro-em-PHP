CREATE DATABASE corretores_db;

USE corretores_db;

CREATE TABLE corretores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    cpf VARCHAR(11) NOT NULL,
    creci VARCHAR(20) NOT NULL
);