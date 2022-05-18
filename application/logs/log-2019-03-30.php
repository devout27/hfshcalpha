<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2019-03-30 15:43:07 --> Query error: Unknown table 'hr' - Invalid query: 
			SELECT h.*, hr.*, p.players_nickname
			FROM horses AS h
			LEFT JOIN players p ON p.players_id=h.join_players_id
			WHERE horses_gender='Stallion' AND 2
		
ERROR - 2019-03-30 15:43:32 --> Query error: Unknown table 'h' - Invalid query: 
			SELECT h.*, hr.*, p.players_nickname
			FROM horse_records AS hr
			LEFT JOIN players p ON p.players_id=h.join_players_id
			WHERE horses_gender='Stallion' AND 2
		
ERROR - 2019-03-30 15:43:36 --> Query error: Unknown table 'h' - Invalid query: 
			SELECT h.*, hr.*, p.players_nickname
			FROM horse_records AS hr
			LEFT JOIN players p ON p.players_id=h.join_players_id
			WHERE horses_gender='Stallion' AND 2
		
ERROR - 2019-03-30 15:44:03 --> Query error: Unknown column 'h.join_players_id' in 'on clause' - Invalid query: 
			SELECT h.*, hr.*, p.players_nickname
			FROM horse_records AS hr
			LEFT JOIN players p ON p.players_id=h.join_players_id
LEFT JOIN horses h ON h.horses_id=hr.join_horses_id
			WHERE horses_gender='Stallion' AND 2
		
ERROR - 2019-03-30 15:44:25 --> Query error: Unknown column 'h.join_players_id' in 'on clause' - Invalid query: 
			SELECT h.*, hr.*, p.players_nickname
			FROM horse_records AS hr
			LEFT JOIN players p ON p.players_id=h.join_players_id
LEFT JOIN horses h ON h.horses_id=hr.join_horses_id
			WHERE horses_gender='Stallion' AND 2
		
ERROR - 2019-03-30 15:49:22 --> Severity: error --> Exception: syntax error, unexpected ':', expecting :: (T_PAAMAYIM_NEKUDOTAYIM) /home/wzyzjm74avny/public_html/hfdev/application/views/partials/owner-table.php 16
ERROR - 2019-03-30 15:49:24 --> Severity: error --> Exception: syntax error, unexpected ':', expecting :: (T_PAAMAYIM_NEKUDOTAYIM) /home/wzyzjm74avny/public_html/hfdev/application/views/partials/owner-table.php 16
ERROR - 2019-03-30 16:03:39 --> Query error: Unknown column 'h.horse_id' in 'group statement' - Invalid query: 
			SELECT hr.horse_records_id, h.*, hr.*, p.players_nickname
			FROM horse_records AS hr
			LEFT JOIN players p ON p.players_id=hr.join_players_id
LEFT JOIN horses h ON h.horses_id=hr.join_horses_id
			WHERE hr.horse_records_type="Owner" AND hr.horse_records_date>='2018/01/01' AND h.horses_deceased=0 AND h.join_players_id!=2
			GROUP BY hr.join_players_id, h.horse_id
			ORDER BY hr.horse_records_date ASC
		
