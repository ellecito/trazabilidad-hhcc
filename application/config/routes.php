<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['default_controller'] = "inicio";
$route['404_override'] = '';


/* RUTAS PYME */

#login
$route['login']											= "inicio/login";

#logout
$route['logout']										= "inicio/logout";

#pacientes
$route['pacientes/(:num)'] 								= "pacientes/index/$1";
$route['pacientes'] 									= "pacientes";

#funcionarios
$route['funcionarios/(:num)'] 							= "funcionarios/index/$1";
$route['funcionarios'] 									= "funcionarios";

#medicos
$route['medicos/(:num)'] 								= "medicos/index/$1";
$route['medicos'] 										= "medicos";

#bodegas
$route['bodegas/(:num)'] 								= "bodegas/index/$1";
$route['bodegas'] 										= "bodegas";

#anaqueles
$route['anaqueles/(:num)'] 								= "anaqueles/index/$1";
$route['anaqueles'] 									= "anaqueles";

#divisiones
$route['divisiones/(:num)'] 							= "divisiones/index/$1";
$route['divisiones'] 									= "divisiones";

#especialidades
$route['especialidades/(:num)'] 						= "especialidades/index/$1";
$route['especialidades'] 								= "especialidades";

#solicitudes
$route['solicitudes/(:num)'] 							= "solicitudes/index/$1";
$route['solicitudes'] 									= "solicitudes";

#unidades
$route['unidades/(:num)'] 								= "unidades/index/$1";
$route['unidades'] 										= "unidades";

#box
$route['box/(:num)'] 									= "box/index/$1";
$route['box'] 											= "box";

#servicios
$route['servicios/(:num)'] 								= "servicios/index/$1";
$route['servicios'] 									= "servicios";

#conformidad
$route['conformidad/(:num)'] 							= "conformidad/index/$1";
$route['conformidad'] 									= "conformidad";

#motivo solicitudes
$route['motivo-solicitudes/(:num)'] 					= "motivo_solicitudes/index/$1";
$route['motivo-solicitudes'] 							= "motivo_solicitudes";
$route['motivo-solicitudes/agregar'] 					= "motivo_solicitudes/agregar";
$route['motivo-solicitudes/editar/(:num)'] 				= "motivo_solicitudes/editar/$1";
$route['motivo-solicitudes/editar'] 					= "motivo_solicitudes/editar";

#motivo conforme
$route['motivo-conforme/(:num)'] 						= "motivo_conforme/index/$1";
$route['motivo-conforme'] 								= "motivo_conforme";
$route['motivo-conforme/agregar'] 						= "motivo_conforme/agregar";
$route['motivo-conforme/editar/(:num)'] 				= "motivo_conforme/editar/$1";
$route['motivo-conforme/editar'] 						= "motivo_conforme/editar";

/* End of file routes.php */
/* Location: ./application/config/routes.php */
