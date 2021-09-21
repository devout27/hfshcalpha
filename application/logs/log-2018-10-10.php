<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2018-10-10 14:21:21 --> 404 Page Not Found: Faviconico/index
ERROR - 2018-10-10 16:38:13 --> Severity: Compile Error --> Cannot redeclare Bank::admin_accept_application() /home/wzyzjm74avny/public_html/hfdev/application/models/Bank.php 578
ERROR - 2018-10-10 16:42:00 --> Query error: Unknown column 'b.bank_pending' in 'field list' - Invalid query: UPDATE bank SET b.bank_pending=0 WHERE bank_id='34'
ERROR - 2018-10-10 16:59:08 --> Query error: Unknown column 'bank_loans_id' in 'field list' - Invalid query: INSERT INTO `bank` (`bank_loans_id`, `accept`, `join_players_id`, `bank_type`, `bank_balance`, `bank_credit_limit`, `bank_credit_payment_date`, `bank_nickname`) VALUES ('5', 'Accept', '1', 'Loan', 0, NULL, '2018-11-30', 'Loan')
ERROR - 2018-10-10 16:59:47 --> Query error: Unknown column 'bank_credit_payment_date' in 'field list' - Invalid query: INSERT INTO `bank` (`join_players_id`, `bank_type`, `bank_balance`, `bank_credit_limit`, `bank_credit_payment_date`, `bank_nickname`) VALUES ('1', 'Loan', 0, NULL, '2018-11-30', 'Loan')
ERROR - 2018-10-10 17:00:11 --> Query error: Column 'bank_credit_limit' cannot be null - Invalid query: INSERT INTO `bank` (`join_players_id`, `bank_type`, `bank_balance`, `bank_credit_limit`, `bank_credit_payment_due`, `bank_nickname`) VALUES ('1', 'Loan', 0, NULL, '2018-11-30', 'Loan')
ERROR - 2018-10-10 17:19:48 --> Query error: Unknown table 'b' - Invalid query: 
				SELECT b.*, p.players_nickname, DATEDIFF(NOW(), bank_credit_payment_due) AS days_late
				FROM bank bl
					LEFT JOIN players p ON p.players_id=b.join_players_id
				WHERE
					b.bank_credit_payment_due!='0000-00-00' AND b.bank_credit_payment_due<NOW()
				ORDER BY bank_credit_payment_due ASC
			
ERROR - 2018-10-10 18:02:03 --> Severity: error --> Exception: Call to undefined method Bank::search() /home/wzyzjm74avny/public_html/hfdev/application/controllers/Admin.php 302
ERROR - 2018-10-10 18:05:03 --> Severity: error --> Exception: syntax error, unexpected '}', expecting end of file /home/wzyzjm74avny/public_html/hfdev/application/models/Bank.php 731
ERROR - 2018-10-10 18:05:08 --> Severity: error --> Exception: syntax error, unexpected '}', expecting end of file /home/wzyzjm74avny/public_html/hfdev/application/models/Bank.php 731
ERROR - 2018-10-10 18:05:30 --> Query error: Unknown table 'b' - Invalid query: 
			SELECT b.*, p.players_nickname
			FROM cabs AS c
			LEFT JOIN players p ON p.players_id=b.join_players_id
			WHERE cabs_pending=0 AND cabs_disabled=0
		
ERROR - 2018-10-10 18:05:44 --> Query error: Unknown column 'cabs_pending' in 'where clause' - Invalid query: 
			SELECT b.*, p.players_nickname
			FROM bank AS b
			LEFT JOIN players p ON p.players_id=b.join_players_id
			WHERE cabs_pending=0 AND cabs_disabled=0
		
