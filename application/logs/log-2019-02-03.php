<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2019-02-03 14:23:04 --> Severity: error --> Exception: Too few arguments to function Horses::vet(), 0 passed in /home/wzyzjm74avny/public_html/hfdev/system/core/CodeIgniter.php on line 532 and exactly 1 expected /home/wzyzjm74avny/public_html/hfdev/application/controllers/Horses.php 233
ERROR - 2019-02-03 14:29:48 --> Severity: error --> Exception: Class 'Horse' not found /home/wzyzjm74avny/public_html/hfdev/application/controllers/City.php 309
ERROR - 2019-02-03 14:29:49 --> Severity: error --> Exception: Class 'Horse' not found /home/wzyzjm74avny/public_html/hfdev/application/controllers/City.php 309
ERROR - 2019-02-03 14:30:36 --> Severity: error --> Exception: syntax error, unexpected ';', expecting ',' or ')' /home/wzyzjm74avny/public_html/hfdev/application/models/Horse.php 363
ERROR - 2019-02-03 14:30:38 --> Severity: error --> Exception: syntax error, unexpected ';', expecting ',' or ')' /home/wzyzjm74avny/public_html/hfdev/application/models/Horse.php 363
ERROR - 2019-02-03 14:38:33 --> Severity: error --> Exception: syntax error, unexpected end of file /home/wzyzjm74avny/public_html/hfdev/application/models/Horse.php 320
ERROR - 2019-02-03 14:38:46 --> Severity: error --> Exception: Too few arguments to function Horses::vet(), 0 passed in /home/wzyzjm74avny/public_html/hfdev/system/core/CodeIgniter.php on line 532 and exactly 1 expected /home/wzyzjm74avny/public_html/hfdev/application/controllers/Horses.php 233
ERROR - 2019-02-03 14:57:17 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '? AND ha.horse_appointments_type = "Vet" AND ha.horse_appointments_completed = "' at line 5 - Invalid query: 
				SELECT
					ha.*, h.horses_id, h.horses_name, h.horses_birthyear, h.horses_gender, h.horses_vet
				FROM horse_appointments ha
				LEFT JOIN horses h ON h.horses_id=ha.join_horses_id
				WHERE ha.horses_appointments_id=? AND ha.horse_appointments_type = "Vet" AND ha.horse_appointments_completed = "0000-00-00 00:00:00"
				ORDER BY ha.horse_appointments_id ASC
			
ERROR - 2019-02-03 14:57:49 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '? AND ha.horse_appointments_type = "Vet" AND ha.horse_appointments_completed = "' at line 5 - Invalid query: 
				SELECT
					ha.*, h.horses_id, h.horses_name, h.horses_birthyear, h.horses_gender, h.horses_vet
				FROM horse_appointments ha
				LEFT JOIN horses h ON h.horses_id=ha.join_horses_id
				WHERE ha.horses_appointments_id=? AND ha.horse_appointments_type = "Vet" AND ha.horse_appointments_completed = "0000-00-00 00:00:00"
				ORDER BY ha.horse_appointments_id ASC
			
ERROR - 2019-02-03 14:57:52 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '? AND ha.horse_appointments_type = "Vet" AND ha.horse_appointments_completed = "' at line 5 - Invalid query: 
				SELECT
					ha.*, h.horses_id, h.horses_name, h.horses_birthyear, h.horses_gender, h.horses_vet
				FROM horse_appointments ha
				LEFT JOIN horses h ON h.horses_id=ha.join_horses_id
				WHERE ha.horses_appointments_id=? AND ha.horse_appointments_type = "Vet" AND ha.horse_appointments_completed = "0000-00-00 00:00:00"
				ORDER BY ha.horse_appointments_id ASC
			
ERROR - 2019-02-03 14:58:15 --> Query error: Unknown column 'ha.horses_appointments_id' in 'where clause' - Invalid query: 
				SELECT
					ha.*, h.horses_id, h.horses_name, h.horses_birthyear, h.horses_gender, h.horses_vet
				FROM horse_appointments ha
				LEFT JOIN horses h ON h.horses_id=ha.join_horses_id
				WHERE ha.horses_appointments_id='1' AND ha.horse_appointments_type = "Vet" AND ha.horse_appointments_completed = "0000-00-00 00:00:00"
				ORDER BY ha.horse_appointments_id ASC
			
ERROR - 2019-02-03 14:58:28 --> Query error: Unknown column 'ha.horses_appointments_id' in 'where clause' - Invalid query: 
				SELECT
					ha.*, h.horses_id, h.horses_name, h.horses_birthyear, h.horses_gender, h.horses_vet
				FROM horse_appointments ha
				LEFT JOIN horses h ON h.horses_id=ha.join_horses_id
				WHERE ha.horses_appointments_id='1' AND ha.horse_appointments_type = "Vet" AND ha.horse_appointments_completed = "0000-00-00 00:00:00"
				ORDER BY ha.horse_appointments_id ASC
			
