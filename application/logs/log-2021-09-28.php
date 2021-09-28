<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2021-09-28 05:25:36 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-28 05:25:46 --> 404 Page Not Found: super-admin/Subscriptions/index
ERROR - 2021-09-28 05:29:06 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-28 05:31:35 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-28 05:33:17 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-28 06:00:36 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-28 06:02:29 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-28 06:03:00 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-28 06:03:17 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-28 06:04:57 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-28 06:07:15 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-28 06:07:34 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-28 06:10:21 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-28 06:10:33 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-28 06:12:29 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-28 06:12:40 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-28 06:14:17 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-28 06:15:04 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-28 06:15:19 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-28 06:25:07 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-28 06:27:34 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-28 06:35:19 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-28 06:36:18 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-28 06:42:09 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-28 06:42:31 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-28 06:51:35 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-28 06:52:00 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-28 06:52:05 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-28 06:55:02 --> Severity: error --> Exception: Too few arguments to function Banks::process_check(), 1 passed in D:\xampp\htdocs\hfshcalpha\system\core\CodeIgniter.php on line 532 and exactly 2 expected D:\xampp\htdocs\hfshcalpha\application\controllers\super-admin\Banks.php 213
ERROR - 2021-09-28 06:56:29 --> Severity: error --> Exception: Too few arguments to function Banks::process_check(), 1 passed in D:\xampp\htdocs\hfshcalpha\system\core\CodeIgniter.php on line 532 and exactly 2 expected D:\xampp\htdocs\hfshcalpha\application\controllers\super-admin\Banks.php 213
ERROR - 2021-09-28 07:01:58 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-28 07:02:16 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-28 07:02:22 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-28 07:02:55 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-28 07:04:39 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-28 07:04:57 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-28 07:05:06 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-28 07:05:08 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-28 07:07:51 --> Severity: Error --> Maximum execution time of 120 seconds exceeded D:\xampp\htdocs\hfshcalpha\system\libraries\Session\drivers\Session_files_driver.php 210
ERROR - 2021-09-28 07:07:51 --> Severity: Error --> Maximum execution time of 120 seconds exceeded D:\xampp\htdocs\hfshcalpha\system\libraries\Session\drivers\Session_files_driver.php 180
ERROR - 2021-09-28 07:08:54 --> Severity: Error --> Maximum execution time of 120 seconds exceeded D:\xampp\htdocs\hfshcalpha\system\libraries\Session\drivers\Session_files_driver.php 212
ERROR - 2021-09-28 07:11:23 --> Severity: Error --> Maximum execution time of 120 seconds exceeded D:\xampp\htdocs\hfshcalpha\system\libraries\Session\drivers\Session_files_driver.php 212
ERROR - 2021-09-28 07:14:22 --> Severity: Error --> Maximum execution time of 120 seconds exceeded D:\xampp\htdocs\hfshcalpha\system\libraries\Session\drivers\Session_files_driver.php 212
ERROR - 2021-09-28 07:15:50 --> Severity: Error --> Maximum execution time of 120 seconds exceeded D:\xampp\htdocs\hfshcalpha\system\libraries\Session\drivers\Session_files_driver.php 212
ERROR - 2021-09-28 07:41:08 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-28 07:49:43 --> Severity: Error --> Maximum execution time of 120 seconds exceeded D:\xampp\htdocs\hfshcalpha\system\libraries\Session\drivers\Session_files_driver.php 212
ERROR - 2021-09-28 07:52:30 --> Query error: Unknown column 'bank_checks_memo2' in 'where clause' - Invalid query: SELECT `bc`.*, DATE_FORMAT(bc.bank_checks_date, '%Y/%m/%d') AS bank_checks_date, `b1`.`bank_nickname` AS `b1_nickname`, `b2`.`bank_nickname` AS `b2_nickname`
FROM `bank_checks` `bc`
LEFT JOIN `bank` `b1` ON `b1`.`bank_id`=`bc`.`join_bank_id`
LEFT JOIN `bank` `b2` ON `b2`.`bank_id`=`bc`.`bank_checks_to_id`
WHERE `join_bank_id` = '3'
OR `bank_checks_to_id` = '3'
AND `bank_checks_status` != 'Pending'
OR  `join_bank_id` LIKE '%d%' ESCAPE '!'
OR  `bank_checks_id` LIKE '%d%' ESCAPE '!'
OR  `bank_checks_status` LIKE '%d%' ESCAPE '!'
OR  `bank_checks_memo` LIKE '%d%' ESCAPE '!'
OR  `bank_checks_memo2` LIKE '%d%' ESCAPE '!'
ORDER BY `bc`.`join_bank_id` DESC
 LIMIT 10
