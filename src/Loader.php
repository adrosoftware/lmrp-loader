<?php

namespace AdroSoftware\Lmrp;

use Laminas\Stdlib\Glob;

class Loader
{
    /** @var string */
    private $pattern;

    /**
     * @param string $pattern A glob pattern by which to look up config files.
     */
    public function __construct($pattern)
    {
        $this->pattern = $pattern;
    }

    /**
     * @return void
     */
    public function load($app, $factory, $container)
    {
        foreach ($this->glob($this->pattern) as $file) {
            (require_once $file)($app, $factory, $container);
        }
    }

    /**
     * @return void
     */
    public function prefix($app, $factory, $container)
    {
        foreach ($this->glob($this->pattern) as $file) {
            (require_once $file)(
                $app,
                $factory,
                $container,
                new Prefixer(
                    $app,
                    $this->calculatePrefix($file)
                )
            );
        }
    }

    /**
     * Calculate the prefix according to the name of the route file.
     *
     * @param string $file
     * @return string
     */
    private function calculatePrefix(string $file): string
    {
        preg_match('/(.*)routes.(.*).php/', $file, $match);
        return '/' . end($match);
    }

    /**
     * Return a set of filesystem items based on a glob pattern.
     *
     * Uses the zend-stdlib Glob class for cross-platform globbing to
     * ensure results are sorted by brace pattern order _after_
     * sorting by filename.
     *
     * @param string $pattern
     * @return array
     */
    private function glob($pattern)
    {
        return Glob::glob($pattern, Glob::GLOB_BRACE, true);
    }
}
