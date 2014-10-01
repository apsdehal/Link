<?php

require("config/bootstrap.php");
$routes = array (
	"/" => "HomeController",
	"/posts/{i}" => "PostController"
	"/posts/create" => "CreateController"
)