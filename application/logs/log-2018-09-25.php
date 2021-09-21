<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2018-09-25 13:24:37 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '?, ?, ?, ?, ?, ?, ?)' at line 1 - Invalid query: INSERT INTO bank_recurring(join_bank_id, bank_recurring_to, bank_recurring_amount, bank_recurring_start_date, bank_recurring_days, bank_recurring_months, bank_recurring_memo) VALUES(?, ?, ?, ?, ?, ?, ?)
ERROR - 2018-09-25 13:25:29 --> Query error: Column 'bank_recurring_days' cannot be null - Invalid query: INSERT INTO bank_recurring(join_bank_id, bank_recurring_to, bank_recurring_amount, bank_recurring_start_date, bank_recurring_days, bank_recurring_months, bank_recurring_memo) VALUES('1', '22', '5000', 'Automatic Transfer', NULL, NULL, NULL)
ERROR - 2018-09-25 13:26:21 --> Query error: Column 'bank_recurring_days' cannot be null - Invalid query: INSERT INTO bank_recurring(join_bank_id, bank_recurring_to, bank_recurring_amount, bank_recurring_start_date, bank_recurring_days, bank_recurring_months, bank_recurring_memo) VALUES('1', '22', '5000', 'Automatic Transfer', NULL, NULL, NULL)
ERROR - 2018-09-25 13:26:58 --> Query error: Column 'bank_recurring_days' cannot be null - Invalid query: INSERT INTO bank_recurring(join_bank_id, bank_recurring_to, bank_recurring_amount, bank_recurring_start_date, bank_recurring_days, bank_recurring_months, bank_recurring_memo) VALUES('1', '22', '5000', 'Automatic Transfer', NULL, 0, 0)
ERROR - 2018-09-25 13:34:18 --> Severity: error --> Exception: syntax error, unexpected end of file, expecting ',' or ';' /home/wzyzjm74avny/public_html/hfdev/application/views/city/bank-transfer.php 27
ERROR - 2018-09-25 15:19:15 --> Query error: Unknown column 'bank_from_id' in 'where clause' - Invalid query: 
				SELECT br.*,
					bt.bank_balance AS bank_balance2, bt.bank_pending AS bank_pending2, bt.bank_closed AS bank_closed2, bt.bank_type AS bank_type2, bt.join_players_id AS join_players_id2
				FROM bank_recurring br
					LEFT JOIN bank bf ON br.join_bank_id=bf.bank_id
					LEFT JOIN bank bt ON bc.bank_recurring_to=bt.bank_id
				WHERE bank_from_id IN ('1','4','22','6')
			
ERROR - 2018-09-25 15:19:16 --> Query error: Unknown column 'bank_from_id' in 'where clause' - Invalid query: 
				SELECT br.*,
					bt.bank_balance AS bank_balance2, bt.bank_pending AS bank_pending2, bt.bank_closed AS bank_closed2, bt.bank_type AS bank_type2, bt.join_players_id AS join_players_id2
				FROM bank_recurring br
					LEFT JOIN bank bf ON br.join_bank_id=bf.bank_id
					LEFT JOIN bank bt ON bc.bank_recurring_to=bt.bank_id
				WHERE bank_from_id IN ('1','4','22','6')
			
ERROR - 2018-09-25 15:19:30 --> Query error: Unknown column 'bc.bank_recurring_to' in 'on clause' - Invalid query: 
				SELECT br.*,
					bt.bank_balance AS bank_balance2, bt.bank_pending AS bank_pending2, bt.bank_closed AS bank_closed2, bt.bank_type AS bank_type2, bt.join_players_id AS join_players_id2
				FROM bank_recurring br
					LEFT JOIN bank bf ON br.join_bank_id=bf.bank_id
					LEFT JOIN bank bt ON bc.bank_recurring_to=bt.bank_id
				WHERE join_bank_id IN ('1','4','22','6')
			
