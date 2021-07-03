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

INSERT INTO elementos (controlador)
VALUES
(
    'Departamento'
),
(
    'Municipio'
);

INSERT INTO permisos(elemento, nombre)
VALUES
(
    (SELECT id FROM elementos WHERE controlador = 'Departamento'),
    'Consulta de departamentos'
),
(
    (SELECT id FROM elementos WHERE controlador = 'Municipio'),
    'Consulta de municipios'
);

INSERT INTO acciones(nombre, valor, permiso)
VALUES
(
    'GET',
    true,
    (SELECT id FROM permisos WHERE nombre = 'Consulta de departamentos')
),
(
    'POST',
    false,
    (SELECT id FROM permisos WHERE nombre = 'Consulta de departamentos')
),
(
    'PUT',
    false,
    (SELECT id FROM permisos WHERE nombre = 'Consulta de departamentos')
),
(
    'DELETE',
    false,
    (SELECT id FROM permisos WHERE nombre = 'Consulta de departamentos')
),
(
    'GET',
    true,
    (SELECT id FROM permisos WHERE nombre = 'Consulta de municipios')
),
(
    'POST',
    false,
    (SELECT id FROM permisos WHERE nombre = 'Consulta de municipios')
),
(
    'PUT',
    false,
    (SELECT id FROM permisos WHERE nombre = 'Consulta de municipios')
),
(
    'DELETE',
    false,
    (SELECT id FROM permisos WHERE nombre = 'Consulta de municipios')
);

INSERT INTO permisos_x_tipos_usuario(permiso, tipo_usuario)
VALUES
(
    (SELECT id FROM permisos WHERE nombre = 'Consulta de departamentos'),
    (SELECT id FROM tipos_usuario WHERE nombre = 'Administrador')
),
(
    (SELECT id FROM permisos WHERE nombre = 'Consulta de municipios'),
    (SELECT id FROM tipos_usuario WHERE nombre = 'Administrador')
);