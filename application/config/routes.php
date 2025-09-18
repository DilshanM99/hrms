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
|	https://codeigniter.com/userguide3/general/routing.html
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
$route['default_controller'] = 'auth';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


// Auth module routes (explicit for clarity, though HMVC handles module/controller/method automatically)

$route['auth'] = 'auth/auth/index';
$route['auth/login'] = 'auth/auth/index';
$route['auth/login_post'] = 'auth/auth/login_post';
$route['auth/logout'] = 'auth/auth/logout';
$route['auth/forgot_password'] = 'auth/auth/forgot_password';
$route['auth/forgot_password_post'] = 'auth/auth/forgot_password_post';
$route['auth/reset/(:any)'] = 'auth/auth/reset/$1';
$route['auth/reset_post'] = 'auth/auth/reset_post';

// Dashboard route
$route['dashboard'] = 'dashboard';

// Employee module routes
$route['employee'] = 'employee/employee/index';
$route['employee/create'] = 'employee/employee/create';
$route['employee/store'] = 'employee/employee/store';
$route['employee/edit/(:num)'] = 'employee/employee/edit/$1';
$route['employee/update/(:num)'] = 'employee/employee/update/$1';
$route['employee/delete/(:num)'] = 'employee/employee/delete/$1';
$route['employee/profile/(:num)'] = 'employee/employee/profile/$1';

// Masters routes
$route['employee/masters/departments'] = 'employee/masters/departments';
$route['employee/masters/create_department'] = 'employee/masters/create_department';
$route['employee/masters/store_department'] = 'employee/masters/store_department';
$route['employee/masters/edit_department/(:num)'] = 'employee/masters/edit_department/$1';
$route['employee/masters/update_department/(:num)'] = 'employee/masters/update_department/$1';
$route['employee/masters/delete_department/(:num)'] = 'employee/masters/delete_department/$1';
$route['employee/masters/designations'] = 'employee/masters/designations';
$route['employee/masters/create_designation'] = 'employee/masters/create_designation';
$route['employee/masters/store_designation'] = 'employee/masters/store_designation';
$route['employee/masters/edit_designation/(:num)'] = 'employee/masters/edit_designation/$1';
$route['employee/masters/update_designation/(:num)'] = 'employee/masters/update_designation/$1';
$route['employee/masters/delete_designation/(:num)'] = 'employee/masters/delete_designation/$1';

// Payroll routes
$route['payroll'] = 'payroll/payroll';
$route['payroll/create_run'] = 'payroll/payroll/create_run';
$route['payroll/store_run'] = 'payroll/payroll/store_run';
$route['payroll/edit_run/(:num)'] = 'payroll/payroll/edit_run/$1';
$route['payroll/update_run/(:num)'] = 'payroll/payroll/update_run/$1';
$route['payroll/delete_run/(:num)'] = 'payroll/payroll/delete_run/$1';
$route['payroll/view_run/(:num)'] = 'payroll/payroll/view_run/$1';
$route['payroll/generate_run/(:num)'] = 'payroll/payroll/generate_run/$1';
$route['payroll/allowances'] = 'payroll/payroll/allowances';
$route['payroll/create_allowance'] = 'payroll/payroll/create_allowance';
$route['payroll/store_allowance'] = 'payroll/payroll/store_allowance';
$route['payroll/edit_allowance/(:num)'] = 'payroll/payroll/edit_allowance/$1';
$route['payroll/update_allowance/(:num)'] = 'payroll/payroll/update_allowance/$1';
$route['payroll/delete_allowance/(:num)'] = 'payroll/payroll/delete_allowance/$1';
$route['payroll/deductions'] = 'payroll/payroll/deductions';
$route['payroll/create_deduction'] = 'payroll/payroll/create_deduction';
$route['payroll/store_deduction'] = 'payroll/payroll/store_deduction';
$route['payroll/edit_deduction/(:num)'] = 'payroll/payroll/edit_deduction/$1';
$route['payroll/update_deduction/(:num)'] = 'payroll/payroll/update_deduction/$1';
$route['payroll/delete_deduction/(:num)'] = 'payroll/payroll/delete_deduction/$1';
$route['payroll/store_employee_allowance/(:num)'] = 'payroll/payroll/store_employee_allowance/$1';
$route['payroll/remove_employee_allowance/(:num)/(:num)'] = 'payroll/payroll/remove_employee_allowance/$1/$2';
$route['payroll/store_employee_deduction/(:num)'] = 'payroll/payroll/store_employee_deduction/$1';
$route['payroll/remove_employee_deduction/(:num)/(:num)'] = 'payroll/payroll/remove_employee_deduction/$1/$2';