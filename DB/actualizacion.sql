ALTER TABLE `decora_transforma`.`detalles_factura` 
CHANGE COLUMN `precio` `precio_unitario` DECIMAL(15,2) NULL DEFAULT NULL AFTER `valor_descuento`,
ADD COLUMN `precio_total` DECIMAL(15,2) NULL DEFAULT NULL AFTER `precio_unitario`;

ALTER TABLE `decora_transforma`.`detalles_factura` 
CHANGE COLUMN `cantidad` `cantidad` DECIMAL(10,2) NULL DEFAULT 0 ,
CHANGE COLUMN `descripcion` `descripcion` VARCHAR(250) NULL DEFAULT 0 ,
CHANGE COLUMN `porcentaje_descuento` `porcentaje_descuento` DECIMAL(10,2) NULL DEFAULT 0 ,
CHANGE COLUMN `valor_descuento` `valor_descuento` DECIMAL(15,2) NULL DEFAULT 0 ,
CHANGE COLUMN `precio_unitario` `precio_unitario` DECIMAL(15,2) NULL DEFAULT 0 ,
CHANGE COLUMN `precio_total` `precio_total` DECIMAL(15,2) NULL DEFAULT 0 ;