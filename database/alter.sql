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

--14-OCT-2021--
ALTER TABLE `events` CHANGE `events_type` `events_type` ENUM('Show','Race','Olympic','WEGs') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;

ALTER TABLE `players` ADD `players_events_weekly_limit` INT(1) NOT NULL DEFAULT '0' AFTER `players_super_admin`;

--24-DEC-2021--

CREATE TABLE `hfshcpha_dev_hfshcpha_game`.`horses_sale_purposals` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `join_players_id` INT(11) NULL , `join_players_username` VARCHAR(255) NOT NULL , `title` VARCHAR(255) NOT NULL , `email` VARCHAR(255) NOT NULL , `phone_number` VARCHAR(30) NOT NULL , `description` LONGTEXT NULL DEFAULT NULL , `created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , `price` DOUBLE(10,2) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

ALTER TABLE `horses_sale_purposals` ADD `join_horse_id` INT(11) NOT NULL AFTER `join_players_username`;

ALTER TABLE `horses_sale_purposals` ADD `join_horses_name` VARCHAR(255) NOT NULL AFTER `join_players_username`;
ALTER TABLE `horses_sale_purposals` ADD `seen_status` INT(1) NOT NULL DEFAULT '0' AFTER `price`;
ALTER TABLE `horses_breedings` ADD `horses_breedings_name` VARCHAR(255) NULL AFTER `horses_breedings_date`;

--19-May-2022--
ALTER TABLE `horse_records` ADD `owner_name` VARCHAR(255) NULL;

ALTER TABLE `auctions_bids` ADD `join_players_name` VARCHAR(255) NULL DEFAULT NULL AFTER `join_players_id`;

ALTER TABLE `stables` ADD `players_nickname` VARCHAR(255) NULL DEFAULT NULL AFTER `join_players_id`;

ALTER TABLE `stables` ADD `players_email` VARCHAR(255) NULL AFTER `players_nickname`;

ALTER TABLE `bank` ADD `players_nickname` VARCHAR(255) NULL AFTER `join_players_id`;

ALTER TABLE `bank_loans` ADD `players_nickname` VARCHAR(255) NULL DEFAULT NULL AFTER `join_players_id`;

ALTER TABLE `cabs` ADD `players_nickname` VARCHAR(255) NULL AFTER `join_players_id`;

ALTER TABLE `events` ADD `players_nickname` VARCHAR(255) NULL DEFAULT NULL AFTER `join_players_id`;

ALTER TABLE `horses` ADD `players_nickname` VARCHAR(255) NULL DEFAULT NULL AFTER `join_players_id`;

ALTER TABLE `import_requests` ADD `players_nickname` VARCHAR(255) NULL DEFAULT NULL AFTER `join_players_id`;

ALTER TABLE `inventory` ADD `players_nickname` VARCHAR(255) NULL DEFAULT NULL AFTER `join_players_id`;

ALTER TABLE `log` ADD `players_nickname` VARCHAR(255) NULL DEFAULT NULL AFTER `join_players_id`;

--24-May-2022--
ALTER TABLE `horses_breedings` ADD `horses_breedings_owner_nickname` VARCHAR(255) NULL AFTER `horses_breedings_owner`;