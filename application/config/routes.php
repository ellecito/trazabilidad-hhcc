<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['default_controller'] = "inicio";
$route['404_override'] = '';


/* RUTAS PYME */

#login
$route['login']											= "inicio/login";

#logout
$route['logout']										= "inicio/logout";

#paginas editables
$route['motivo-solicitudes'] 							= "motivo_solicitudes";
$route['motivo-solicitudes/agregar'] 					= "motivo_solicitudes/agregar";
$route['motivo-solicitudes/editar/(:num)'] 				= "motivo_solicitudes/editar/$1";
$route['motivo-solicitudes/editar'] 					= "motivo_solicitudes/editar";

/* End of file routes.php */
/* Location: ./application/config/routes.php */