ERROR - 2019-03-30 16:33:18 --> Severity: error --> Exception: syntax error, unexpected '=>' (T_DOUBLE_ARROW) /home/wzyzjm74avny/public_html/hfdev/application/models/Horse.php 1080
ERROR - 2019-03-30 16:33:20 --> Severity: error --> Exception: syntax error, unexpected '=>' (T_DOUBLE_ARROW) /home/wzyzjm74avny/public_html/hfdev/application/models/Horse.php 1080
ERROR - 2019-03-30 16:33:27 --> Severity: error --> Exception: syntax error, unexpected '=>' (T_DOUBLE_ARROW) /home/wzyzjm74avny/public_html/hfdev/application/models/Horse.php 1080
ERROR - 2019-03-30 16:33:58 --> Severity: error --> Exception: /home/wzyzjm74avny/public_html/hfdev/application/models/Horse.php exists, but doesn't declare class Horse /home/wzyzjm74avny/public_html/hfdev/system/core/Loader.php 340
ERROR - 2019-03-30 17:06:40 --> 404 Page Not Found: Horses/export
ERROR - 2019-03-30 17:08:00 --> 404 Page Not Found: Horses/export
ERROR - 2019-03-30 17:08:03 --> Severity: error --> Exception: Too few arguments to function Horses::vet(), 0 passed in /home/wzyzjm74avny/public_html/hfdev/system/core/CodeIgniter.php on line 532 and exactly 1 expected /home/wzyzjm74avny/public_html/hfdev/application/controllers/Horses.php 283
ERROR - 2019-03-30 17:08:06 --> Severity: error --> Exception: Too few arguments to function Horses::farrier(), 0 passed in /home/wzyzjm74avny/public_html/hfdev/system/core/CodeIgniter.php on line 532 and exactly 1 expected /home/wzyzjm74avny/public_html/hfdev/application/controllers/Horses.php 314
ERROR - 2019-03-30 17:09:01 --> 404 Page Not Found: Game/credits
ERROR - 2019-03-30 17:09:42 --> 404 Page Not Found: Game/credits
ERROR - 2019-03-30 17:10:05 --> 404 Page Not Found: Game/credits
ERROR - 2019-03-30 17:14:18 --> 404 Page Not Found: City/ami
ERROR - 2019-03-30 17:14:57 --> 404 Page Not Found: City/ami
ERROR - 2019-03-30 17:15:46 --> 404 Page Not Found: City/community
ERROR - 2019-03-30 17:18:20 --> 404 Page Not Found: City/humane
ERROR - 2019-03-30 17:18:42 --> 404 Page Not Found: City/humane
ERROR - 2019-03-30 17:42:16 --> Severity: error --> Exception: Class 'Auction' not found /home/wzyzjm74avny/public_html/hfdev/application/controllers/City.php 28
ERROR - 2019-03-30 17:49:42 --> Severity: error --> Exception: Class 'Auction' not found /home/wzyzjm74avny/public_html/hfdev/application/controllers/City.php 28
ERROR - 2019-03-30 17:49:43 --> Severity: error --> Exception: Class 'Auction' not found /home/wzyzjm74avny/public_html/hfdev/application/controllers/City.php 28
ERROR - 2019-03-30 17:49:44 --> Severity: error --> Exception: Class 'Auction' not found /home/wzyzjm74avny/public_html/hfdev/application/controllers/City.php 28
ERROR - 2019-03-30 17:54:37 --> Query error: Not unique table/alias: 'h' - Invalid query: 
			SELECT a.*, h.*, p.players_nickname
			FROM horses AS h
			LEFT JOIN horses h ON h.horses_id=a.join_horses_id
LEFT JOIN players p ON p.players_id=h.join_players_id
			WHERE h.horses_pending = 0
		
ERROR - 2019-03-30 17:55:06 --> Query error: Not unique table/alias: 'h' - Invalid query: 
			SELECT a.*, h.*, p.players_nickname
			FROM horses AS h
			LEFT JOIN horses h ON h.horses_id=a.join_horses_id
LEFT JOIN players p ON p.players_id=h.join_players_id
			WHERE h.horses_pending = 0
		
ERROR - 2019-03-30 17:55:07 --> Severity: error --> Exception: /home/wzyzjm74avny/public_html/hfdev/application/models/Auction.php exists, but doesn't declare class Auction /home/wzyzjm74avny/public_html/hfdev/system/core/Loader.php 340
ERROR - 2019-03-30 17:59:41 --> Severity: error --> Exception: syntax error, unexpected ',' /home/wzyzjm74avny/public_html/hfdev/application/models/Auction.php 233
ERROR - 2019-03-30 17:59:42 --> Severity: error --> Exception: syntax error, unexpected ',' /home/wzyzjm74avny/public_html/hfdev/application/models/Auction.php 233
ERROR - 2019-03-30 17:59:43 --> Severity: error --> Exception: syntax error, unexpected ',' /home/wzyzjm74avny/public_html/hfdev/application/models/Auction.php 233
ERROR - 2019-03-30 17:59:58 --> Severity: error --> Exception: syntax error, unexpected ''' (T_ENCAPSED_AND_WHITESPACE) /home/wzyzjm74avny/public_html/hfdev/application/models/Auction.php 31
