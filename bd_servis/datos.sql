-- Crear la base de datos "prueba"
CREATE DATABASE IF NOT EXISTS prueba;

-- Usar la base de datos "prueba"
USE prueba;

-- Crear la tabla "alumnos"
CREATE TABLE IF NOT EXISTS alumnos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    apellidos VARCHAR(200),
    nombres VARCHAR(200),
    dni INT(11)
);

-- Insertar registros en la tabla "alumnos"
INSERT INTO alumnos (id, apellidos, nombres, dni, nota) VALUES
    (1, 'García', 'Juan', 345678901, 8),
    (2, 'López', 'María', 456789012, 9),
    (3, 'Martínez', 'Carlos', 367890123, 10);