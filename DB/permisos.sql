DELETE FROM acciones WHERE id > 0;
DELETE FROM permisos_x_tipos_usuario WHERE permiso > 0;
DELETE FROM permisos WHERE id > 0;
DELETE FROM elementos WHERE id > 0;

INSERT INTO elementos (controlador)
VALUES
(
    'Departamento'
),
(
    'Municipio'
),
(
    'TipoPersona'
),
(
    'Producto'
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
),
(
    (SELECT id FROM elementos WHERE controlador = 'TipoPersona'),
    'Consultar tipos de persona'
),
(
    (SELECT id FROM elementos WHERE controlador = 'Producto'),
    'Administrar productos'
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
),
(
    'GET',
    true,
    (SELECT id FROM permisos WHERE nombre = 'Consultar tipos de persona')
),
(
    'POST',
    false,
    (SELECT id FROM permisos WHERE nombre = 'Consultar tipos de persona')
),
(
    'PUT',
    false,
    (SELECT id FROM permisos WHERE nombre = 'Consultar tipos de persona')
),
(
    'DELETE',
    false,
    (SELECT id FROM permisos WHERE nombre = 'Consultar tipos de persona')
),
(
    'GET',
    true,
    (SELECT id FROM permisos WHERE nombre = 'Administrar productos')
),
(
    'POST',
    false,
    (SELECT id FROM permisos WHERE nombre = 'Administrar productos')
),
(
    'PUT',
    false,
    (SELECT id FROM permisos WHERE nombre = 'Administrar productos')
),
(
    'DELETE',
    false,
    (SELECT id FROM permisos WHERE nombre = 'Administrar productos')
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
),
(
    (SELECT id FROM permisos WHERE nombre = 'Consultar tipos de persona'),
    (SELECT id FROM tipos_usuario WHERE nombre = 'Administrador')
),
(
    (SELECT id FROM permisos WHERE nombre = 'Administrar productos'),
    (SELECT id FROM tipos_usuario WHERE nombre = 'Administrador')
);