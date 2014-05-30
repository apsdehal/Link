<?php

/**
 * @class Main class of the Link router that helps you create and deploy routes
 */	
class Link {

	/**
	 * @var A collection of the routes originally passed into all function. Used by static function route
	 */	
	private static $routes = array();

	/**
	 * Static function of the class Link that deploys the route according to the passed handler and path
	 * 
	 * @param $routes array An array of conbination of the path and its handler, that are final deployed for a particular url
	 */	
	public static function all( $routes ) {
		self::$routes = $routes;
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
			if( is_array( $routes[$path] ) )
				$handler = $routes[$path][0];
			else
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

			foreach ( $routes as $routePath => $routeDesc ){
				$routePath = preg_replace( $regex, $replacements, $routePath );
				if( preg_match( '#^/?' . $routePath . '/?$#', $path, $matches ) ){
					if( is_array( $routeDesc ) )
						$handler = $routeDesc[0];
					else 
						$handler = $routeDesc;
					$matched = $matches;
					break;
				}
			}
		}
		if ( $handler ) {
			unset( $matched[0] );
			if ( is_callable( $handler ) ){
				call_user_func_array( $handler, $matched ) ;
			} else {
				if( class_exists( $handler ) ) {
					$instanceOfHandler = new $handler();
				} else {
					echo 'Class or function ' . $handler . ' not found';
					die();
				}
			}
		}

		if( isset( $instanceOfHandler ) ) {
			if( method_exists( $instanceOfHandler, $method ) ) {
				try {
					call_user_func_array( array( $instanceOfHandler, $method ), $matched );
				} catch ( Exception $e ){
					error_log($e);
					print_r($e);
					die();
				} 	
			}
		}
	}

	/**
	 * Static function that helps you generate links effortlesly and pass parameters to them, thus enabling to generate dynamic links
	 *
	 * @param $name string name of the route for which the link has to be generated
	 * @param $params array An array of parameters that are replaced in the route if it contains wildcards
	 *						For e.g. if route is /name/{i}/{a} and parameters passed are 1, aps then link generated will be /name/1/aps  
	 */	
	public static function route( $name, $params = array() ){
		$href = null;
		foreach ( self::$routes as $routePath => $routeDesc ) {
			if( is_array( $routeDesc ) ){
				if( $name == $routeDesc[1] ){
					$href = $routePath;
					for( $i = 0; $i < count($params); $i++){
						$href = preg_replace('#{(.*?)}#', $params[$i], $href, 1);
					}
				}

			}
		}
		return $href;
	}
}