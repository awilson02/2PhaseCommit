-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET utf8 ;
USE `mydb` ;

-- -----------------------------------------------------
-- Table `mydb`.`parts543`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Xparts543` (
    `XpartNo543` VARCHAR(5) NOT NULL,
    `XpartName543` VARCHAR(20) NOT NULL,
    `XpartDescription543` VARCHAR(45) NULL,
    `XcurrentPrice543` DOUBLE NOT NULL,
    `XQoH543` INT NOT NULL,
    PRIMARY KEY (`XpartNo543`),
    UNIQUE INDEX `partNo_UNIQUE` (`XpartNo543` ASC) )
    ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`clients543`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Xclients543` (
    `XclientId543` VARCHAR(5) NOT NULL,
    `XclientName543` VARCHAR(45) NOT NULL,
    `XclientCity543` VARCHAR(45) NOT NULL,
    `XclientCompPassword543` VARCHAR(45) NOT NULL,
    `XmoneyOwed543` DOUBLE NULL,
    `XclientStatus543` VARCHAR(45) NULL,
    PRIMARY KEY (`XclientId543`))
    ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`pos543`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Xpos543` (
    `XpoNo543` VARCHAR(5) NOT NULL,
    `XdataPO543` DATETIME NOT NULL,
    `Xstatus543` VARCHAR(45) NOT NULL,
    `XclientId543` VARCHAR(5) NOT NULL,
    PRIMARY KEY (`XpoNo543`),
    INDEX `fk_pos543_clients5431_idx` (`XclientId543` ASC) ,
    CONSTRAINT `fk_Xpos543_Xclients5431`
    FOREIGN KEY (`XclientId543`)
    REFERENCES `mydb`.`Xclients543` (`XclientId543`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
    ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`lines543`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Xlines543` (
    `XpartNo543` VARCHAR(5) NOT NULL,
    `XlineNum543` VARCHAR(5) NOT NULL,
    `XpoNo543` VARCHAR(5) NOT NULL,
    `Xprice543` DOUBLE NULL,
    `Xquantity543` INT NULL,
    INDEX `fk_lines_Xparts5431_idx` (`XpartNo543` ASC) ,
    PRIMARY KEY (`XlineNum543`, `XpoNo543`),
    INDEX `fk_lines_Xpos5431_idx` (`XpoNo543` ASC) ,
    CONSTRAINT `fk_lines_Xparts5431`
    FOREIGN KEY (`XpartNo543`)
    REFERENCES `mydb`.`Xparts543` (`XpartNo543`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
    CONSTRAINT `fk_lines_Xpos5431`
    FOREIGN KEY (`XpoNo543`)
    REFERENCES `mydb`.`Xpos543` (`XpoNo543`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
    ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;






-- -----------------------------------------------------
-- Table `mydb`.`parts543`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Yparts543` (
    `YpartNo543` VARCHAR(5) NOT NULL,
    `YpartName543` VARCHAR(20) NOT NULL,
    `YpartDescription543` VARCHAR(45) NULL,
    `YcurrentPrice543` DOUBLE NOT NULL,
    `YQoH543` INT NOT NULL,
    PRIMARY KEY (`YpartNo543`),
    UNIQUE INDEX `partNo_UNIQUE` (`YpartNo543` ASC) )
    ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`clients543`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Yclients543` (
    `YclientId543` VARCHAR(5) NOT NULL,
    `YclientName543` VARCHAR(45) NOT NULL,
    `YclientCity543` VARCHAR(45) NOT NULL,
    `YclientCompPassword543` VARCHAR(45) NOT NULL,
    `YmoneyOwed543` DOUBLE NULL,
    `YclientStatus543` VARCHAR(45) NULL,
    PRIMARY KEY (`YclientId543`))
    ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`pos543`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Ypos543` (
    `YpoNo543` VARCHAR(5) NOT NULL,
    `YdataPO543` DATETIME NOT NULL,
    `Ystatus543` VARCHAR(45) NOT NULL,
    `YclientId543` VARCHAR(5) NOT NULL,
    PRIMARY KEY (`YpoNo543`),
    INDEX `fk_Ypos543_Yclients5431_idx` (`YclientId543` ASC) ,
    CONSTRAINT `fk_Ypos543_Yclients5431`
    FOREIGN KEY (`YclientId543`)
    REFERENCES `mydb`.`Yclients543` (`YclientId543`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
    ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`lines543`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Ylines543` (
    `YpartNo543` VARCHAR(5) NOT NULL,
    `YlineNum543` VARCHAR(5) NOT NULL,
    `YpoNo543` VARCHAR(5) NOT NULL,
    `Yprice543` DOUBLE NULL,
    `Yquantity543` INT NULL,
    INDEX `fk_lines_Yparts5431_idx` (`YpartNo543` ASC) ,
    PRIMARY KEY (`YlineNum543`, `YpoNo543`),
    INDEX `fk_lines_Ypos5431_idx` (`YpoNo543` ASC) ,
    CONSTRAINT `fk_lines_Yparts5431`
    FOREIGN KEY (`YpartNo543`)
    REFERENCES `mydb`.`Yparts543` (`YpartNo543`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
    CONSTRAINT `fk_lines_pos5431`
    FOREIGN KEY (`YpoNo543`)
    REFERENCES `mydb`.`Ypos543` (`YpoNo543`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
    ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;



-- -----------------------------------------------------
-- Z
-- Table `mydb`.`clients543`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Zclients543` (
    `ZclientId543` VARCHAR(5) NOT NULL,
    `ZclientName543` VARCHAR(45) NOT NULL,
    `ZclientCity543` VARCHAR(45) NOT NULL,
    `ZclientCompPassword543` VARCHAR(45) NOT NULL,
    `ZmoneyOwed543` DOUBLE NULL,
    `ZclientStatus543` VARCHAR(45) NULL,
    PRIMARY KEY (`ZclientId543`))
    ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`pos543`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Zpos543` (
    `ZpoNo543` VARCHAR(5) NOT NULL,
    `ZdataPO543` DATETIME NOT NULL,
    `Zstatus543` VARCHAR(45) NOT NULL,
    `ZclientId543` VARCHAR(5) NOT NULL,
    PRIMARY KEY (`ZpoNo543`),
    INDEX `fk_Zpos543_Zclients5431_idx` (`ZclientId543` ASC) ,
    CONSTRAINT `fk_Zpos543_Zclients5431`
    FOREIGN KEY (`ZclientId543`)
    REFERENCES `mydb`.`Zclients543` (`ZclientId543`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
    ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`lines543`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Zlines543` (
    `ZpartNo543` VARCHAR(5) NOT NULL,
    `ZlineNum543` VARCHAR(5) NOT NULL,
    `ZpoNo543` VARCHAR(5) NOT NULL,
    `ZCompany543` VARCHAR(5) NOT NULL,
    `CompanypoNo543` VARCHAR(5) NOT NULL,
    `Zprice543` DOUBLE NULL,
    `Zquantity543` INT NULL,
    PRIMARY KEY (`ZlineNum543`, `ZpoNo543`),
    INDEX `fk_lines_Zpos5431_idx` (`ZpoNo543` ASC) ,
    CONSTRAINT `fk_lines_Zpos5431`
    FOREIGN KEY (`ZpoNo543`)
    REFERENCES `mydb`.`Zpos543` (`ZpoNo543`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
    ENGINE = InnoDB;






-- -----------------------------------------------------
-- Table `mydb`.`log543`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`xlog543` (
    `xtransactionID543` INT NOT NULL,
    `xstate543` VARCHAR(45) NOT NULL,
    `ts` timestamp ,
    PRIMARY KEY (`xtransactionID543`, `xstate543`))
    ENGINE = InnoDB;





CREATE TABLE IF NOT EXISTS `mydb`.`ylog543` (
    `ytransactionID543` INT NOT NULL,
    `ystate543` VARCHAR(45) NOT NULL,
    `ts` timestamp ,
    PRIMARY KEY (`ytransactionID543`, `ystate543`))
    ENGINE = InnoDB;





CREATE TABLE IF NOT EXISTS `mydb`.`zlog543` (
    `ztransactionID543` INT NOT NULL,
    `zstate543` VARCHAR(45) NOT NULL,
    `ts` timestamp,
    PRIMARY KEY (`ztransactionID543`, `zstate543`))
    ENGINE = InnoDB;





-- procedure
DELIMITER $$
CREATE PROCEDURE  XGetPrice( IN PartNo  varchar(30), INOUT Price double )
BEGIN

    set Price = (SELECT XcurrentPrice543 FROM Xparts543 WHERE XpartNo543 = PartNo);

END;
$$


-- trigger

DELIMITER $$
CREATE  TRIGGER  XMoneyOweda
    BEFORE INSERT ON  Xlines543
    FOR EACH ROW
BEGIN
CALL XGetPrice( NEW.XpartNo543, NEW.Xprice543);


UPDATE Xclients543
SET XmoneyOwed543 = XmoneyOwed543 + ( NEW.Xprice543 * NEW.Xquantity543)
WHERE XclientId543 = (SELECT XclientId543 FROM Xpos543 WHERE XpoNo543 = NEW.XpoNo543);
END;
    $$


-- procedure
DELIMITER $$
CREATE  PROCEDURE  YGetPrice( IN PartNo  varchar(30), INOUT Price double )
BEGIN

    set Price = (SELECT YcurrentPrice543 FROM Yparts543 WHERE YpartNo543 = PartNo);

END;
$$

-- trigger

DELIMITER $$
CREATE TRIGGER   YMoneyOwed
    BEFORE INSERT ON  Ylines543
    FOR EACH ROW
BEGIN
CALL YGetPrice( NEW.YpartNo543, NEW.Yprice543);


UPDATE Yclients543
SET YmoneyOwed543 = YmoneyOwed543 + ( NEW.Yprice543 * NEW.Yquantity543)
WHERE YclientId543 = (SELECT YclientId543 FROM Ypos543 WHERE YpoNo543 = NEW.YpoNo543);
END;
$$




-- trigger

DELIMITER $$
CREATE TRIGGER   ZMoneyOwed
    BEFORE INSERT ON  Zlines543
    FOR EACH ROW
BEGIN



    UPDATE Zclients543
    SET ZmoneyOwed543 = ZmoneyOwed543 + ( NEW.Zprice543 * NEW.Zquantity543)
    WHERE ZclientId543 = (SELECT ZclientId543 FROM Zpos543 WHERE ZpoNo543 = NEW.ZpoNo543);
END;
$$


