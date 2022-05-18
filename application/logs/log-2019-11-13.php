<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2019-11-13 09:56:38 --> 404 Page Not Found: Faviconico/index
ERROR - 2019-11-13 09:57:08 --> 404 Page Not Found: Faviconico/index
ERROR - 2019-11-13 09:57:43 --> 404 Page Not Found: Faviconico/index
ERROR - 2019-11-13 10:28:58 --> Severity: error --> Exception: Call to undefined method Stables::get_amenity() /home/wzyzjm74avny/public_html/hfdev/application/controllers/Admin.php 70
ERROR - 2019-11-13 11:23:10 --> Severity: error --> Exception: Call to undefined method Events::admin_update_amenity() /home/wzyzjm74avny/public_html/hfdev/application/controllers/Admin.php 87
ERROR - 2019-11-13 11:23:30 --> Severity: error --> Exception: Call to undefined method Events::admin_update_amenity() /home/wzyzjm74avny/public_html/hfdev/application/controllers/Admin.php 87
ERROR - 2019-11-13 11:27:04 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '?, amenities_cost=?, amenities_description=?, amenities_type=?, amenities_acres=' at line 1 - Invalid query: UPDATE amenities SET amenities_name=?, amenities_cost=?, amenities_description=?, amenities_type=?, amenities_acres=?, amenities_stalls=?, amenities_limit, WHERE amenities_id=?
ERROR - 2019-11-13 11:27:53 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '?, amenities_cost=?, amenities_description=?, amenities_type=?, amenities_acres=' at line 1 - Invalid query: UPDATE amenities SET amenities_name=?, amenities_cost=?, amenities_description=?, amenities_type=?, amenities_acres=?, amenities_stalls=?, amenities_limit, WHERE amenities_id=?
ERROR - 2019-11-13 11:34:13 --> 404 Page Not Found: Admin/stables
ERROR - 2019-11-13 11:42:18 --> 404 Page Not Found: Faviconico/index
ERROR - 2019-11-13 11:42:21 --> 404 Page Not Found: Admin/stables
ERROR - 2019-11-13 11:56:37 --> 404 Page Not Found: Admin/stables
ERROR - 2019-11-13 11:58:01 --> 404 Page Not Found: Faviconico/index
ERROR - 2019-11-13 11:59:37 --> 404 Page Not Found: Admin/stables_amenities_delete
ERROR - 2019-11-13 11:59:44 --> 404 Page Not Found: Admin/stables_amenities_delete
ERROR - 2019-11-13 12:00:06 --> 404 Page Not Found: Admin/stables_amenities_delete
ERROR - 2019-11-13 12:00:41 --> 404 Page Not Found: Admin/stables_amenities_delete
ERROR - 2019-11-13 12:22:42 --> Severity: error --> Exception: Call to undefined method Stables::get_packages() /home/wzyzjm74avny/public_html/hfdev/application/controllers/Admin.php 66
ERROR - 2019-11-13 12:29:32 --> Query error: Unknown column 'spxa.stable_packages_x_amenities_id' in 'field list' - Invalid query: SELECT sp.*, spxa.stable_packages_x_amenities_id, a.* FROM stables_packages sp LEFT JOIN stables_packages_x_amenities spxa ON spxa.join_stables_packages_id=stables_packages_id LEFT JOIN amenities a ON a.amenities_id=spxa.join_amenities_id ORDER BY sp.stables_packages_name ASC
