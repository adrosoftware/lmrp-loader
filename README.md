# Laminas Mezzio Routes and Pipeline Loader

[![Build status][Master image]][Master]
[![Coverage Status][Master coverage image]][Master coverage]
[![Latest Stable Version][Stable version image]][Stable version]
[![License][License image]][License]

## Purpose

When building a medium to large applications on Laminas Mezzio is better if you can organize your routes. By default *mezzio* define all the routes in the `routes.php` file under the `config` directory. For me is better if you can at least organize the routes by modules of routes prefix. For example `routes.web.php` for all the web routes and `routes.api.php` for all the api routes.

## Usage

```bash
$ composer require adrosoftware/lmrp-loader
```

The `public/index.php` file by default look like this:

```php
<?php

declare(strict_types=1);

// Delegate static file requests back to the PHP built-in webserver
if (PHP_SAPI === 'cli-server' && $_SERVER['SCRIPT_FILENAME'] !== __FILE__) {
    return false;
}

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

/**
 * Self-called anonymous function that creates its own scope and keep the global namespace clean.
 */
(function () {
    /** @var \Psr\Container\ContainerInterface $container */
    $container = require 'config/container.php';

    /** @var \Mezzio\Application $app */
    $app = $container->get(\Mezzio\Application::class);
    $factory = $container->get(\Mezzio\MiddlewareFactory::class);

    // Execute programmatic/declarative middleware pipeline and routing
    // configuration statements
    (require 'config/pipeline.php')($app, $factory, $container);
    (require 'config/routes.php')($app, $factory, $container);

    $app->run();
})();
```

Assuming you have `config/routes.web.php` and `config/routes.api.php` and so on, then replace:

```php
(require 'config/routes.php')($app, $factory, $container);
```

With something like this:

```php
(new \AdroSoftware\Lmrp\Loader('config/routes.*.php'))->load($app, $factory, $container);
```

## Prefixing routes.

Since version 1.1 now you can use the name of the file to prefix the routes inside them. We create and inject a `Prefixer` class that behind the scenes uses the `\Mezzio\Application $app` to generate the routes. 

For example let say you have `routes.web.php` and `routes.api.php`, in your `index.php` you use the `prefix` method instead of the `load` one, like this:

```php
(new \AdroSoftware\Lmrp\Loader('config/routes.*.php'))->prefix($app, $factory, $container);
```

Then in your `routes.web.php` and `routes.api.php` you replace the definition of the anonymous function from 

```php
return static function (Application $app, MiddlewareFactory $factory, ContainerInterface $container): void
```

to 

```php
return static function (Application $app, MiddlewareFactory $factory, ContainerInterface $container, \AdroSoftware\Lmrp\Prefixer $prefixer = null): void 
```

Now you are ready to use the `$prefixer` instead of the `$app` to create the routes:

```php
// `routes.api.php`
return static function (Application $app, MiddlewareFactory $factory, ContainerInterface $container, \AdroSoftware\Lmrp\Prefixer $prefixer = null): void {
    $app->get('/api/', Api\Handler\HomeHandler::class, 'api.home');
    // or
    $prefixer->get('/', Api\Handler\HomeHandler::class, 'api.home');
};
```

As you can see, you can avoid typing `/api` on all the routes. 

> NOTE: If you don't want to prefix your route with `/api` then you can just use `\Mezzio\Application $app` normally.

## Authors:

[Adro Rocker](https://github.com/adrorocker).

  [Master]: https://travis-ci.org/adrosoftware/lmrp-loader/
  [Master image]: https://travis-ci.org/adrosoftware/lmrp-loader.svg?branch=master
  [Master coverage]: https://coveralls.io/github/adrosoftware/lmrp-loader
  [Master coverage image]: https://coveralls.io/repos/github/adrosoftware/lmrp-loader/badge.svg?branch=master
  [Stable version]: https://packagist.org/packages/adrosoftware/lmrp-loader
  [Stable version image]: https://poser.pugx.org/adrosoftware/lmrp-loader/v/stable
  [License]: https://packagist.org/packages/adrosoftware/lmrp-loader
  [License image]: https://poser.pugx.org/adrosoftware/lmrp-loader/license