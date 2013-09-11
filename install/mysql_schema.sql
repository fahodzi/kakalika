SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';


-- -----------------------------------------------------
-- Table `users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(45) NOT NULL,
  `firstname` VARCHAR(45) NOT NULL,
  `lastname` VARCHAR(45) NULL,
  `password` VARCHAR(45) NOT NULL,
  `email` VARCHAR(45) NOT NULL,
  `is_admin` TINYINT(1) NULL,
  `blocked` TINYINT(1) NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `username_UNIQUE` (`username` ASC),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `projects`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `projects` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `code` VARCHAR(45) NOT NULL,
  `description` TEXT NULL,
  `number_of_issues` INT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `code_UNIQUE` (`code` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `user_projects`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `user_projects` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `project_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  `creator` TINYINT(1) NULL,
  `admin` TINYINT(1) NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_user_projects_1_idx` (`project_id` ASC),
  INDEX `fk_user_projects_2_idx` (`user_id` ASC),
  CONSTRAINT `fk_user_projects_projects`
    FOREIGN KEY (`project_id`)
    REFERENCES `projects` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_user_projects_users`
    FOREIGN KEY (`user_id`)
    REFERENCES `users` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `issues`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `issues` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `project_id` INT NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `status` VARCHAR(45) NOT NULL,
  `number` INT(11) NOT NULL,
  `assignee` INT NULL,
  `kind` VARCHAR(45) NULL,
  `priority` VARCHAR(45) NULL,
  `description` TEXT NULL,
  `created` TIMESTAMP NULL,
  `updated` TIMESTAMP NULL,
  `opener` INT NOT NULL,
  `updater` INT NULL,
  `assigned` TIMESTAMP NULL,
  `number_of_updates` INT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_issues_1_idx` (`project_id` ASC),
  INDEX `fk_issues_2_idx` (`assignee` ASC),
  INDEX `fk_issues_3_idx` (`opener` ASC),
  INDEX `fk_issues_4_idx` (`updater` ASC),
  CONSTRAINT `fk_issues_1`
    FOREIGN KEY (`project_id`)
    REFERENCES `projects` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_issues_2`
    FOREIGN KEY (`assignee`)
    REFERENCES `users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_issues_3`
    FOREIGN KEY (`opener`)
    REFERENCES `users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_issues_4`
    FOREIGN KEY (`updater`)
    REFERENCES `users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `updates`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `updates` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `issue_id` INT UNSIGNED NOT NULL,
  `user_id` INT NOT NULL,
  `created` TIMESTAMP NOT NULL,
  `comment` TEXT NULL,
  `title` VARCHAR(255) NULL,
  `status` VARCHAR(45) NULL,
  `assignee` INT NULL,
  `kind` VARCHAR(45) NULL,
  `priority` VARCHAR(45) NULL,
  `number` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_activities_1_idx` (`issue_id` ASC),
  INDEX `fk_activities_2_idx` (`user_id` ASC),
  CONSTRAINT `fk_activities_1`
    FOREIGN KEY (`issue_id`)
    REFERENCES `issues` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_activities_2`
    FOREIGN KEY (`user_id`)
    REFERENCES `users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