ERROR - 2019-02-03 14:58:29 --> Query error: Unknown column 'horse_id' in 'where clause' - Invalid query: UPDATE horses SET horses_vet='2018-11-02 06:57:19' WHERE horse_id='55'
ERROR - 2019-02-03 15:10:58 --> Query error: Column 'join_players_id' cannot be null - Invalid query: INSERT INTO notices(join_players_id, notices_body) VALUES(NULL, '<a href=\'/horses/view/2\'>  Better Horse!! #2</a> has been seen by the Vet.')
ERROR - 2019-02-03 15:11:17 --> Severity: error --> Exception: syntax error, unexpected end of file, expecting variable (T_VARIABLE) or ${ (T_DOLLAR_OPEN_CURLY_BRACES) or {$ (T_CURLY_OPEN) /home/wzyzjm74avny/public_html/hfdev/application/models/Player.php 42
ERROR - 2019-02-03 15:11:19 --> Query error: Unknown column 'h.players_id' in 'field list' - Invalid query: 
				SELECT
					ha.*, h.horses_id, h.horses_name, h.horses_birthyear, h.horses_gender, h.horses_vet, h.players_id
				FROM horse_appointments ha
				LEFT JOIN horses h ON h.horses_id=ha.join_horses_id
				WHERE ha.horse_appointments_id='5' AND ha.horse_appointments_type = "Vet" AND ha.horse_appointments_completed = "0000-00-00 00:00:00"
				ORDER BY ha.horse_appointments_id ASC
			
ERROR - 2019-02-03 15:11:20 --> Query error: Unknown column 'h.players_id' in 'field list' - Invalid query: 
				SELECT
					ha.*, h.horses_id, h.horses_name, h.horses_birthyear, h.horses_gender, h.horses_vet, h.players_id
				FROM horse_appointments ha
				LEFT JOIN horses h ON h.horses_id=ha.join_horses_id
				WHERE ha.horse_appointments_id='5' AND ha.horse_appointments_type = "Vet" AND ha.horse_appointments_completed = "0000-00-00 00:00:00"
				ORDER BY ha.horse_appointments_id ASC
			
ERROR - 2019-02-03 15:11:26 --> Query error: Unknown column 'h.players_id' in 'field list' - Invalid query: 
				SELECT
					ha.*, h.horses_id, h.horses_name, h.horses_birthyear, h.horses_gender, h.horses_vet, h.players_id
				FROM horse_appointments ha
				LEFT JOIN horses h ON h.horses_id=ha.join_horses_id
				WHERE ha.horse_appointments_id='5' AND ha.horse_appointments_type = "Vet" AND ha.horse_appointments_completed = "0000-00-00 00:00:00"
				ORDER BY ha.horse_appointments_id ASC
			
ERROR - 2019-02-03 15:19:02 --> Severity: error --> Exception: syntax error, unexpected end of file, expecting function (T_FUNCTION) or const (T_CONST) /home/wzyzjm74avny/public_html/hfdev/application/controllers/City.php 397
ERROR - 2019-02-03 15:19:03 --> Severity: error --> Exception: syntax error, unexpected end of file, expecting function (T_FUNCTION) or const (T_CONST) /home/wzyzjm74avny/public_html/hfdev/application/controllers/City.php 397
ERROR - 2019-02-03 15:19:04 --> Severity: error --> Exception: syntax error, unexpected end of file, expecting function (T_FUNCTION) or const (T_CONST) /home/wzyzjm74avny/public_html/hfdev/application/controllers/City.php 397
ERROR - 2019-02-03 15:22:22 --> Severity: error --> Exception: syntax error, unexpected end of file, expecting elseif (T_ELSEIF) or else (T_ELSE) or endif (T_ENDIF) /home/wzyzjm74avny/public_html/hfdev/application/views/game/profile.php 76
ERROR - 2019-02-03 15:38:28 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '?, ?, ?, ?)' at line 1 - Invalid query: INSERT INTO horse_records(join_players_id, join_horses_id, horse_records_type, horse_records_date, horse_records_notes) VALUES(?, ?, ?, ?)
ERROR - 2019-02-03 15:46:22 --> 404 Page Not Found: Faviconico/index
ERROR - 2019-02-03 15:49:24 --> Severity: error --> Exception: syntax error, unexpected ''s' (T_ENCAPSED_AND_WHITESPACE), expecting ']' /home/wzyzjm74avny/public_html/hfdev/application/views/horses/view.php 90
ERROR - 2019-02-03 15:52:40 --> 404 Page Not Found: Faviconico/index
ERROR - 2019-02-03 15:53:16 --> 404 Page Not Found: Faviconico/index
ERROR - 2019-02-03 16:07:27 --> 404 Page Not Found: Admin/horses
ERROR - 2019-02-03 16:26:56 --> Severity: error --> Exception: syntax error, unexpected ';' /home/wzyzjm74avny/public_html/hfdev/application/controllers/Horses.php 118
ERROR - 2019-02-03 16:26:57 --> Severity: error --> Exception: syntax error, unexpected ';' /home/wzyzjm74avny/public_html/hfdev/application/controllers/Horses.php 118
ERROR - 2019-02-03 16:26:58 --> Severity: error --> Exception: syntax error, unexpected ';' /home/wzyzjm74avny/public_html/hfdev/application/controllers/Horses.php 118
ERROR - 2019-02-03 16:27:50 --> Severity: error --> Exception: syntax error, unexpected ';' /home/wzyzjm74avny/public_html/hfdev/application/controllers/Horses.php 118
ERROR - 2019-02-03 16:27:51 --> Severity: error --> Exception: syntax error, unexpected ';' /home/wzyzjm74avny/public_html/hfdev/application/controllers/Horses.php 118
ERROR - 2019-02-03 16:27:52 --> Severity: error --> Exception: syntax error, unexpected ';' /home/wzyzjm74avny/public_html/hfdev/application/controllers/Horses.php 118
ERROR - 2019-02-03 16:27:52 --> Severity: error --> Exception: syntax error, unexpected ';' /home/wzyzjm74avny/public_html/hfdev/application/controllers/Horses.php 118
ERROR - 2019-02-03 16:27:53 --> Severity: error --> Exception: syntax error, unexpected ';' /home/wzyzjm74avny/public_html/hfdev/application/controllers/Horses.php 118
ERROR - 2019-02-03 16:29:13 --> Severity: error --> Exception: syntax error, unexpected ';' /home/wzyzjm74avny/public_html/hfdev/application/controllers/Horses.php 118
ERROR - 2019-02-03 16:29:15 --> Severity: error --> Exception: syntax error, unexpected ';' /home/wzyzjm74avny/public_html/hfdev/application/controllers/Horses.php 118
ERROR - 2019-02-03 16:38:14 --> Severity: error --> Exception: Cannot use object of type Player as array /home/wzyzjm74avny/public_html/hfdev/application/models/Horse.php 460
ERROR - 2019-02-03 16:41:11 --> Severity: error --> Exception: syntax error, unexpected end of file /home/wzyzjm74avny/public_html/hfdev/application/models/Horse.php 356
ERROR - 2019-02-03 16:45:37 --> 404 Page Not Found: Admin/horses
ERROR - 2019-02-03 17:02:24 --> Severity: error --> Exception: Cannot use object of type Horse as array /home/wzyzjm74avny/public_html/hfdev/application/models/Horse.php 472
ERROR - 2019-02-03 17:03:04 --> Query error: Column 'join_players_id' cannot be null - Invalid query: INSERT INTO notices(join_players_id, notices_body) VALUES(NULL, '<b>Breeding request accepted! <a href=\'/horses/\'>  </a> x <a href=\'/horses/\'>  </a> for <font color=green>$</font>.')
ERROR - 2019-02-03 17:03:06 --> Query error: Column 'join_players_id' cannot be null - Invalid query: INSERT INTO notices(join_players_id, notices_body) VALUES(NULL, '<b>Breeding request accepted! <a href=\'/horses/\'>  </a> x <a href=\'/horses/\'>  </a> for <font color=green>$</font>.')
ERROR - 2019-02-03 17:10:17 --> 404 Page Not Found: Horses/55
ERROR - 2019-02-03 17:15:09 --> 404 Page Not Found: City/humane
ERROR - 2019-02-03 17:41:31 --> 404 Page Not Found: Faviconico/index
ERROR - 2019-02-03 18:59:01 --> 404 Page Not Found: Admin/horses
ERROR - 2019-02-03 19:14:00 --> 404 Page Not Found: Game/credits
ERROR - 2019-02-03 19:19:01 --> Severity: error --> Exception: syntax error, unexpected 'endif' (T_ENDIF) /home/wzyzjm74avny/public_html/hfdev/application/views/admin/horse-import.php 37
ERROR - 2019-02-03 19:19:02 --> Severity: error --> Exception: syntax error, unexpected 'endif' (T_ENDIF) /home/wzyzjm74avny/public_html/hfdev/application/views/admin/horse-import.php 37
ERROR - 2019-02-03 19:31:16 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '? ORDER BY disciplines_name ASC' at line 1 - Invalid query: SELECT disciplines_name FROM disciplines WHERE join_horses_id=? ORDER BY disciplines_name ASC
ERROR - 2019-02-03 19:31:17 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '? ORDER BY disciplines_name ASC' at line 1 - Invalid query: SELECT disciplines_name FROM disciplines WHERE join_horses_id=? ORDER BY disciplines_name ASC
ERROR - 2019-02-03 19:31:49 --> Query error: Unknown column 'join_horses_id' in 'where clause' - Invalid query: SELECT disciplines_name FROM disciplines WHERE join_horses_id='1' ORDER BY disciplines_name ASC
ERROR - 2019-02-03 19:32:29 --> Query error: Table 'hfdev.disciplines_x_horses' doesn't exist - Invalid query: SELECT disciplines_name FROM disciplines_x_horses WHERE join_horses_id='1' ORDER BY disciplines_name ASC
ERROR - 2019-02-03 19:56:12 --> Severity: error --> Exception: syntax error, unexpected 'public' (T_PUBLIC) /home/wzyzjm74avny/public_html/hfdev/application/controllers/Admin.php 278
ERROR - 2019-02-03 19:57:35 --> 404 Page Not Found: Admin/horse_import
