<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'Auth/login';
$route['usuario'] = 'user/usuario';
$route['clasifiaciones'] = 'clasifiaciones';
$route['partidos'] = 'partidos';
$route['equipos'] = 'equipos';
$route['admin'] = 'admin';
$route['user/agregar_jugadores/(:num)'] = 'user/agregar_jugadores/$1';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['logout'] = 'Auth/logout';
$route['registro'] = 'registro/index';
$route['registro/registrar'] = 'registro/registrar';
$route['torneos'] = 'Torneos';
$route['auth/do_login'] = 'Auth/do_login';
$route['notificaciones'] = 'notificaciones/obtener_notificaciones';