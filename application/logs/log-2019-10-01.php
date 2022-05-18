<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2019-10-01 06:44:31 --> Query error: Table 'hfdev.classlist_classes' doesn't exist - Invalid query: INSERT INTO events_x_classes(join_events_id, events_x_classes_name, events_x_classes_description, events_x_classes_min_age, events_x_classes_max_age, events_x_classes_strenuous, events_x_classes_fee, events_x_classes_prize)
				(SELECT NULL AS join_events_id, classlist_classes_name, classlist_classes_description, classlist_classes_min_age, classlist_classes_max_age, classlist_classes_strenuous, classlist_classes_recommended_fee, classlist_classes_recommended_prize FROM classlist_classes WHERE join_classlists_id='3')
ERROR - 2019-10-01 06:46:39 --> 404 Page Not Found: City/events
ERROR - 2019-10-01 07:08:17 --> Severity: error --> Exception: /home/wzyzjm74avny/public_html/hfdev/application/models/Player.php exists, but doesn't declare class Player /home/wzyzjm74avny/public_html/hfdev/system/core/Loader.php 340
ERROR - 2019-10-01 07:18:41 --> 404 Page Not Found: City/events
ERROR - 2019-10-01 07:20:32 --> 404 Page Not Found: City/events
ERROR - 2019-10-01 07:20:33 --> 404 Page Not Found: City/events
ERROR - 2019-10-01 07:20:34 --> 404 Page Not Found: City/events
ERROR - 2019-10-01 07:20:44 --> 404 Page Not Found: City/events
ERROR - 2019-10-01 07:28:09 --> Severity: error --> Exception: Call to undefined method Events::create_event() /home/wzyzjm74avny/public_html/hfdev/application/controllers/City.php 342
ERROR - 2019-10-01 07:29:28 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '?, ?, ?, ?, ?, ?, ?, ?)' at line 1 - Invalid query: INSERT INTO events(join_players_id, events_name, events_pending, events_date1, events_date2, events_date3, join_cabs_id, join_classlists_id) VALUES(?, ?, ?, ?, ?, ?, ?, ?)
ERROR - 2019-10-01 11:29:12 --> 404 Page Not Found: Css/images
ERROR - 2019-10-01 11:29:17 --> Severity: error --> Exception: syntax error, unexpected ';' /home/wzyzjm74avny/public_html/hfdev/application/models/Events.php 133
ERROR - 2019-10-01 11:37:03 --> 404 Page Not Found: Faviconico/index
ERROR - 2019-10-01 11:41:45 --> 404 Page Not Found: Css/images
ERROR - 2019-10-01 11:45:35 --> Severity: error --> Exception: syntax error, unexpected end of file /home/wzyzjm74avny/public_html/hfdev/application/models/Events.php 110
