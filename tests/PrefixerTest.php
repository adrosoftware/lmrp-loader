<?php

namespace AdroSoftware\Lmrp\Test;

use AdroSoftware\Lmrp\Prefixer;
use Mezzio\Application;
use Mezzio\Router\Route;
use PHPUnit\Framework\TestCase;

class PrefixerTest extends TestCase
{
    public function testInstance()
    {
        /** @var Application */
        $app = $this->getMockBuilder(\Mezzio\Application::class)
            ->disableOriginalConstructor()
            ->getMock();

        $prefixer = new Prefixer($app, '/test');

        $this->assertInstanceOf(Prefixer::class, $prefixer);
    }

    public function testHttpMethods()
    {
        /** @var Application */
        $app = $this->getMockBuilder(\Mezzio\Application::class)
            ->disableOriginalConstructor()
            ->getMock();

        $prefixer = new Prefixer($app, '/test');

        $this->assertInstanceOf(Route::class, $prefixer->get('/', function () {}, 'get'));
        $this->assertInstanceOf(Route::class, $prefixer->post('/', function () {}, 'post'));
        $this->assertInstanceOf(Route::class, $prefixer->put('/', function () {}, 'put'));
        $this->assertInstanceOf(Route::class, $prefixer->patch('/', function () {}, 'patch'));
        $this->assertInstanceOf(Route::class, $prefixer->delete('/', function () {}, 'delete'));
        $this->assertInstanceOf(Route::class, $prefixer->any('/', function () {}, 'any'));
        $this->assertIsArray($prefixer->getRoutes());
    }
}
