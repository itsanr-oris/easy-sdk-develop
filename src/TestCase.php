<?php

/** @noinspection PhpUndefinedClassInspection */
/** @noinspection PhpIncludeInspection */

namespace Foris\Easy\Sdk\Develop;

use Foris\Demo\Sdk\Application;
use org\bovigo\vfs\vfsStream;
use Symfony\Component\Console\Tester\TesterTrait;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\StreamOutput;

/**
 * Class TestCase
 *
 * @method expectException($class)
 * @method expectExceptionMessage($message)
 * @method setExpectedException($class, $message = "", $code = null)
 * @method assertStringContainsString(string $needle, string $haystack, string $message = '')
 * @method assertStringContainsStringIgnoringCase(string $needle, string $haystack, string $message = '')
 */
class TestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * Application instance.
     *
     * @var Application
     */
    protected $app;

    /**
     * vfsStreamDirectory instance
     *
     * @var \org\bovigo\vfs\vfsStreamDirectory
     */
    protected $vfs;

    /**
     * ConsoleOutput instance.
     *
     * @var ConsoleOutput
     */
    protected $output;

    /**
     * Set up test environment
     */
    protected function setUp()
    {
        parent::setUp();

        $this->initVfs();
        $this->app = new Application();
    }

    /**
     * Gets application instance
     *
     * @return Application
     */
    protected function app()
    {
        return $this->app;
    }

    /**
     * Get vfs instance
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

    /**
     * Initializes the output property.
     *
     * @param array $options
     * @return \Symfony\Component\Console\Output\OutputInterface
     */
    protected function initOutput($options = [])
    {
        $this->output = new StreamOutput(fopen('php://memory', 'w', false));
        if (isset($options['decorated'])) {
            $this->output->setDecorated($options['decorated']);
        }
        if (isset($options['verbosity'])) {
            $this->output->setVerbosity($options['verbosity']);
        }
        return $this->output;
    }

    /**
     * Gets the display returned by the last execution of the command or application.
     *
     * @param bool $normalize
     * @return string The display
     */
    public function getDisplay($normalize = false)
    {
        if (null === $this->output) {
            throw new \RuntimeException('Output not initialized, did you execute the command before requesting the display?');
        }

        rewind($this->output->getStream());

        $display = stream_get_contents($this->output->getStream());

        if ($normalize) {
            $display = str_replace(\PHP_EOL, "\n", $display);
        }

        return $display;
    }

    /**
     * Run an Artisan console command by name.
     *
     * @param       $command
     * @param array $parameters
     * @return int
     *
     * @throws \Exception
     */
    public function call($command, $parameters = [])
    {
        return $this->app()->artisan()->call($command, $parameters, $this->initOutput());
    }

    /**
     * Assert a exception was thrown.
     *
     * @param        $class
     * @param string $message
     */
    protected function assertThrowException($class, $message = '')
    {
        if (method_exists($this, 'setExpectedException')) {
            $this->setExpectedException($class, $message);
            return ;
        } else {
            $this->expectException($class);
            $this->expectExceptionMessage($message);
            return ;
        }
    }

    /**
     * Assert a given string is a sub-string of another string.
     *
     * @param string $needle
     * @param string $haystack
     * @param string $message
     */
    protected function assertHasSubString($needle, $haystack, $message = '')
    {
        if (method_exists($this, 'assertStringContainsString')) {
            $this->assertStringContainsString($needle, $haystack, $message);
            return ;
        }

        $this->assertTrue(mb_strpos($haystack, $needle) !== false);
    }

    /**
     * Assert a given string is a sub-string of another string.
     *
     * @param string $needle
     * @param string $haystack
     * @param string $message
     */
    protected function assertHasSubStringIgnoringCase($needle, $haystack, $message = '')
    {
        if (method_exists($this, 'assertStringContainsStringIgnoringCase')) {
            $this->assertStringContainsStringIgnoringCase($needle, $haystack, $message);
            return ;
        }

        $this->assertTrue(mb_stripos($haystack, $needle) !== false);
    }
}
