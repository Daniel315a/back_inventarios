INSERT INTO empresas (nombre)
VALUES ('Decora y transforma');

INSERT INTO tipos_usuario (nombre)
VALUES ('Administrador');

INSERT INTO usuarios (tipo_usuario, nombre, contrasenna, token, empresa)
VALUES 
(
    (SELECT id FROM tipos_usuario WHERE nombre = 'Administrador'),
    'Administrador',
    -- a
    '0cc175b9c0f1b6a831c399e269772661',
    '05b752f8270b4de3a5de314fe6ba0663',
    (SELECT id FROM empresas WHERE nombre = 'Decora y transforma')
);

INSERT INTO tipos_persona (id, nombre, es_empleado)
VALUES
(1, 'Cliente', false),
(2, 'Vendedor', true),
(3, 'Instalador', true),
(4, 'Distribuidor', false);

INSERT INTO tipos_documento (nombre)
VALUES
('Cédula de ciudadanía');