<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2021-12-20 06:20:55 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '? AND horses_id <>  AND horses_dam = ? LIMIT 1' at line 1 - Invalid query: SELECT horses_id FROM horses WHERE  horses_birthyear = ? AND horses_id <>  AND horses_dam = ? LIMIT 1
ERROR - 2021-12-20 06:51:44 --> 404 Page Not Found: Assets/admin
ERROR - 2021-12-20 06:51:50 --> Query error: Unknown column 'bank_available_balance' in 'where clause' - Invalid query: SELECT `bank`.*, `p`.`players_nickname`
FROM `bank`
LEFT JOIN `players` `p` ON `p`.`players_id`=`bank`.`join_players_id`
WHERE   (
`bank_nickname` LIKE '%Loan #147%' ESCAPE '!'
OR  `bank_balance` LIKE '%Loan #147%' ESCAPE '!'
OR  `bank_id` LIKE '%Loan #147%' ESCAPE '!'
OR  `join_players_id` LIKE '%Loan #147%' ESCAPE '!'
OR  `bank_available_balance` LIKE '%Loan #147%' ESCAPE '!'
OR  `bank_type` LIKE '%Loan #147%' ESCAPE '!'
OR  `bank_status` LIKE '%Loan #147%' ESCAPE '!'
 )
ORDER BY `bank_id` DESC
 LIMIT 10
ERROR - 2021-12-20 06:52:02 --> Query error: Unknown column 'bank_available_balance' in 'where clause' - Invalid query: SELECT `bank`.*, `p`.`players_nickname`
FROM `bank`
LEFT JOIN `players` `p` ON `p`.`players_id`=`bank`.`join_players_id`
WHERE   (
`bank_nickname` LIKE '%Loan #14%' ESCAPE '!'
OR  `bank_balance` LIKE '%Loan #14%' ESCAPE '!'
OR  `bank_id` LIKE '%Loan #14%' ESCAPE '!'
OR  `join_players_id` LIKE '%Loan #14%' ESCAPE '!'
OR  `bank_available_balance` LIKE '%Loan #14%' ESCAPE '!'
OR  `bank_type` LIKE '%Loan #14%' ESCAPE '!'
OR  `bank_status` LIKE '%Loan #14%' ESCAPE '!'
 )
ORDER BY `bank_id` DESC
 LIMIT 10
ERROR - 2021-12-20 06:52:02 --> Query error: Unknown column 'bank_available_balance' in 'where clause' - Invalid query: SELECT `bank`.*, `p`.`players_nickname`
FROM `bank`
LEFT JOIN `players` `p` ON `p`.`players_id`=`bank`.`join_players_id`
WHERE   (
`bank_nickname` LIKE '%Loan #147%' ESCAPE '!'
OR  `bank_balance` LIKE '%Loan #147%' ESCAPE '!'
OR  `bank_id` LIKE '%Loan #147%' ESCAPE '!'
OR  `join_players_id` LIKE '%Loan #147%' ESCAPE '!'
OR  `bank_available_balance` LIKE '%Loan #147%' ESCAPE '!'
OR  `bank_type` LIKE '%Loan #147%' ESCAPE '!'
OR  `bank_status` LIKE '%Loan #147%' ESCAPE '!'
 )
ORDER BY `bank_id` DESC
 LIMIT 10
ERROR - 2021-12-20 06:54:34 --> Query error: Unknown column 'bank_status' in 'where clause' - Invalid query: SELECT `bank`.*, `p`.`players_nickname`
FROM `bank`
LEFT JOIN `players` `p` ON `p`.`players_id`=`bank`.`join_players_id`
WHERE   (
`bank_nickname` LIKE '%Loan for JaneKing #146%' ESCAPE '!'
OR  `bank_balance` LIKE '%Loan for JaneKing #146%' ESCAPE '!'
OR  `bank_id` LIKE '%Loan for JaneKing #146%' ESCAPE '!'
OR  `join_players_id` LIKE '%Loan for JaneKing #146%' ESCAPE '!'
OR  `bank_type` LIKE '%Loan for JaneKing #146%' ESCAPE '!'
OR  `bank_status` LIKE '%Loan for JaneKing #146%' ESCAPE '!'
 )
ORDER BY `bank_id` DESC
 LIMIT 10
ERROR - 2021-12-20 06:55:07 --> 404 Page Not Found: Assets/admin
ERROR - 2021-12-20 06:57:33 --> 404 Page Not Found: Assets/admin
ERROR - 2021-12-20 06:58:29 --> 404 Page Not Found: Assets/admin
ERROR - 2021-12-20 06:58:50 --> 404 Page Not Found: Assets/admin
ERROR - 2021-12-20 07:06:19 --> Severity: error --> Exception: syntax error, unexpected 'ho' (T_STRING), expecting variable (T_VARIABLE) or '{' or '$' /home1/hfshcpha/dev.hfshcalpha.com/application/views/horses/update.php 37
ERROR - 2021-12-20 07:13:46 --> Query error: Column 'horses_created' cannot be null - Invalid query: INSERT INTO `horses` (`join_players_id`, `horses_name`, `horses_created`, `horses_breed`, `horses_birthyear`, `horses_gender`, `horses_color`, `horses_pattern`, `horses_breed2`, `horses_line`, `horses_sire`, `horses_dam`, `horses_pending_date`, `horses_registration_type`) VALUES ('3', 'DamHorse', NULL, 'Arabian', '2000', 'Mare', 'Bay', 'Blanket (Appaloosa)', 'Breed/Pattern', 'Irish (TB)', '', '', '2021-12-20 07:13:46', 'creation')
ERROR - 2021-12-20 07:49:39 --> Query error: Column 'horses_created' cannot be null - Invalid query: INSERT INTO `horses` (`join_players_id`, `horses_name`, `horses_created`, `horses_breed`, `horses_birthyear`, `horses_gender`, `horses_color`, `horses_pattern`, `horses_breed2`, `horses_line`, `horses_sire`, `horses_dam`, `horses_pending_date`, `horses_registration_type`) VALUES ('3', 'DamHorse', NULL, 'Arabian', '2000', 'Mare', 'Bay', 'Blanket (Appaloosa)', 'Breed/Pattern', 'Irish (TB)', '', '', '2021-12-20 07:49:39', 'creation')
