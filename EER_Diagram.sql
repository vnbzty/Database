-- MySQL Script generated by MySQL Workbench
-- Wed May 25 21:28:08 2016
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `mydb` ;

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET utf8 ;
USE `mydb` ;

-- -----------------------------------------------------
-- Table `mydb`.`DEPARTMENT`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`DEPARTMENT` ;

CREATE TABLE IF NOT EXISTS `mydb`.`DEPARTMENT` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(20) NOT NULL,
  `EMPLOYEE_id` INT UNSIGNED NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_DEPARTMENT_EMPLOYEE1`
    FOREIGN KEY (`EMPLOYEE_id`)
    REFERENCES `mydb`.`EMPLOYEE` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE UNIQUE INDEX `id_UNIQUE` ON `mydb`.`DEPARTMENT` (`id` ASC);

CREATE INDEX `fk_DEPARTMENT_EMPLOYEE1_idx` ON `mydb`.`DEPARTMENT` (`EMPLOYEE_id` ASC);

CREATE UNIQUE INDEX `name_UNIQUE` ON `mydb`.`DEPARTMENT` (`name` ASC);


-- -----------------------------------------------------
-- Table `mydb`.`EMPLOYEE`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`EMPLOYEE` ;

CREATE TABLE IF NOT EXISTS `mydb`.`EMPLOYEE` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(20) NOT NULL,
  `password` VARCHAR(45) NOT NULL,
  `gender` CHAR(1) NOT NULL,
  `level` INT NULL,
  `id_card` CHAR(18) NOT NULL,
  `DEPARTMENT_id` INT UNSIGNED NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_EMPLOYEE_DEPARTMENT1`
    FOREIGN KEY (`DEPARTMENT_id`)
    REFERENCES `mydb`.`DEPARTMENT` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE UNIQUE INDEX `id_UNIQUE` ON `mydb`.`EMPLOYEE` (`id` ASC);

CREATE UNIQUE INDEX `id_card_UNIQUE` ON `mydb`.`EMPLOYEE` (`id_card` ASC);

CREATE INDEX `fk_EMPLOYEE_DEPARTMENT1_idx` ON `mydb`.`EMPLOYEE` (`DEPARTMENT_id` ASC);

CREATE UNIQUE INDEX `alias_UNIQUE` ON `mydb`.`EMPLOYEE` (`name` ASC);


-- -----------------------------------------------------
-- Table `mydb`.`CATAGORY`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`CATAGORY` ;

CREATE TABLE IF NOT EXISTS `mydb`.`CATAGORY` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(20) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

CREATE UNIQUE INDEX `id_UNIQUE` ON `mydb`.`CATAGORY` (`id` ASC);


-- -----------------------------------------------------
-- Table `mydb`.`SUPPLIER`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`SUPPLIER` ;

