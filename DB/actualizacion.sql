ALTER TABLE `decora_transforma`.`detalles_factura` 
CHANGE COLUMN `precio` `precio_unitario` DECIMAL(15,2) NULL DEFAULT NULL AFTER `valor_descuento`,
ADD COLUMN `precio_total` DECIMAL(15,2) NULL DEFAULT NULL AFTER `precio_unitario`;