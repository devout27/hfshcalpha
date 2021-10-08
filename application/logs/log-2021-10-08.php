<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2021-10-08 07:24:18 --> 404 Page Not Found: Assets/admin
ERROR - 2021-10-08 08:33:44 --> 404 Page Not Found: Assets/admin
ERROR - 2021-10-08 08:55:16 --> 404 Page Not Found: Assets/admin
ERROR - 2021-10-08 08:55:18 --> 404 Page Not Found: super-admin/Ameneties/index
ERROR - 2021-10-08 08:57:54 --> Query error: Table 'ci_hfshph_game.amenities_x_amenities' doesn't exist - Invalid query: SELECT `amenities`.*, `players`.`players_nickname`, `players`.`players_email`
FROM `amenities_x_amenities`
LEFT JOIN `players` ON `players`.`players_id`=`amenities`.`join_players_id`
ORDER BY `amenities_id` DESC
 LIMIT 10
ERROR - 2021-10-08 08:58:38 --> Query error: Table 'ci_hfshph_game.amenities_x_amenities' doesn't exist - Invalid query: SELECT `amenities`.*, `players`.`players_nickname`, `players`.`players_email`
FROM `amenities_x_amenities`
LEFT JOIN `players` ON `players`.`players_id`=`amenities`.`join_players_id`
ORDER BY `amenities_id` DESC
 LIMIT 10
ERROR - 2021-10-08 08:58:43 --> Query error: Table 'ci_hfshph_game.amenities_x_amenities' doesn't exist - Invalid query: SELECT `amenities`.*, `players`.`players_nickname`, `players`.`players_email`
FROM `amenities_x_amenities`
LEFT JOIN `players` ON `players`.`players_id`=`amenities`.`join_players_id`
ORDER BY `amenities_id` DESC
 LIMIT 10
ERROR - 2021-10-08 08:59:35 --> Query error: Unknown table 'ci_hfshph_game.amenities' - Invalid query: SELECT `amenities`.*, `players`.`players_nickname`, `players`.`players_email`
FROM `stables_x_amenities`
LEFT JOIN `players` ON `players`.`players_id`=`amenities`.`join_players_id`
ORDER BY `amenities_id` DESC
 LIMIT 10
ERROR - 2021-10-08 09:01:28 --> Query error: Unknown column 'amenities.join_players_id' in 'on clause' - Invalid query: SELECT `amenities`.*, `players`.`players_nickname`, `players`.`players_email`
FROM `amenities`
LEFT JOIN `players` ON `players`.`players_id`=`amenities`.`join_players_id`
ORDER BY `amenities_id` DESC
 LIMIT 10
ERROR - 2021-10-08 09:14:20 --> 404 Page Not Found: Assets/admin
ERROR - 2021-10-08 09:14:47 --> 404 Page Not Found: Assets/admin
ERROR - 2021-10-08 09:15:13 --> 404 Page Not Found: Assets/admin
ERROR - 2021-10-08 09:16:32 --> 404 Page Not Found: Assets/admin
ERROR - 2021-10-08 09:16:46 --> 404 Page Not Found: Assets/admin
ERROR - 2021-10-08 09:17:17 --> 404 Page Not Found: Assets/admin
ERROR - 2021-10-08 09:19:23 --> Query error: Unknown column 'join_players_id' in 'where clause' - Invalid query: SELECT *
FROM `amenities`
WHERE   (
`amenities_id` LIKE '%a%' ESCAPE '!'
OR  `join_players_id` LIKE '%a%' ESCAPE '!'
OR  `players_nickname` LIKE '%a%' ESCAPE '!'
OR  `players_email` LIKE '%a%' ESCAPE '!'
 )
ORDER BY `amenities_id` DESC
 LIMIT 10
