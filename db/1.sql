-- 2022-01-30
ALTER TABLE `raceWinning` CHANGE `raceIdentifier` `raceCode` VARCHAR(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL;

CREATE TABLE `raceWinningHorseAmount` ( `id` INT NOT NULL AUTO_INCREMENT ,
 `bettingHorseId` INT NOT NULL , `amountTypeId` INT NOT NULL , `amount` DOUBLE NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
