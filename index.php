<?php
require('src/Link.php');
require('controllers/HomeController.php'); 
/* 
  You can autoload these classes by adding the folder to your 
  autoload section in composer.json of your project
*/
echo '<pre>';
print_r($_SERVER);

class ymm{
	function get(){
		echo 'Hello';
	}
}
$routes = array(
	'/hello' => 'Hello',
	'/hello/' => 'hello',
	'/hello/([a-zA-Z]+)' => ['ymm', 'Hello'],
	'/hello/{i}/{s}/{a}' => ['ymm', 'Yello'],
	);

Link::all($routes);

echo Link::route('Yello', array(1, 'a', 's'));