<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2018-08-24 02:53:38 --> 404 Page Not Found: Faviconico/index
ERROR - 2018-08-24 07:11:29 --> 404 Page Not Found: Faviconico/index
ERROR - 2018-08-24 10:06:13 --> Severity: 4096 --> Object of class CI_Loader could not be converted to string /home/wzyzjm74avny/public_html/hfdev/application/views/game/messages.php 31
ERROR - 2018-08-24 10:09:50 --> 404 Page Not Found: Faviconico/index
ERROR - 2018-08-24 10:24:13 --> Severity: error --> Exception: Too few arguments to function Player::get_unread(), 0 passed in /home/wzyzjm74avny/public_html/hfdev/application/controllers/Game.php on line 14 and exactly 1 expected /home/wzyzjm74avny/public_html/hfdev/application/models/Player.php 39
ERROR - 2018-08-24 10:24:57 --> Query error: Unknown column 'messages_unread' in 'where clause' - Invalid query: SELECT * FROM messages WHERE messages_to = '1' AND messages_unread = 0
ERROR - 2018-08-24 10:24:58 --> Query error: Unknown column 'messages_unread' in 'where clause' - Invalid query: SELECT * FROM messages WHERE messages_to = '1' AND messages_unread = 0
ERROR - 2018-08-24 10:50:00 --> 404 Page Not Found: Game/send_message
ERROR - 2018-08-24 15:00:47 --> 404 Page Not Found: Faviconico/index
ERROR - 2018-08-24 16:02:15 --> Severity: error --> Exception: /home/wzyzjm74avny/public_html/hfdev/application/models/Messages.php exists, but doesn't declare class Messages /home/wzyzjm74avny/public_html/hfdev/system/core/Loader.php 340
ERROR - 2018-08-24 16:22:46 --> 404 Page Not Found: Game/messages
ERROR - 2018-08-24 16:22:47 --> Query error: Unknown column 'm.messages_from' in 'on clause' - Invalid query: 
				SELECT m.*,
					LEFT(m.messages_body, 50) AS messages_body,
					DATE_FORMAT(m.messages_date, '%b %D, %Y at %l:%i %p') AS messages_date_formatted,
					p1.players_nickname AS p1_name, p2.players_nickname AS p2_name
				FROM messages m
					LEFT JOIN players p1 ON p1.players_id=m.messages_to
					LEFT JOIN players p2 ON p2.players_id=m.messages_from
				WHERE m.messages_to='1'
				ORDER BY m.messages_read ASC, m.messages_date DESC
			
ERROR - 2018-08-24 16:22:48 --> Query error: Unknown column 'm.messages_from' in 'on clause' - Invalid query: 
				SELECT m.*,
					LEFT(m.messages_body, 50) AS messages_body,
					DATE_FORMAT(m.messages_date, '%b %D, %Y at %l:%i %p') AS messages_date_formatted,
					p1.players_nickname AS p1_name, p2.players_nickname AS p2_name
				FROM messages m
					LEFT JOIN players p1 ON p1.players_id=m.messages_to
					LEFT JOIN players p2 ON p2.players_id=m.messages_from
				WHERE m.messages_to='1'
				ORDER BY m.messages_read ASC, m.messages_date DESC
			
ERROR - 2018-08-24 16:28:40 --> 404 Page Not Found: Faviconico/index
ERROR - 2018-08-24 16:29:45 --> 404 Page Not Found: Faviconico/index
ERROR - 2018-08-24 16:33:04 --> 404 Page Not Found: Faviconico/index
ERROR - 2018-08-24 16:47:17 --> 404 Page Not Found: Images/sort_both.png
ERROR - 2018-08-24 16:47:17 --> 404 Page Not Found: Images/sort_asc.png
ERROR - 2018-08-24 16:50:27 --> 404 Page Not Found: Images/sort_both.png
ERROR - 2018-08-24 16:50:27 --> 404 Page Not Found: Images/sort_asc.png
ERROR - 2018-08-24 16:51:53 --> 404 Page Not Found: Images/sort_both.png
ERROR - 2018-08-24 16:51:53 --> 404 Page Not Found: Images/sort_asc.png
ERROR - 2018-08-24 16:51:56 --> 404 Page Not Found: Images/sort_both.png
ERROR - 2018-08-24 16:51:56 --> 404 Page Not Found: Images/sort_asc.png
ERROR - 2018-08-24 16:53:21 --> 404 Page Not Found: Images/sort_asc.png
ERROR - 2018-08-24 16:53:21 --> 404 Page Not Found: Images/sort_both.png
ERROR - 2018-08-24 16:54:09 --> 404 Page Not Found: Images/sort_both.png
ERROR - 2018-08-24 16:54:09 --> 404 Page Not Found: Images/sort_asc.png
ERROR - 2018-08-24 16:54:11 --> 404 Page Not Found: Images/sort_both.png
ERROR - 2018-08-24 16:54:11 --> 404 Page Not Found: Images/sort_asc.png
ERROR - 2018-08-24 16:55:19 --> 404 Page Not Found: Images/sort_both.png
ERROR - 2018-08-24 16:55:19 --> 404 Page Not Found: Images/sort_asc.png
ERROR - 2018-08-24 16:55:39 --> 404 Page Not Found: Images/sort_asc.png
ERROR - 2018-08-24 16:55:39 --> 404 Page Not Found: Images/sort_both.png
ERROR - 2018-08-24 16:55:40 --> 404 Page Not Found: Images/sort_both.png
ERROR - 2018-08-24 16:55:40 --> 404 Page Not Found: Images/sort_asc.png
ERROR - 2018-08-24 16:56:05 --> 404 Page Not Found: Images/sort_both.png
ERROR - 2018-08-24 16:56:05 --> 404 Page Not Found: Images/sort_asc.png
ERROR - 2018-08-24 16:56:23 --> 404 Page Not Found: Images/sort_both.png
ERROR - 2018-08-24 16:56:23 --> 404 Page Not Found: Images/sort_asc.png
