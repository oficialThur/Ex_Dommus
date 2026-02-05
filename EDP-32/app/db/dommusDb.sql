CREATE DATABASE IF NOT EXISTS dommus;

USE dommus;

CREATE TABLE IF NOT EXISTS imoveis (
    id INT AUTO_INCREMENT PRIMARY KEY,
    descricao VARCHAR(255) NOT NULL,
    preco DECIMAL(10, 2) NOT NULL,
    disponibilidade VARCHAR(50) NOT NULL
);

INSERT INTO imoveis (descricao, preco, disponibilidade) VALUES 
('Apartamento Centro', 300000.00, 'venda'),
('Casa de Praia', 450000.00, 'aluguel'),
('Kitnet Estudante', 120000.00, 'venda');