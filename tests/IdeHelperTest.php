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
     * Gets the service providers array.
     *
     * @return array
     */
    protected function providers()
    {
        return array_merge(parent::providers(), [ServiceProvider::class]);
    }

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

        $this->artisan()->call('ide-helper:meta');

        $this->assertFileExists($file);
        $this->assertHasSubString("'ide-helper.phpstorm.meta' => \Foris\Easy\Sdk\Develop\Commands\IdeHelper\PhpStormMeta::class", Filesystem::get($file));
    }
}
