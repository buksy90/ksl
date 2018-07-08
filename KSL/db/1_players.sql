ALTER TABLE `ksl`.`v2_players` 
ADD COLUMN `sex` ENUM('male', 'female') NOT NULL AFTER `weight`;

ALTER TABLE `ksl`.`v2_players` 
CHANGE COLUMN `birthdate` `birthdate` DATETIME NOT NULL ;
