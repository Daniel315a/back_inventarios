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
),
(
    'TipoDocumento'
),
(
    'Persona'
),
(
    'Factura'
),
(
    'Remision'
),
(
    'DetalleDevolucion'
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
),
(
    (SELECT id FROM elementos WHERE controlador = 'TipoDocumento'),
    'Gestionar tipos documentos'
),
(
    (SELECT id FROM elementos WHERE controlador = 'Persona'),
    'Gestionar personas'
),
(
    (SELECT id FROM elementos WHERE controlador = 'Factura'),
    'Gestionar facturas'
),
(
    (SELECT id FROM elementos WHERE controlador = 'Remision'),
    'Gestionar remisiones'
),
(
    (SELECT id FROM elementos WHERE controlador = 'DetalleDevolucion'),
    'Gestionar detalles de devoluciones'
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
    true,
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
    false,
    (SELECT id FROM permisos WHERE nombre = 'Gestionar tipos documentos')
),
(
    'DELETE',
    false,
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
    false,
    (SELECT id FROM permisos WHERE nombre = 'Gestionar personas')
),
(
    'DELETE',
    false,
    (SELECT id FROM permisos WHERE nombre = 'Gestionar personas')
),
(
    'GET',
    true,
    (SELECT id FROM permisos WHERE nombre = 'Gestionar facturas')
),
(
    'POST',
    true,
    (SELECT id FROM permisos WHERE nombre = 'Gestionar facturas')
),
(
    'PUT',
    false,
    (SELECT id FROM permisos WHERE nombre = 'Gestionar facturas')
),
(
    'DELETE',
    false,
    (SELECT id FROM permisos WHERE nombre = 'Gestionar facturas')
),
(
    'GET',
    true,
    (SELECT id FROM permisos WHERE nombre = 'Gestionar remisiones')
),
(
    'POST',
    true,
    (SELECT id FROM permisos WHERE nombre = 'Gestionar remisiones')
),
(
    'PUT',
    false,
    (SELECT id FROM permisos WHERE nombre = 'Gestionar remisiones')
),
(
    'DELETE',
    false,
    (SELECT id FROM permisos WHERE nombre = 'Gestionar remisiones')
),
(
    'GET',
    true,
    (SELECT id FROM permisos WHERE nombre = 'Gestionar detalles de devoluciones')
),
(
    'POST',
    true,
    (SELECT id FROM permisos WHERE nombre = 'Gestionar detalles de devoluciones')
),
(
    'PUT',
    false,
    (SELECT id FROM permisos WHERE nombre = 'Gestionar detalles de devoluciones')
),
(
    'DELETE',
    false,
    (SELECT id FROM permisos WHERE nombre = 'Gestionar detalles de devoluciones')
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
),
(
    (SELECT id FROM permisos WHERE nombre = 'Gestionar tipos documentos'),
    (SELECT id FROM tipos_usuario WHERE nombre = 'Administrador')
),
(
    (SELECT id FROM permisos WHERE nombre = 'Gestionar personas'),
    (SELECT id FROM tipos_usuario WHERE nombre = 'Administrador')
),
(
    (SELECT id FROM permisos WHERE nombre = 'Gestionar facturas'),
    (SELECT id FROM tipos_usuario WHERE nombre = 'Administrador')
),
(
    (SELECT id FROM permisos WHERE nombre = 'Gestionar remisiones'),
    (SELECT id FROM tipos_usuario WHERE nombre = 'Administrador')
),
(
    (SELECT id FROM permisos WHERE nombre = 'Gestionar detalles de devoluciones'),
    (SELECT id FROM tipos_usuario WHERE nombre = 'Administrador')
);



-- Permisos para gestión de prestamos.

INSERT INTO elementos (controlador)
VALUES
(
    'Prestamo'
);

INSERT INTO permisos(elemento, nombre)
VALUES
(
    (SELECT id FROM elementos WHERE controlador = 'Prestamo'),
    'Gestion de prestamos'
);

INSERT INTO acciones(nombre, valor, permiso)
VALUES
(
    'GET',
    true,
    (SELECT id FROM permisos WHERE nombre = 'Gestion de prestamos')
),
(
    'POST',
    true,
    (SELECT id FROM permisos WHERE nombre = 'Gestion de prestamos')
);

INSERT INTO permisos_x_tipos_usuario(permiso, tipo_usuario)
VALUES
(
    (SELECT id FROM permisos WHERE nombre = 'Gestion de prestamos'),
    (SELECT id FROM tipos_usuario WHERE nombre = 'Administrador')
);


-- Permisos para gestión de cotizaciones.

INSERT INTO elementos (controlador)
VALUES
(
    'Cotizacion'
);

INSERT INTO permisos(elemento, nombre)
VALUES
(
    (SELECT id FROM elementos WHERE controlador = 'Cotizacion'),
    'Gestion de cotizaciones'
);

INSERT INTO acciones(nombre, valor, permiso)
VALUES
(
    'GET',
    true,
    (SELECT id FROM permisos WHERE nombre = 'Gestion de cotizaciones')
),
(
    'POST',
    true,
    (SELECT id FROM permisos WHERE nombre = 'Gestion de cotizaciones')
);

INSERT INTO permisos_x_tipos_usuario(permiso, tipo_usuario)
VALUES
(
    (SELECT id FROM permisos WHERE nombre = 'Gestion de cotizaciones'),
    (SELECT id FROM tipos_usuario WHERE nombre = 'Administrador')
);

/*
 * Esta línea siempre debe ir al final
 */

UPDATE permisos SET acceso_denegado = false WHERE id > 0;