ERROR - 2021-09-28 07:52:44 --> Query error: Unknown column 'bank_checks_memo2' in 'where clause' - Invalid query: SELECT `bc`.*, DATE_FORMAT(bc.bank_checks_date, '%Y/%m/%d') AS bank_checks_date, `b1`.`bank_nickname` AS `b1_nickname`, `b2`.`bank_nickname` AS `b2_nickname`
FROM `bank_checks` `bc`
LEFT JOIN `bank` `b1` ON `b1`.`bank_id`=`bc`.`join_bank_id`
LEFT JOIN `bank` `b2` ON `b2`.`bank_id`=`bc`.`bank_checks_to_id`
WHERE `join_bank_id` = '3'
OR `bank_checks_to_id` = '3'
AND `bank_checks_status` != 'Pending'
OR  `join_bank_id` LIKE '%a%' ESCAPE '!'
OR  `bank_checks_id` LIKE '%a%' ESCAPE '!'
OR  `bank_checks_status` LIKE '%a%' ESCAPE '!'
OR  `bank_checks_memo` LIKE '%a%' ESCAPE '!'
OR  `bank_checks_memo2` LIKE '%a%' ESCAPE '!'
ORDER BY `bc`.`join_bank_id` DESC
 LIMIT 10
ERROR - 2021-09-28 08:00:34 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-28 08:00:35 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-28 08:04:18 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near ')
ORDER BY `bc`.`join_bank_id` DESC
 LIMIT 10' at line 10 - Invalid query: SELECT `bc`.*, DATE_FORMAT(bc.bank_checks_date, '%Y/%m/%d') AS bank_checks_date, `b1`.`bank_nickname` AS `b1_nickname`, `b2`.`bank_nickname` AS `b2_nickname`
FROM `bank_checks` `bc`
LEFT JOIN `bank` `b1` ON `b1`.`bank_id`=`bc`.`join_bank_id`
LEFT JOIN `bank` `b2` ON `b2`.`bank_id`=`bc`.`bank_checks_to_id`
WHERE `join_bank_id` = '3'
OR `bank_checks_to_id` = '3'
AND `bank_checks_status` != 'Pending'
OR  `bank_checks_id` LIKE '%1585%' ESCAPE '!'
OR  `bank_checks_status` LIKE '%1585%' ESCAPE '!'
)
ORDER BY `bc`.`join_bank_id` DESC
 LIMIT 10
ERROR - 2021-09-28 08:04:28 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near ')
ORDER BY `bc`.`join_bank_id` DESC
 LIMIT 10' at line 10 - Invalid query: SELECT `bc`.*, DATE_FORMAT(bc.bank_checks_date, '%Y/%m/%d') AS bank_checks_date, `b1`.`bank_nickname` AS `b1_nickname`, `b2`.`bank_nickname` AS `b2_nickname`
FROM `bank_checks` `bc`
LEFT JOIN `bank` `b1` ON `b1`.`bank_id`=`bc`.`join_bank_id`
LEFT JOIN `bank` `b2` ON `b2`.`bank_id`=`bc`.`bank_checks_to_id`
WHERE `join_bank_id` = '3'
OR `bank_checks_to_id` = '3'
AND `bank_checks_status` != 'Pending'
OR  `bank_checks_id` LIKE '%6%' ESCAPE '!'
OR  `bank_checks_status` LIKE '%6%' ESCAPE '!'
)
ORDER BY `bc`.`join_bank_id` DESC
 LIMIT 10
ERROR - 2021-09-28 08:08:21 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near ')
ORDER BY `bc`.`join_bank_id` DESC
 LIMIT 10' at line 10 - Invalid query: SELECT `bc`.*, DATE_FORMAT(bc.bank_checks_date, '%Y/%m/%d') AS bank_checks_date, `b1`.`bank_nickname` AS `b1_nickname`, `b2`.`bank_nickname` AS `b2_nickname`
