#Link
A __minimal__ router for your php webapps and APIs that effortlessly links all your project. Its fast and to the point.

#Features
- RESTful routing
- Wildcards for your limitless creativity
- Named routes to help you create links easily
- Self documented, speaks its own legacy
- Before and after routes function support
- Tested with PHP >5.3

##HHVM Version

HHVM version of Link can be found at https://github.com/bmbsqd/Link-Hack . Thanks to [Andy Hawkins](https://github.com/a904guy) for creating it.


#Installation

## Composer

For install from composer just add the following line to your project's composer.json file
```json
	"require" : {
    	"link/link" : "dev-master"
    }
```

Then run `php composer.phar install`

## Manually

Run `git clone https://github.com/apsdehal/Link.git` in your project's home directory and include it using

```php
	require("Link/src/Link.php");
```

#Basics

##Simple Routing

Routing is too simple with Link, following example supports it:

```php
<?php

function routeMe(){
	echo 'I am routed';
}

Link::all( array(
	'/' => 'routeMe'
));
```

##Named Routing

In Link routes can be named and then further used generatings links in a simple and elegant way.

```php

<?php

function nameMe(){
	echo 'I am named';
}

Link::all( array(
	'/named' => ['nameMe', 'Its my name']
));
```

Names to routes must be given as second argument in array while the first being the route handler.

###Usage

These named routes can be used in creating in hassle free links.

```html
	<a href="<?php echo Link::route('Its my name') ?>">Go to named route</a>
```

##Routing with classes

Link can handle classes as Route handler easily, but remember non-static class will be handled RESTfully.

```php

<?php

$routes = array(
	'/' => 'IndexController::getMeHome', //Static function
    '/home' => 'HomeController', //RESTful class
    '/office' => 'OfficeController'
);

Link::all($routes)
```

##RESTful routing

RESTful routing is a breeze for Link.

```php

<?php

class HomeController
{
	
    function get(){
    	echo 'You have got to home :)';
    }
    
    function post(){
    	echo 'You have posted to home';
    }
    
    function put(){
    	echo 'You have put to home';
    }
    
    function delete(){
    	echo 'You have deleted the home :(';
    }
}

Link::all( array (
	'/' => ['HomeController', 'HomeRoute']
));
```
##WildCards

Link supports numbers, string and alphanumeric wildcards which can be used as `{i} {s} {a}` respectively and of course it can render regex also. Example will clear away your doubts

```php
$routes = array(
	'/' => 'IndexController',
    '/{i}' => 'IndexController',
    //Parameter in place of {i} will be passed to IndexController
	'/posts/{a}/{i}/{s}' => 'PostsController'
);

Link::all($routes);
```
##Supplimentary Handlers

###Universal Extra Handlers

Through Link, universal before and after handlers can be added, such that these are executed always before any route is routed. This can be done as follows:

```php
<?php
function universalBeforeHandler( $id ) {
    echo 'Hello I occured before with ' . $id . '\n';
}

function universalAfterHandler( $id ) {
    if( $id )
        echo 'Hello I occured after with ' . $id;
    else
        echo 'I simply occured after';
}

function main(){
    echo 'I simply occured\n'
}

Link::before( 'universalBeforeHandler', ['12'] ); //If you want to pass parameters to them, pass them as arrays
Link::before( 'universalBeforeHandler'); //else don't even pass them

Link::all( array(
    '/' => 'main'
    ))
```

Now go to '/' in your browser to find:

Hello I occured before with 12

I simply occured

I simply occured after.

###Single Route

You can add a before (middle) handler to a specific route, just pass the before handler to routes array as third parameters. The wildcards extracted from route will be passed to to before handler and if it return some array, this array will be passed further to main handler but if not the original extracted wildcards would be passed away. Make sure you return an array from before handler.

```php
<?php 
function beforeHandler( $name ) {
    return [ $name . ' Link' ];
}

function mainHandler( $name ){
    echo $name;
}

Link::all(array(
    '/{s}' => ['mainHandler', 'Main', 'beforHandler']
    ));
``` 

Go to '/aps' in browser, you will get *aps Link*.

##Passing Parameters to Named Routes

You can pass parameters to named routes if the have wildcards in the route path, this will thus generate dynamic links through a single named route.

```php

<?php

function nameMe( $i, $s ){
	echo 'I am named and I have been passed ' . $i . $s ;
}

Link::all( array(
	'/named/{i}/{s}' => ['nameMe', 'Its my name']
));
```

Now generate a link through Link

```php

echo Link::route( 'Its my name', array(1, 'Me') );
```

This in turn will generate `YOUR_DOMAIN/named/1/Me`.

## 404 Errors

You should probably add a 404 handler to your routes array, rest Link will take care of handling routes that are not found. In case, Link doesn't find a 404 route defined, it will just send a 404 header.

# Server Configuration

## Apache

You should add the following code snippet in your Apache HTTP server VHost configuration or **.htaccess** file.

```apacheconf
<IfModule mod_rewrite.c>
    RewriteEngine on
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond $1 !^(index\.php)
    RewriteRule ^(.*)$ index.php/$1 [L]
</IfModule>
```

Alternatively, in a version of Apache greater than 2.2.15, then you can use this:
```apacheconf
FallbackResource /index.php
```

#Notes

If you are planning to use non-Restful method and non-static classes, then use them as follows:

```php
class HelloHandler 
{
    public function home(){
        echo 'Hello home';
    }
}

$helloObject = new HelloHandler();

Link::all( array(
    '/' => array( $helloObejct, 'home' )
    ))
```

So you need to pass such functions as `array( $object, 'functionName' )`

#Contributions

Thanks to all people below for contributing to Link.

- @jedmiry
- @pborelli

#License

Link is available under MIT license, so feel free to contribute and modify it as you like. Free software, Yeah!
