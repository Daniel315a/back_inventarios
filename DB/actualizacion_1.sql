-- Se deben eliminar las cotizaciones antes

ALTER TABLE `appdecor_inventarios`.`cotizaciones`
ADD COLUMN `usuario` INT NOT NULL AFTER `fecha`,
ADD INDEX `fk_cotizaciones_usuarios1_idx` (`usuario` ASC);

ALTER TABLE `appdecor_inventarios`.`cotizaciones` 
ADD CONSTRAINT `fk_cotizaciones_usuarios1`
  FOREIGN KEY (`usuario`)
  REFERENCES `appdecor_inventarios`.`usuarios` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `appdecor_inventarios`.`usuarios` 
ADD COLUMN `persona` INT NULL AFTER `empresa`,
ADD INDEX `fk_usuarios_personas1_idx` (`persona` ASC);

ALTER TABLE `appdecor_inventarios`.`usuarios` 
ADD CONSTRAINT `fk_usuarios_personas1`
  FOREIGN KEY (`persona`)
  REFERENCES `appdecor_inventarios`.`personas` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;