<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2021-09-21 06:43:57 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near ')' at line 7 - Invalid query: 
				SELECT br.*,
					bf.bank_nickname, bf.bank_balance, bf.bank_pending, bf.bank_closed, bf.bank_type,
					bt.bank_nickname AS bank_nickname2, bt.bank_balance AS bank_balance2, bt.bank_pending AS bank_pending2, bt.bank_closed AS bank_closed2, bt.bank_type AS bank_type2, bt.join_players_id AS join_players_id2
				FROM bank_recurring br
					LEFT JOIN bank bf ON br.join_bank_id=bf.bank_id
					LEFT JOIN bank bt ON br.bank_recurring_to=bt.bank_id
				WHERE join_bank_id IN ()
			
ERROR - 2021-09-21 06:46:35 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'ORDER BY players_last_active DESC' at line 1 - Invalid query: SELECT players_nickname, DATE_FORMAT(players_last_active, "%M %D, %Y at %l:%i %p") AS players_last_active2, players_id FROM players WHERE players_last_active>NOW() - INTERVAL  HOUR ORDER BY players_last_active DESC
ERROR - 2021-09-21 06:52:55 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'ORDER BY players_last_active DESC' at line 1 - Invalid query: SELECT players_nickname, DATE_FORMAT(players_last_active, "%M %D, %Y at %l:%i %p") AS players_last_active2, players_id FROM players WHERE players_last_active>NOW() - INTERVAL  HOUR ORDER BY players_last_active DESC
ERROR - 2021-09-21 07:20:34 --> Severity: error --> Exception: Call to a member function query() on null D:\xampp\htdocs\hfshcalpha\application\models\Horse.php 2456
ERROR - 2021-09-21 07:20:49 --> Severity: error --> Exception: Cannot use object of type Player as array D:\xampp\htdocs\hfshcalpha\application\models\Horse.php 2457
ERROR - 2021-09-21 07:20:50 --> Severity: error --> Exception: Cannot use object of type Player as array D:\xampp\htdocs\hfshcalpha\application\models\Horse.php 2457
ERROR - 2021-09-21 07:24:43 --> Severity: error --> Exception: Cannot use object of type Player as array D:\xampp\htdocs\hfshcalpha\application\models\Horse.php 2458
ERROR - 2021-09-21 07:52:41 --> 404 Page Not Found: Js/tinymce
ERROR - 2021-09-21 07:57:53 --> Severity: error --> Exception: Using $this when not in object context D:\xampp\htdocs\hfshcalpha\application\models\Horse.php 2330
ERROR - 2021-09-21 07:58:39 --> Severity: error --> Exception: Using $this when not in object context D:\xampp\htdocs\hfshcalpha\application\models\Horse.php 2330
ERROR - 2021-09-21 08:00:00 --> Severity: 8192 --> Non-static method Horse::getTodayAdoption() should not be called statically D:\xampp\htdocs\hfshcalpha\application\models\Horse.php 2330
ERROR - 2021-09-21 08:00:15 --> Severity: 8192 --> Non-static method Horse::getTodayAdoption() should not be called statically D:\xampp\htdocs\hfshcalpha\application\models\Horse.php 2330
ERROR - 2021-09-21 08:16:24 --> 404 Page Not Found: My-horses/index
ERROR - 2021-09-21 09:04:21 --> Severity: error --> Exception: Call to a member function countAll() on null D:\xampp\htdocs\hfshcalpha\application\controllers\Horses.php 56
ERROR - 2021-09-21 09:12:30 --> Query error: Unknown column 'id' in 'order clause' - Invalid query: SELECT *
FROM `horses`
WHERE `join_players_id` = '3'
ORDER BY `id` DESC
 LIMIT 10
ERROR - 2021-09-21 09:13:00 --> Query error: Unknown column 'id' in 'order clause' - Invalid query: SELECT *
FROM `horses`
WHERE `join_players_id` = '3'
ORDER BY `id` DESC
 LIMIT 10
ERROR - 2021-09-21 09:13:34 --> Query error: Unknown column 'id' in 'where clause' - Invalid query: SELECT *
FROM `horses`
WHERE `join_players_id` = '3'
AND   (
`id` LIKE '%Horsie Mc x Prettiest	%' ESCAPE '!'
OR  `horses_name` LIKE '%Horsie Mc x Prettiest	%' ESCAPE '!'
OR  `horses_birthyear` LIKE '%Horsie Mc x Prettiest	%' ESCAPE '!'
OR  `horses_gender` LIKE '%Horsie Mc x Prettiest	%' ESCAPE '!'
OR  `horses_color` LIKE '%Horsie Mc x Prettiest	%' ESCAPE '!'
OR  `horses_pattern` LIKE '%Horsie Mc x Prettiest	%' ESCAPE '!'
OR  `horses_breed` LIKE '%Horsie Mc x Prettiest	%' ESCAPE '!'
OR  `horses_points` LIKE '%Horsie Mc x Prettiest	%' ESCAPE '!'
OR  `horses_competition_title` LIKE '%Horsie Mc x Prettiest	%' ESCAPE '!'
OR  `horses_breeding_title` LIKE '%Horsie Mc x Prettiest	%' ESCAPE '!'
OR  `horses_level` LIKE '%Horsie Mc x Prettiest	%' ESCAPE '!'
 )
ORDER BY `horses_id` DESC
 LIMIT 10
