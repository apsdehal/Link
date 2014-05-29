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

class HomeController{
	
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

Link supports numbers, string and alphanumeric wildcards which can be used as `{i} {s} {a}` respectively and of course it can renders regex also. Example will clear away your doubts

```php
$routes = array(
	'/' => 'IndexController',
    '/{i}' => 'IndexController' 
    //Parameter in place of {i} will be passed to IndexController
	'/posts/{a}/{i}/{s}' => 'PostsController'
);

Link::all($routes);
```

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

#Todo

- Middlewares