<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2018-09-09 14:03:17 --> Severity: error --> Exception: Cannot use object of type Horse as array /home/wzyzjm74avny/public_html/hfdev/application/models/Horse.php 175
ERROR - 2018-09-09 14:06:49 --> Severity: error --> Exception: syntax error, unexpected ';', expecting ',' or ')' /home/wzyzjm74avny/public_html/hfdev/application/models/Horse.php 171
ERROR - 2018-09-09 14:06:51 --> Severity: error --> Exception: syntax error, unexpected ';', expecting ',' or ')' /home/wzyzjm74avny/public_html/hfdev/application/models/Horse.php 171
ERROR - 2018-09-09 14:11:29 --> Severity: error --> Exception: syntax error, unexpected end of file /home/wzyzjm74avny/public_html/hfdev/application/models/Horse.php 343
ERROR - 2018-09-09 14:12:49 --> Severity: error --> Exception: /home/wzyzjm74avny/public_html/hfdev/application/models/Horse.php exists, but doesn't declare class Horse /home/wzyzjm74avny/public_html/hfdev/system/core/Loader.php 340
ERROR - 2018-09-09 14:13:33 --> Severity: error --> Exception: Using $this when not in object context /home/wzyzjm74avny/public_html/hfdev/application/models/Horse.php 190
ERROR - 2018-09-09 14:15:36 --> Severity: error --> Exception: syntax error, unexpected ''playe' (T_ENCAPSED_AND_WHITESPACE), expecting ']' /home/wzyzjm74avny/public_html/hfdev/application/models/Horse.php 344
ERROR - 2018-09-09 14:19:07 --> Severity: error --> Exception: Using $this when not in object context /home/wzyzjm74avny/public_html/hfdev/application/models/Horse.php 190
ERROR - 2018-09-09 14:19:09 --> Severity: error --> Exception: Using $this when not in object context /home/wzyzjm74avny/public_html/hfdev/application/models/Horse.php 190
ERROR - 2018-09-09 14:19:41 --> Severity: error --> Exception: Cannot use object of type Player as array /home/wzyzjm74avny/public_html/hfdev/application/models/Horse.php 190
ERROR - 2018-09-09 14:19:59 --> Severity: error --> Exception: Cannot use object of type Player as array /home/wzyzjm74avny/public_html/hfdev/application/models/Horse.php 190
ERROR - 2018-09-09 14:20:00 --> Severity: error --> Exception: Cannot use object of type Player as array /home/wzyzjm74avny/public_html/hfdev/application/models/Horse.php 191
ERROR - 2018-09-09 14:20:12 --> Severity: error --> Exception: syntax error, unexpected ''SE' (T_ENCAPSED_AND_WHITESPACE) /home/wzyzjm74avny/public_html/hfdev/application/models/Horse.php 34
ERROR - 2018-09-09 14:21:37 --> Severity: error --> Exception: syntax error, unexpected end of file /home/wzyzjm74avny/public_html/hfdev/application/models/Horse.php 344
ERROR - 2018-09-09 14:25:49 --> Query error: Column 'join_mares_id' cannot be null - Invalid query: INSERT INTO `horses_breedings` (`join_horses_id`, `join_mares_id`) VALUES ('55', NULL)
ERROR - 2018-09-09 14:26:20 --> Severity: error --> Exception: Using $this when not in object context /home/wzyzjm74avny/public_html/hfdev/application/models/Horse.php 248
ERROR - 2018-09-09 14:26:33 --> Severity: error --> Exception: Using $this when not in object context /home/wzyzjm74avny/public_html/hfdev/application/models/Horse.php 248
ERROR - 2018-09-09 15:13:47 --> Query error: Unknown column 'b.mares_id' in 'on clause' - Invalid query: SELECT b.*, h.* FROM horses_breedings b LEFT JOIN horses h ON b.mares_id=h.horses_id WHERE b.join_horses_id='55'
ERROR - 2018-09-09 15:14:10 --> Severity: error --> Exception: Call to undefined function num_format() /home/wzyzjm74avny/public_html/hfdev/application/views/horses/breed.php 80
ERROR - 2018-09-09 15:14:12 --> Severity: error --> Exception: Call to undefined function num_format() /home/wzyzjm74avny/public_html/hfdev/application/views/horses/breed.php 80
ERROR - 2018-09-09 15:14:31 --> Severity: error --> Exception: Call to undefined function num_format() /home/wzyzjm74avny/public_html/hfdev/application/views/horses/breed.php 80
ERROR - 2018-09-09 15:56:14 --> Severity: error --> Exception: Unable to locate the model you have specified: Bank /home/wzyzjm74avny/public_html/hfdev/system/core/Loader.php 348
ERROR - 2018-09-09 16:36:46 --> Severity: 8192 --> Non-static method Bank::get_accounts() should not be called statically /home/wzyzjm74avny/public_html/hfdev/application/controllers/City.php 31
ERROR - 2018-09-09 16:36:46 --> Severity: error --> Exception: Using $this when not in object context /home/wzyzjm74avny/public_html/hfdev/application/models/Bank.php 11
ERROR - 2018-09-09 16:36:58 --> Severity: error --> Exception: Using $this when not in object context /home/wzyzjm74avny/public_html/hfdev/application/models/Bank.php 11
ERROR - 2018-09-09 16:37:00 --> Severity: error --> Exception: Using $this when not in object context /home/wzyzjm74avny/public_html/hfdev/application/models/Bank.php 11
ERROR - 2018-09-09 16:37:24 --> Severity: error --> Exception: Using $this when not in object context /home/wzyzjm74avny/public_html/hfdev/application/models/Bank.php 11
ERROR - 2018-09-09 16:45:17 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '? OR bank_checks_to_id=?) AND bank_checks_status='Pending'' at line 3 - Invalid query: 
					SELECT join_bank_id, bank_checks_amount, bank_checks_status
					FROM bank_checks
					WHERE (join_bank_id=? OR bank_checks_to_id=?) AND bank_checks_status='Pending'
				
