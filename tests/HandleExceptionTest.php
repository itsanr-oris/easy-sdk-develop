<?php

namespace Foris\Easy\Sdk\Develop\Tests;

use Foris\Easy\Sdk\Develop\Exceptions\RegistersExceptionHandlers;
use Psr\Log\Test\TestLogger;

/**
 * Class HandleExceptionTest
 */
class HandleExceptionTest extends TestCase
{
    use RegistersExceptionHandlers;

    /**
     * Set up test environment
     */
    protected function setUp()
    {
        parent::setUp();

        $this->app()->singleton('logger', function () {
            return new TestLogger();
        });
    }

    /**
     * Test handle an uncaught exception instance.
     */
    public function testHandleException()
    {
        $exception = new \Exception('Test exception message');
        $this->handleException($exception);

        $logger = $this->app()->get('logger');
        $this->assertCount(1, $logger->records);
        $this->assertEquals('error', $logger->records[0]['level']);
        $this->assertEquals('Test exception message', $logger->records[0]['message']);
        $this->assertEquals(['exception' => $exception], $logger->records[0]['context']);
    }
}
