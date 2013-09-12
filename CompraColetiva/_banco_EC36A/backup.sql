SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `compracoletiva` DEFAULT CHARACTER SET latin1 ;
USE `compracoletiva` ;

-- -----------------------------------------------------
-- Table `compracoletiva`.`usuario`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `compracoletiva`.`usuario` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `nome` VARCHAR(200) NULL ,
  `sobrenome` VARCHAR(200) NULL ,
  `sexo` CHAR(1) NULL ,
  `nascimento` DATE NULL ,
  `login` VARCHAR(200) NULL ,
  `senha` VARCHAR(255) NULL ,
  `tipo` CHAR(1) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `compracoletiva`.`estado`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `compracoletiva`.`estado` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `uf` VARCHAR(10) NULL ,
  `nome` VARCHAR(20) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `compracoletiva`.`cidade`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `compracoletiva`.`cidade` (
  `id` INT(4) NOT NULL AUTO_INCREMENT ,
  `estado` INT(2) NULL ,
  `uf` VARCHAR(4) NULL ,
  `nome` VARCHAR(50) NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_cidade_estado1_idx` (`estado` ASC) ,
  CONSTRAINT `fk_cidade_estado1`
    FOREIGN KEY (`estado` )
    REFERENCES `compracoletiva`.`estado` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `compracoletiva`.`endereco`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `compracoletiva`.`endereco` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `cidade_id` INT(11) NOT NULL ,
  `logradouro` VARCHAR(200) NULL ,
  `numero` VARCHAR(45) NULL ,
  `complemento` VARCHAR(100) NULL ,
  `bairro` VARCHAR(100) NULL ,
  `tp_endereco` VARCHAR(45) NULL ,
  `usuario_id` INT(11) NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_endereco_cidade1_idx` (`cidade_id` ASC) ,
  INDEX `fk_endereco_usuario1_idx` (`usuario_id` ASC) ,
  CONSTRAINT `fk_endereco_cidade1`
    FOREIGN KEY (`cidade_id` )
    REFERENCES `compracoletiva`.`cidade` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_endereco_usuario1`
    FOREIGN KEY (`usuario_id` )
    REFERENCES `compracoletiva`.`usuario` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `compracoletiva`.`oferta`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `compracoletiva`.`oferta` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `nome` VARCHAR(200) NULL ,
  `descricao` TEXT NULL ,
  `data_inicio` DATETIME NULL ,
  `data_fim` DATETIME NULL ,
  `qtd_minima` INT NULL ,
  `qtd_vendida` INT NULL ,
  `valor_real` VARCHAR(45) NULL ,
  `valor_liquido` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `compracoletiva`.`recursos`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `compracoletiva`.`recursos` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `oferta_id` INT(11) NULL ,
  `nome` VARCHAR(200) NULL ,
  `descricao` VARCHAR(200) NULL ,
  `url` VARCHAR(255) NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_recursos_oferta1_idx` (`oferta_id` ASC) ,
  CONSTRAINT `fk_recursos_oferta1`
    FOREIGN KEY (`oferta_id` )
    REFERENCES `compracoletiva`.`oferta` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `compracoletiva`.`venda`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `compracoletiva`.`venda` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `oferta_id` INT(11) NULL ,
  `usuario_id` INT(11) NULL ,
  `data` DATETIME NULL ,
  `status` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_venda_oferta_idx` (`oferta_id` ASC) ,
  INDEX `fk_venda_usuario1_idx` (`usuario_id` ASC) ,
  CONSTRAINT `fk_venda_oferta`
    FOREIGN KEY (`oferta_id` )
    REFERENCES `compracoletiva`.`oferta` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_venda_usuario1`
    FOREIGN KEY (`usuario_id` )
    REFERENCES `compracoletiva`.`usuario` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

USE `compracoletiva` ;

-- -----------------------------------------------------
-- procedure atualizaTempo
-- -----------------------------------------------------

DELIMITER $$
USE `compracoletiva`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `atualizaTempo`()
BEGIN
  UPDATE oferta SET data_fim = data_fim - INTERVAL 1 SECOND WHERE id = 2 LIMIT 1;
END$$

DELIMITER ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
