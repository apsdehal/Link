<?php
require('vendor/autoload.php');

$routes = array(
	'/' => ['Home', 'Home'],
	'/posts' => 'Post',
	'/posts/{a}' => 'Post',
	'/test' => 'Tester::testHandler'	
);

Link::all($routes);
