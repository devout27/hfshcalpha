<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2019-04-28 07:01:02 --> Query error: Column 'log_ip' cannot be null - Invalid query: INSERT INTO log(join_players_id, log_date, log_ip, log_activity)
				VALUES (0, NOW(), NULL, 'Cron: Start Bank Transfers')
ERROR - 2019-04-28 07:02:01 --> Query error: Column 'log_ip' cannot be null - Invalid query: INSERT INTO log(join_players_id, log_date, log_ip, log_activity)
				VALUES (0, NOW(), NULL, 'Cron: Start Auctions')
ERROR - 2019-04-28 07:03:01 --> Query error: Column 'log_ip' cannot be null - Invalid query: INSERT INTO log(join_players_id, log_date, log_ip, log_activity)
				VALUES (0, NOW(), NULL, 'Cron: Start Retirement')
ERROR - 2019-04-28 15:19:12 --> Severity: error --> Exception: syntax error, unexpected '$this' (T_VARIABLE) /home/wzyzjm74avny/public_html/hfdev/application/controllers/City.php 64
ERROR - 2019-04-28 15:19:13 --> Severity: error --> Exception: syntax error, unexpected '$this' (T_VARIABLE) /home/wzyzjm74avny/public_html/hfdev/application/controllers/City.php 64
ERROR - 2019-04-28 15:19:14 --> Severity: error --> Exception: syntax error, unexpected '$this' (T_VARIABLE) /home/wzyzjm74avny/public_html/hfdev/application/controllers/City.php 64
ERROR - 2019-04-28 15:19:42 --> Severity: error --> Exception: syntax error, unexpected '$this' (T_VARIABLE) /home/wzyzjm74avny/public_html/hfdev/application/controllers/City.php 63
ERROR - 2019-04-28 15:19:43 --> Severity: error --> Exception: syntax error, unexpected '$this' (T_VARIABLE) /home/wzyzjm74avny/public_html/hfdev/application/controllers/City.php 63
ERROR - 2019-04-28 15:20:03 --> Severity: error --> Exception: syntax error, unexpected '$this' (T_VARIABLE) /home/wzyzjm74avny/public_html/hfdev/application/controllers/City.php 63
ERROR - 2019-04-28 16:03:04 --> Could not find the language line "form_validation_date_valid"
ERROR - 2019-04-28 16:06:21 --> Severity: error --> Exception: Call to a member function set_message() on null /home/wzyzjm74avny/public_html/hfdev/application/libraries/MY_Form_validation.php 28
ERROR - 2019-04-28 16:07:01 --> Could not find the language line "form_validation_date_valid"
ERROR - 2019-04-28 16:07:31 --> Could not find the language line "form_validation_date_valid"
ERROR - 2019-04-28 16:07:43 --> Could not find the language line "form_validation_date_valid"
ERROR - 2019-04-28 16:07:53 --> Could not find the language line "form_validation_date_valid"
ERROR - 2019-04-28 16:13:48 --> 404 Page Not Found: Faviconico/index
ERROR - 2019-04-28 16:17:46 --> Severity: error --> Exception: syntax error, unexpected '?>' /home/wzyzjm74avny/public_html/hfdev/application/views/admin/horse-register.php 35
ERROR - 2019-04-28 16:17:47 --> Severity: error --> Exception: syntax error, unexpected '?>' /home/wzyzjm74avny/public_html/hfdev/application/views/admin/horse-register.php 35
ERROR - 2019-04-28 16:17:59 --> Severity: error --> Exception: syntax error, unexpected '?>' /home/wzyzjm74avny/public_html/hfdev/application/views/admin/horse-register.php 35
ERROR - 2019-04-28 16:18:00 --> Severity: error --> Exception: syntax error, unexpected '?>' /home/wzyzjm74avny/public_html/hfdev/application/views/admin/horse-register.php 35
ERROR - 2019-04-28 16:41:29 --> Severity: error --> Exception: Call to undefined method Horse::admin_get_breedings() /home/wzyzjm74avny/public_html/hfdev/application/controllers/Admin.php 38
ERROR - 2019-04-28 16:41:30 --> Severity: error --> Exception: Call to undefined method Horse::admin_get_breedings() /home/wzyzjm74avny/public_html/hfdev/application/controllers/Admin.php 38
ERROR - 2019-04-28 16:41:31 --> Severity: error --> Exception: Call to undefined method Horse::admin_get_breedings() /home/wzyzjm74avny/public_html/hfdev/application/controllers/Admin.php 38
ERROR - 2019-04-28 16:41:32 --> Severity: error --> Exception: Call to undefined method Horse::admin_get_breedings() /home/wzyzjm74avny/public_html/hfdev/application/controllers/Admin.php 38
ERROR - 2019-04-28 16:46:05 --> 404 Page Not Found: Admin/horses
ERROR - 2019-04-28 16:56:35 --> Severity: error --> Exception: syntax error, unexpected '<' /home/wzyzjm74avny/public_html/hfdev/application/views/admin/horse-breed.php 38
ERROR - 2019-04-28 16:56:35 --> Severity: error --> Exception: syntax error, unexpected '<' /home/wzyzjm74avny/public_html/hfdev/application/views/admin/horse-breed.php 38
ERROR - 2019-04-28 16:56:36 --> Severity: error --> Exception: syntax error, unexpected '<' /home/wzyzjm74avny/public_html/hfdev/application/views/admin/horse-breed.php 38
ERROR - 2019-04-28 16:56:37 --> Severity: error --> Exception: syntax error, unexpected '<' /home/wzyzjm74avny/public_html/hfdev/application/views/admin/horse-breed.php 38
ERROR - 2019-04-28 16:56:38 --> Severity: error --> Exception: syntax error, unexpected '<' /home/wzyzjm74avny/public_html/hfdev/application/views/admin/horse-breed.php 38
ERROR - 2019-04-28 16:56:47 --> Severity: error --> Exception: syntax error, unexpected '<' /home/wzyzjm74avny/public_html/hfdev/application/views/admin/horse-breed.php 38
ERROR - 2019-04-28 16:59:34 --> Query error: Unknown column 'hb.horse_breedings_date' in 'field list' - Invalid query: 
				SELECT h1.*, p1.players_nickname AS p1_nickname,
					h2.horses_id AS h2_id, h2.horses_name AS h2_name, h2.horses_birthyear AS h2_birthyear, h2.horses_gender AS h2_gender, h2.horses_breed AS h2_breed, h2.horses_breed2 AS h2_breed2,
					p2.players_nickname AS p2_nickname,
					p2.players_id AS p2_id,
					DATE_FORMAT(hb.horse_breedings_date, '%Y/%m/%d') AS horse_breedings_date
				FROM horses_breedings hb
					LEFT JOIN horses h1 ON h1.horses_id=hb.join_horses_id
					LEFT JOIN horses h2 ON h2.horses_id=hb.join_mares_id
					LEFT JOIN players p1 ON p1.players_id=h1.join_players_id
					LEFT JOIN players p2 ON p2.players_id=h2.join_players_id
				WHERE hb.horses_breedings_accepted=0
				ORDER BY hb.horses_breedings_date ASC
