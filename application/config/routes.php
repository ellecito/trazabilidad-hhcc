<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['default_controller'] = "inicio";
$route['404_override'] = '';


/* RUTAS PYME */

#login
$route['login']											= "inicio/login";

#logout
$route['logout']										= "inicio/logout";

#motivo solicitudes
$route['motivo-solicitudes'] 							= "motivo_solicitudes";
$route['motivo-solicitudes/agregar'] 					= "motivo_solicitudes/agregar";
$route['motivo-solicitudes/editar/(:num)'] 				= "motivo_solicitudes/editar/$1";
$route['motivo-solicitudes/editar'] 					= "motivo_solicitudes/editar";

#motivo conforme
$route['motivo-conforme'] 							= "motivo_conforme";
$route['motivo-conforme/agregar'] 					= "motivo_conforme/agregar";
$route['motivo-conforme/editar/(:num)'] 			= "motivo_conforme/editar/$1";
$route['motivo-conforme/editar'] 					= "motivo_conforme/editar";

/* End of file routes.php */
/* Location: ./application/config/routes.php */
