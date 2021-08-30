<?php

use Mezzio\Application;
use Mezzio\MiddlewareFactory;
use AdroSoftware\Lmrp\Prefixer;
use Psr\Container\ContainerInterface;

return function (Application $app, MiddlewareFactory $factory, ContainerInterface $container, Prefixer $prefixer = null) {
    $prefixer->get('/', function () {}, 'test');
};
