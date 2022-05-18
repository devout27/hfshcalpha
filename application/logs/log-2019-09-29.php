<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2019-09-29 04:58:40 --> 404 Page Not Found: Forum/index
ERROR - 2019-09-29 04:58:41 --> 404 Page Not Found: Forums/index
ERROR - 2019-09-29 04:58:42 --> 404 Page Not Found: Vb/index
ERROR - 2019-09-29 04:58:43 --> 404 Page Not Found: Vbulletin/index
ERROR - 2019-09-29 04:58:44 --> 404 Page Not Found: Vb5/index
ERROR - 2019-09-29 04:58:45 --> 404 Page Not Found: Vbulletin5/index
ERROR - 2019-09-29 05:41:07 --> 404 Page Not Found: Wp/index
ERROR - 2019-09-29 05:41:08 --> 404 Page Not Found: Wordpress/index
ERROR - 2019-09-29 05:41:08 --> 404 Page Not Found: Blog/index
ERROR - 2019-09-29 10:49:59 --> Severity: error --> Exception: syntax error, unexpected '"' /home/wzyzjm74avny/public_html/hfdev/application/models/Horse.php 1649
ERROR - 2019-09-29 10:58:16 --> Severity: error --> Exception: syntax error, unexpected end of file, expecting variable (T_VARIABLE) or ${ (T_DOLLAR_OPEN_CURLY_BRACES) or {$ (T_CURLY_OPEN) /home/wzyzjm74avny/public_html/hfdev/application/models/Horse.php 1893
ERROR - 2019-09-29 10:58:28 --> Severity: error --> Exception: syntax error, unexpected 'p' (T_STRING), expecting function (T_FUNCTION) or const (T_CONST) /home/wzyzjm74avny/public_html/hfdev/application/models/Horse.php 2085
ERROR - 2019-09-29 11:20:28 --> 404 Page Not Found: Faviconico/index
ERROR - 2019-09-29 11:20:33 --> 404 Page Not Found: Faviconico/index
ERROR - 2019-09-29 11:20:50 --> 404 Page Not Found: Faviconico/index
ERROR - 2019-09-29 11:21:05 --> 404 Page Not Found: Faviconico/index
ERROR - 2019-09-29 11:24:25 --> 404 Page Not Found: Faviconico/index
ERROR - 2019-09-29 11:25:18 --> 404 Page Not Found: Faviconico/index
ERROR - 2019-09-29 11:25:59 --> 404 Page Not Found: Faviconico/index
ERROR - 2019-09-29 11:39:13 --> 404 Page Not Found: Horses/53
ERROR - 2019-09-29 11:53:41 --> Query error: Table 'hfdev.genes_blueprints_x_genes_value' doesn't exist - Invalid query: 
				SELECT join_genes_id AS horses_x_genes_id, genes_blueprints_x_genes_value AS horses_x_genes_value, join_blueprints_id
				FROM genes_blueprints_x_genes_value
				WHERE join_blueprints_id IN
					(SELECT gene_blueprints_id FROM gene_blueprints WHERE gene_blueprints_name='Buckskin' AND join_genes_categories_name='Color')
				
ERROR - 2019-09-29 11:54:27 --> Query error: Table 'hfdev.gene_blueprints' doesn't exist - Invalid query: 
				SELECT join_genes_id AS horses_x_genes_id, genes_blueprints_x_genes_value AS horses_x_genes_value, join_blueprints_id
				FROM genes_blueprints_x_genes
				WHERE join_blueprints_id IN
					(SELECT gene_blueprints_id FROM gene_blueprints WHERE gene_blueprints_name='Buckskin' AND join_genes_categories_name='Color')
				
ERROR - 2019-09-29 11:54:30 --> Query error: Table 'hfdev.gene_blueprints' doesn't exist - Invalid query: 
				SELECT join_genes_id AS horses_x_genes_id, genes_blueprints_x_genes_value AS horses_x_genes_value, join_blueprints_id
				FROM genes_blueprints_x_genes
				WHERE join_blueprints_id IN
					(SELECT gene_blueprints_id FROM gene_blueprints WHERE gene_blueprints_name='Buckskin' AND join_genes_categories_name='Color')
				
ERROR - 2019-09-29 11:54:47 --> Query error: Unknown column 'join_blueprints_id' in 'field list' - Invalid query: 
				SELECT join_genes_id AS horses_x_genes_id, genes_blueprints_x_genes_value AS horses_x_genes_value, join_blueprints_id
				FROM genes_blueprints_x_genes
				WHERE join_blueprints_id IN
					(SELECT genes_blueprints_id FROM genes_blueprints WHERE genes_blueprints_name='Buckskin' AND join_genes_categories_name='Color')
				
ERROR - 2019-09-29 11:55:14 --> Query error: Unknown column 'join_blueprints_id' in 'field list' - Invalid query: 
				SELECT join_genes_id AS horses_x_genes_id, genes_blueprints_x_genes_value AS horses_x_genes_value, join_blueprints_id
				FROM genes_blueprints_x_genes
				WHERE join_genes_blueprints_id IN
					(SELECT genes_blueprints_id FROM genes_blueprints WHERE genes_blueprints_name='Buckskin' AND join_genes_categories_name='Color')
				
ERROR - 2019-09-29 11:55:19 --> Query error: Unknown column 'join_blueprints_id' in 'field list' - Invalid query: 
				SELECT join_genes_id AS horses_x_genes_id, genes_blueprints_x_genes_value AS horses_x_genes_value, join_blueprints_id
				FROM genes_blueprints_x_genes
				WHERE join_genes_blueprints_id IN
					(SELECT genes_blueprints_id FROM genes_blueprints WHERE genes_blueprints_name='Buckskin' AND join_genes_categories_name='Color')
				
ERROR - 2019-09-29 12:07:47 --> Severity: error --> Exception: syntax error, unexpected end of file /home/wzyzjm74avny/public_html/hfdev/application/models/Horse.php 2255
ERROR - 2019-09-29 12:13:39 --> Severity: error --> Exception: syntax error, unexpected 'foreach' (T_FOREACH) /home/wzyzjm74avny/public_html/hfdev/application/models/Horse.php 917
ERROR - 2019-09-29 12:13:41 --> Severity: error --> Exception: syntax error, unexpected 'foreach' (T_FOREACH) /home/wzyzjm74avny/public_html/hfdev/application/models/Horse.php 917
ERROR - 2019-09-29 12:14:47 --> Severity: error --> Exception: syntax error, unexpected end of file /home/wzyzjm74avny/public_html/hfdev/application/models/Horse.php 91
ERROR - 2019-09-29 12:23:07 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '?, ?, ?), (?, ?, ?), (?, ?, ?), (?, ?, ?)' at line 1 - Invalid query: INSERT INTO horses_x_genes(join_horses_id, join_genes_id, horses_x_genes_value) VALUES (?, ?, ?), (?, ?, ?), (?, ?, ?), (?, ?, ?)
ERROR - 2019-09-29 12:24:19 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'SET (?, ?, ?), (?, ?, ?), (?, ?, ?), (?, ?, ?)' at line 1 - Invalid query: INSERT INTO horses_x_genes(join_horses_id, join_genes_id, horses_x_genes_value) SET (?, ?, ?), (?, ?, ?), (?, ?, ?), (?, ?, ?)
ERROR - 2019-09-29 12:24:39 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '?, ?, ?), (?, ?, ?), (?, ?, ?), (?, ?, ?)' at line 1 - Invalid query: INSERT INTO horses_x_genes(join_horses_id, join_genes_id, horses_x_genes_value) VALUES (?, ?, ?), (?, ?, ?), (?, ?, ?), (?, ?, ?)
ERROR - 2019-09-29 12:25:16 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '?, ?, ?), (?, ?, ?), (?, ?, ?), (?, ?, ?)' at line 1 - Invalid query: INSERT INTO horses_x_genes(join_horses_id, join_genes_id, horses_x_genes_value) VALUES (?, ?, ?), (?, ?, ?), (?, ?, ?), (?, ?, ?)
ERROR - 2019-09-29 12:25:17 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '?, ?, ?), (?, ?, ?), (?, ?, ?), (?, ?, ?)' at line 1 - Invalid query: INSERT INTO horses_x_genes(join_horses_id, join_genes_id, horses_x_genes_value) VALUES (?, ?, ?), (?, ?, ?), (?, ?, ?), (?, ?, ?)
ERROR - 2019-09-29 12:27:00 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '?, ?, ?), (?, ?, ?), (?, ?, ?), (?, ?, ?)' at line 1 - Invalid query: INSERT INTO horses_x_genes(join_horses_id, join_genes_id, horses_x_genes_value) VALUES (?, ?, ?), (?, ?, ?), (?, ?, ?), (?, ?, ?)
ERROR - 2019-09-29 12:29:33 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '?, ?, ?), (?, ?, ?), (?, ?, ?), (?, ?, ?)' at line 1 - Invalid query: INSERT INTO horses_x_genes(join_horses_id, join_genes_id, horses_x_genes_value) VALUES (?, ?, ?), (?, ?, ?), (?, ?, ?), (?, ?, ?)
ERROR - 2019-09-29 12:29:59 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '?, ?, ?), (?, ?, ?), (?, ?, ?), (?, ?, ?)' at line 1 - Invalid query: INSERT INTO horses_x_genes(join_horses_id, join_genes_id, horses_x_genes_value) VALUES (?, ?, ?), (?, ?, ?), (?, ?, ?), (?, ?, ?)
ERROR - 2019-09-29 12:30:41 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '?, ?, ?), (?, ?, ?), (?, ?, ?), (?, ?, ?)' at line 1 - Invalid query: INSERT INTO horses_x_genes(join_horses_id, join_genes_id, horses_x_genes_value) VALUES (?, ?, ?), (?, ?, ?), (?, ?, ?), (?, ?, ?)
ERROR - 2019-09-29 12:33:04 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '?, ?, ?), (?, ?, ?), (?, ?, ?), (?, ?, ?)' at line 1 - Invalid query: INSERT INTO horses_x_genes(join_horses_id, join_genes_id, horses_x_genes_value) VALUES (?, ?, ?), (?, ?, ?), (?, ?, ?), (?, ?, ?)
ERROR - 2019-09-29 12:48:35 --> 404 Page Not Found: Faviconico/index
ERROR - 2019-09-29 12:49:21 --> 404 Page Not Found: Faviconico/index
ERROR - 2019-09-29 12:57:14 --> Severity: error --> Exception: syntax error, unexpected ''start_date'];' (T_ENCAPSED_AND_WHITESPACE), expecting ']' /home/wzyzjm74avny/public_html/hfdev/application/models/Horse.php 2367
ERROR - 2019-09-29 12:57:34 --> Severity: error --> Exception: syntax error, unexpected end of file /home/wzyzjm74avny/public_html/hfdev/application/models/Horse.php 2244
ERROR - 2019-09-29 13:00:26 --> Severity: error --> Exception: syntax error, unexpected end of file /home/wzyzjm74avny/public_html/hfdev/application/models/Horse.php 91
ERROR - 2019-09-29 13:00:47 --> Severity: error --> Exception: syntax error, unexpected end of file /home/wzyzjm74avny/public_html/hfdev/application/models/Horse.php 2044
ERROR - 2019-09-29 13:01:35 --> Severity: error --> Exception: syntax error, unexpected 'h', expecting variable (T_VARIABLE) or quoted-string and whitespace (T_ENCAPSED_AND_WHITESPACE) or ${ (T_DOLLAR_OPEN_CURLY_BRACES) or {$ (T_CURLY_OPEN) /home/wzyzjm74avny/public_html/hfdev/application/models/Horse.php 2367
ERROR - 2019-09-29 13:02:53 --> Severity: error --> Exception: syntax error, unexpected end of file /home/wzyzjm74avny/public_html/hfdev/application/models/Horse.php 91
ERROR - 2019-09-29 13:05:07 --> Severity: error --> Exception: /home/wzyzjm74avny/public_html/hfdev/application/models/Horse.php exists, but doesn't declare class Horse /home/wzyzjm74avny/public_html/hfdev/system/core/Loader.php 340
ERROR - 2019-09-29 13:05:23 --> Severity: error --> Exception: syntax error, unexpected 'I', expecting variable (T_VARIABLE) or quoted-string and whitespace (T_ENCAPSED_AND_WHITESPACE) or ${ (T_DOLLAR_OPEN_CURLY_BRACES) or {$ (T_CURLY_OPEN) /home/wzyzjm74avny/public_html/hfdev/application/models/Horse.php 890
ERROR - 2019-09-29 13:06:03 --> Severity: error --> Exception: syntax error, unexpected 'E', expecting variable (T_VARIABLE) or ${ (T_DOLLAR_OPEN_CURLY_BRACES) or {$ (T_CURLY_OPEN) /home/wzyzjm74avny/public_html/hfdev/application/models/Horse.php 1437
ERROR - 2019-09-29 13:24:47 --> 404 Page Not Found: Admin/horses
ERROR - 2019-09-29 13:24:56 --> 404 Page Not Found: Admin/horses
ERROR - 2019-09-29 13:26:12 --> 404 Page Not Found: Admin/horses
