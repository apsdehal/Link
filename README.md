#Link
A __minimal__ router for your php webapps and APIs that effortlessly links all your project. Its fast and to the point.

#Features
- RESTful routing
- Wildcards for your limitless creativity
- Named routes to help you create links easily
- Self documented, speaks its own legacy
- Tested with PHP >5.3

#Installation

## Composer

For install from composer just add the following line to your project's composer.json file
```json
	"require" : {
    	"apsdehal/Link" : "dev-master"
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

class HomeController{
	
    function get(){
    	echo 'You have got to home :grinning:';
    }
    
    function post(){
    	echo 'You have posted to home';
    }
    
    function put(){
    	echo 'You have put to home';
    }
    
    function delete(){
    	echo 'You have deleted the home :sad:';
    }
}

Link::all( array (
	'/' => ['HomeController', 'HomeRoute']
));