ERROR - 2019-04-28 16:59:35 --> Query error: Unknown column 'hb.horse_breedings_date' in 'field list' - Invalid query: 
				SELECT h1.*, p1.players_nickname AS p1_nickname,
					h2.horses_id AS h2_id, h2.horses_name AS h2_name, h2.horses_birthyear AS h2_birthyear, h2.horses_gender AS h2_gender, h2.horses_breed AS h2_breed, h2.horses_breed2 AS h2_breed2,
					p2.players_nickname AS p2_nickname,
					p2.players_id AS p2_id,
					DATE_FORMAT(hb.horse_breedings_date, '%Y/%m/%d') AS horse_breedings_date
				FROM horses_breedings hb
					LEFT JOIN horses h1 ON h1.horses_id=hb.join_horses_id
					LEFT JOIN horses h2 ON h2.horses_id=hb.join_mares_id
					LEFT JOIN players p1 ON p1.players_id=h1.join_players_id
					LEFT JOIN players p2 ON p2.players_id=h2.join_players_id
				WHERE hb.horses_breedings_accepted=0
				ORDER BY hb.horses_breedings_date ASC
ERROR - 2019-04-28 16:59:36 --> Query error: Unknown column 'hb.horse_breedings_date' in 'field list' - Invalid query: 
				SELECT h1.*, p1.players_nickname AS p1_nickname,
					h2.horses_id AS h2_id, h2.horses_name AS h2_name, h2.horses_birthyear AS h2_birthyear, h2.horses_gender AS h2_gender, h2.horses_breed AS h2_breed, h2.horses_breed2 AS h2_breed2,
					p2.players_nickname AS p2_nickname,
					p2.players_id AS p2_id,
					DATE_FORMAT(hb.horse_breedings_date, '%Y/%m/%d') AS horse_breedings_date
				FROM horses_breedings hb
					LEFT JOIN horses h1 ON h1.horses_id=hb.join_horses_id
					LEFT JOIN horses h2 ON h2.horses_id=hb.join_mares_id
					LEFT JOIN players p1 ON p1.players_id=h1.join_players_id
					LEFT JOIN players p2 ON p2.players_id=h2.join_players_id
				WHERE hb.horses_breedings_accepted=0
				ORDER BY hb.horses_breedings_date ASC
