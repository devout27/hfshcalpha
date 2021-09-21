<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2019-04-21 07:03:01 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'YEAR' at line 1 - Invalid query: UPDATE horses SET deceased=1 WHERE horses_birthyear>=NOW() - 30 YEAR
ERROR - 2019-04-21 13:32:19 --> Query error: Unknown column 'horses_deceased' in 'where clause' - Invalid query: 
			SELECT p.*
			FROM players AS p
			
			WHERE players_id != 0 AND players_deleted = 0 AND players_pending = 0 AND horses_deceased=0 AND horses_exported=0
		
ERROR - 2019-04-21 14:44:29 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'DAY' at line 4 - Invalid query: 
			SELECT p.*
			FROM players AS p
			
			WHERE players_id != 0 AND players_deleted = 0 AND players_pending = 0 AND players_last_active>=NOW() - 30 DAY
		
ERROR - 2019-04-21 14:54:44 --> Query error: Table 'hfdev.ip_log' doesn't exist - Invalid query: SELECT join_players_id FROM ip_log WHERE join_players_id='1' AND ip_log_ip='107.77.83.28' AND ip_log_date>=NOW() - INTERVAL 1 HOUR
ERROR - 2019-04-21 15:13:22 --> Severity: error --> Exception: Call to undefined method Logs::get_admins() /home/wzyzjm74avny/public_html/hfdev/application/controllers/Admin.php 53
ERROR - 2019-04-21 15:30:18 --> Severity: error --> Exception: syntax error, unexpected ''DATE_FORMAT(log_date, "%M %D,' (T_CONSTANT_ENCAPSED_STRING), expecting ')' /home/wzyzjm74avny/public_html/hfdev/application/models/Logs.php 15
ERROR - 2019-04-21 15:30:19 --> Severity: error --> Exception: syntax error, unexpected ''DATE_FORMAT(log_date, "%M %D,' (T_CONSTANT_ENCAPSED_STRING), expecting ')' /home/wzyzjm74avny/public_html/hfdev/application/models/Logs.php 15
ERROR - 2019-04-21 15:30:40 --> Severity: error --> Exception: syntax error, unexpected ''DATE_FORMAT(log_date, "%M %D,' (T_CONSTANT_ENCAPSED_STRING), expecting ')' /home/wzyzjm74avny/public_html/hfdev/application/models/Logs.php 15
ERROR - 2019-04-21 15:33:19 --> Query error: Table 'hfdev.logs' doesn't exist - Invalid query: 
			SELECT l.*, p.players_nickname, DATE_FORMAT(log_date, "%M %D, %Y at %l:%i %p") AS log_date2
			FROM logs l
			LEFT JOIN players p ON p.players_id=l.join_players_id
			
		
ERROR - 2019-04-21 15:33:33 --> Severity: error --> Exception: Call to undefined method CI_Log::search() /home/wzyzjm74avny/public_html/hfdev/application/controllers/Admin.php 56
ERROR - 2019-04-21 15:33:35 --> Severity: error --> Exception: Call to undefined method CI_Log::search() /home/wzyzjm74avny/public_html/hfdev/application/controllers/Admin.php 56
ERROR - 2019-04-21 15:34:09 --> Query error: Table 'hfdev.logs' doesn't exist - Invalid query: 
			SELECT l.*, p.players_nickname, DATE_FORMAT(log_date, "%M %D, %Y at %l:%i %p") AS log_date2
			FROM logs l
			LEFT JOIN players p ON p.players_id=l.join_players_id
			
		
ERROR - 2019-04-21 15:34:24 --> Severity: error --> Exception: Call to a member function last_query() on null /home/wzyzjm74avny/public_html/hfdev/application/models/Logs.php 66
ERROR - 2019-04-21 15:34:26 --> Severity: error --> Exception: Call to a member function last_query() on null /home/wzyzjm74avny/public_html/hfdev/application/models/Logs.php 66
ERROR - 2019-04-21 15:34:31 --> Severity: error --> Exception: Call to a member function last_query() on null /home/wzyzjm74avny/public_html/hfdev/application/models/Logs.php 66
ERROR - 2019-04-21 15:38:38 --> 404 Page Not Found: Faviconico/index
ERROR - 2019-04-21 15:51:19 --> 404 Page Not Found: Auto/retirement
ERROR - 2019-04-21 15:51:23 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'YEAR' at line 1 - Invalid query: UPDATE horses SET deceased=1 WHERE horses_birthyear>=NOW() - 30 YEAR
ERROR - 2019-04-21 15:51:42 --> Severity: error --> Exception: syntax error, unexpected end of file, expecting variable (T_VARIABLE) or ${ (T_DOLLAR_OPEN_CURLY_BRACES) or {$ (T_CURLY_OPEN) /home/wzyzjm74avny/public_html/hfdev/application/models/Autos.php 89
ERROR - 2019-04-21 15:51:43 --> Query error: Unknown column 'deceased' in 'field list' - Invalid query: UPDATE horses SET deceased=1 WHERE horses_birthyear>=NOW() - INTERVAL 30 YEAR
ERROR - 2019-04-21 15:51:45 --> Query error: Unknown column 'deceased' in 'field list' - Invalid query: UPDATE horses SET deceased=1 WHERE horses_birthyear>=NOW() - INTERVAL 30 YEAR
ERROR - 2019-04-21 15:51:50 --> Query error: Unknown column 'deceased' in 'field list' - Invalid query: UPDATE horses SET deceased=1 WHERE horses_birthyear>=NOW() - INTERVAL 30 YEAR
ERROR - 2019-04-21 15:59:36 --> 404 Page Not Found: Game/quit
ERROR - 2019-04-21 16:09:35 --> 404 Page Not Found: Faviconico/index
ERROR - 2019-04-21 16:10:51 --> 404 Page Not Found: Faviconico/index
ERROR - 2019-04-21 16:11:19 --> 404 Page Not Found: Faviconico/index
ERROR - 2019-04-21 16:11:38 --> 404 Page Not Found: Faviconico/index
ERROR - 2019-04-21 16:18:40 --> 404 Page Not Found: Faviconico/index
ERROR - 2019-04-21 16:23:00 --> 404 Page Not Found: Faviconico/index
ERROR - 2019-04-21 16:25:07 --> 404 Page Not Found: Faviconico/index
ERROR - 2019-04-21 16:26:21 --> 404 Page Not Found: Faviconico/index
ERROR - 2019-04-21 16:27:53 --> 404 Page Not Found: Faviconico/index
ERROR - 2019-04-21 16:28:42 --> 404 Page Not Found: Faviconico/index
ERROR - 2019-04-21 16:28:46 --> 404 Page Not Found: Faviconico/index
ERROR - 2019-04-21 16:29:20 --> 404 Page Not Found: Faviconico/index
ERROR - 2019-04-21 16:35:27 --> Severity: error --> Exception: syntax error, unexpected end of file, expecting elseif (T_ELSEIF) or else (T_ELSE) or endif (T_ENDIF) /home/wzyzjm74avny/public_html/hfdev/application/views/layout/header.php 143
ERROR - 2019-04-21 16:35:28 --> Severity: error --> Exception: syntax error, unexpected end of file, expecting elseif (T_ELSEIF) or else (T_ELSE) or endif (T_ENDIF) /home/wzyzjm74avny/public_html/hfdev/application/views/layout/header.php 143
ERROR - 2019-04-21 16:35:30 --> Severity: error --> Exception: syntax error, unexpected end of file, expecting elseif (T_ELSEIF) or else (T_ELSE) or endif (T_ENDIF) /home/wzyzjm74avny/public_html/hfdev/application/views/layout/header.php 143
ERROR - 2019-04-21 16:40:26 --> Severity: error --> Exception: Call to a member function quit() on null /home/wzyzjm74avny/public_html/hfdev/application/controllers/Game.php 133
ERROR - 2019-04-21 16:45:03 --> 404 Page Not Found: Faviconico/index
ERROR - 2019-04-21 16:45:37 --> 404 Page Not Found: Faviconico/index
ERROR - 2019-04-21 16:59:40 --> Severity: error --> Exception: syntax error, unexpected '=>' (T_DOUBLE_ARROW), expecting ',' or ')' /home/wzyzjm74avny/public_html/hfdev/application/controllers/Game.php 146
ERROR - 2019-04-21 16:59:58 --> Severity: error --> Exception: syntax error, unexpected ''partials/msg' (T_ENCAPSED_AND_WHITESPACE) /home/wzyzjm74avny/public_html/hfdev/application/controllers/Game.php 107
ERROR - 2019-04-21 17:04:25 --> 404 Page Not Found: Game/cancel-quit
ERROR - 2019-04-21 17:12:32 --> 404 Page Not Found: Admin/members
ERROR - 2019-04-21 17:12:53 --> 404 Page Not Found: Admin/members
ERROR - 2019-04-21 17:19:03 --> 404 Page Not Found: Admin/members
ERROR - 2019-04-21 17:19:04 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '>= NOW() + INTERVAL 7 DAY THEN 0
				ELSE  1
				END as players_pending_delete_r' at line 4 - Invalid query: SELECT *, DATE_FORMAT(players_pending_delete_date, "%M %D, %Y") AS players_pending_delete_date2,

				CASE players_pending_delete_date
				WHEN >= NOW() + INTERVAL 7 DAY THEN 0
				ELSE  1
				END as players_pending_delete_ready
		 FROM players WHERE players_pending_delete = 1 ORDER BY players_pending_delete_date ASC
ERROR - 2019-04-21 17:19:05 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '>= NOW() + INTERVAL 7 DAY THEN 0
				ELSE  1
				END as players_pending_delete_r' at line 4 - Invalid query: SELECT *, DATE_FORMAT(players_pending_delete_date, "%M %D, %Y") AS players_pending_delete_date2,

				CASE players_pending_delete_date
				WHEN >= NOW() + INTERVAL 7 DAY THEN 0
				ELSE  1
				END as players_pending_delete_ready
		 FROM players WHERE players_pending_delete = 1 ORDER BY players_pending_delete_date ASC
ERROR - 2019-04-21 17:20:23 --> 404 Page Not Found: Admin/members
ERROR - 2019-04-21 17:20:48 --> 404 Page Not Found: Admin/members
ERROR - 2019-04-21 17:22:58 --> 404 Page Not Found: Admin/members
ERROR - 2019-04-21 17:23:39 --> 404 Page Not Found: Admin/member_delete
ERROR - 2019-04-21 17:30:05 --> 404 Page Not Found: Admin/member_delete
