<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2019-04-08 01:19:38 --> Severity: error --> Exception: syntax error, unexpected '}' /home/wzyzjm74avny/public_html/hfdev/application/models/Auction.php 160
ERROR - 2019-04-08 01:19:40 --> Severity: error --> Exception: syntax error, unexpected '}' /home/wzyzjm74avny/public_html/hfdev/application/models/Auction.php 160
ERROR - 2019-04-08 02:04:26 --> 404 Page Not Found: Faviconico/index
ERROR - 2019-04-08 02:04:32 --> 404 Page Not Found: City/colosseum
ERROR - 2019-04-08 02:08:47 --> Severity: error --> Exception: syntax error, unexpected 'endif' (T_ENDIF) /home/wzyzjm74avny/public_html/hfdev/application/views/partials/auctions.php 45
ERROR - 2019-04-08 02:08:48 --> Severity: error --> Exception: syntax error, unexpected 'endif' (T_ENDIF) /home/wzyzjm74avny/public_html/hfdev/application/views/partials/auctions.php 45
ERROR - 2019-04-08 02:08:49 --> Severity: error --> Exception: syntax error, unexpected 'endif' (T_ENDIF) /home/wzyzjm74avny/public_html/hfdev/application/views/partials/auctions.php 45
ERROR - 2019-04-08 02:08:50 --> Severity: error --> Exception: syntax error, unexpected 'endif' (T_ENDIF) /home/wzyzjm74avny/public_html/hfdev/application/views/partials/auctions.php 45
ERROR - 2019-04-08 02:09:02 --> Severity: error --> Exception: syntax error, unexpected 'endif' (T_ENDIF) /home/wzyzjm74avny/public_html/hfdev/application/views/partials/auctions.php 45
ERROR - 2019-04-08 02:09:04 --> Severity: error --> Exception: syntax error, unexpected 'endforeach' (T_ENDFOREACH) /home/wzyzjm74avny/public_html/hfdev/application/views/partials/auctions.php 56
ERROR - 2019-04-08 02:09:06 --> Severity: error --> Exception: syntax error, unexpected 'endforeach' (T_ENDFOREACH) /home/wzyzjm74avny/public_html/hfdev/application/views/partials/auctions.php 56
ERROR - 2019-04-08 02:09:25 --> Severity: error --> Exception: syntax error, unexpected 'endforeach' (T_ENDFOREACH) /home/wzyzjm74avny/public_html/hfdev/application/views/partials/auctions.php 56
ERROR - 2019-04-08 02:09:26 --> Severity: error --> Exception: syntax error, unexpected '}' /home/wzyzjm74avny/public_html/hfdev/application/views/partials/auctions.php 45
ERROR - 2019-04-08 02:09:28 --> Severity: error --> Exception: syntax error, unexpected '}' /home/wzyzjm74avny/public_html/hfdev/application/views/partials/auctions.php 45
ERROR - 2019-04-08 02:09:29 --> Severity: error --> Exception: syntax error, unexpected '}' /home/wzyzjm74avny/public_html/hfdev/application/views/partials/auctions.php 45
ERROR - 2019-04-08 02:09:30 --> Severity: error --> Exception: syntax error, unexpected '}' /home/wzyzjm74avny/public_html/hfdev/application/views/partials/auctions.php 45
ERROR - 2019-04-08 02:09:54 --> Severity: error --> Exception: syntax error, unexpected '}' /home/wzyzjm74avny/public_html/hfdev/application/views/partials/auctions.php 45
ERROR - 2019-04-08 02:15:43 --> Query error: Column count doesn't match value count at row 1 - Invalid query: INSERT INTO auctions_bids(join_auctions_id, join_players_id, join_bank_id, auctions_start, auctions_end, auctions_increment, auctions_starting_bid) VALUES(NULL, NOW(), NOW()+INTERVAL NULL DAY, NULL, NULL)
ERROR - 2019-04-08 02:22:49 --> Query error: Unknown table 'a' - Invalid query: SELECT a.*, h.join_players_id AS horse_owner FROM auctions LEFT JOIN horses h ON h.horse_id=a.join_horses_id WHERE a.auctions_id='2' AND a.auctions_end>=NOW() LIMIT 1
ERROR - 2019-04-08 02:23:01 --> Query error: Unknown column 'h.horse_id' in 'on clause' - Invalid query: SELECT a.*, h.join_players_id AS horse_owner FROM auctions a LEFT JOIN horses h ON h.horse_id=a.join_horses_id WHERE a.auctions_id='2' AND a.auctions_end>=NOW() LIMIT 1
ERROR - 2019-04-08 02:23:03 --> Query error: Unknown column 'h.horse_id' in 'on clause' - Invalid query: SELECT a.*, h.join_players_id AS horse_owner FROM auctions a LEFT JOIN horses h ON h.horse_id=a.join_horses_id WHERE a.auctions_id='2' AND a.auctions_end>=NOW() LIMIT 1
ERROR - 2019-04-08 11:52:56 --> Severity: error --> Exception: syntax error, unexpected end of file, expecting elseif (T_ELSEIF) or else (T_ELSE) or endif (T_ENDIF) /home/wzyzjm74avny/public_html/hfdev/application/views/partials/auctions.php 39
ERROR - 2019-04-08 12:10:31 --> Severity: error --> Exception: Class 'Bank' not found /home/wzyzjm74avny/public_html/hfdev/application/views/horses/auction.php 18
ERROR - 2019-04-08 12:10:32 --> Severity: error --> Exception: Class 'Bank' not found /home/wzyzjm74avny/public_html/hfdev/application/views/horses/auction.php 18
ERROR - 2019-04-08 12:10:47 --> Severity: error --> Exception: Class 'Bank' not found /home/wzyzjm74avny/public_html/hfdev/application/views/horses/auction.php 18
ERROR - 2019-04-08 12:11:10 --> Severity: error --> Exception: Class 'Bank' not found /home/wzyzjm74avny/public_html/hfdev/application/views/horses/auction.php 18
ERROR - 2019-04-08 12:17:24 --> Query error: Column 'join_bank_id' cannot be null - Invalid query: INSERT INTO auctions(join_horses_id, join_bank_id, auctions_start, auctions_end, auctions_increment, auctions_starting_bid) VALUES('54', NULL, NOW(), NOW() + INTERVAL '21' DAY, NULL, NULL)
ERROR - 2019-04-08 12:17:48 --> Query error: Column 'auctions_increment' cannot be null - Invalid query: INSERT INTO auctions(join_horses_id, join_bank_id, auctions_start, auctions_end, auctions_increment, auctions_starting_bid) VALUES('54', '1', NOW(), NOW() + INTERVAL '21' DAY, NULL, NULL)
ERROR - 2019-04-08 13:01:14 --> Severity: error --> Exception: syntax error, unexpected end of file, expecting variable (T_VARIABLE) or ${ (T_DOLLAR_OPEN_CURLY_BRACES) or {$ (T_CURLY_OPEN) /home/wzyzjm74avny/public_html/hfdev/application/models/Autos.php 37
ERROR - 2019-04-08 13:04:20 --> Severity: error --> Exception: Too few arguments to function Bank::transfer(), 1 passed in /home/wzyzjm74avny/public_html/hfdev/application/models/Autos.php on line 144 and exactly 2 expected /home/wzyzjm74avny/public_html/hfdev/application/models/Bank.php 423
ERROR - 2019-04-08 13:05:36 --> Severity: error --> Exception: Too few arguments to function Bank::transfer(), 1 passed in /home/wzyzjm74avny/public_html/hfdev/application/models/Autos.php on line 144 and exactly 2 expected /home/wzyzjm74avny/public_html/hfdev/application/models/Bank.php 423
ERROR - 2019-04-08 13:05:38 --> Severity: error --> Exception: Too few arguments to function Bank::transfer(), 1 passed in /home/wzyzjm74avny/public_html/hfdev/application/models/Autos.php on line 144 and exactly 2 expected /home/wzyzjm74avny/public_html/hfdev/application/models/Bank.php 423
ERROR - 2019-04-08 13:10:52 --> Severity: error --> Exception: syntax error, unexpected '". Please accept the check and' (T_CONSTANT_ENCAPSED_STRING) /home/wzyzjm74avny/public_html/hfdev/application/models/Autos.php 147
ERROR - 2019-04-08 13:10:54 --> Severity: error --> Exception: syntax error, unexpected '". Please accept the check and' (T_CONSTANT_ENCAPSED_STRING) /home/wzyzjm74avny/public_html/hfdev/application/models/Autos.php 147
ERROR - 2019-04-08 13:14:15 --> Query error: Column 'bank_checks_to_id' cannot be null - Invalid query: INSERT INTO bank_checks(join_bank_id, bank_checks_to_id, bank_checks_amount, bank_checks_memo, bank_checks_status) VALUES('1',NULL,'8700','Winning auction bid for Horse #2','Pending')
ERROR - 2019-04-08 15:12:45 --> Severity: error --> Exception: Call to a member function get_article() on null /home/wzyzjm74avny/public_html/hfdev/application/controllers/City.php 59
ERROR - 2019-04-08 15:19:12 --> Severity: error --> Exception: Call to a member function search() on null /home/wzyzjm74avny/public_html/hfdev/application/controllers/City.php 64
ERROR - 2019-04-08 15:19:14 --> Severity: error --> Exception: Call to a member function search() on null /home/wzyzjm74avny/public_html/hfdev/application/controllers/City.php 64
ERROR - 2019-04-08 16:53:36 --> 404 Page Not Found: Horses/adopt
ERROR - 2019-04-08 17:02:53 --> Severity: error --> Exception: syntax error, unexpected 'public' (T_PUBLIC) /home/wzyzjm74avny/public_html/hfdev/application/models/Horse.php 258
ERROR - 2019-04-08 17:02:54 --> Severity: error --> Exception: syntax error, unexpected 'public' (T_PUBLIC) /home/wzyzjm74avny/public_html/hfdev/application/models/Horse.php 258
ERROR - 2019-04-08 17:29:33 --> Severity: error --> Exception: Cannot use object of type Player as array /home/wzyzjm74avny/public_html/hfdev/application/models/Horse.php 196
ERROR - 2019-04-08 17:38:44 --> 404 Page Not Found: Game/update-profile
ERROR - 2019-04-08 17:41:31 --> Severity: error --> Exception: Cannot use object of type Player as array /home/wzyzjm74avny/public_html/hfdev/application/controllers/Game.php 114
ERROR - 2019-04-08 17:41:32 --> Severity: error --> Exception: Cannot use object of type Player as array /home/wzyzjm74avny/public_html/hfdev/application/controllers/Game.php 114
