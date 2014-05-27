<?php

class Link {
	
	public static function all( $routes ) {
		$method = strtolower($_SERVER['REQUEST_METHOD']);
		$path = '/';
		if( !empty ( $_SERVER['PATH_INFO'] ) ) {
			$path = $_SERVER['PATH_INFO'];
		} else if ( !empty ( $_SERVER['REQUEST_URI'] ) ) {
            $path = (strpos($_SERVER['REQUEST_URI'], '?') > 0) ? strstr($_SERVER['REQUEST_URI'], '?', true) : $_SERVER['REQUEST_URI'];
		}
		echo $path;
	}
}