FROM `bank_checks` `bc`
LEFT JOIN `bank` `b1` ON `b1`.`bank_id`=`bc`.`join_bank_id`
LEFT JOIN `bank` `b2` ON `b2`.`bank_id`=`bc`.`bank_checks_to_id`
WHERE `join_bank_id` = '3'
OR `bank_checks_to_id` = '3'
AND `bank_checks_status` != 'Pending'
OR  `bc`.`bank_checks_id` LIKE '%1585%' ESCAPE '!'
OR  `bc`.`bank_checks_status` LIKE '%1585%' ESCAPE '!'
)
ORDER BY `bc`.`join_bank_id` DESC
 LIMIT 10
ERROR - 2021-09-28 08:09:53 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near ')
ORDER BY `bc`.`join_bank_id` DESC
 LIMIT 10' at line 10 - Invalid query: SELECT `bc`.*, DATE_FORMAT(bc.bank_checks_date, '%Y/%m/%d') AS bank_checks_date, `b1`.`bank_nickname` AS `b1_nickname`, `b2`.`bank_nickname` AS `b2_nickname`
FROM `bank_checks` `bc`
LEFT JOIN `bank` `b1` ON `b1`.`bank_id`=`bc`.`join_bank_id`
LEFT JOIN `bank` `b2` ON `b2`.`bank_id`=`bc`.`bank_checks_to_id`
WHERE `join_bank_id` = '3'
OR `bank_checks_to_id` = '3'
AND `bank_checks_status` != 'Pending'
OR  `bc`.`bank_checks_id` LIKE '%1585%' ESCAPE '!'
OR  `bc`.`bank_checks_status` LIKE '%1585%' ESCAPE '!'
)
ORDER BY `bc`.`join_bank_id` DESC
 LIMIT 10
ERROR - 2021-09-28 08:10:25 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near ')
 LIMIT 10' at line 10 - Invalid query: SELECT `bc`.*, DATE_FORMAT(bc.bank_checks_date, '%Y/%m/%d') AS bank_checks_date, `b1`.`bank_nickname` AS `b1_nickname`, `b2`.`bank_nickname` AS `b2_nickname`
FROM `bank_checks` `bc`
LEFT JOIN `bank` `b1` ON `b1`.`bank_id`=`bc`.`join_bank_id`
LEFT JOIN `bank` `b2` ON `b2`.`bank_id`=`bc`.`bank_checks_to_id`
WHERE `join_bank_id` = '3'
OR `bank_checks_to_id` = '3'
AND `bank_checks_status` != 'Pending'
OR  `bc`.`bank_checks_id` LIKE '%a%' ESCAPE '!'
OR  `bc`.`bank_checks_status` LIKE '%a%' ESCAPE '!'
)
 LIMIT 10
ERROR - 2021-09-28 08:12:48 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near ')
ORDER BY `bc`.`join_bank_id` DESC
 LIMIT 10' at line 9 - Invalid query: SELECT `bc`.*, DATE_FORMAT(bc.bank_checks_date, '%Y/%m/%d') AS bank_checks_date, `b1`.`bank_nickname` AS `b1_nickname`, `b2`.`bank_nickname` AS `b2_nickname`
FROM `bank_checks` `bc`
LEFT JOIN `bank` `b1` ON `b1`.`bank_id`=`bc`.`join_bank_id`
LEFT JOIN `bank` `b2` ON `b2`.`bank_id`=`bc`.`bank_checks_to_id`
WHERE `join_bank_id` = '3'
AND `bank_checks_status` != 'Pending'
OR  `bc`.`bank_checks_id` LIKE '%d%' ESCAPE '!'
OR  `bc`.`bank_checks_status` LIKE '%d%' ESCAPE '!'
)
ORDER BY `bc`.`join_bank_id` DESC
 LIMIT 10
ERROR - 2021-09-28 08:18:19 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near ')
ORDER BY `bc`.`join_bank_id` DESC
 LIMIT 10' at line 9 - Invalid query: SELECT `bc`.*, DATE_FORMAT(bc.bank_checks_date, '%Y/%m/%d') AS bank_checks_date, `b1`.`bank_nickname` AS `b1_nickname`, `b2`.`bank_nickname` AS `b2_nickname`
