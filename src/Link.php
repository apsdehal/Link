<?php

class Link {
	
	private static $recognized = array();

	public static function all( $routes ) {
		$method = strtolower($_SERVER['REQUEST_METHOD']);
		$path = '/';
		if ( !empty ( $_SERVER['PATH_INFO'] ) ) {
			$path = $_SERVER['PATH_INFO'];
		} else if ( !empty ( $_SERVER['REQUEST_URI'] ) ) {
            $path = (strpos($_SERVER['REQUEST_URI'], '?') > 0) ? strstr($_SERVER['REQUEST_URI'], '?', true) : $_SERVER['REQUEST_URI'];
		}

		if ( isset($routes[$path] ) ) {
			$handler = $routes[$path]
		}

		if ( isset($handler) ) {
			if ( is_callable($handler) ){
				$instanceOfHandler = $handler();
			} else {
				$instanceOfHandler = new $handler();
			}
		}

		if( isset( $handler ) ) {
			if( method_exists( $handler, $method ) ) {
				call_user_func(array($handler, $method));
				if ( !isset( self::$recognized[$path]  ) ) {
					self::$recognized[$path] = $handler;
				}	
			}
		}
	}
}