<?php

namespace Foris\Easy\Sdk\Develop\Tests;

use Foris\Easy\Sdk\Develop\ServiceProvider;
use Foris\Easy\Support\Filesystem;

/**
 * Class IdeHelperTest
 */
class IdeHelperTest extends TestCase
{
    /**
     * Test generate metadata file
     *
     * @throws \ReflectionException
     * @throws \Exception
     */
    public function testGenerateMetaFile()
    {
        $file = $this->app()->getRootPath() . '/.phpstorm.meta.php';
        $this->assertFileNotExists($file);

        $this->app()->registerProviders([ServiceProvider::class]);
        $this->app()->artisan()->call('ide-helper:meta');

        $this->assertFileExists($file);
        $this->assertHasSubString("'ide-helper.phpstorm.meta' => \Foris\Easy\Sdk\Develop\Commands\IdeHelper\PhpStormMeta::class", Filesystem::get($file));
    }
}
