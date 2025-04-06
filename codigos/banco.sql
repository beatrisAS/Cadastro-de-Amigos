CREATE DATABASE sistema_amigos;
USE sistema_amigos;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    senha VARCHAR(255)
);

CREATE TABLE amigos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100),
    email VARCHAR(100),
    telefone VARCHAR(20),
    observacoes TEXT,
    id_usuario INT,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
);
