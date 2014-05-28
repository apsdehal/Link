<?php
require('vendor/autoload.php');
$routes = array(
	'/' => ['HomeController', 'Home'],
	'/posts' => 'PostController',
	'/posts/{a}' => 'PostController',	
);

Link::all($routes);