FROM `bank_checks` `bc`
LEFT JOIN `bank` `b1` ON `b1`.`bank_id`=`bc`.`join_bank_id`
LEFT JOIN `bank` `b2` ON `b2`.`bank_id`=`bc`.`bank_checks_to_id`
WHERE `join_bank_id` = '3'
OR `bank_checks_to_id` = '3'
AND `bank_checks_status` != 'Pending'
OR  `bc`.`bank_checks_status` LIKE '%Deposited%' ESCAPE '!'
)
ORDER BY `bc`.`join_bank_id` DESC
 LIMIT 10
ERROR - 2021-09-28 08:22:58 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near ')
ORDER BY `bc`.`join_bank_id` DESC
 LIMIT 10' at line 10 - Invalid query: SELECT `bc`.*, DATE_FORMAT(bc.bank_checks_date, '%Y/%m/%d') AS bank_checks_date, `b1`.`bank_nickname` AS `b1_nickname`, `b2`.`bank_nickname` AS `b2_nickname`
FROM `bank_checks` `bc`
LEFT JOIN `bank` `b1` ON `b1`.`bank_id`=`bc`.`join_bank_id`
LEFT JOIN `bank` `b2` ON `b2`.`bank_id`=`bc`.`bank_checks_to_id`
WHERE `join_bank_id` = '3'
OR `bank_checks_to_id` = '3'
AND `bank_checks_status` != 'Pending'
OR  `bc`.`bank_checks_id` LIKE '%d%' ESCAPE '!'
OR  `bc`.`bank_checks_status` LIKE '%d%' ESCAPE '!'
)
ORDER BY `bc`.`join_bank_id` DESC
 LIMIT 10
ERROR - 2021-09-28 08:23:08 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near ')
ORDER BY `bc`.`join_bank_id` DESC
 LIMIT 10' at line 10 - Invalid query: SELECT `bc`.*, DATE_FORMAT(bc.bank_checks_date, '%Y/%m/%d') AS bank_checks_date, `b1`.`bank_nickname` AS `b1_nickname`, `b2`.`bank_nickname` AS `b2_nickname`
FROM `bank_checks` `bc`
LEFT JOIN `bank` `b1` ON `b1`.`bank_id`=`bc`.`join_bank_id`
LEFT JOIN `bank` `b2` ON `b2`.`bank_id`=`bc`.`bank_checks_to_id`
WHERE `join_bank_id` = '3'
OR `bank_checks_to_id` = '3'
AND `bank_checks_status` != 'Pending'
OR  `bc`.`bank_checks_id` LIKE '%d%' ESCAPE '!'
OR  `bc`.`bank_checks_status` LIKE '%d%' ESCAPE '!'
)
ORDER BY `bc`.`join_bank_id` DESC
 LIMIT 10
ERROR - 2021-09-28 08:23:57 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near ')
ORDER BY `bc`.`join_bank_id` DESC
 LIMIT 10' at line 7 - Invalid query: SELECT `bc`.*, DATE_FORMAT(bc.bank_checks_date, '%Y/%m/%d') AS bank_checks_date, `b1`.`bank_nickname` AS `b1_nickname`, `b2`.`bank_nickname` AS `b2_nickname`
FROM `bank_checks` `bc`
LEFT JOIN `bank` `b1` ON `b1`.`bank_id`=`bc`.`join_bank_id`
LEFT JOIN `bank` `b2` ON `b2`.`bank_id`=`bc`.`bank_checks_to_id`
WHERE `bc`.`bank_checks_id` LIKE '%Deposited%' ESCAPE '!'
OR  `bc`.`bank_checks_status` LIKE '%Deposited%' ESCAPE '!'
)
ORDER BY `bc`.`join_bank_id` DESC
 LIMIT 10
ERROR - 2021-09-28 08:39:40 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-28 08:39:44 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near ')
ORDER BY `bc`.`join_bank_id` DESC
 LIMIT 10' at line 10 - Invalid query: SELECT `bc`.*, DATE_FORMAT(bc.bank_checks_date, '%Y/%m/%d') AS bank_checks_date, `b1`.`bank_nickname` AS `b1_nickname`, `b2`.`bank_nickname` AS `b2_nickname`