ERROR - 2018-09-09 16:45:17 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '? OR bank_checks_to_id=?) AND bank_checks_status='Pending'' at line 3 - Invalid query: 
					SELECT join_bank_id, bank_checks_amount, bank_checks_status
					FROM bank_checks
					WHERE (join_bank_id=? OR bank_checks_to_id=?) AND bank_checks_status='Pending'
				
ERROR - 2018-09-09 16:48:22 --> 404 Page Not Found: City/bank_account
ERROR - 2018-09-09 16:57:09 --> 404 Page Not Found: City/bank_account
ERROR - 2018-09-09 16:57:10 --> Severity: error --> Exception: Call to a member function query() on null /home/wzyzjm74avny/public_html/hfdev/application/models/Bank.php 29
ERROR - 2018-09-09 16:57:12 --> Severity: error --> Exception: Call to a member function query() on null /home/wzyzjm74avny/public_html/hfdev/application/models/Bank.php 29
ERROR - 2018-09-09 16:57:25 --> Query error: Unknown table 'bc' - Invalid query: 
				SELECT bc.*
				FROM bank_checks
				WHERE (join_bank_id='1' OR bank_checks_to_id='1') AND bank_checks_status='Pending'
			
ERROR - 2018-09-09 16:57:26 --> Query error: Unknown table 'bc' - Invalid query: 
				SELECT bc.*
				FROM bank_checks
				WHERE (join_bank_id='1' OR bank_checks_to_id='1') AND bank_checks_status='Pending'
			
ERROR - 2018-09-09 16:57:31 --> Query error: Unknown table 'bc' - Invalid query: 
				SELECT bc.*
				FROM bank_checks
				WHERE (join_bank_id='1' OR bank_checks_to_id='1') AND bank_checks_status='Pending'
			
ERROR - 2018-09-09 17:36:48 --> Severity: error --> Exception: syntax error, unexpected ')', expecting ',' or ';' /home/wzyzjm74avny/public_html/hfdev/application/views/city/bank_account.php 24
ERROR - 2018-09-09 17:36:49 --> Severity: error --> Exception: syntax error, unexpected ')', expecting ',' or ';' /home/wzyzjm74avny/public_html/hfdev/application/views/city/bank_account.php 24
ERROR - 2018-09-09 17:36:56 --> Severity: error --> Exception: syntax error, unexpected ')', expecting ',' or ';' /home/wzyzjm74avny/public_html/hfdev/application/views/city/bank_account.php 24
ERROR - 2018-09-09 17:52:57 --> 404 Page Not Found: City/bank_account
ERROR - 2018-09-09 18:05:03 --> Query error: Unknown column 'b.bank_id' in 'on clause' - Invalid query: 
				SELECT bc.*, b1.bank_nickname AS b1_nickname, b2.bank_nickname AS b2_nickname
				FROM bank_checks bc
					LEFT JOIN bank b1 ON b.bank_id=bc.join_bank_id
					LEFT JOIN bank b2 ON b.bank_id=bc.bank_checks_to_id
				WHERE (join_bank_id='1' OR bank_checks_to_id='1')
				ORDER BY bank_checks_date DESC
			
ERROR - 2018-09-09 18:05:04 --> Query error: Unknown column 'b.bank_id' in 'on clause' - Invalid query: 
				SELECT bc.*, b1.bank_nickname AS b1_nickname, b2.bank_nickname AS b2_nickname
				FROM bank_checks bc
					LEFT JOIN bank b1 ON b.bank_id=bc.join_bank_id
					LEFT JOIN bank b2 ON b.bank_id=bc.bank_checks_to_id
				WHERE (join_bank_id='1' OR bank_checks_to_id='1')
				ORDER BY bank_checks_date DESC
			
ERROR - 2018-09-09 23:36:02 --> 404 Page Not Found: Faviconico/index
