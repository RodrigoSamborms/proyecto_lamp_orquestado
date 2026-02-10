CREATE TABLE IF NOT EXISTS personas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    activo TINYINT(1) DEFAULT 1
);

INSERT INTO personas (nombre, activo) VALUES ('Usuario Inicial', 1), ('Prueba Docker', 1);