ERROR - 2018-09-25 15:35:51 --> Query error: Unknown column 'bt.bank_nickname2' in 'field list' - Invalid query: 
				SELECT br.*,
					bf.bank_nickname, bf.bank_balance, bf.bank_pending, bf.bank_closed, bf.bank_type,
					bt.bank_nickname2, bt.bank_balance AS bank_balance2, bt.bank_pending AS bank_pending2, bt.bank_closed AS bank_closed2, bt.bank_type AS bank_type2, bt.join_players_id AS join_players_id2
				FROM bank_recurring br
					LEFT JOIN bank bf ON br.join_bank_id=bf.bank_id
					LEFT JOIN bank bt ON br.bank_recurring_to=bt.bank_id
				WHERE join_bank_id IN ('1','4','22','6')
			
ERROR - 2018-09-25 15:35:52 --> Query error: Unknown column 'bt.bank_nickname2' in 'field list' - Invalid query: 
				SELECT br.*,
					bf.bank_nickname, bf.bank_balance, bf.bank_pending, bf.bank_closed, bf.bank_type,
					bt.bank_nickname2, bt.bank_balance AS bank_balance2, bt.bank_pending AS bank_pending2, bt.bank_closed AS bank_closed2, bt.bank_type AS bank_type2, bt.join_players_id AS join_players_id2
				FROM bank_recurring br
					LEFT JOIN bank bf ON br.join_bank_id=bf.bank_id
					LEFT JOIN bank bt ON br.bank_recurring_to=bt.bank_id
				WHERE join_bank_id IN ('1','4','22','6')
			
