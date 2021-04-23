<?php /** @noinspection PhpUndefinedClassInspection */
/** @noinspection PhpIncludeInspection */

namespace Foris\Easy\Sdk\Develop;

use Foris\Demo\Sdk\Application;
use Foris\Demo\Sdk\Console\Application as Artisan;
use org\bovigo\vfs\vfsStream;

/**
 * Class TestCase
 */
class TestCase extends \Foris\Easy\Sdk\Test\TestCase
{
    /**
     * vfsStreamDirectory instance
     *
     * @var \org\bovigo\vfs\vfsStreamDirectory
     */
    protected $vfs;

    /**
     * Set up test environment
     */
    protected function setUp()
    {
        $this->initVfs();
        parent::setUp();
    }

    /**
     * Gets the service providers array.
     *
     * @return array
     */
    protected function providers()
    {
        return [];
    }

    /**
     * Create sdk application instance.
     *
     * @return Application|\Foris\Easy\Sdk\Application
     */
    protected function createApplication()
    {
        $app = new Application();
        $app->registerProviders($this->providers());
        return $app;
    }


    /**
     * Create artisan command application instance.
     *
     * @return \Foris\Demo\Sdk\Console\Application|\Foris\Easy\Sdk\Console\Application
     * @throws \ReflectionException
     */
    protected function createArtisan()
    {
        return new Artisan($this->app());
    }

    /**
     * Gets vfs instance
     *
     * @return \org\bovigo\vfs\vfsStreamDirectory
     */
    protected function vfs()
    {
        return $this->vfs;
    }

    /**
     * Init vfs instance
     *
     * @return \org\bovigo\vfs\vfsStreamDirectory
     */
    protected function initVfs()
    {
        if (empty($this->vfs)) {
            $base = vfsStream::setup('demo-sdk');
            $this->vfs = vfsStream::copyFromFileSystem(__DIR__ . '/../demo', $base);
            require_once $this->vfs->url() . '/vendor/autoload.php';
        }

        return $this->vfs;
    }
}
