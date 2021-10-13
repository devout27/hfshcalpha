<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2021-10-13 13:07:38 --> Severity: error --> Exception: Call to undefined method Game::get_flashdata() D:\xampp\htdocs\hfshcalpha\application\controllers\Game.php 399
ERROR - 2021-10-13 13:07:58 --> Severity: error --> Exception: Call to undefined method CI_Session::get_flashdata() D:\xampp\htdocs\hfshcalpha\application\controllers\Game.php 399
ERROR - 2021-10-13 13:07:59 --> Severity: error --> Exception: Call to undefined method CI_Session::get_flashdata() D:\xampp\htdocs\hfshcalpha\application\controllers\Game.php 399
ERROR - 2021-10-13 13:07:59 --> Severity: error --> Exception: Call to undefined method CI_Session::get_flashdata() D:\xampp\htdocs\hfshcalpha\application\controllers\Game.php 399
ERROR - 2021-10-13 13:07:59 --> Severity: error --> Exception: Call to undefined method CI_Session::get_flashdata() D:\xampp\htdocs\hfshcalpha\application\controllers\Game.php 399
ERROR - 2021-10-13 13:08:00 --> Severity: error --> Exception: Call to undefined method CI_Session::get_flashdata() D:\xampp\htdocs\hfshcalpha\application\controllers\Game.php 399
ERROR - 2021-10-13 13:08:00 --> Severity: error --> Exception: Call to undefined method CI_Session::get_flashdata() D:\xampp\htdocs\hfshcalpha\application\controllers\Game.php 399
ERROR - 2021-10-13 13:08:00 --> Severity: error --> Exception: Call to undefined method CI_Session::get_flashdata() D:\xampp\htdocs\hfshcalpha\application\controllers\Game.php 399
ERROR - 2021-10-13 13:09:46 --> Severity: error --> Exception: Cannot use object of type Player as array D:\xampp\htdocs\hfshcalpha\application\views\game\inventory.php 1
ERROR - 2021-10-13 13:09:56 --> Severity: error --> Exception: Cannot use object of type Player as array D:\xampp\htdocs\hfshcalpha\application\views\game\inventory.php 1
ERROR - 2021-10-13 13:15:06 --> Query error: Table 'ci_hfshph_game.inventories' doesn't exist - Invalid query: SELECT `inventories`.*, `players`.`players_nickname`, `players`.`players_email`
FROM `inventories`
LEFT JOIN `players` ON `players`.`players_id`=`inventories`.`join_players_id`
WHERE `join_players_id` = '3'
ORDER BY `itemid` DESC
 LIMIT 10
ERROR - 2021-10-13 13:15:14 --> Query error: Table 'ci_hfshph_game.inventories' doesn't exist - Invalid query: SELECT `inventories`.*, `players`.`players_nickname`, `players`.`players_email`
FROM `inventories`
LEFT JOIN `players` ON `players`.`players_id`=`inventories`.`join_players_id`
WHERE `join_players_id` = '3'
ORDER BY `itemid` DESC
 LIMIT 10
ERROR - 2021-10-13 13:15:24 --> Query error: Table 'ci_hfshph_game.inventories' doesn't exist - Invalid query: SELECT `inventories`.*, `players`.`players_nickname`, `players`.`players_email`
FROM `inventories`
LEFT JOIN `players` ON `players`.`players_id`=`inventories`.`join_players_id`
WHERE `join_players_id` = '3'
ORDER BY `itemid` DESC
 LIMIT 10
ERROR - 2021-10-13 13:16:04 --> Query error: Table 'ci_hfshph_game.inventories' doesn't exist - Invalid query: SELECT `inventories`.*, `players`.`players_nickname`, `players`.`players_email`
FROM `inventories`
LEFT JOIN `players` ON `players`.`players_id`=`inventories`.`join_players_id`
WHERE `join_players_id` = '3'
ORDER BY `itemid` DESC
 LIMIT 10
ERROR - 2021-10-13 13:16:44 --> Query error: Table 'ci_hfshph_game.inventories' doesn't exist - Invalid query: SELECT `inventory`.*, `players`.`players_nickname`, `players`.`players_email`
FROM `inventories`
LEFT JOIN `players` ON `players`.`players_id`=`inventory`.`join_players_id`
WHERE `join_players_id` = '3'
ORDER BY `itemid` DESC
 LIMIT 10
ERROR - 2021-10-13 13:21:46 --> 404 Page Not Found: Game/hi
ERROR - 2021-10-13 13:44:19 --> 404 Page Not Found: Fonts/la-solid-900.woff2
ERROR - 2021-10-13 13:44:19 --> 404 Page Not Found: Fonts/la-solid-900.woff
ERROR - 2021-10-13 13:44:19 --> 404 Page Not Found: Fonts/la-solid-900.ttf
ERROR - 2021-10-13 13:44:22 --> 404 Page Not Found: Fonts/la-solid-900.woff2
ERROR - 2021-10-13 13:44:22 --> 404 Page Not Found: Fonts/la-solid-900.woff
ERROR - 2021-10-13 13:44:23 --> 404 Page Not Found: Fonts/la-solid-900.ttf
ERROR - 2021-10-13 13:44:26 --> 404 Page Not Found: Fonts/la-solid-900.woff2
ERROR - 2021-10-13 13:44:26 --> 404 Page Not Found: Fonts/la-solid-900.woff
ERROR - 2021-10-13 13:44:26 --> 404 Page Not Found: Fonts/la-solid-900.ttf
ERROR - 2021-10-13 14:41:51 --> 404 Page Not Found: Game/BASE_URL
ERROR - 2021-10-13 14:42:52 --> Query error: Table 'ci_hfshph_game.inventories' doesn't exist - Invalid query: SELECT s.*, p.players_nickname FROM inventories s LEFT JOIN players p ON p.players_id=s.join_players_id WHERE itemid='2'
ERROR - 2021-10-13 14:57:46 --> 404 Page Not Found: Inventory/index
ERROR - 2021-10-13 14:58:15 --> 404 Page Not Found: Inventory/index
ERROR - 2021-10-13 14:58:21 --> Severity: error --> Exception: Call to undefined method Game::set_flashdata() D:\xampp\htdocs\hfshcalpha\application\controllers\Game.php 416
ERROR - 2021-10-13 15:34:13 --> Severity: error --> Exception: Call to a member function getInventoryDataById() on null D:\xampp\htdocs\hfshcalpha\application\controllers\Game.php 471