ERROR - 2018-09-25 15:51:20 --> Severity: error --> Exception: Call to undefined method Bank::cancel_transfer() /home/wzyzjm74avny/public_html/hfdev/application/controllers/City.php 155
ERROR - 2018-09-25 15:58:20 --> Query error: Unknown column 'join_player_id' in 'where clause' - Invalid query: DELETE FROM bank_recurring WHERE bank_recurring_id='2' AND join_bank_id IN (SELECT bank_id FROM bank WHERE join_player_id='1')
ERROR - 2018-09-25 15:58:37 --> 404 Page Not Found: City/bank-transfer
ERROR - 2018-09-25 15:58:39 --> 404 Page Not Found: City/bank-transfer
ERROR - 2018-09-25 16:15:37 --> 404 Page Not Found: Crons/index
ERROR - 2018-09-25 16:16:36 --> 404 Page Not Found: Cron/bank
ERROR - 2018-09-25 16:44:06 --> Severity: error --> Exception: Class Cron already exists and doesn't extend CI_Model /home/wzyzjm74avny/public_html/hfdev/system/core/Loader.php 353
ERROR - 2018-09-25 16:44:07 --> 404 Page Not Found: Faviconico/index
ERROR - 2018-09-25 16:44:42 --> Severity: error --> Exception: Class Cron already exists and doesn't extend CI_Model /home/wzyzjm74avny/public_html/hfdev/system/core/Loader.php 353
ERROR - 2018-09-25 16:44:43 --> Severity: Compile Error --> Cannot declare class Cron, because the name is already in use /home/wzyzjm74avny/public_html/hfdev/application/models/Crons.php 572
ERROR - 2018-09-25 16:44:44 --> Severity: Compile Error --> Cannot declare class Cron, because the name is already in use /home/wzyzjm74avny/public_html/hfdev/application/models/Crons.php 572
ERROR - 2018-09-25 16:45:08 --> Severity: Compile Error --> Cannot declare class Cron, because the name is already in use /home/wzyzjm74avny/public_html/hfdev/application/models/Crons.php 572
ERROR - 2018-09-25 16:45:42 --> Severity: Compile Error --> Cannot declare class Cron, because the name is already in use /home/wzyzjm74avny/public_html/hfdev/application/models/Crons.php 572
ERROR - 2018-09-25 16:45:55 --> Severity: Compile Error --> Cannot declare class Cron, because the name is already in use /home/wzyzjm74avny/public_html/hfdev/application/models/Crons.php 572
ERROR - 2018-09-25 16:46:10 --> Severity: Compile Error --> Cannot declare class Cron, because the name is already in use /home/wzyzjm74avny/public_html/hfdev/application/models/Crons.php 572
ERROR - 2018-09-25 16:46:57 --> Severity: error --> Exception: Class Autos already exists and doesn't extend CI_Model /home/wzyzjm74avny/public_html/hfdev/system/core/Loader.php 353
ERROR - 2018-09-25 16:47:40 --> Severity: error --> Exception: Class Autos already exists and doesn't extend CI_Model /home/wzyzjm74avny/public_html/hfdev/system/core/Loader.php 353
ERROR - 2018-09-25 16:47:43 --> Severity: error --> Exception: Class Autos already exists and doesn't extend CI_Model /home/wzyzjm74avny/public_html/hfdev/system/core/Loader.php 353
ERROR - 2018-09-25 16:48:31 --> Severity: error --> Exception: Class Autos already exists and doesn't extend CI_Model /home/wzyzjm74avny/public_html/hfdev/system/core/Loader.php 353
ERROR - 2018-09-25 16:48:47 --> Severity: error --> Exception: Class Autos already exists and doesn't extend CI_Model /home/wzyzjm74avny/public_html/hfdev/system/core/Loader.php 353
ERROR - 2018-09-25 16:48:49 --> Severity: error --> Exception: Class Autos already exists and doesn't extend CI_Model /home/wzyzjm74avny/public_html/hfdev/system/core/Loader.php 353
ERROR - 2018-09-25 16:49:03 --> Severity: error --> Exception: Class Autos already exists and doesn't extend CI_Model /home/wzyzjm74avny/public_html/hfdev/system/core/Loader.php 353
ERROR - 2018-09-25 16:49:05 --> Severity: error --> Exception: Class Autos already exists and doesn't extend CI_Model /home/wzyzjm74avny/public_html/hfdev/system/core/Loader.php 353
ERROR - 2018-09-25 16:49:09 --> Severity: error --> Exception: Class Autos already exists and doesn't extend CI_Model /home/wzyzjm74avny/public_html/hfdev/system/core/Loader.php 353
ERROR - 2018-09-25 16:49:11 --> Severity: error --> Exception: Class Autos already exists and doesn't extend CI_Model /home/wzyzjm74avny/public_html/hfdev/system/core/Loader.php 353
ERROR - 2018-09-25 16:49:21 --> 404 Page Not Found: Autos/bank_transfers
ERROR - 2018-09-25 16:50:44 --> Severity: error --> Exception: Class Autos already exists and doesn't extend CI_Model /home/wzyzjm74avny/public_html/hfdev/system/core/Loader.php 353
ERROR - 2018-09-25 16:52:00 --> 404 Page Not Found: Autos/bank_transfers
ERROR - 2018-09-25 16:52:02 --> 404 Page Not Found: Autos/bank_transfers
ERROR - 2018-09-25 17:04:34 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '*
				FROM bank_recurring
				WHERE bank_recurring_days!=0
					AND DATEDIFF('20' at line 1 - Invalid query: 
				SELECT DATEDIFF('2016-02-29', NOW()) AS test, DATEDIFF('2016-02-29', NOW()) % bank_recurring_days AS test2, *
				FROM bank_recurring
				WHERE bank_recurring_days!=0
					AND DATEDIFF('2016-02-29', NOW()) % bank_recurring_days = 0
			
ERROR - 2018-09-25 17:04:35 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '*
				FROM bank_recurring
				WHERE bank_recurring_days!=0
					AND DATEDIFF('20' at line 1 - Invalid query: 
				SELECT DATEDIFF('2016-02-29', NOW()) AS test, DATEDIFF('2016-02-29', NOW()) % bank_recurring_days AS test2, *
				FROM bank_recurring
				WHERE bank_recurring_days!=0
					AND DATEDIFF('2016-02-29', NOW()) % bank_recurring_days = 0
			
ERROR - 2018-09-25 17:05:22 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '*
				FROM bank_recurring
				WHERE bank_recurring_days!=0
					AND DATEDIFF('20' at line 1 - Invalid query: 
				SELECT DATEDIFF('2016-02-29', NOW()) AS test, DATEDIFF('2016-02-29', NOW()) % bank_recurring_days AS test2, *
				FROM bank_recurring
				WHERE bank_recurring_days!=0
					AND DATEDIFF('2016-02-29', NOW()) % bank_recurring_days = 0
			
ERROR - 2018-09-25 17:06:14 --> Severity: error --> Exception: /home/wzyzjm74avny/public_html/hfdev/application/models/Autos.php exists, but doesn't declare class Autos /home/wzyzjm74avny/public_html/hfdev/system/core/Loader.php 340
ERROR - 2018-09-25 17:14:28 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '(br.bank_recurring_months!=0 AND TIMESTAMPDIFF(MONTH, br.bank_recurring_start_da' at line 8 - Invalid query: 
				SELECT br.*
				FROM bank_recurring br
					JOIN bank bf ON br.join_bank_id=bf.bank_id
					JOIN bank bt ON br.bank_recurring_to=bt.bank_id
				WHERE
					bf.bank_pending=0 AND bf.bank_closed=0 AND bt.bank_pending=0 AND bt.bank_closed=0 AND
					(br.bank_recurring_days!=0 AND DATEDIFF(br.bank_recurring_start_date, NOW()) % br.bank_recurring_days = 0)
					(br.bank_recurring_months!=0 AND TIMESTAMPDIFF(MONTH, br.bank_recurring_start_date, NOW()) % br.bank_recurring_months = 0)
			
ERROR - 2018-09-25 21:44:33 --> Query error: Incorrect parameter count in the call to native function 'LAST_DAY' - Invalid query: 
				SELECT br.*,
					bf.join_players_id AS pid, bf.bank_balance, bf.bank_type,
					bt.join_players_id AS pid2, bt.bank_balance AS bank_balance2, bt.bank_type AS bank_type2
				FROM bank_recurring br
					JOIN bank bf ON br.join_bank_id=bf.bank_id
					JOIN bank bt ON br.bank_recurring_to=bt.bank_id
				WHERE
					bf.bank_pending=0 AND bf.bank_closed=0 AND bt.bank_pending=0 AND bt.bank_closed=0 AND
					((br.bank_recurring_days!=0 AND DATEDIFF(br.bank_recurring_start_date, NOW()) % br.bank_recurring_days = 0) OR
					(
						br.bank_recurring_months!=0
						AND TIMESTAMPDIFF(MONTH, br.bank_recurring_start_date, NOW()) % br.bank_recurring_months = 0
						AND (
							EXTRACT(DAY FROM br.bank_recurring_start_date) = '25')
							OR (
								CASE WHEN LAST_DAY() == EXTRACT(DAY FROM br.bank_recurring_start_date) THEN EXTRACT(DAY FROM br.bank_recurring_date) > '25'
							)
						)

					)
			
ERROR - 2018-09-25 21:46:08 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '== EXTRACT(DAY FROM br.bank_recurring_start_date) THEN EXTRACT(DAY FROM br.bank_' at line 16 - Invalid query: 
				SELECT br.*,
					bf.join_players_id AS pid, bf.bank_balance, bf.bank_type,
					bt.join_players_id AS pid2, bt.bank_balance AS bank_balance2, bt.bank_type AS bank_type2
				FROM bank_recurring br
					JOIN bank bf ON br.join_bank_id=bf.bank_id
					JOIN bank bt ON br.bank_recurring_to=bt.bank_id
				WHERE
					bf.bank_pending=0 AND bf.bank_closed=0 AND bt.bank_pending=0 AND bt.bank_closed=0 AND
					((br.bank_recurring_days!=0 AND DATEDIFF(br.bank_recurring_start_date, NOW()) % br.bank_recurring_days = 0) OR
					(
						br.bank_recurring_months!=0
						AND TIMESTAMPDIFF(MONTH, br.bank_recurring_start_date, NOW()) % br.bank_recurring_months = 0
						AND (
							EXTRACT(DAY FROM br.bank_recurring_start_date) = '2018-09-25')
							OR (
								CASE WHEN LAST_DAY('25') == EXTRACT(DAY FROM br.bank_recurring_start_date) THEN EXTRACT(DAY FROM br.bank_recurring_date) > '25'
							)
						)

					)
			
ERROR - 2018-09-25 21:46:30 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ')
						)

					)' at line 17 - Invalid query: 
				SELECT br.*,
					bf.join_players_id AS pid, bf.bank_balance, bf.bank_type,
					bt.join_players_id AS pid2, bt.bank_balance AS bank_balance2, bt.bank_type AS bank_type2
				FROM bank_recurring br
					JOIN bank bf ON br.join_bank_id=bf.bank_id
					JOIN bank bt ON br.bank_recurring_to=bt.bank_id
				WHERE
					bf.bank_pending=0 AND bf.bank_closed=0 AND bt.bank_pending=0 AND bt.bank_closed=0 AND
					((br.bank_recurring_days!=0 AND DATEDIFF(br.bank_recurring_start_date, NOW()) % br.bank_recurring_days = 0) OR
					(
						br.bank_recurring_months!=0
						AND TIMESTAMPDIFF(MONTH, br.bank_recurring_start_date, NOW()) % br.bank_recurring_months = 0
						AND (
							EXTRACT(DAY FROM br.bank_recurring_start_date) = '2018-09-25')
							OR (
								CASE WHEN LAST_DAY('25') = EXTRACT(DAY FROM br.bank_recurring_start_date) THEN EXTRACT(DAY FROM br.bank_recurring_date) > '25'
							)
						)

					)
			
ERROR - 2018-09-25 21:47:17 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ')
						)

					))' at line 17 - Invalid query: 
				SELECT br.*,
					bf.join_players_id AS pid, bf.bank_balance, bf.bank_type,
					bt.join_players_id AS pid2, bt.bank_balance AS bank_balance2, bt.bank_type AS bank_type2
				FROM bank_recurring br
					JOIN bank bf ON br.join_bank_id=bf.bank_id
					JOIN bank bt ON br.bank_recurring_to=bt.bank_id
				WHERE
					bf.bank_pending=0 AND bf.bank_closed=0 AND bt.bank_pending=0 AND bt.bank_closed=0 AND
					((br.bank_recurring_days!=0 AND DATEDIFF(br.bank_recurring_start_date, NOW()) % br.bank_recurring_days = 0) OR
					(
						br.bank_recurring_months!=0
						AND TIMESTAMPDIFF(MONTH, br.bank_recurring_start_date, NOW()) % br.bank_recurring_months = 0
						AND (
							EXTRACT(DAY FROM br.bank_recurring_start_date) = '2018-09-25')
							OR (
								CASE WHEN LAST_DAY('25') = EXTRACT(DAY FROM br.bank_recurring_start_date) THEN EXTRACT(DAY FROM br.bank_recurring_date) > '25'
							)
						)

					))
			
