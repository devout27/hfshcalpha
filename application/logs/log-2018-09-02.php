<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2018-09-02 11:02:49 --> 404 Page Not Found: Faviconico/index
ERROR - 2018-09-02 14:56:16 --> 404 Page Not Found: Faviconico/index
ERROR - 2018-09-02 14:56:47 --> 404 Page Not Found: Faviconico/index
ERROR - 2018-09-02 14:57:14 --> 404 Page Not Found: Faviconico/index
ERROR - 2018-09-02 15:00:45 --> 404 Page Not Found: Faviconico/index
ERROR - 2018-09-02 15:03:44 --> 404 Page Not Found: Faviconico/index
ERROR - 2018-09-02 15:14:25 --> Query error: Table 'hfdev.items' doesn't exist - Invalid query: 
			SELECT *, (i.items_datetime + INTERVAL 21 DAY) AS items_expiration, CONCAT(m.members_firstname, " ", SUBSTR(m.members_lastname FROM 1 FOR 1), ".") AS members_name, IF(i.items_datetime + INTERVAL 21 DAY <= NOW(), 1, 0) AS items_expired
			FROM items AS i
			LEFT JOIN members as m ON i.join_members_id = m.members_id
			WHERE items_deleted = 0
			GROUP BY i.items_id
		
ERROR - 2018-09-02 15:34:37 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'players p ON p.players_id=h.join_players_id
			WHERE horses_pending = 0 AND hors' at line 3 - Invalid query: 
			SELECT h.*, p.players_nickname
			FROM items AS i
			players p ON p.players_id=h.join_players_id
			WHERE horses_pending = 0 AND horses_deceased=0 AND horses_exported=0
			GROUP BY i.items_id
		
ERROR - 2018-09-02 15:35:04 --> Query error: Table 'hfdev.items' doesn't exist - Invalid query: 
			SELECT h.*, p.players_nickname
			FROM items AS i
			LEFT JOIN players p ON p.players_id=h.join_players_id
			WHERE horses_pending = 0 AND horses_deceased=0 AND horses_exported=0
			GROUP BY i.items_id
		
ERROR - 2018-09-02 15:44:38 --> 404 Page Not Found: Faviconico/index
ERROR - 2018-09-02 16:13:03 --> Query error: Column 'horses_id' in where clause is ambiguous - Invalid query: SELECT
				*, p.players_nickname, s.stables_name, sire.horses_name AS horses_sire_name, dam.horses_name AS horses_dam_name
				FROM horses h
				LEFT JOIN players p ON p.players_id=h.join_players_id
				LEFT JOIN stables s ON s.stables_id=h.join_stables_id
				LEFT JOIN horses sire ON sire.horses_id=h.horses_sire
				LEFT JOIN horses dam ON dam.horses_id=h.horses_dam
				WHERE horses_id = '33' LIMIT 1
			
ERROR - 2018-09-02 16:13:04 --> Query error: Column 'horses_id' in where clause is ambiguous - Invalid query: SELECT
				*, p.players_nickname, s.stables_name, sire.horses_name AS horses_sire_name, dam.horses_name AS horses_dam_name
				FROM horses h
				LEFT JOIN players p ON p.players_id=h.join_players_id
				LEFT JOIN stables s ON s.stables_id=h.join_stables_id
				LEFT JOIN horses sire ON sire.horses_id=h.horses_sire
				LEFT JOIN horses dam ON dam.horses_id=h.horses_dam
				WHERE horses_id = '33' LIMIT 1
			
ERROR - 2018-09-02 16:40:43 --> Severity: error --> Exception: syntax error, unexpected ';', expecting ',' or ')' /home/wzyzjm74avny/public_html/hfdev/application/views/partials/horse-search.php 8
ERROR - 2018-09-02 16:43:01 --> 404 Page Not Found: Faviconico/index
ERROR - 2018-09-02 16:53:13 --> Query error: Query was empty - Invalid query: 
				
ERROR - 2018-09-02 16:53:14 --> Query error: Query was empty - Invalid query: 
				
ERROR - 2018-09-02 16:53:33 --> Query error: Query was empty - Invalid query: 
				
ERROR - 2018-09-02 16:55:48 --> Query error: Unknown column 'horse_id' in 'where clause' - Invalid query: 
					SELECT p.players_nickname, hr.*
					FROM horse_records hr
					LEFT JOIN players p ON p.players_id=hr.join_players_id
					WHERE horse_id='53'
					ORDER BY hr.horse_records_id DESC
				
ERROR - 2018-09-02 16:56:03 --> Query error: Unknown column 'horse_id' in 'where clause' - Invalid query: 
					SELECT p.players_nickname, hr.*
					FROM horse_records hr
					LEFT JOIN players p ON p.players_id=hr.join_players_id
					WHERE horse_id='53'
					ORDER BY hr.horse_records_id DESC
				
ERROR - 2018-09-02 18:10:41 --> 404 Page Not Found: Faviconico/index