FROM `bank_checks` `bc`
LEFT JOIN `bank` `b1` ON `b1`.`bank_id`=`bc`.`join_bank_id`
LEFT JOIN `bank` `b2` ON `b2`.`bank_id`=`bc`.`bank_checks_to_id`
WHERE `join_bank_id` = '3'
OR `bank_checks_to_id` = '3'
AND `bank_checks_status` != 'Pending'
OR  `bc`.`bank_checks_id` LIKE '%d%' ESCAPE '!'
OR  `bc`.`bank_checks_status` LIKE '%d%' ESCAPE '!'
)
ORDER BY `bc`.`join_bank_id` DESC
 LIMIT 10
ERROR - 2021-09-28 08:43:04 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-28 08:43:05 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'LIKE '%a%' ESCAPE '!' 
OR  `bc`.`bank_checks_date` LIKE '%a%' ESCAPE '!'
OR  ...' at line 8 - Invalid query: SELECT `bc`.*, DATE_FORMAT(bc.bank_checks_date, '%Y/%m/%d') AS bank_checks_date, `b1`.`bank_nickname` AS `b1_nickname`, `b2`.`bank_nickname` AS `b2_nickname`
FROM `bank_checks` `bc`
LEFT JOIN `bank` `b1` ON `b1`.`bank_id`=`bc`.`join_bank_id`
LEFT JOIN `bank` `b2` ON `b2`.`bank_id`=`bc`.`bank_checks_to_id`
WHERE `join_bank_id` = '3'
OR `bank_checks_to_id` = '3'
AND `bank_checks_status` != 'Pending'
OR    LIKE '%a%' ESCAPE '!' 
OR  `bc`.`bank_checks_date` LIKE '%a%' ESCAPE '!'
OR  `bc`.`bank_checks_memo` LIKE '%a%' ESCAPE '!'
OR  `bc`.`bank_checks_id` LIKE '%a%' ESCAPE '!'
OR  `bc`.`bank_checks_status` LIKE '%a%' ESCAPE '!'
)
ORDER BY `bc`.`join_bank_id` DESC
 LIMIT 10
ERROR - 2021-09-28 08:44:37 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-28 08:44:43 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near ')
ORDER BY `bc`.`join_bank_id` DESC
 LIMIT 10' at line 7 - Invalid query: SELECT `bc`.*, DATE_FORMAT(bc.bank_checks_date, '%Y/%m/%d') AS bank_checks_date, `b1`.`bank_nickname` AS `b1_nickname`, `b2`.`bank_nickname` AS `b2_nickname`
FROM `bank_checks` `bc`
LEFT JOIN `bank` `b1` ON `b1`.`bank_id`=`bc`.`join_bank_id`
LEFT JOIN `bank` `b2` ON `b2`.`bank_id`=`bc`.`bank_checks_to_id`
WHERE `bc`.`bank_checks_id` LIKE '%d%' ESCAPE '!'
OR  `bc`.`bank_checks_status` LIKE '%d%' ESCAPE '!'
)
ORDER BY `bc`.`join_bank_id` DESC
 LIMIT 10
ERROR - 2021-09-28 08:45:17 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-28 08:45:21 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near ')
ORDER BY `bc`.`join_bank_id` DESC
 LIMIT 10' at line 10 - Invalid query: SELECT `bc`.*, DATE_FORMAT(bc.bank_checks_date, '%Y/%m/%d') AS bank_checks_date, `b1`.`bank_nickname` AS `b1_nickname`, `b2`.`bank_nickname` AS `b2_nickname`
FROM `bank_checks` `bc`
LEFT JOIN `bank` `b1` ON `b1`.`bank_id`=`bc`.`join_bank_id`
LEFT JOIN `bank` `b2` ON `b2`.`bank_id`=`bc`.`bank_checks_to_id`
WHERE `join_bank_id` = '3'
OR `bank_checks_to_id` = '3'
AND `bank_checks_status` != 'Pending'
OR  `bc`.`bank_checks_id` LIKE '%d%' ESCAPE '!'
OR  `bc`.`bank_checks_status` LIKE '%d%' ESCAPE '!'
)
ORDER BY `bc`.`join_bank_id` DESC
 LIMIT 10
