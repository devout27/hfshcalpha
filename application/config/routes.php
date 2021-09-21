<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['login'] = "welcome/login";
$route['logout'] = "welcome/logout";
/*$route['forgot_password'] = "welcome/forgot_password";*/
$route['tos'] = "welcome/tos";
//$route['register/(:any)'] = "welcome/register/$1";
$route['register'] = "welcome/register";
//$route['register_success'] = "welcome/register_success";


$route['game/profile/search'] = "game/search";
$route['game/update-profile'] = "game/update_profile";
$route['game/quit'] = "game/quit";
$route['game/cancel-quit'] = "game/cancel_quit";
$route['game/inventory/(:num)'] = "game/inventory/$1";

$route['game/messages/view/(:num)'] = "game/view_message/$1";
$route['game/messages/reply/(:num)'] = "game/msg_reply/$1";


$route['city/online/(:num)/(:any)'] = "city/bank_account/$1/$2";
$route['city/ideal-dreams'] = "city/ideal_dreams";
$route['city/stable/edit/(:num)'] = "city/stables_edit/$1";

$route['city/bank/(:num)'] = "city/bank_account/$1";
$route['city/bank/transfer'] = "city/transfer";
$route['city/bank/open_account'] = "city/open_account";
$route['city/bank/transfer/cancel/(:num)'] = "city/cancel_transfer/$1";
$route['city/bank/(:num)/transfer'] = "city/transfer/$1";
$route['city/bank/process_check/(:num)'] = "city/process_check/$1";

$route['city/vet/action'] = "city/vet";


$route['city/cabs/view/(:num)'] = "city/view_cabs/$1";
$route['city/cabs/edit/(:num)'] = "city/edit_cabs/$1";
$route['city/cabs/create'] = "city/create_cab";

$route['city/events/create'] = "city/events_create";
$route['city/events/create/(:num)'] = "city/events_create/$1";
$route['city/events/view/(:num)'] = "city/events_view/$1";
$route['city/events/classes/(:num)'] = "city/events_classes_view/$1";
$route['city/events/edit/(:num)'] = "city/events_edit/$1";
$route['city/events/cancel/(:num)'] = "city/events_cancel/$1";

$route['city/articles/(:num)'] = "city/articles_view/$1";


$route['horses/adopt/(:num)/(:any)'] = "horses/adopt/$1/$2";
$route['horses/view/offspring-genes/(:num)'] = "horses/view_offspring_genes/$1";

//my routes
$route['manage-horses'] = "horses/manageHorses";

$route['admin/mods/add'] = "admin/add_mod";
$route['admin/mods/edit/(:num)'] = "admin/edit_mod/$1";
$route['admin/mods/delete/(:num)'] = "admin/delete_mod/$1";

$route['admin/members/applications'] = "admin/member_applications";
$route['admin/members/applications/process'] = "admin/member_applications_process";
$route['admin/members/deletions'] = "admin/member_delete";
$route['admin/members/deletions/process/(:num)'] = "admin/member_delete_process/$1";

$route['admin/members/vets'] = "admin/member_vets";
$route['admin/members/vets/add'] = "admin/add_vet";
$route['admin/members/vets/revoke/(:num)'] = "admin/delete_vet/$1";
$route['admin/members/farriers'] = "admin/member_farriers";
$route['admin/members/farriers/add'] = "admin/add_farrier";
$route['admin/members/farriers/revoke/(:num)'] = "admin/delete_farrier/$1";

$route['admin/members/manage/(:num)'] = "admin/member_manage/$1";
$route['admin/members/remove/(:num)'] = "admin/member_remove/$1";


$route['admin/bank/applications'] = "admin/bank_applications";
$route['admin/bank/applications/process'] = "admin/bank_applications_process";
$route['admin/bank/applications/loan_process'] = "admin/bank_applications_loan_process";
$route['admin/bank/loans'] = "admin/bank_loans";
$route['admin/bank/transfer'] = "admin/bank_transfer";
$route['admin/bank/search'] = "admin/bank_search";
$route['admin/bank/search_transactions'] = "admin/bank_search_transactions";


$route['admin/cabs/pending'] = "admin/cabs_pending";
$route['admin/cabs/pending/process'] = "admin/cabs_process";
$route['admin/cabs/disable/(:num)'] = "admin/cabs_disable/$1";
$route['admin/cabs/enable/(:num)'] = "admin/cabs_enable/$1";


$route['admin/articles/add'] = "admin/articles_add";
$route['admin/articles/(:num)'] = "admin/articles_view/$1";
$route['admin/articles/delete/(:num)'] = "admin/articles_delete/$1";

$route['admin/members/adoptathon'] = "admin/adoptathon";
$route['admin/members/log'] = "admin/log";



$route['admin/horses/register'] = "admin/horse_register";
$route['admin/horses/breed'] = "admin/horse_breed";
$route['admin/horses/import'] = "admin/horse_import";
$route['admin/horses/export'] = "admin/horse_export";
$route['admin/horses/search'] = "admin/horse_search";
$route['admin/horses/breeds'] = "admin/horse_breeds";
$route['admin/horses/genes/edit/(:num)'] = "admin/horse_genes_edit/$1";
$route['admin/horses/genes'] = "admin/horse_genes";
$route['admin/horses/genes/blueprints/edit/(:num)'] = "admin/horse_gene_blueprints_edit/$1";
$route['admin/horses/genes/blueprints'] = "admin/horse_gene_blueprints";

$route['admin/events/pending'] = "admin/events_pending";
$route['admin/events/classlists'] = "admin/events_classlists";
$route['admin/events/classlists/view/(:num)'] = "admin/events_classlists_view/$1";
$route['admin/events/classlists/delete/(:num)'] = "admin/events_classlists_delete/$1";


$route['admin/stables/pending'] = "admin/stables_pending";
$route['admin/stables/amenities'] = "admin/stables_amenities";
$route['admin/stables/amenities/view/(:num)'] = "admin/stables_amenities_view/$1";
$route['admin/stables/amenities/delete/(:num)'] = "admin/stables_amenities_delete/$1";
$route['admin/stables/packages'] = "admin/stables_packages";
$route['admin/stables/packages/view/(:num)'] = "admin/stables_packages_view/$1";
$route['admin/stables/packages/delete/(:num)'] = "admin/stables_packages_delete/$1";
$route['admin/stables/land'] = "admin/stables_land";



$route['/city/ajax/(:any)'] = "city/ajax/$1";
$route['/admin/ajax/(:any)'] = "admin/ajax/$1";