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

INSERT INTO tipos_persona (nombre, es_empleado)
VALUES
('Cliente', false),
('Vendedor', true),
('Instalador', true),
('Distribuidor', false);