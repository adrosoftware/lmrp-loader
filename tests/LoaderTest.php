<?php

namespace AdroSoftware\Lmrp\Test;

use AdroSoftware\Lmrp\Loader;
use PHPUnit\Framework\TestCase;

class LoaderTest extends TestCase
{
    public function testInstance()
    {
        $loader = new Loader('./config/routes.*.php');

        $this->assertInstanceOf(Loader::class, $loader);
    }

    public function testLoadingFiles()
    {
        $dir = __DIR__ . DIRECTORY_SEPARATOR;
        $loader = new Loader($dir . 'config/routes.*.php');

        /**
         * Dummy variables.
         */

        $app = new \stdClass();
        $factory = new \stdClass();
        $container = new \stdClass();

        $loader->load($app, $factory, $container);

        $loaded = get_required_files();

        $files = [
            'config/routes.api.php',
            'config/routes.web.php',
        ];

        foreach ($files as $file) {
            $file = $dir . $file;
            $this->assertTrue(in_array($file, $loaded));
        }
    }

    public function testPrefixingFiles()
    {
        $dir = __DIR__ . DIRECTORY_SEPARATOR;
        $loader = new Loader($dir . 'config/prefix/routes.*.php');

        /**
         * Dummy variables.
         */
        $app = $this->getMockBuilder(\Mezzio\Application::class)
            ->disableOriginalConstructor()
            ->getMock();
        $factory = $this->getMockBuilder(\Mezzio\MiddlewareFactory::class)
             ->disableOriginalConstructor()
            ->getMock();
        $container = $this->getMockBuilder(\Psr\Container\ContainerInterface::class)
            ->getMock();

        $loader->prefix($app, $factory, $container);

        $loaded = get_required_files();

        $files = [
            'config/prefix/routes.api.php',
        ];

        foreach ($files as $file) {
            $file = $dir . $file;
            $this->assertTrue(in_array($file, $loaded));
        }
    }
}
