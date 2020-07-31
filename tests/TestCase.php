<?php

namespace Foris\Easy\Sdk\Develop\Tests;

/**
 * Class TestCase
 */
class TestCase extends \Foris\Easy\Sdk\Develop\TestCase
{
    /**
     * Test get demo application instance.
     */
    public function testGetDemoApplicationInstance()
    {
        $this->assertInstanceOf('Foris\Demo\Sdk\Application', $this->app());
    }
}
