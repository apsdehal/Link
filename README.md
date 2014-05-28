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

