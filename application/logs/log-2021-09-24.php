<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2021-09-24 05:05:41 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-24 05:46:02 --> Severity: error --> Exception: syntax error, unexpected '$this' (T_VARIABLE) D:\xampp\htdocs\hfshcalpha\application\controllers\super-admin\Banks.php 89
ERROR - 2021-09-24 07:08:06 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-24 07:10:37 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-24 07:11:25 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-24 07:12:40 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-24 07:13:12 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-24 07:13:12 --> Severity: error --> Exception: Using $this when not in object context D:\xampp\htdocs\hfshcalpha\application\models\Bank.php 1077
ERROR - 2021-09-24 07:15:30 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-24 07:15:30 --> Severity: error --> Exception: Using $this when not in object context D:\xampp\htdocs\hfshcalpha\application\models\Bank.php 1077
ERROR - 2021-09-24 07:16:29 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-24 07:16:29 --> Severity: error --> Exception: Using $this when not in object context D:\xampp\htdocs\hfshcalpha\application\models\Bank.php 1077
ERROR - 2021-09-24 07:18:04 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-24 07:18:04 --> Severity: error --> Exception: Using $this when not in object context D:\xampp\htdocs\hfshcalpha\application\models\Bank.php 1078
ERROR - 2021-09-24 07:20:48 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-24 07:20:48 --> Severity: error --> Exception: Using $this when not in object context D:\xampp\htdocs\hfshcalpha\application\models\Bank.php 1089
ERROR - 2021-09-24 07:22:38 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-24 07:22:38 --> Severity: error --> Exception: Using $this when not in object context D:\xampp\htdocs\hfshcalpha\application\models\Bank.php 1077
ERROR - 2021-09-24 07:22:54 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-24 07:22:54 --> Severity: error --> Exception: Using $this when not in object context D:\xampp\htdocs\hfshcalpha\application\models\Bank.php 1077
ERROR - 2021-09-24 07:24:11 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-24 07:24:11 --> Severity: error --> Exception: Using $this when not in object context D:\xampp\htdocs\hfshcalpha\application\models\Bank.php 1077
ERROR - 2021-09-24 07:26:29 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-24 07:26:30 --> Query error: Column 'bank_id' in order clause is ambiguous - Invalid query: SELECT `bc`.*, DATE_FORMAT(bc.bank_checks_date, '%Y/%m/%d') AS bank_checks_date, `b1`.`bank_nickname` AS `b1_nickname`, `b2`.`bank_nickname` AS `b2_nickname`
FROM `bank_checks` `bc`
LEFT JOIN `bank` `b1` ON `b1`.`bank_id`=`bc`.`join_bank_id`
LEFT JOIN `bank` `b2` ON `b2`.`bank_id`=`bc`.`bank_checks_to_id`
WHERE `join_bank_id` = '3'
OR `bank_checks_to_id` = '3'
ORDER BY `bank_id` DESC
 LIMIT 10
ERROR - 2021-09-24 07:27:18 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-24 07:27:18 --> Query error: Unknown column 'bc.bank_id' in 'order clause' - Invalid query: SELECT `bc`.*, DATE_FORMAT(bc.bank_checks_date, '%Y/%m/%d') AS bank_checks_date, `b1`.`bank_nickname` AS `b1_nickname`, `b2`.`bank_nickname` AS `b2_nickname`
FROM `bank_checks` `bc`
LEFT JOIN `bank` `b1` ON `b1`.`bank_id`=`bc`.`join_bank_id`
LEFT JOIN `bank` `b2` ON `b2`.`bank_id`=`bc`.`bank_checks_to_id`
WHERE `join_bank_id` = '3'
OR `bank_checks_to_id` = '3'
ORDER BY `bc`.`bank_id` DESC
 LIMIT 10
ERROR - 2021-09-24 07:28:11 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-24 07:28:11 --> Query error: Unknown column 'bank.bank_id' in 'order clause' - Invalid query: SELECT `bc`.*, DATE_FORMAT(bc.bank_checks_date, '%Y/%m/%d') AS bank_checks_date, `b1`.`bank_nickname` AS `b1_nickname`, `b2`.`bank_nickname` AS `b2_nickname`
FROM `bank_checks` `bc`
LEFT JOIN `bank` `b1` ON `b1`.`bank_id`=`bc`.`join_bank_id`
LEFT JOIN `bank` `b2` ON `b2`.`bank_id`=`bc`.`bank_checks_to_id`
WHERE `join_bank_id` = '3'
OR `bank_checks_to_id` = '3'
ORDER BY `bank`.`bank_id` DESC
 LIMIT 10
ERROR - 2021-09-24 07:28:18 --> Query error: Unknown column 'bank_checks.bank_id' in 'order clause' - Invalid query: SELECT `bc`.*, DATE_FORMAT(bc.bank_checks_date, '%Y/%m/%d') AS bank_checks_date, `b1`.`bank_nickname` AS `b1_nickname`, `b2`.`bank_nickname` AS `b2_nickname`
FROM `bank_checks` `bc`
LEFT JOIN `bank` `b1` ON `b1`.`bank_id`=`bc`.`join_bank_id`
LEFT JOIN `bank` `b2` ON `b2`.`bank_id`=`bc`.`bank_checks_to_id`
WHERE `join_bank_id` = '3'
OR `bank_checks_to_id` = '3'
ORDER BY `bank_checks`.`bank_id` DESC
 LIMIT 10
ERROR - 2021-09-24 07:28:44 --> Query error: Unknown column 'bc.bank_id' in 'order clause' - Invalid query: SELECT `bc`.*, DATE_FORMAT(bc.bank_checks_date, '%Y/%m/%d') AS bank_checks_date, `b1`.`bank_nickname` AS `b1_nickname`, `b2`.`bank_nickname` AS `b2_nickname`
FROM `bank_checks` `bc`
LEFT JOIN `bank` `b1` ON `b1`.`bank_id`=`bc`.`join_bank_id`
LEFT JOIN `bank` `b2` ON `b2`.`bank_id`=`bc`.`bank_checks_to_id`
WHERE `join_bank_id` = '3'
OR `bank_checks_to_id` = '3'
ORDER BY `bc`.`bank_id` DESC
 LIMIT 10
ERROR - 2021-09-24 07:36:41 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-24 15:30:05 --> 404 Page Not Found: Assets/admin
ERROR - 2021-09-24 15:42:59 --> 404 Page Not Found: Assets/admin
