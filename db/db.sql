SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `kakalika` DEFAULT CHARACTER SET latin1 ;

-- -----------------------------------------------------
-- Table `kakalika`.`users`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `kakalika`.`users` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `username` VARCHAR(255) NOT NULL ,
  `password` VARCHAR(255) NOT NULL ,
  `full_name` VARCHAR(225) NOT NULL ,
  `is_admin` TINYINT(1)  NOT NULL ,
  `email` VARCHAR(255) NOT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `username` (`username` ASC) )
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `kakalika`.`messages`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `kakalika`.`messages` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `from` INT NOT NULL ,
  `to` INT NOT NULL ,
  `title` VARCHAR(255) NOT NULL ,
  `body` TEXT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_messages_from_user_id` (`from` ASC, `to` ASC) ,
  CONSTRAINT `fk_messages_from_user_id`
    FOREIGN KEY (`from`)
    REFERENCES `kakalika`.`users` (`id` , `id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `kakalika`.`projects`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `kakalika`.`projects` (
  `id` INT NOT NULL ,
  `name` VARCHAR(255) NOT NULL ,
  `description` TEXT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `kakalika`.`roles`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `kakalika`.`roles` (
  `id` INT NOT NULL ,
  `name` VARCHAR(255) NOT NULL ,
  `project_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_roles_projects1` (`project_id` ASC) ,
  CONSTRAINT `fk_roles_projects1`
    FOREIGN KEY (`project_id` )
    REFERENCES `kakalika`.`projects` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `kakalika`.`permissions`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `kakalika`.`permissions` (
  `id` INT NOT NULL ,
  `description` VARCHAR(128) NOT NULL ,
  `value` TINYINT(1)  NOT NULL ,
  `role_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_permissions_roles1` (`role_id` ASC) ,
  CONSTRAINT `fk_permissions_roles1`
    FOREIGN KEY (`role_id` )
    REFERENCES `kakalika`.`roles` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `kakalika`.`role_users`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `kakalika`.`role_users` (
  `id` INT NOT NULL ,
  `user_id` INT NOT NULL ,
  `role_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_project_users_users1` (`user_id` ASC) ,
  INDEX `fk_project_users_roles1` (`role_id` ASC) ,
  CONSTRAINT `fk_project_users_users1`
    FOREIGN KEY (`user_id` )
    REFERENCES `kakalika`.`users` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_project_users_roles1`
    FOREIGN KEY (`role_id` )
    REFERENCES `kakalika`.`roles` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `kakalika`.`issues`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `kakalika`.`issues` (
  `id` INT NOT NULL ,
  `title` VARCHAR(255) NOT NULL ,
  `body` VARCHAR(45) NOT NULL ,
  `creator` INT NOT NULL ,
  `assigned_to` INT NOT NULL ,
  `status` VARCHAR(16) NOT NULL ,
  `project_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_issues_user_id` (`assigned_to` ASC, `creator` ASC) ,
  INDEX `fk_issues_projects1` (`project_id` ASC) ,
  CONSTRAINT `fk_issues_user_id`
    FOREIGN KEY (`assigned_to` , `creator` )
    REFERENCES `kakalika`.`users` (`id` , `id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_issues_projects1`
    FOREIGN KEY (`project_id` )
    REFERENCES `kakalika`.`projects` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
