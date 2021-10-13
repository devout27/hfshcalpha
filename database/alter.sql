--21-Sep-2021--

ALTER TABLE `players` ADD `per_day_credits` INT(11) NOT NULL DEFAULT '1' AFTER `players_credits_adoptathon`;

ALTER TABLE `horses` ADD `horses_sale_price` DOUBLE(10,2) NULL DEFAULT NULL AFTER `horses_sale`;

--22-Sep-2021--
ALTER TABLE `players` ADD `players_super_admin` INT(1) NOT NULL DEFAULT '0' AFTER `per_day_credits`;

--30-Sep-2021--

ALTER TABLE `stables` ADD `created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `stables_boarding_public`;

--08-OCT-2021--
ALTER TABLE `horses` ADD `horses_registration_type` VARCHAR(20) NULL AFTER `horses_level`;

ALTER TABLE `amenities` ADD `ameneties_created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `amenities_acres`;

ALTER TABLE `stables_packages` ADD `stables_packages_created` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP AFTER `stables_packages_available`;

--13-OCT-2021--
ALTER TABLE `inventory` CHANGE `itemtype` `itemtype` VARCHAR(255) NULL;
ALTER TABLE `inventory` CHANGE `itemrarity` `itemrarity` VARCHAR(255) NULL;
ALTER TABLE `inventory` ADD `created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `itemdesc`;