<?php
require('src/Link.php');
require('controllers/HomeController.php');
require('controllers/PostController.php');
require('models/view.php');

$routes = array(
	'/' => ['HomeController', 'Home'],
	'/posts' => 'PostController',
	'/posts/{a}' => 'PostController',	
);

Link::all($routes);
