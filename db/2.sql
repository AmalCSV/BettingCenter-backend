ALTER TABLE `user` ADD `roleId` INT(1) NOT NULL AFTER `password`;

CREATE TABLE `BettingCenter`.`role` ( `id` INT(2) NOT NULL , `name` VARCHAR(20) NOT NULL ) ENGINE = InnoDB;
ALTER TABLE `role` ADD PRIMARY KEY(`id`);
INSERT INTO `role` (`id`, `name`) VALUES ('1', 'Admin'), ('2', 'User'), ('3', 'Supervisor');