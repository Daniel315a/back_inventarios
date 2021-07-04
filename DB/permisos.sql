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
    'TipoDocumento'
),
(
    'Persona'
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
    (SELECT id FROM elementos WHERE controlador = 'TipoDocumento'),
    'Gestionar tipos documentos'
),
(
    (SELECT id FROM elementos WHERE controlador = 'Persona'),
    'Gestionar personas'
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
    (SELECT id FROM permisos WHERE nombre = 'Gestionar tipos documentos')
),
(
    'POST',
    true,
    (SELECT id FROM permisos WHERE nombre = 'Gestionar tipos documentos')
),
(
    'PUT',
    true,
    (SELECT id FROM permisos WHERE nombre = 'Gestionar tipos documentos')
),
(
    'DELETE',
    true,
    (SELECT id FROM permisos WHERE nombre = 'Gestionar tipos documentos')
),
(
    'GET',
    true,
    (SELECT id FROM permisos WHERE nombre = 'Gestionar personas')
),
(
    'POST',
    true,
    (SELECT id FROM permisos WHERE nombre = 'Gestionar personas')
),
(
    'PUT',
    true,
    (SELECT id FROM permisos WHERE nombre = 'Gestionar personas')
),
(
    'DELETE',
    true,
    (SELECT id FROM permisos WHERE nombre = 'Gestionar personas')
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
    (SELECT id FROM permisos WHERE nombre = 'Gestionar tipos documentos'),
    (SELECT id FROM tipos_usuario WHERE nombre = 'Administrador')
),
(
    (SELECT id FROM permisos WHERE nombre = 'Gestionar personas'),
    (SELECT id FROM tipos_usuario WHERE nombre = 'Administrador')
);