ERROR - 2018-10-10 18:10:51 --> Severity: error --> Exception: syntax error, unexpected end of file /home/wzyzjm74avny/public_html/hfdev/application/models/Bank.php 528
ERROR - 2018-10-10 18:11:14 --> Severity: error --> Exception: /home/wzyzjm74avny/public_html/hfdev/application/models/Bank.php exists, but doesn't declare class Bank /home/wzyzjm74avny/public_html/hfdev/system/core/Loader.php 340
ERROR - 2018-10-10 18:30:27 --> 404 Page Not Found: Admin/cabs
ERROR - 2018-10-10 18:31:50 --> Severity: error --> Exception: syntax error, unexpected ''CAB' (T_ENCAPSED_AND_WHITESPACE) /home/wzyzjm74avny/public_html/hfdev/application/views/admin/index.php 38
ERROR - 2018-10-10 19:54:54 --> Severity: error --> Exception: /home/wzyzjm74avny/public_html/hfdev/application/models/Cabs.php exists, but doesn't declare class Cabs /home/wzyzjm74avny/public_html/hfdev/system/core/Loader.php 340
ERROR - 2018-10-10 20:09:35 --> Severity: error --> Exception: syntax error, unexpected end of file, expecting ']' /home/wzyzjm74avny/public_html/hfdev/application/controllers/City.php 109
ERROR - 2018-10-10 20:09:36 --> Severity: error --> Exception: syntax error, unexpected end of file, expecting identifier (T_STRING) or variable (T_VARIABLE) or '{' or '$' /home/wzyzjm74avny/public_html/hfdev/application/controllers/City.php 227
ERROR - 2018-10-10 20:09:38 --> Severity: error --> Exception: syntax error, unexpected end of file, expecting identifier (T_STRING) or variable (T_VARIABLE) or '{' or '$' /home/wzyzjm74avny/public_html/hfdev/application/controllers/City.php 227
ERROR - 2018-10-10 20:17:42 --> Severity: error --> Exception: Cannot use object of type Player as array /home/wzyzjm74avny/public_html/hfdev/application/controllers/City.php 210
ERROR - 2018-10-10 20:17:54 --> Severity: error --> Exception: Cannot use object of type Player as array /home/wzyzjm74avny/public_html/hfdev/application/controllers/City.php 210
ERROR - 2018-10-10 20:25:16 --> Severity: error --> Exception: syntax error, unexpected end of file /home/wzyzjm74avny/public_html/hfdev/application/controllers/City.php 258
ERROR - 2018-10-10 20:25:36 --> 404 Page Not Found: Faviconico/index
ERROR - 2018-10-10 20:33:21 --> 404 Page Not Found: Admin/cabs_enable
ERROR - 2018-10-10 20:38:50 --> 404 Page Not Found: Admin/articles
ERROR - 2018-10-10 21:07:37 --> 404 Page Not Found: Js/tinymce
ERROR - 2018-10-10 21:09:40 --> 404 Page Not Found: Js/tinymce
ERROR - 2018-10-10 21:11:53 --> 404 Page Not Found: Js/tinymce
ERROR - 2018-10-10 21:12:00 --> 404 Page Not Found: Js/tinymce
ERROR - 2018-10-10 21:12:10 --> 404 Page Not Found: 5/index
ERROR - 2018-10-10 21:12:27 --> 404 Page Not Found: Js/tinymce
ERROR - 2018-10-10 21:12:30 --> 404 Page Not Found: Js/tinymce
ERROR - 2018-10-10 21:12:38 --> 404 Page Not Found: Admin/articles
ERROR - 2018-10-10 21:13:08 --> 404 Page Not Found: Js/tinymce
ERROR - 2018-10-10 21:20:32 --> 404 Page Not Found: Js/tinymce
ERROR - 2018-10-10 21:27:26 --> 404 Page Not Found: Admin/admin
ERROR - 2018-10-10 21:27:36 --> Severity: error --> Exception: syntax error, unexpected end of file, expecting elseif (T_ELSEIF) or else (T_ELSE) or endif (T_ENDIF) /home/wzyzjm74avny/public_html/hfdev/application/views/admin/index.php 131
ERROR - 2018-10-10 21:27:39 --> 404 Page Not Found: Faviconico/index
ERROR - 2018-10-10 21:37:29 --> 404 Page Not Found: City/articles
