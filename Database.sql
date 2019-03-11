CREATE TABLE `tareasSymfony4`.`users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `role` VARCHAR(50) NULL,
  `name` VARCHAR(45) NULL,
  `surname` VARCHAR(45) NULL,
  `email` VARCHAR(45) NULL,
  `password` VARCHAR(45) NULL,
  `created_at` DATETIME NULL COMMENT 'Tabla usuarios',
  PRIMARY KEY (`id`));
  
CREATE TABLE `tareasSymfony4`.`tasks` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NULL,
  `title` VARCHAR(45) NULL,
  `content` LONGTEXT NULL,
  `priority` VARCHAR(45) NULL,
  `hours` INT NULL,
  `created_at` DATETIME NULL,
  PRIMARY KEY (`id`));

  ALTER TABLE `tareasSymfony4`.`tasks` 
ADD INDEX `fk_tasks_users_idx` (`user_id` ASC);
ALTER TABLE `tareasSymfony4`.`tasks` 
ADD CONSTRAINT `fk_tasks_users`
  FOREIGN KEY (`user_id`)
  REFERENCES `tareasSymfony4`.`users` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;


use tareasSymfony4;
insert into users values(null,'ROLE_USER','Andres', 'BRUSUTTI','andresbrusutti@gmail.com',
	'password', CURTIME());
    
insert into users values(null,'ROLE_USER','Oscar', 'Perez','oscar@gmail.com',
	'password', CURTIME());

insert into users values(null,'ROLE_USER','Alfredo', 'Benitez','alfredo@gmail.com',
	'password', CURTIME());    


insert into tasks values(null,1,'Tarea 1', 'Horas Presupuestadas','high',40,CURTIME());    
insert into tasks values(null,1,'Tarea 2', 'Horas Presupuestadas','high',40,CURTIME());    
insert into tasks values(null,2,'Tarea 1', 'Horas Presupuestadas','high',40,CURTIME());    
insert into tasks values(null,2,'Tarea 2', 'Horas Presupuestadas','high',40,CURTIME());    
insert into tasks values(null,3,'Tarea 3', 'Horas Presupuestadas','high',40,CURTIME());    
	