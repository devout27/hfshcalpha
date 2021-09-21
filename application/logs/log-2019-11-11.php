<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2019-11-11 10:17:05 --> Severity: error --> Exception: syntax error, unexpected ':' /home/wzyzjm74avny/public_html/hfdev/application/views/city/events-classes-view.php 84
ERROR - 2019-11-11 10:17:06 --> Severity: error --> Exception: syntax error, unexpected ':' /home/wzyzjm74avny/public_html/hfdev/application/views/city/events-classes-view.php 84
ERROR - 2019-11-11 10:17:07 --> Severity: error --> Exception: syntax error, unexpected ':' /home/wzyzjm74avny/public_html/hfdev/application/views/city/events-classes-view.php 84
ERROR - 2019-11-11 10:17:16 --> Severity: error --> Exception: syntax error, unexpected ':' /home/wzyzjm74avny/public_html/hfdev/application/views/city/events-classes-view.php 84
ERROR - 2019-11-11 10:28:53 --> Severity: error --> Exception: Unsupported operand types /home/wzyzjm74avny/public_html/hfdev/application/views/admin/events-classlist.php 219
ERROR - 2019-11-11 12:02:56 --> Query error: Unknown column 'ed.join_divisions_id' in 'on clause' - Invalid query: SELECT exc.*, cd.*, ed.* FROM events_x_classes exc LEFT JOIN classlists_divisions cd ON cd.classlists_divisions_id=exc.join_divisions_id LEFT JOIN events_divisions ed ON ed.join_divisions_id=exc.join_divisions_id WHERE events_x_classes_id='51'
ERROR - 2019-11-11 12:02:57 --> Query error: Unknown column 'ed.join_divisions_id' in 'on clause' - Invalid query: SELECT exc.*, cd.*, ed.* FROM events_x_classes exc LEFT JOIN classlists_divisions cd ON cd.classlists_divisions_id=exc.join_divisions_id LEFT JOIN events_divisions ed ON ed.join_divisions_id=exc.join_divisions_id WHERE events_x_classes_id='51'
ERROR - 2019-11-11 12:19:37 --> Query error: Unknown column 'ed.join_events_x_classes_id' in 'where clause' - Invalid query: SELECT ed.*, h.horses_name, h.horses_breed, p.players_nickname FROM events_divisions ed LEFT JOIN horses h ON h.horses_id=ed.join_horses_id LEFT JOIN players p ON p.players_id=h.join_players_id WHERE ed.join_events_x_classes_id='49' ORDER BY ed.events_divisions_place ASC
ERROR - 2019-11-11 12:45:19 --> Severity: error --> Exception: /home/wzyzjm74avny/public_html/hfdev/application/models/Events.php exists, but doesn't declare class Events /home/wzyzjm74avny/public_html/hfdev/system/core/Loader.php 340
ERROR - 2019-11-11 12:49:40 --> 404 Page Not Found: Faviconico/index
ERROR - 2019-11-11 12:50:27 --> 404 Page Not Found: Faviconico/index
ERROR - 2019-11-11 12:50:59 --> 404 Page Not Found: Faviconico/index
ERROR - 2019-11-11 13:00:32 --> 404 Page Not Found: Faviconico/index
ERROR - 2019-11-11 13:01:36 --> 404 Page Not Found: Faviconico/index
ERROR - 2019-11-11 14:49:45 --> Severity: error --> Exception: Call to a member function admin_get_pending() on null /home/wzyzjm74avny/public_html/hfdev/application/controllers/Admin.php 45
ERROR - 2019-11-11 14:54:14 --> Severity: error --> Exception: Call to a member function admin_get_pending() on null /home/wzyzjm74avny/public_html/hfdev/application/controllers/Admin.php 45
ERROR - 2019-11-11 14:55:34 --> Severity: error --> Exception: Call to a member function admin_get_pending() on null /home/wzyzjm74avny/public_html/hfdev/application/controllers/Admin.php 45
ERROR - 2019-11-11 14:55:35 --> Severity: error --> Exception: Call to a member function admin_get_pending() on null /home/wzyzjm74avny/public_html/hfdev/application/controllers/Admin.php 45
ERROR - 2019-11-11 14:55:36 --> Severity: error --> Exception: Call to a member function admin_get_pending() on null /home/wzyzjm74avny/public_html/hfdev/application/controllers/Admin.php 45
ERROR - 2019-11-11 14:55:59 --> Query error: Unknown column 'e.stables_id' in 'order clause' - Invalid query: SELECT e.*, p.players_nickname, c.cabs_name FROM events e
				LEFT OUTER JOIN cabs c ON c.cabs_id=e.join_cabs_id
				LEFT JOIN players p ON p.players_id=c.join_players_id
				WHERE e.events_pending=2 ORDER BY e.stables_id ASC
			
ERROR - 2019-11-11 14:56:00 --> Query error: Unknown column 'e.stables_id' in 'order clause' - Invalid query: SELECT e.*, p.players_nickname, c.cabs_name FROM events e
				LEFT OUTER JOIN cabs c ON c.cabs_id=e.join_cabs_id
				LEFT JOIN players p ON p.players_id=c.join_players_id
				WHERE e.events_pending=2 ORDER BY e.stables_id ASC
			
ERROR - 2019-11-11 15:01:06 --> 404 Page Not Found: Admin/stables
