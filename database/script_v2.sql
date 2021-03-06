-- MySQL Script generated by MySQL Workbench
-- dim. 22 déc. 2019 18:14:53 CET
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema 4c
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema 4c
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `4c` DEFAULT CHARACTER SET utf8 ;
USE `4c` ;

-- -----------------------------------------------------
-- Table `4c`.`user`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `4c`.`user` ;

CREATE TABLE IF NOT EXISTS `4c`.`user` (
  `id_user` INT(11) NOT NULL,
  `firstname` VARCHAR(45) NOT NULL,
  `lastname` VARCHAR(45) NULL,
  `email` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `roles` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id_user`))
AUTO_INCREMENT = 1;


-- -----------------------------------------------------
-- Table `4c`.`todo_list`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `4c`.`todo_list` ;

CREATE TABLE IF NOT EXISTS `4c`.`todo_list` (
  `id_list` INT NOT NULL AUTO_INCREMENT COMMENT '	',
  `user` INT(11) NOT NULL,
  `listname` VARCHAR(45) NULL,
  `createDate` DATE NOT NULL,
  `dueDate` DATE NULL,
  `description` VARCHAR(500) NULL,
  PRIMARY KEY (`id_list`),
  INDEX `fk_list_user1_idx` (`user` ASC),
  CONSTRAINT `fk_list_user1`
    FOREIGN KEY (`user`)
    REFERENCES `4c`.`user` (`id_user`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 1;


-- -----------------------------------------------------
-- Table `4c`.`task`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `4c`.`task` ;

CREATE TABLE IF NOT EXISTS `4c`.`task` (
  `id_task` INT NOT NULL AUTO_INCREMENT,
  `todo_list` INT NOT NULL,
  `taskname` VARCHAR(45) NULL,
  `user` INT(11) NOT NULL,
  `createDate` DATE NOT NULL,
  `dueDate` DATE NULL,
  `description` VARCHAR(500) NULL,
  PRIMARY KEY (`id_task`),
  INDEX `fk_task_list_idx` (`todo_list` ASC),
  INDEX `fk_task_user1_idx` (`user` ASC),
  CONSTRAINT `fk_task_list`
    FOREIGN KEY (`todo_list`)
    REFERENCES `4c`.`todo_list` (`id_list`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_task_user1`
    FOREIGN KEY (`user`)
    REFERENCES `4c`.`user` (`id_user`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 1;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