ERROR - 2018-09-25 21:50:44 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ')
							)
						)
					)' at line 18 - Invalid query: 
				SELECT br.*,
					bf.join_players_id AS pid, bf.bank_balance, bf.bank_type,
					bt.join_players_id AS pid2, bt.bank_balance AS bank_balance2, bt.bank_type AS bank_type2
				FROM bank_recurring br
					JOIN bank bf ON br.join_bank_id=bf.bank_id
					JOIN bank bt ON br.bank_recurring_to=bt.bank_id
				WHERE
					bf.bank_pending=0 AND bf.bank_closed=0 AND bt.bank_pending=0 AND bt.bank_closed=0
					AND (
						(br.bank_recurring_days!=0 AND DATEDIFF(br.bank_recurring_start_date, NOW()) % br.bank_recurring_days = 0)
						OR (
							br.bank_recurring_months!=0
							AND TIMESTAMPDIFF(MONTH, br.bank_recurring_start_date, NOW()) % br.bank_recurring_months = 0
							AND (
								EXTRACT(DAY FROM br.bank_recurring_start_date) = '2018-09-25'
								OR (
									CASE WHEN LAST_DAY('25') = EXTRACT(DAY FROM br.bank_recurring_start_date) THEN EXTRACT(DAY FROM br.bank_recurring_date) > '25'
								)
							)
						)
					)
			
