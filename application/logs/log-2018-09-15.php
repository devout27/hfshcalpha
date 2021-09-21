<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2018-09-15 03:27:50 --> 404 Page Not Found: Faviconico/index
ERROR - 2018-09-15 15:07:34 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '?,?,?,?,?)' at line 1 - Invalid query: INSERT INTO bank_checks(join_bank_id, bank_checks_to_id, bank_checks_amount, bank_checks_memo, bank_checks_status) VALUES(?,?,?,?,?)
ERROR - 2018-09-15 15:08:04 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '?,?,?,?,?)' at line 1 - Invalid query: INSERT INTO bank_checks(join_bank_id, bank_checks_to_id, bank_checks_amount, bank_checks_memo, bank_checks_status) VALUES(?,?,?,?,?)
ERROR - 2018-09-15 15:12:32 --> 404 Page Not Found: Faviconico/index
ERROR - 2018-09-15 15:13:06 --> 404 Page Not Found: Faviconico/index
ERROR - 2018-09-15 15:14:58 --> 404 Page Not Found: Faviconico/index
ERROR - 2018-09-15 15:19:08 --> Severity: error --> Exception: syntax error, unexpected end of file /home/wzyzjm74avny/public_html/hfdev/application/views/city/bank-savings.php 56
ERROR - 2018-09-15 15:40:42 --> 404 Page Not Found: Faviconico/index
ERROR - 2018-09-15 16:02:20 --> Severity: error --> Exception: syntax error, unexpected '?>', expecting ',' or ')' /home/wzyzjm74avny/public_html/hfdev/application/views/city/bank-loan.php 32
ERROR - 2018-09-15 16:02:21 --> Severity: error --> Exception: syntax error, unexpected '?>', expecting ',' or ')' /home/wzyzjm74avny/public_html/hfdev/application/views/city/bank-loan.php 32
ERROR - 2018-09-15 16:02:21 --> Severity: error --> Exception: syntax error, unexpected '?>', expecting ',' or ')' /home/wzyzjm74avny/public_html/hfdev/application/views/city/bank-loan.php 32
ERROR - 2018-09-15 16:04:42 --> Severity: error --> Exception: syntax error, unexpected '?>', expecting ',' or ')' /home/wzyzjm74avny/public_html/hfdev/application/views/city/bank-loan.php 32
ERROR - 2018-09-15 16:04:48 --> Severity: error --> Exception: syntax error, unexpected '?>', expecting ',' or ')' /home/wzyzjm74avny/public_html/hfdev/application/views/city/bank-loan.php 32
ERROR - 2018-09-15 16:32:31 --> 404 Page Not Found: Faviconico/index
ERROR - 2018-09-15 16:32:48 --> Severity: error --> Exception: Too few arguments to function City::transfer(), 0 passed in /home/wzyzjm74avny/public_html/hfdev/system/core/CodeIgniter.php on line 532 and exactly 1 expected /home/wzyzjm74avny/public_html/hfdev/application/controllers/City.php 108
ERROR - 2018-09-15 16:32:49 --> Severity: error --> Exception: Too few arguments to function City::transfer(), 0 passed in /home/wzyzjm74avny/public_html/hfdev/system/core/CodeIgniter.php on line 532 and exactly 1 expected /home/wzyzjm74avny/public_html/hfdev/application/controllers/City.php 108
ERROR - 2018-09-15 16:33:56 --> 404 Page Not Found: Faviconico/index
ERROR - 2018-09-15 16:34:30 --> 404 Page Not Found: Faviconico/index
ERROR - 2018-09-15 16:34:32 --> 404 Page Not Found: Faviconico/index
ERROR - 2018-09-15 16:34:44 --> 404 Page Not Found: Faviconico/index
ERROR - 2018-09-15 16:34:46 --> 404 Page Not Found: Faviconico/index
ERROR - 2018-09-15 16:46:40 --> 404 Page Not Found: Faviconico/index
ERROR - 2018-09-15 16:50:05 --> 404 Page Not Found: Faviconico/index
ERROR - 2018-09-15 17:12:08 --> 404 Page Not Found: Faviconico/index
ERROR - 2018-09-15 17:12:13 --> Query error: Unknown table 'bc' - Invalid query: 
				SELECT bc.*,
					bf.bank_balance, bf.bank_pending, bf.bank_closed, bf.bank_type,
					bt.bank_balance AS bank_balance2, bt.bank_pending AS bank_pending2, bt.bank_closed AS bank_closed2, bt.bank_type AS bank_type2
				FROM bank_checks
					LEFT JOIN bank bf ON bc.join_bank_id=bf.bank_id
					LEFT JOIN bank bt ON bc.bank_checks_to_id=bt.bank_id
				WHERE bank_checks_id='16' AND bank_checks_status='Pending'
			
ERROR - 2018-09-15 17:53:38 --> 404 Page Not Found: Horse/update
ERROR - 2018-09-15 17:53:42 --> 404 Page Not Found: Horse/transfer