ERROR - 2021-09-28 08:45:37 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-28 08:46:51 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-28 08:47:16 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-28 08:47:31 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-28 08:48:27 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-28 08:49:12 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-28 08:49:32 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-28 08:50:15 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-28 08:50:56 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-28 08:51:29 --> Severity: error --> Exception: syntax error, unexpected end of file, expecting function (T_FUNCTION) or const (T_CONST) D:\xampp\htdocs\hfshcalpha\application\models\Bank.php 1126
ERROR - 2021-09-28 08:51:35 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-28 08:52:30 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-28 08:52:49 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-28 08:54:49 --> Severity: Error --> Maximum execution time of 120 seconds exceeded D:\xampp\htdocs\hfshcalpha\system\libraries\Session\drivers\Session_files_driver.php 212
ERROR - 2021-09-28 08:54:49 --> Severity: Error --> Maximum execution time of 120 seconds exceeded D:\xampp\htdocs\hfshcalpha\application\models\Strings.php 1
ERROR - 2021-09-28 08:54:55 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-28 08:55:00 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-28 08:57:16 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-28 08:57:17 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-28 08:57:51 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-28 08:59:19 --> Severity: Error --> Maximum execution time of 120 seconds exceeded D:\xampp\htdocs\hfshcalpha\system\libraries\Session\drivers\Session_files_driver.php 212
ERROR - 2021-09-28 08:59:19 --> Severity: Error --> Maximum execution time of 120 seconds exceeded D:\xampp\htdocs\hfshcalpha\system\libraries\Session\drivers\Session_files_driver.php 212
ERROR - 2021-09-28 09:00:02 --> Severity: Error --> Maximum execution time of 120 seconds exceeded D:\xampp\htdocs\hfshcalpha\system\libraries\Session\drivers\Session_files_driver.php 212
ERROR - 2021-09-28 09:00:02 --> Severity: Error --> Maximum execution time of 120 seconds exceeded D:\xampp\htdocs\hfshcalpha\system\database\drivers\mysqli\mysqli_driver.php 305
ERROR - 2021-09-28 09:00:55 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-28 09:03:05 --> Severity: Error --> Maximum execution time of 120 seconds exceeded D:\xampp\htdocs\hfshcalpha\system\libraries\Session\drivers\Session_files_driver.php 217
ERROR - 2021-09-28 09:03:05 --> Severity: Error --> Maximum execution time of 120 seconds exceeded D:\xampp\htdocs\hfshcalpha\system\libraries\Session\drivers\Session_files_driver.php 212
ERROR - 2021-09-28 09:05:08 --> Severity: Error --> Maximum execution time of 120 seconds exceeded D:\xampp\htdocs\hfshcalpha\system\libraries\Session\drivers\Session_files_driver.php 212
ERROR - 2021-09-28 09:05:08 --> Severity: Error --> Maximum execution time of 120 seconds exceeded D:\xampp\htdocs\hfshcalpha\system\libraries\Session\drivers\Session_files_driver.php 212
ERROR - 2021-09-28 09:06:23 --> Severity: Error --> Maximum execution time of 120 seconds exceeded D:\xampp\htdocs\hfshcalpha\system\libraries\Session\drivers\Session_files_driver.php 212
ERROR - 2021-09-28 09:06:30 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-28 09:06:58 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-28 09:12:28 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-28 09:12:39 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-28 09:15:36 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-28 09:26:54 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-28 09:27:30 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-28 09:27:32 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-28 09:33:57 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-28 09:34:02 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-28 09:34:09 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-28 09:34:16 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-28 09:37:54 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-28 09:44:28 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-28 10:25:54 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-28 10:26:25 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-28 10:32:51 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-28 10:38:10 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-28 10:45:26 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-28 10:49:43 --> 404 Page Not Found: super-admin/Members/inactive
ERROR - 2021-09-28 10:49:48 --> Query error: Unknown column 'status' in 'where clause' - Invalid query: SELECT *
FROM `players`
WHERE `status` = 0
AND `players_deleted` = 0
ORDER BY `players_id` DESC
 LIMIT 10
ERROR - 2021-09-28 11:03:38 --> 404 Page Not Found: Assets/admin
