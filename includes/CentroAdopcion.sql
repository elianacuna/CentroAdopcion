CREATE DATABASE IF NOT EXISTS CentroAdopcion;

USE CentroAdopcion;

CREATE TABLE propietario (
    id_propietario INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(200) NOT NULL,
    direccion TEXT NOT NULL,
    telefono VARCHAR(11) UNIQUE,
    correo VARCHAR(255) UNIQUE
);

CREATE TABLE mascota (
    id_mascota INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(200) NOT NULL,
    tipo TEXT NOT NULL,
    edad INT,
    adoptado VARCHAR(2)
);

CREATE TABLE empleado (
    id_empleado INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(200) NOT NULL,
    cargo VARCHAR(100) NOT NULL,
    telefono VARCHAR(11) UNIQUE,
    correo VARCHAR(200) UNIQUE
);

CREATE TABLE adopcion (
    id_adopcion INTEGER PRIMARY KEY AUTO_INCREMENT,
    fk_id_propietario INT,
    fk_id_mascota INT,
    fk_id_empleado INT,
    fecha_adopcion DATE NOT NULL,
    FOREIGN KEY (fk_id_propietario) REFERENCES propietario(id_propietario),
    FOREIGN KEY (fk_id_mascota) REFERENCES mascota(id_mascota),
    FOREIGN KEY (fk_id_empleado) REFERENCES empleado(id_empleado)
);