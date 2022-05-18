<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2021-12-09 06:22:02 --> 404 Page Not Found: Horsesregister/index
ERROR - 2021-12-09 07:13:36 --> Severity: error --> Exception: Call to undefined function is_number() /home1/hfshcpha/dev.hfshcalpha.com/application/models/Horse.php 2534
ERROR - 2021-12-09 07:35:35 --> 404 Page Not Found: Hor/index
ERROR - 2021-12-09 07:46:34 --> 404 Page Not Found: Assets/admin
ERROR - 2021-12-09 07:49:01 --> 404 Page Not Found: Hors/index
ERROR - 2021-12-09 20:33:01 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ')' at line 7 - Invalid query: 
                SELECT br.*,
                    bf.bank_nickname, bf.bank_balance, bf.bank_pending, bf.bank_closed, bf.bank_type,
                    bt.bank_nickname AS bank_nickname2, bt.bank_balance AS bank_balance2, bt.bank_pending AS bank_pending2, bt.bank_closed AS bank_closed2, bt.bank_type AS bank_type2, bt.join_players_id AS join_players_id2
                FROM bank_recurring br
                    LEFT JOIN bank bf ON br.join_bank_id=bf.bank_id
                    LEFT JOIN bank bt ON br.bank_recurring_to=bt.bank_id
                WHERE join_bank_id IN ()
            
