<?php

/**
 * @class Main class of the Link router that helps you create and deploy routes
 */	
class Link {

	/**
	 * @var array A collection of the routes originally passed into all function. Used by static function route
	 */	
	private static $routes = array();

	/**
	 * @var array A collection of functions that are executed before a route completion ( valid for all routes ), aka universal before functions
	 */	
	private static $beforeFuncs = array();

	/**
	 * @var array A collection of function that are executed after a route completion ( valid for all routes ), aka universal after functions
	 */	
	private static $afterFuncs = array();

	/**
	 * Static function of the class Link that deploys the route according to the passed handler and path
	 * 
	 * @param array $routes An array of combination of the path and its handler, that are final deployed for a particular url
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
					if( is_array( $routeDesc ) ) {
						$handler = $routeDesc[0];
						if( isset( $routeDesc[2] ))
							$middleware = $routeDesc[2];
					}
					else 
						$handler = $routeDesc;
					$matched = $matches;
					break;
				}
			}
		}
		unset( $matched[0] );

		if( isset($middleware) ){
			$newMatched = self::callFunction( $middleware, $matched );
			/* If new wildcard param are there pass them to main handler */
			if( $newMatched ) 
				self::callFunction( $handler, $newMatched );
			else
				self::callFunction( $handler, $matched );
		} else {
			self::callFunction( $handler, $matched );
		}
	}

	/**
	 * Static function that helps you generate links effortlessly and pass parameters to them, thus enabling to generate dynamic links
	 *
	 * @param string $name name of the route for which the link has to be generated
	 * @param array $params An array of parameters that are replaced in the route if it contains wildcards
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

	/**
	 * Static function to handle cases when route is not found, call handler of 404 if defined else
	 * sends a 404 header
	 */	
	public static function handle404() {
		/* Call '404' route if it exists */
		if( isset ( self::$routes['404'] ) )
			call_user_func( self::$routes['404'] );
		else
			header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found"); 
	}

	/**
	 * Static function to handle both middlewares' call and main handler's call.
	 *
	 * @param array|string $handler Handler that will handle the routes call or middleware
	 * @param array $matched The parameters that we get from the route wildcard
	 * @return array $newParams The parameters return in the case of middleware if you intend to
	 * 							the wildcards that were originally passed, this newParams will 
	 *							be next passed to main handler   
	 */	
	public static function callFunction( $handler , $matched ){
		if ( $handler ) {	
			if ( is_callable( $handler ) ){
				$newParams = call_user_func_array( $handler, $matched ) ;
			} else {
		
				/* Check if class exists in the case user is using RESTful pattern  */
		
				if( class_exists( $handler ) ) {
					$instanceOfHandler = new $handler(); // Won't work in case of middleware since we aren't using RESTful in that
				} else {
					print_r('Class or function ' . $handler . ' not found');
					die();
				}
			}
		} else {
			self::handle404();
		}

		if( isset( $instanceOfHandler ) ) {
			if( method_exists( $instanceOfHandler, $method ) ) {
				try {
					$newParams = call_user_func_array( array( $instanceOfHandler, $method ), $matched );
				} catch ( Exception $exception ){
					$string = str_replace("\n", ' ', var_export($exception, TRUE));
					error_log($string); //Log to error file only if display errors has been declared
					die();
				} 	
			}
		}
		if( $newParams ){
			return $newParams;		
		}
	}
}