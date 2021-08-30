<?php

namespace AdroSoftware\Lmrp;

use Mezzio\Application;
use Mezzio\Router;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class Prefixer
{
    /** @var Application */
    private $app;

    /** @var string */
    private $prefix;

    public function __construct(Application $app, string $prefix = '')
    {
        $this->app = $app;
        $this->prefix = $prefix;
    }

    /**
     * @param string|array|callable|MiddlewareInterface|RequestHandlerInterface $middleware
     *     Middleware or request handler (or service name resolving to one of
     *     those types) to associate with route.
     * @param null|string $name The name of the route.
     */
    public function get(string $path, $middleware, string $name = null) : Router\Route
    {
        return $this->app->get($this->prefix.$path, $middleware, $name);
    }

    /**
     * @param string|array|callable|MiddlewareInterface|RequestHandlerInterface $middleware
     *     Middleware or request handler (or service name resolving to one of
     *     those types) to associate with route.
     * @param null|string $name The name of the route.
     */
    public function post(string $path, $middleware, $name = null) : Router\Route
    {
        return $this->app->post($this->prefix.$path, $middleware, $name);
    }

    /**
     * @param string|array|callable|MiddlewareInterface|RequestHandlerInterface $middleware
     *     Middleware or request handler (or service name resolving to one of
     *     those types) to associate with route.
     * @param null|string $name The name of the route.
     */
    public function put(string $path, $middleware, string $name = null) : Router\Route
    {
        return $this->app->put($this->prefix.$path, $middleware, $name);
    }

    /**
     * @param string|array|callable|MiddlewareInterface|RequestHandlerInterface $middleware
     *     Middleware or request handler (or service name resolving to one of
     *     those types) to associate with route.
     * @param null|string $name The name of the route.
     */
    public function patch(string $path, $middleware, string $name = null) : Router\Route
    {
        return $this->app->patch($this->prefix.$path, $middleware, $name);
    }

    /**
     * @param string|array|callable|MiddlewareInterface|RequestHandlerInterface $middleware
     *     Middleware or request handler (or service name resolving to one of
     *     those types) to associate with route.
     * @param null|string $name The name of the route.
     */
    public function delete(string $path, $middleware, string $name = null) : Router\Route
    {
        return $this->app->delete($this->prefix.$path, $middleware, $name);
    }

    /**
     * @param string|array|callable|MiddlewareInterface|RequestHandlerInterface $middleware
     *     Middleware or request handler (or service name resolving to one of
     *     those types) to associate with route.
     * @param null|string $name The name of the route.
     */
    public function any(string $path, $middleware, string $name = null) : Router\Route
    {
        return $this->app->any($this->prefix.$path, $middleware, $name);
    }

    /**
     * Retrieve all directly registered routes with the application.
     *
     * @return Router\Route[]
     */
    public function getRoutes() : array
    {
        return $this->app->getRoutes();
    }
}