CREATE TABLE IF NOT EXISTS `mydb`.`SUPPLIER` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` CHAR(8) NOT NULL,
  `address` VARCHAR(20) NOT NULL,
  `phone_number` VARCHAR(15) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

CREATE UNIQUE INDEX `id_UNIQUE` ON `mydb`.`SUPPLIER` (`id` ASC);

CREATE UNIQUE INDEX `name_UNIQUE` ON `mydb`.`SUPPLIER` (`name` ASC);


-- -----------------------------------------------------
-- Table `mydb`.`GOODS`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`GOODS` ;

CREATE TABLE IF NOT EXISTS `mydb`.`GOODS` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(20) NOT NULL,
  `prize` INT NOT NULL,
  `amount` INT NOT NULL,
  `EMPLOYEE_id` INT UNSIGNED NOT NULL,
  `CATAGORY_id` INT UNSIGNED NULL,
  `SUPPLIER_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_GOODS_EMPLOYEE1`
    FOREIGN KEY (`EMPLOYEE_id`)
    REFERENCES `mydb`.`EMPLOYEE` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_GOODS_CATAGORY1`
    FOREIGN KEY (`CATAGORY_id`)
    REFERENCES `mydb`.`CATAGORY` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_GOODS_SUPPLIER1`
    FOREIGN KEY (`SUPPLIER_id`)
    REFERENCES `mydb`.`SUPPLIER` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE UNIQUE INDEX `id_UNIQUE` ON `mydb`.`GOODS` (`id` ASC);

CREATE INDEX `fk_GOODS_EMPLOYEE1_idx` ON `mydb`.`GOODS` (`EMPLOYEE_id` ASC);

CREATE INDEX `fk_GOODS_CATAGORY1_idx` ON `mydb`.`GOODS` (`CATAGORY_id` ASC);

CREATE INDEX `fk_GOODS_SUPPLIER1_idx` ON `mydb`.`GOODS` (`SUPPLIER_id` ASC);

CREATE UNIQUE INDEX `name_UNIQUE` ON `mydb`.`GOODS` (`name` ASC);


-- -----------------------------------------------------
-- Table `mydb`.`MEMBERSHIP`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`MEMBERSHIP` ;

CREATE TABLE IF NOT EXISTS `mydb`.`MEMBERSHIP` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `total_cost` INT NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

CREATE UNIQUE INDEX `id_UNIQUE` ON `mydb`.`MEMBERSHIP` (`id` ASC);


-- -----------------------------------------------------
-- Table `mydb`.`CONSUMER`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`CONSUMER` ;

CREATE TABLE IF NOT EXISTS `mydb`.`CONSUMER` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(20) NOT NULL,
  `password` VARCHAR(45) NOT NULL,
  `gender` CHAR(1) NULL,
  `MEMBERSHIP_id` INT UNSIGNED NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_CONSUMER_MEMBERSHIP1`
    FOREIGN KEY (`MEMBERSHIP_id`)
    REFERENCES `mydb`.`MEMBERSHIP` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE UNIQUE INDEX `id_UNIQUE` ON `mydb`.`CONSUMER` (`id` ASC);

CREATE INDEX `fk_CONSUMER_MEMBERSHIP1_idx` ON `mydb`.`CONSUMER` (`MEMBERSHIP_id` ASC);

CREATE UNIQUE INDEX `alias_UNIQUE` ON `mydb`.`CONSUMER` (`name` ASC);


-- -----------------------------------------------------
-- Table `mydb`.`TRANSACTION`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`TRANSACTION` ;

CREATE TABLE IF NOT EXISTS `mydb`.`TRANSACTION` (
  `number` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `date` DATETIME NOT NULL,
  `total_prize` INT NOT NULL,
  `CONSUMER_id` INT UNSIGNED NOT NULL,
  `EMPLOYEE_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`number`),
  CONSTRAINT `fk_TRANSACTION_CONSUMER1`
    FOREIGN KEY (`CONSUMER_id`)
    REFERENCES `mydb`.`CONSUMER` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_TRANSACTION_EMPLOYEE1`
    FOREIGN KEY (`EMPLOYEE_id`)
    REFERENCES `mydb`.`EMPLOYEE` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE UNIQUE INDEX `number_UNIQUE` ON `mydb`.`TRANSACTION` (`number` ASC);

CREATE INDEX `fk_TRANSACTION_CONSUMER1_idx` ON `mydb`.`TRANSACTION` (`CONSUMER_id` ASC);

CREATE INDEX `fk_TRANSACTION_EMPLOYEE1_idx` ON `mydb`.`TRANSACTION` (`EMPLOYEE_id` ASC);


-- -----------------------------------------------------
-- Table `mydb`.`TRANSACTION_DETAIL`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`TRANSACTION_DETAIL` ;

CREATE TABLE IF NOT EXISTS `mydb`.`TRANSACTION_DETAIL` (
  `amount` INT UNSIGNED NOT NULL,
  `unit_prize` INT NOT NULL,
  `total_prize` INT NOT NULL,
  `TRANSACTION_number` INT UNSIGNED NOT NULL,
  `GOODS_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`TRANSACTION_number`, `GOODS_id`),
  CONSTRAINT `fk_TRANSACTION_DETAIL_TRANSACTION1`
    FOREIGN KEY (`TRANSACTION_number`)
    REFERENCES `mydb`.`TRANSACTION` (`number`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_TRANSACTION_DETAIL_GOODS1`
    FOREIGN KEY (`GOODS_id`)
    REFERENCES `mydb`.`GOODS` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_TRANSACTION_DETAIL_GOODS1_idx` ON `mydb`.`TRANSACTION_DETAIL` (`GOODS_id` ASC);


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
