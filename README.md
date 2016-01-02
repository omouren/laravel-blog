# didcode/laravel-blog


## Description

A Laravel 5 package to add a simple blog to an existing Laravel 5 site.

[Live example](http://didcode.com/blog/)

## Packagist

Packagist name : didcode/laravel-blog


## Installation

Update your composer.json 

```
"require": {
    "didcode/laravel-blog": "dev-master"
}
"autoload": {
    "psr-4": {
        "didcode\\Blog\\": "vendor/didcode/laravel-blog/src"
    }
}
```

Then refresh autoload paths by running  
``` 
composer dump-autoload
``` 

Publish the configuration of the package :

```
php artisan vendor:publish --provider="didcode\Blog\BlogServiceProvider"
```

Run the migrations to create tables for posts, options and categories :
```
php artisan migrate
```

Register the provider in your config/app.php file :

```'
providers' => [
    'didcode\Blog\BlogServiceProvider',
]
```

Customize your views in 
``` 
resources/views/vendor/blog
``` 

You can add/edit posts :
```
/admin/blog/
```