ERROR - 2019-04-28 17:39:15 --> Severity: error --> Exception: syntax error, unexpected ''pending_horse_registra' (T_ENCAPSED_AND_WHITESPACE), expecting ']' /home/wzyzjm74avny/public_html/hfdev/application/controllers/Admin.php 37
ERROR - 2019-04-28 17:54:14 --> 404 Page Not Found: Admin/bank
ERROR - 2019-04-28 17:55:13 --> Severity: error --> Exception: Call to undefined method Horse::reject_export() /home/wzyzjm74avny/public_html/hfdev/application/controllers/Admin.php 538
ERROR - 2019-04-28 17:57:31 --> Severity: error --> Exception: Too few arguments to function Horse::reject_export(), 1 passed in /home/wzyzjm74avny/public_html/hfdev/application/controllers/Admin.php on line 538 and exactly 2 expected /home/wzyzjm74avny/public_html/hfdev/application/models/Horse.php 739
ERROR - 2019-04-28 17:57:33 --> Severity: error --> Exception: Too few arguments to function Horse::reject_export(), 1 passed in /home/wzyzjm74avny/public_html/hfdev/application/controllers/Admin.php on line 538 and exactly 2 expected /home/wzyzjm74avny/public_html/hfdev/application/models/Horse.php 739
ERROR - 2019-04-28 17:58:06 --> Query error: Column 'join_players_id' cannot be null - Invalid query: INSERT INTO notices(join_players_id, notices_body) VALUES(NULL, '<a href=\'/horses/view/65\'>  test discipline4 #65</a> has been rejected for export.')
ERROR - 2019-04-28 18:21:43 --> Severity: error --> Exception: syntax error, unexpected ''col' (T_ENCAPSED_AND_WHITESPACE) /home/wzyzjm74avny/public_html/hfdev/application/views/horses/breed.php 29
ERROR - 2019-04-28 18:28:03 --> Severity: error --> Exception: syntax error, unexpected ';' /home/wzyzjm74avny/public_html/hfdev/application/models/Horse.php 1047
ERROR - 2019-04-28 18:28:04 --> Severity: error --> Exception: syntax error, unexpected ';' /home/wzyzjm74avny/public_html/hfdev/application/models/Horse.php 1047
ERROR - 2019-04-28 18:28:23 --> Severity: error --> Exception: syntax error, unexpected ';' /home/wzyzjm74avny/public_html/hfdev/application/models/Horse.php 1047
ERROR - 2019-04-28 18:48:11 --> Severity: error --> Exception: syntax error, unexpected ''btn b' (T_ENCAPSED_AND_WHITESPACE) /home/wzyzjm74avny/public_html/hfdev/application/views/horses/breed.php 104
ERROR - 2019-04-28 18:49:25 --> Severity: error --> Exception: syntax error, unexpected ''col' (T_ENCAPSED_AND_WHITESPACE) /home/wzyzjm74avny/public_html/hfdev/application/views/horses/breed.php 29
ERROR - 2019-04-28 18:49:57 --> 404 Page Not Found: Faviconico/index
ERROR - 2019-04-28 18:56:58 --> 404 Page Not Found: Horses/breed