ERROR - 2021-09-21 09:13:44 --> Query error: Unknown column 'id' in 'where clause' - Invalid query: SELECT *
FROM `horses`
WHERE `join_players_id` = '3'
AND   (
`id` LIKE '%Horsie Mc x Prettiest	%' ESCAPE '!'
OR  `horses_name` LIKE '%Horsie Mc x Prettiest	%' ESCAPE '!'
OR  `horses_birthyear` LIKE '%Horsie Mc x Prettiest	%' ESCAPE '!'
OR  `horses_gender` LIKE '%Horsie Mc x Prettiest	%' ESCAPE '!'
OR  `horses_color` LIKE '%Horsie Mc x Prettiest	%' ESCAPE '!'
OR  `horses_pattern` LIKE '%Horsie Mc x Prettiest	%' ESCAPE '!'
OR  `horses_breed` LIKE '%Horsie Mc x Prettiest	%' ESCAPE '!'
OR  `horses_points` LIKE '%Horsie Mc x Prettiest	%' ESCAPE '!'
OR  `horses_competition_title` LIKE '%Horsie Mc x Prettiest	%' ESCAPE '!'
OR  `horses_breeding_title` LIKE '%Horsie Mc x Prettiest	%' ESCAPE '!'
OR  `horses_level` LIKE '%Horsie Mc x Prettiest	%' ESCAPE '!'
 )
ORDER BY `horses_id` DESC
 LIMIT 10
ERROR - 2021-09-21 11:17:24 --> 404 Page Not Found: Game/stables
ERROR - 2021-09-21 11:27:05 --> Query error: Unknown column 's.stables_name' in 'field list' - Invalid query: SELECT `horses`.*, `s`.`stables_name`
FROM `horses`
LEFT JOIN `stables` ON `s`.`stables_id`=`horses`.`join_stables_id`
WHERE `join_players_id` = '3'
ORDER BY `horses_id` DESC
 LIMIT 10
ERROR - 2021-09-21 11:27:23 --> Query error: Unknown column 's.stables_name' in 'field list' - Invalid query: SELECT `horses`.*, `s`.`stables_name`
FROM `horses`
LEFT JOIN `stables` ON `s`.`stables_id`=`horses`.`join_stables_id`
WHERE `join_players_id` = '3'
ORDER BY `horses_id` DESC
 LIMIT 10
ERROR - 2021-09-21 11:28:47 --> Query error: Unknown column 's.stables_name' in 'field list' - Invalid query: SELECT `horses`.*, `s`.`stables_name`
FROM `horses`
LEFT JOIN `stables` ON `s`.`stables_id`=`horses`.`join_stables_id`
WHERE `join_players_id` = '3'
ORDER BY `horses_id` DESC
 LIMIT 10
ERROR - 2021-09-21 11:29:10 --> Query error: Column 'join_players_id' in where clause is ambiguous - Invalid query: SELECT `horses`.*, `s`.`stables_name`
FROM `horses`
LEFT JOIN `stables` `s` ON `s`.`stables_id`=`horses`.`join_stables_id`
WHERE `join_players_id` = '3'
ORDER BY `horses_id` DESC
 LIMIT 10
ERROR - 2021-09-21 12:31:22 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'ORDER BY players_last_active DESC' at line 1 - Invalid query: SELECT players_nickname, DATE_FORMAT(players_last_active, "%M %D, %Y at %l:%i %p") AS players_last_active2, players_id FROM players WHERE players_last_active>NOW() - INTERVAL  HOUR ORDER BY players_last_active DESC
ERROR - 2021-09-21 12:47:28 --> 404 Page Not Found: Game/stables
ERROR - 2021-09-21 12:52:57 --> 404 Page Not Found: Game/stables
ERROR - 2021-09-21 13:00:04 --> Severity: 8192 --> Non-static method Horse::getTodayAdoption() should not be called statically D:\xampp\htdocs\hfshcalpha\application\models\Horse.php 2331
ERROR - 2021-09-21 13:00:23 --> Severity: 8192 --> Non-static method Horse::getTodayAdoption() should not be called statically D:\xampp\htdocs\hfshcalpha\application\models\Horse.php 2331
ERROR - 2021-09-21 13:02:35 --> Severity: 8192 --> Non-static method Horse::getTodayAdoption() should not be called statically D:\xampp\htdocs\hfshcalpha\application\models\Horse.php 2331
ERROR - 2021-09-21 13:15:54 --> Severity: 8192 --> Non-static method Horse::getTodayAdoption() should not be called statically D:\xampp\htdocs\hfshcalpha\application\models\Horse.php 2339
ERROR - 2021-09-21 13:22:40 --> Severity: 8192 --> Non-static method Horse::getTodayAdoption() should not be called statically D:\xampp\htdocs\hfshcalpha\application\models\Horse.php 2343
ERROR - 2021-09-21 13:23:56 --> Severity: 8192 --> Non-static method Horse::getTodayAdoption() should not be called statically D:\xampp\htdocs\hfshcalpha\application\models\Horse.php 2343
ERROR - 2021-09-21 13:26:14 --> Severity: 8192 --> Non-static method Horse::getTodayAdoption() should not be called statically D:\xampp\htdocs\hfshcalpha\application\models\Horse.php 2352
ERROR - 2021-09-21 13:26:18 --> Severity: 8192 --> Non-static method Horse::getTodayAdoption() should not be called statically D:\xampp\htdocs\hfshcalpha\application\models\Horse.php 2352
ERROR - 2021-09-21 13:26:18 --> Severity: error --> Exception: Call to a member function query() on null D:\xampp\htdocs\hfshcalpha\application\models\Horse.php 2338
ERROR - 2021-09-21 13:26:32 --> Severity: error --> Exception: Call to a member function query() on null D:\xampp\htdocs\hfshcalpha\application\models\Horse.php 2338
