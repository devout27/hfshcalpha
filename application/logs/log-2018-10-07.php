<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2018-10-07 11:43:03 --> Severity: error --> Exception: Call to a member function get_questions() on array /home/wzyzjm74avny/public_html/hfdev/application/models/Player.php 50
ERROR - 2018-10-07 11:43:04 --> Severity: error --> Exception: Call to a member function get_questions() on array /home/wzyzjm74avny/public_html/hfdev/application/models/Player.php 50
ERROR - 2018-10-07 11:52:47 --> 404 Page Not Found: Faviconico/index
ERROR - 2018-10-07 12:04:23 --> 404 Page Not Found: Admin/members
ERROR - 2018-10-07 13:13:22 --> Severity: error --> Exception: syntax error, unexpected end of file /home/wzyzjm74avny/public_html/hfdev/application/views/admin/member-applications.php 38
ERROR - 2018-10-07 14:24:26 --> Severity: error --> Exception: Using $this when not in object context /home/wzyzjm74avny/public_html/hfdev/application/models/Player.php 178
ERROR - 2018-10-07 14:37:40 --> Severity: error --> Exception: syntax error, unexpected '->' (T_OBJECT_OPERATOR) /home/wzyzjm74avny/public_html/hfdev/application/models/Player.php 182
ERROR - 2018-10-07 14:55:21 --> Severity: error --> Exception: syntax error, unexpected '->' (T_OBJECT_OPERATOR) /home/wzyzjm74avny/public_html/hfdev/application/models/Player.php 197
ERROR - 2018-10-07 15:26:12 --> 404 Page Not Found: Faviconico/index
ERROR - 2018-10-07 15:41:12 --> Severity: error --> Exception: syntax error, unexpected '=>' (T_DOUBLE_ARROW) /home/wzyzjm74avny/public_html/hfdev/application/models/Player.php 160
ERROR - 2018-10-07 15:41:53 --> Severity: error --> Exception: Call to a member function send_email() on array /home/wzyzjm74avny/public_html/hfdev/application/models/Player.php 178
ERROR - 2018-10-07 15:43:22 --> Severity: error --> Exception: Call to a member function send_email() on null /home/wzyzjm74avny/public_html/hfdev/application/models/Player.php 178
ERROR - 2018-10-07 15:43:48 --> Severity: error --> Exception: Call to a member function send_email() on array /home/wzyzjm74avny/public_html/hfdev/application/models/Player.php 178
ERROR - 2018-10-07 15:44:12 --> Severity: error --> Exception: Call to a member function send_email() on null /home/wzyzjm74avny/public_html/hfdev/application/models/Player.php 178
ERROR - 2018-10-07 15:46:34 --> Severity: error --> Exception: Call to a member function send_email() on null /home/wzyzjm74avny/public_html/hfdev/application/models/Player.php 174
ERROR - 2018-10-07 15:58:26 --> 404 Page Not Found: Faviconico/index
ERROR - 2018-10-07 16:13:06 --> Severity: error --> Exception: Call to undefined method Player::admin_get_pending_bank() /home/wzyzjm74avny/public_html/hfdev/application/controllers/Admin.php 190
ERROR - 2018-10-07 16:17:08 --> Severity: error --> Exception: Call to undefined method Player::admin_get_pending_bank() /home/wzyzjm74avny/public_html/hfdev/application/controllers/Admin.php 190
ERROR - 2018-10-07 16:17:09 --> Severity: error --> Exception: Call to undefined method Player::admin_get_pending_bank() /home/wzyzjm74avny/public_html/hfdev/application/controllers/Admin.php 190
ERROR - 2018-10-07 16:17:54 --> Severity: error --> Exception: Call to undefined method Player::admin_get_pending_bank() /home/wzyzjm74avny/public_html/hfdev/application/controllers/Admin.php 190
ERROR - 2018-10-07 16:17:55 --> Query error: Unknown column 'b.banks_pending' in 'where clause' - Invalid query: SELECT b.*, p.players_nickname FROM bank b LEFT JOIN players p ON p.players_id=b.join_players_id  WHERE b.banks_pending=1 ORDER BY b.banks_id ASC
ERROR - 2018-10-07 16:17:56 --> Query error: Unknown column 'b.banks_pending' in 'where clause' - Invalid query: SELECT b.*, p.players_nickname FROM bank b LEFT JOIN players p ON p.players_id=b.join_players_id  WHERE b.banks_pending=1 ORDER BY b.banks_id ASC
ERROR - 2018-10-07 21:06:26 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ' DATE_FORMAT(players_join_date, '%M %D, %Y at %l:%i %p') AS players_join_date2, ' at line 1 - Invalid query: SELECT b.*, p.players_nickname, , DATE_FORMAT(players_join_date, '%M %D, %Y at %l:%i %p') AS players_join_date2, DATE_FORMAT(players_last_active, '%M %D, %Y at %l:%i %p') AS players_last_active2 FROM bank b LEFT JOIN players p ON p.players_id=b.join_players_id  WHERE b.bank_pending=1 ORDER BY b.bank_id ASC
ERROR - 2018-10-07 21:06:27 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ' DATE_FORMAT(players_join_date, '%M %D, %Y at %l:%i %p') AS players_join_date2, ' at line 1 - Invalid query: SELECT b.*, p.players_nickname, , DATE_FORMAT(players_join_date, '%M %D, %Y at %l:%i %p') AS players_join_date2, DATE_FORMAT(players_last_active, '%M %D, %Y at %l:%i %p') AS players_last_active2 FROM bank b LEFT JOIN players p ON p.players_id=b.join_players_id  WHERE b.bank_pending=1 ORDER BY b.bank_id ASC