ERROR - 2021-10-08 09:20:44 --> 404 Page Not Found: Assets/admin
ERROR - 2021-10-08 09:22:44 --> 404 Page Not Found: Assets/admin
ERROR - 2021-10-08 09:25:29 --> 404 Page Not Found: Assets/admin
ERROR - 2021-10-08 09:27:37 --> Query error: Unknown column 's.join_players_id' in 'on clause' - Invalid query: SELECT s.*, p.players_nickname FROM amenities s LEFT JOIN players p ON p.players_id=s.join_players_id WHERE amenities_id='10'
ERROR - 2021-10-08 09:28:33 --> Query error: No tables used - Invalid query: SELECT * WHERE amenities_id='10'
ERROR - 2021-10-08 10:41:25 --> 404 Page Not Found: Assets/admin
ERROR - 2021-10-08 10:51:17 --> 404 Page Not Found: Assets/admin
ERROR - 2021-10-08 10:51:25 --> Query error: Unknown column 'submit' in 'field list' - Invalid query: UPDATE `amenities` SET `amenities_id` = '10', `amenities_name` = 'One Hundred Acres', `amenities_description` = 'A large chunk of acreage to provide enough space for even the largest of stables.', `amenities_picture` = 'https://upload.wikimedia.org/wikipedia/en/a/ac/Map_of_the_Hundred_Acre_Wood.gif', `amenities_cost` = '300000', `amenities_type` = 'Land', `amenities_limit` = '0', `amenities_acres` = '100.0', `amenities_stalls` = '4', `submit` = 'Update Stable'
WHERE `amenities_id` = '10'
ERROR - 2021-10-08 11:20:28 --> 404 Page Not Found: Assets/admin
ERROR - 2021-10-08 11:24:43 --> 404 Page Not Found: Assets/admin
ERROR - 2021-10-08 11:41:17 --> 404 Page Not Found: Assets/admin
ERROR - 2021-10-08 11:48:15 --> 404 Page Not Found: Images/amenity-placeholder.jpeg
ERROR - 2021-10-08 11:48:42 --> 404 Page Not Found: Images/amenity-placeholder.jpeg
ERROR - 2021-10-08 11:49:36 --> 404 Page Not Found: Assets/images
ERROR - 2021-10-08 11:49:47 --> 404 Page Not Found: Assets/images
ERROR - 2021-10-08 12:02:35 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'ORDER BY players_last_active DESC' at line 1 - Invalid query: SELECT players_nickname, DATE_FORMAT(players_last_active, "%M %D, %Y at %l:%i %p") AS players_last_active2, players_id FROM players WHERE players_last_active>NOW() - INTERVAL  HOUR ORDER BY players_last_active DESC
ERROR - 2021-10-08 12:02:47 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'ORDER BY players_last_active DESC' at line 1 - Invalid query: SELECT players_nickname, DATE_FORMAT(players_last_active, "%M %D, %Y at %l:%i %p") AS players_last_active2, players_id FROM players WHERE players_last_active>NOW() - INTERVAL  HOUR ORDER BY players_last_active DESC
ERROR - 2021-10-08 12:05:51 --> 404 Page Not Found: Assets/admin
ERROR - 2021-10-08 12:10:07 --> 404 Page Not Found: City/banks
ERROR - 2021-10-08 12:18:17 --> 404 Page Not Found: Assets/admin
ERROR - 2021-10-08 12:18:20 --> 404 Page Not Found: Assets/admin
ERROR - 2021-10-08 12:18:48 --> 404 Page Not Found: Assets/admin
ERROR - 2021-10-08 12:21:43 --> 404 Page Not Found: Assets/admin
ERROR - 2021-10-08 12:26:10 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'ORDER BY players_last_active DESC' at line 1 - Invalid query: SELECT players_nickname, DATE_FORMAT(players_last_active, "%M %D, %Y at %l:%i %p") AS players_last_active2, players_id FROM players WHERE players_last_active>NOW() - INTERVAL  HOUR ORDER BY players_last_active DESC
ERROR - 2021-10-08 12:38:01 --> 404 Page Not Found: Assets/admin
ERROR - 2021-10-08 12:45:40 --> 404 Page Not Found: Assets/admin
ERROR - 2021-10-08 13:04:47 --> Severity: error --> Exception: Too few arguments to function Amenities::manage(), 0 passed in D:\xampp\htdocs\hfshcalpha\system\core\CodeIgniter.php on line 532 and exactly 1 expected D:\xampp\htdocs\hfshcalpha\application\controllers\super-admin\Amenities.php 66
ERROR - 2021-10-08 13:08:28 --> 404 Page Not Found: Assets/admin
ERROR - 2021-10-08 13:08:50 --> 404 Page Not Found: Assets/admin
ERROR - 2021-10-08 13:09:41 --> 404 Page Not Found: super-admin/Amenities/manage
ERROR - 2021-10-08 13:10:13 --> 404 Page Not Found: Assets/admin
ERROR - 2021-10-08 13:10:17 --> Query error: Unknown column 'Array' in 'where clause' - Invalid query: DELETE FROM `amenities`
WHERE `amenities_id` = Array
ERROR - 2021-10-08 13:10:48 --> 404 Page Not Found: Assets/admin
ERROR - 2021-10-08 13:12:50 --> Severity: error --> Exception: Call to a member function checkPermissionWithUrl() on null D:\xampp\htdocs\hfshcalpha\application\views\super-admin\Amenities\index.php 12
ERROR - 2021-10-08 13:13:00 --> 404 Page Not Found: Assets/admin
ERROR - 2021-10-08 13:27:25 --> 404 Page Not Found: Assets/admin
ERROR - 2021-10-08 13:37:16 --> 404 Page Not Found: Assets/admin
ERROR - 2021-10-08 13:57:50 --> 404 Page Not Found: Assets/admin
ERROR - 2021-10-08 14:15:12 --> 404 Page Not Found: Assets/admin
ERROR - 2021-10-08 14:31:04 --> 404 Page Not Found: Assets/admin
ERROR - 2021-10-08 15:12:48 --> 404 Page Not Found: Assets/admin
ERROR - 2021-10-08 15:13:11 --> 404 Page Not Found: Assets/admin
ERROR - 2021-10-08 15:13:15 --> 404 Page Not Found: Assets/admin
ERROR - 2021-10-08 15:14:31 --> 404 Page Not Found: Assets/admin
ERROR - 2021-10-08 15:14:38 --> 404 Page Not Found: Assets/admin
ERROR - 2021-10-08 15:16:23 --> 404 Page Not Found: Assets/admin
ERROR - 2021-10-08 15:16:37 --> 404 Page Not Found: Assets/admin
ERROR - 2021-10-08 15:17:13 --> 404 Page Not Found: Assets/admin
ERROR - 2021-10-08 15:17:50 --> 404 Page Not Found: Assets/admin
ERROR - 2021-10-08 15:18:54 --> 404 Page Not Found: Assets/admin
ERROR - 2021-10-08 15:20:35 --> 404 Page Not Found: Assets/admin
ERROR - 2021-10-08 15:46:04 --> Query error: Unknown column 'packageAmenitiesList_length' in 'field list' - Invalid query: UPDATE `stables_packages` SET `stables_packages_id` = '6', `stables_packages_name` = 'Standard', `stables_packages_description` = 'abc', `stables_packages_cost` = '10', `stables_packages_cost_usd` = '0.00', `stables_packages_available` = '1', `packageAmenitiesList_length` = '10'
WHERE `stables_packages_id` = '6'
ERROR - 2021-10-08 15:46:58 --> Query error: Unknown column 'packageAmenitiesList_length' in 'field list' - Invalid query: UPDATE `stables_packages` SET `stables_packages_id` = '6', `stables_packages_name` = 'Standard', `stables_packages_description` = 'abc', `stables_packages_cost` = '10', `stables_packages_cost_usd` = '0.00', `stables_packages_available` = '1', `packageAmenitiesList_length` = '10'
WHERE `stables_packages_id` = '6'
ERROR - 2021-10-08 15:47:43 --> Query error: Unknown column 'packageAmenitiesList_length' in 'field list' - Invalid query: UPDATE `stables_packages` SET `stables_packages_id` = '6', `stables_packages_name` = 'Standard', `stables_packages_description` = 'abc', `stables_packages_cost` = '10', `stables_packages_cost_usd` = '0.00', `stables_packages_available` = '1', `packageAmenitiesList_length` = '10'
WHERE `stables_packages_id` = '6'
ERROR - 2021-10-08 15:50:11 --> Query error: Unknown column 'packageAmenitiesList_length' in 'field list' - Invalid query: UPDATE `stables_packages` SET `stables_packages_id` = '6', `stables_packages_name` = 'Standard', `stables_packages_description` = 'abc', `stables_packages_cost` = '10', `stables_packages_cost_usd` = '0.00', `stables_packages_available` = '1', `packageAmenitiesList_length` = '10'
WHERE `stables_packages_id` = '6'
ERROR - 2021-10-08 15:51:05 --> Query error: Unknown column 'packageAmenitiesList_length' in 'field list' - Invalid query: UPDATE `stables_packages` SET `stables_packages_id` = '6', `stables_packages_name` = 'Standard', `stables_packages_description` = 'abc', `stables_packages_cost` = '10', `stables_packages_cost_usd` = '0.00', `stables_packages_available` = '1', `packageAmenitiesList_length` = '10'
WHERE `stables_packages_id` = '6'
ERROR - 2021-10-08 15:51:28 --> Query error: Unknown column 'packageAmenitiesList_length' in 'field list' - Invalid query: UPDATE `stables_packages` SET `stables_packages_id` = '6', `stables_packages_name` = 'Standard', `stables_packages_description` = 'abc', `stables_packages_cost` = '10', `stables_packages_cost_usd` = '0.00', `stables_packages_available` = '1', `packageAmenitiesList_length` = '10'
WHERE `stables_packages_id` = '6'
ERROR - 2021-10-08 15:52:10 --> Severity: error --> Exception: Call to undefined method CI_DB_mysqli_driver::insertBatch() D:\xampp\htdocs\hfshcalpha\application\models\StablePackage_Model.php 101
ERROR - 2021-10-08 15:52:44 --> 404 Page Not Found: Assets/admin
ERROR - 2021-10-08 16:01:37 --> 404 Page Not Found: Assets/admin
ERROR - 2021-10-08 16:03:16 --> 404 Page Not Found: Assets/admin