ERROR - 2018-09-25 21:53:36 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '/*OR (
									CASE WHEN LAST_DAY('25') = EXTRACT(DAY FROM br.bank_recurring_st' at line 21 - Invalid query: 
				SELECT br.*,
					bf.join_players_id AS pid, bf.bank_balance, bf.bank_type,
					bt.join_players_id AS pid2, bt.bank_balance AS bank_balance2, bt.bank_type AS bank_type2
				FROM bank_recurring br
					JOIN bank bf ON br.join_bank_id=bf.bank_id
					JOIN bank bt ON br.bank_recurring_to=bt.bank_id
				WHERE
					bf.bank_pending=0 AND bf.bank_closed=0 AND bt.bank_pending=0 AND bt.bank_closed=0
					AND (
						(br.bank_recurring_days!=0 AND DATEDIFF(br.bank_recurring_start_date, NOW()) % br.bank_recurring_days = 0)
						OR (
							br.bank_recurring_months!=0
							AND TIMESTAMPDIFF(MONTH, br.bank_recurring_start_date, NOW()) % br.bank_recurring_months = 0
							AND (
								EXTRACT(DAY FROM br.bank_recurring_start_date) = '2018-09-25'
								/*OR (
									CASE WHEN LAST_DAY('25') = EXTRACT(DAY FROM br.bank_recurring_start_date) THEN EXTRACT(DAY FROM br.bank_recurring_date) > '25'
								)/*
							)
						)
					)
			
ERROR - 2018-09-25 21:53:50 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '/*OR (
									CASE WHEN LAST_DAY('25') = EXTRACT(DAY FROM br.bank_recurring_st' at line 21 - Invalid query: 
				SELECT br.*,
					bf.join_players_id AS pid, bf.bank_balance, bf.bank_type,
					bt.join_players_id AS pid2, bt.bank_balance AS bank_balance2, bt.bank_type AS bank_type2
				FROM bank_recurring br
					JOIN bank bf ON br.join_bank_id=bf.bank_id
					JOIN bank bt ON br.bank_recurring_to=bt.bank_id
				WHERE
					bf.bank_pending=0 AND bf.bank_closed=0 AND bt.bank_pending=0 AND bt.bank_closed=0
					AND (
						(br.bank_recurring_days!=0 AND DATEDIFF(br.bank_recurring_start_date, NOW()) % br.bank_recurring_days = 0)
						OR (
							br.bank_recurring_months!=0
							AND TIMESTAMPDIFF(MONTH, br.bank_recurring_start_date, NOW()) % br.bank_recurring_months = 0
							AND (
								EXTRACT(DAY FROM br.bank_recurring_start_date) = '2018-09-25'
								/*OR (
									CASE WHEN LAST_DAY('25') = EXTRACT(DAY FROM br.bank_recurring_start_date) THEN EXTRACT(DAY FROM br.bank_recurring_date) > '25'
								)/*
							)
						)
					)
			
ERROR - 2018-09-25 21:54:50 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ')
							)
						)
					)' at line 18 - Invalid query: 
				SELECT br.*,
					bf.join_players_id AS pid, bf.bank_balance, bf.bank_type,
					bt.join_players_id AS pid2, bt.bank_balance AS bank_balance2, bt.bank_type AS bank_type2
				FROM bank_recurring br
					JOIN bank bf ON br.join_bank_id=bf.bank_id
					JOIN bank bt ON br.bank_recurring_to=bt.bank_id
				WHERE
					bf.bank_pending=0 AND bf.bank_closed=0 AND bt.bank_pending=0 AND bt.bank_closed=0
					AND (
						(br.bank_recurring_days!=0 AND DATEDIFF(br.bank_recurring_start_date, NOW()) % br.bank_recurring_days = 0)
						OR (
							br.bank_recurring_months!=0
							AND TIMESTAMPDIFF(MONTH, br.bank_recurring_start_date, NOW()) % br.bank_recurring_months = 0
							AND (
								EXTRACT(DAY FROM br.bank_recurring_start_date) = '25'
								OR (
									CASE WHEN LAST_DAY('25') = EXTRACT(DAY FROM br.bank_recurring_start_date) THEN EXTRACT(DAY FROM br.bank_recurring_date) > '2018-09-25'
								)
							)
						)
					)
			
ERROR - 2018-09-25 21:55:05 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ')
							)
						)
					)' at line 18 - Invalid query: 
				SELECT br.*,
					bf.join_players_id AS pid, bf.bank_balance, bf.bank_type,
					bt.join_players_id AS pid2, bt.bank_balance AS bank_balance2, bt.bank_type AS bank_type2
				FROM bank_recurring br
					JOIN bank bf ON br.join_bank_id=bf.bank_id
					JOIN bank bt ON br.bank_recurring_to=bt.bank_id
				WHERE
					bf.bank_pending=0 AND bf.bank_closed=0 AND bt.bank_pending=0 AND bt.bank_closed=0
					AND (
						(br.bank_recurring_days!=0 AND DATEDIFF(br.bank_recurring_start_date, NOW()) % br.bank_recurring_days = 0)
						OR (
							br.bank_recurring_months!=0
							AND TIMESTAMPDIFF(MONTH, br.bank_recurring_start_date, NOW()) % br.bank_recurring_months = 0
							AND (
								EXTRACT(DAY FROM br.bank_recurring_start_date) = '25'
								OR (
									CASE WHEN LAST_DAY('2018-09-25') = EXTRACT(DAY FROM br.bank_recurring_start_date) THEN EXTRACT(DAY FROM br.bank_recurring_date) > '25'
								)
							)
						)
					)
			
ERROR - 2018-09-25 21:58:14 --> Query error: Unknown column 'br.bank_recurring_date' in 'where clause' - Invalid query: 
				SELECT br.*,
					bf.join_players_id AS pid, bf.bank_balance, bf.bank_type,
					bt.join_players_id AS pid2, bt.bank_balance AS bank_balance2, bt.bank_type AS bank_type2
				FROM bank_recurring br
					JOIN bank bf ON br.join_bank_id=bf.bank_id
					JOIN bank bt ON br.bank_recurring_to=bt.bank_id
				WHERE
					bf.bank_pending=0 AND bf.bank_closed=0 AND bt.bank_pending=0 AND bt.bank_closed=0
					AND (
						(br.bank_recurring_days!=0 AND DATEDIFF(br.bank_recurring_start_date, NOW()) % br.bank_recurring_days = 0)
						OR (
							br.bank_recurring_months!=0
							AND TIMESTAMPDIFF(MONTH, br.bank_recurring_start_date, NOW()) % br.bank_recurring_months = 0
							AND (
								EXTRACT(DAY FROM br.bank_recurring_start_date) = '25'
								OR (
									CASE WHEN LAST_DAY('2018-09-25') = EXTRACT(DAY FROM br.bank_recurring_start_date) THEN EXTRACT(DAY FROM br.bank_recurring_date) > '25' END
								)
							)
						)
					)
			
ERROR - 2018-09-25 22:12:00 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '?
								OR ()
							)
						)
					)' at line 15 - Invalid query: 
				SELECT br.*,
					bf.join_players_id AS pid, bf.bank_balance, bf.bank_type,
					bt.join_players_id AS pid2, bt.bank_balance AS bank_balance2, bt.bank_type AS bank_type2
				FROM bank_recurring br
					JOIN bank bf ON br.join_bank_id=bf.bank_id
					JOIN bank bt ON br.bank_recurring_to=bt.bank_id
				WHERE
					bf.bank_pending=0 AND bf.bank_closed=0 AND bt.bank_pending=0 AND bt.bank_closed=0
					AND (
						(br.bank_recurring_days!=0 AND DATEDIFF(br.bank_recurring_start_date, NOW()) % br.bank_recurring_days = 0)
						OR (
							br.bank_recurring_months!=0
							AND TIMESTAMPDIFF(MONTH, br.bank_recurring_start_date, NOW()) % br.bank_recurring_months = 0
							AND (
								EXTRACT(DAY FROM br.bank_recurring_start_date) = ?
								OR ()
							)
						)
					)
			
ERROR - 2018-09-25 22:12:44 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '?
								
							)
						)
					)' at line 15 - Invalid query: 
				SELECT br.*,
					bf.join_players_id AS pid, bf.bank_balance, bf.bank_type,
					bt.join_players_id AS pid2, bt.bank_balance AS bank_balance2, bt.bank_type AS bank_type2
				FROM bank_recurring br
					JOIN bank bf ON br.join_bank_id=bf.bank_id
					JOIN bank bt ON br.bank_recurring_to=bt.bank_id
				WHERE
					bf.bank_pending=0 AND bf.bank_closed=0 AND bt.bank_pending=0 AND bt.bank_closed=0
					AND (
						(br.bank_recurring_days!=0 AND DATEDIFF(br.bank_recurring_start_date, NOW()) % br.bank_recurring_days = 0)
						OR (
							br.bank_recurring_months!=0
							AND TIMESTAMPDIFF(MONTH, br.bank_recurring_start_date, NOW()) % br.bank_recurring_months = 0
							AND (
								EXTRACT(DAY FROM br.bank_recurring_start_date) = ?
								
							)
						)
					)
			
ERROR - 2018-09-25 22:15:19 --> Severity: error --> Exception: [] operator not supported for strings /home/wzyzjm74avny/public_html/hfdev/application/models/Autos.php 24
ERROR - 2018-09-25 22:15:21 --> Severity: error --> Exception: [] operator not supported for strings /home/wzyzjm74avny/public_html/hfdev/application/models/Autos.php 24
ERROR - 2018-09-25 22:15:25 --> Severity: error --> Exception: [] operator not supported for strings /home/wzyzjm74avny/public_html/hfdev/application/models/Autos.php 24
ERROR - 2018-09-25 22:15:26 --> Severity: error --> Exception: [] operator not supported for strings /home/wzyzjm74avny/public_html/hfdev/application/models/Autos.php 24
ERROR - 2018-09-25 22:15:41 --> Severity: error --> Exception: /home/wzyzjm74avny/public_html/hfdev/application/models/Autos.php exists, but doesn't declare class Autos /home/wzyzjm74avny/public_html/hfdev/system/core/Loader.php 340
ERROR - 2018-09-25 22:15:42 --> Severity: error --> Exception: [] operator not supported for strings /home/wzyzjm74avny/public_html/hfdev/application/models/Autos.php 24
ERROR - 2018-09-25 22:15:43 --> Severity: error --> Exception: [] operator not supported for strings /home/wzyzjm74avny/public_html/hfdev/application/models/Autos.php 24
ERROR - 2018-09-25 22:15:44 --> Severity: error --> Exception: [] operator not supported for strings /home/wzyzjm74avny/public_html/hfdev/application/models/Autos.php 24
ERROR - 2018-09-25 22:16:22 --> Severity: error --> Exception: /home/wzyzjm74avny/public_html/hfdev/application/models/Autos.php exists, but doesn't declare class Autos /home/wzyzjm74avny/public_html/hfdev/system/core/Loader.php 340
ERROR - 2018-09-25 22:16:23 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'EXTRACT(DAY FROM br.bank_recurring_start_date)=26OR EXTRACT(DAY FROM br.bank_rec' at line 16 - Invalid query: 
				SELECT br.*,
					bf.join_players_id AS pid, bf.bank_balance, bf.bank_type,
					bt.join_players_id AS pid2, bt.bank_balance AS bank_balance2, bt.bank_type AS bank_type2
				FROM bank_recurring br
					JOIN bank bf ON br.join_bank_id=bf.bank_id
					JOIN bank bt ON br.bank_recurring_to=bt.bank_id
				WHERE
					bf.bank_pending=0 AND bf.bank_closed=0 AND bt.bank_pending=0 AND bt.bank_closed=0
					AND (
						(br.bank_recurring_days!=0 AND DATEDIFF(br.bank_recurring_start_date, NOW()) % br.bank_recurring_days = 0)
						OR (
							br.bank_recurring_months!=0
							AND TIMESTAMPDIFF(MONTH, br.bank_recurring_start_date, NOW()) % br.bank_recurring_months = 0
							AND (
								EXTRACT(DAY FROM br.bank_recurring_start_date) = '25'
								OR EXTRACT(DAY FROM br.bank_recurring_start_date)=25OR EXTRACT(DAY FROM br.bank_recurring_start_date)=26OR EXTRACT(DAY FROM br.bank_recurring_start_date)=27OR EXTRACT(DAY FROM br.bank_recurring_start_date)=28OR EXTRACT(DAY FROM br.bank_recurring_start_date)=29OR EXTRACT(DAY FROM br.bank_recurring_start_date)=30OR EXTRACT(DAY FROM br.bank_recurring_start_date)=31
							)
						)
					)
			
ERROR - 2018-09-25 22:38:15 --> Severity: error --> Exception: syntax error, unexpected '}', expecting ',' or ';' /home/wzyzjm74avny/public_html/hfdev/application/models/Autos.php 112
ERROR - 2018-09-25 22:38:35 --> Query error: Unknown column 'interest_accrued' in 'field list' - Invalid query: UPDATE bank SET interest_accrued=300, bank_balance=bank_balance+300 WHERE bank_id='4'
