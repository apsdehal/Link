<?php

class Link {
	
	private static $recognized = array();

	public static function all( $routes ) {
		$method = strtolower($_SERVER['REQUEST_METHOD']);
		$path = '/';
		$handler = null;
		$matched = array();
		if ( !empty ( $_SERVER['PATH_INFO'] ) ) {
			$path = $_SERVER['PATH_INFO'];
		} else if ( !empty ( $_SERVER['REQUEST_URI'] ) ) {
            $path = (strpos($_SERVER['REQUEST_URI'], '?') > 0) ? strstr($_SERVER['REQUEST_URI'], '?', true) : $_SERVER['REQUEST_URI'];
		}

		if ( isset($routes[$path] ) ) {
			$handler = $routes[$path];
		} else if ( $routes ) {
			
			$regex = array(
				'/{i}/',
				'/{s}/',
				'/{a}/'
				);

			$replacements = array(
				'([\d]+)'	,
				'([a-zA-Z]+)',
				'([\w-]+)'
				);

			foreach ( $routes as $routePath => $routeHandler ){
				$routePath = preg_replace( $regex, $replacements, $routePath );
				if( preg_match( '#^/?' . $routePath . '/?$#', $path, $matches ) ){
					$handler = $routeHandler;
					$matched = $matches;
					break;
				}
			}
		}
		if ( $handler ) {
			if ( is_callable( $handler ) ){
				$instanceOfHandler = $handler();
			} else {
				$instanceOfHandler = new $handler();
			}
		}

		if( isset( $instanceOfHandler ) ) {
			if( method_exists( $instanceOfHandler, $method ) ) {
				try {
					call_user_func_array( array( $instanceOfHandler, $method ), $matched );
					if ( !isset( self::$recognized[$path]  ) ) {
						self::$recognized[$path] = $instanceOfHandler;
					}
				} catch ( Exception $e ){
					echo '<pre>';
					print_r($e);
					die();
				} 	
			}
		}
	}

}