<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2019-12-23 09:36:30 --> 404 Page Not Found: Faviconico/index
ERROR - 2019-12-23 09:41:56 --> Severity: error --> Exception: Too few arguments to function City::stable(), 0 passed in /home/wzyzjm74avny/public_html/hfdev/system/core/CodeIgniter.php on line 532 and exactly 1 expected /home/wzyzjm74avny/public_html/hfdev/application/controllers/City.php 271
ERROR - 2019-12-23 09:44:56 --> 404 Page Not Found: Admin/stables_land
ERROR - 2019-12-23 09:47:44 --> Severity: error --> Exception: Too few arguments to function City::stable(), 0 passed in /home/wzyzjm74avny/public_html/hfdev/system/core/CodeIgniter.php on line 532 and exactly 1 expected /home/wzyzjm74avny/public_html/hfdev/application/controllers/City.php 271
ERROR - 2019-12-23 09:49:48 --> 404 Page Not Found: City/stables
ERROR - 2019-12-23 10:25:56 --> Severity: error --> Exception: syntax error, unexpected '%' /home/wzyzjm74avny/public_html/hfdev/application/models/Player.php 27
ERROR - 2019-12-23 10:25:58 --> Severity: error --> Exception: syntax error, unexpected '%' /home/wzyzjm74avny/public_html/hfdev/application/models/Player.php 27
ERROR - 2019-12-23 10:26:17 --> Severity: error --> Exception: syntax error, unexpected '%' /home/wzyzjm74avny/public_html/hfdev/application/models/Player.php 27
ERROR - 2019-12-23 10:26:18 --> Severity: error --> Exception: syntax error, unexpected end of file, expecting variable (T_VARIABLE) or ${ (T_DOLLAR_OPEN_CURLY_BRACES) or {$ (T_CURLY_OPEN) /home/wzyzjm74avny/public_html/hfdev/application/models/Player.php 341
ERROR - 2019-12-23 10:27:18 --> Severity: error --> Exception: syntax error, unexpected end of file /home/wzyzjm74avny/public_html/hfdev/application/models/Player.php 338
ERROR - 2019-12-23 10:27:33 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 - Invalid query: SELECT p.players_nickname, p.DATE_FORMAT(players_last_active, "%M %D, %Y at %l:%i %p") AS players_last_active2, p.players_id FROM players WHERE players_last_active>NOW() - INTERVAL '1 HOUR'
ERROR - 2019-12-23 10:31:11 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 - Invalid query: SELECT p.players_nickname, p.DATE_FORMAT(players_last_active, "%M %D, %Y at %l:%i %p") AS players_last_active2, p.players_id FROM players WHERE players_last_active>NOW() - INTERVAL 'HOUR'
ERROR - 2019-12-23 10:31:46 --> Query error: Unknown column 'p.players_nickname' in 'field list' - Invalid query: SELECT p.players_nickname, p.DATE_FORMAT(players_last_active, "%M %D, %Y at %l:%i %p") AS players_last_active2, p.players_id FROM players WHERE players_last_active>NOW() - INTERVAL 1 HOUR
ERROR - 2019-12-23 10:33:19 --> 404 Page Not Found: City/online
ERROR - 2019-12-23 10:34:47 --> 404 Page Not Found: City/online
ERROR - 2019-12-23 10:34:48 --> 404 Page Not Found: City/online
ERROR - 2019-12-23 10:36:38 --> Severity: error --> Exception: Call to a member function get_online() on null /home/wzyzjm74avny/public_html/hfdev/application/controllers/City.php 273
ERROR - 2019-12-23 10:36:39 --> Severity: error --> Exception: Call to a member function get_online() on null /home/wzyzjm74avny/public_html/hfdev/application/controllers/City.php 273
ERROR - 2019-12-23 10:37:30 --> Severity: error --> Exception: Call to a member function get_online() on null /home/wzyzjm74avny/public_html/hfdev/application/controllers/City.php 274
ERROR - 2019-12-23 10:37:31 --> Severity: error --> Exception: Call to a member function get_online() on null /home/wzyzjm74avny/public_html/hfdev/application/controllers/City.php 274
ERROR - 2019-12-23 10:37:32 --> Severity: error --> Exception: Call to a member function get_online() on null /home/wzyzjm74avny/public_html/hfdev/application/controllers/City.php 274
ERROR - 2019-12-23 10:37:32 --> Severity: error --> Exception: Call to a member function get_online() on null /home/wzyzjm74avny/public_html/hfdev/application/controllers/City.php 274
ERROR - 2019-12-23 10:38:20 --> Severity: error --> Exception: Call to a member function get_online() on null /home/wzyzjm74avny/public_html/hfdev/application/controllers/City.php 274
ERROR - 2019-12-23 10:38:21 --> Severity: error --> Exception: syntax error, unexpected ''city/ban' (T_ENCAPSED_AND_WHITESPACE) /home/wzyzjm74avny/public_html/hfdev/application/controllers/City.php 116
ERROR - 2019-12-23 10:47:04 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'OUTER JOIN stables s ON s.join_players_id=p.players_id
			WHERE p.players_id != ' at line 3 - Invalid query: 
			SELECT p.players_id, p.players_nickname, DATE_FORMAT(players_last_active, "%M %D, %Y at %l:%i %p") AS players_last_active2, s.stables_name, s.stables_boarding_fee, s.stables_boarding_public
			FROM players p
			 OUTER JOIN stables s ON s.join_players_id=p.players_id
			WHERE p.players_id != 0 AND p.players_deleted = 0 AND p.players_pending = 0 AND stables_name LIKE '%new%'
		
ERROR - 2019-12-23 10:47:05 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'OUTER JOIN stables s ON s.join_players_id=p.players_id
			WHERE p.players_id != ' at line 3 - Invalid query: 
			SELECT p.players_id, p.players_nickname, DATE_FORMAT(players_last_active, "%M %D, %Y at %l:%i %p") AS players_last_active2, s.stables_name, s.stables_boarding_fee, s.stables_boarding_public
			FROM players p
			 OUTER JOIN stables s ON s.join_players_id=p.players_id
			WHERE p.players_id != 0 AND p.players_deleted = 0 AND p.players_pending = 0 AND stables_name LIKE '%new%'
		
ERROR - 2019-12-23 10:49:34 --> Severity: error --> Exception: syntax error, unexpected end of file /home/wzyzjm74avny/public_html/hfdev/application/models/Player.php 438
ERROR - 2019-12-23 10:52:26 --> Severity: error --> Exception: syntax error, unexpected '?>' /home/wzyzjm74avny/public_html/hfdev/application/views/partials/player-search.php 24
ERROR - 2019-12-23 10:52:27 --> Severity: error --> Exception: syntax error, unexpected '?>' /home/wzyzjm74avny/public_html/hfdev/application/views/partials/player-search.php 24
ERROR - 2019-12-23 11:25:53 --> 404 Page Not Found: City/stables
ERROR - 2019-12-23 11:28:19 --> 404 Page Not Found: City/stables
ERROR - 2019-12-23 11:30:24 --> 404 Page Not Found: City/stables_edit
ERROR - 2019-12-23 11:46:24 --> 404 Page Not Found: City/stables
ERROR - 2019-12-23 11:46:41 --> Severity: error --> Exception: syntax error, unexpected 'endif' (T_ENDIF), expecting end of file /home/wzyzjm74avny/public_html/hfdev/application/views/city/stables-edit.php 76
ERROR - 2019-12-23 11:46:41 --> 404 Page Not Found: Faviconico/index
ERROR - 2019-12-23 11:46:42 --> Severity: error --> Exception: syntax error, unexpected 'endif' (T_ENDIF), expecting end of file /home/wzyzjm74avny/public_html/hfdev/application/views/city/stables-edit.php 76
ERROR - 2019-12-23 11:46:53 --> Severity: error --> Exception: syntax error, unexpected 'endif' (T_ENDIF), expecting end of file /home/wzyzjm74avny/public_html/hfdev/application/views/city/stables-edit.php 76
ERROR - 2019-12-23 11:46:57 --> Severity: error --> Exception: syntax error, unexpected 'endif' (T_ENDIF), expecting end of file /home/wzyzjm74avny/public_html/hfdev/application/views/city/stables-edit.php 76
ERROR - 2019-12-23 11:47:09 --> Severity: error --> Exception: syntax error, unexpected 'endif' (T_ENDIF), expecting end of file /home/wzyzjm74avny/public_html/hfdev/application/views/city/stables-edit.php 76
