<?php

namespace Foris\Easy\Sdk\Develop\Commands\IdeHelper;

use Foris\Easy\Console\Commands\Command;
use Foris\Easy\Sdk\Console\Traits\HasSdkApplication;
use Foris\Easy\Support\Filesystem;

/**
 * Class IdeHelper
 */
class PhpStormMeta extends Command
{
    use HasSdkApplication;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'ide-helper:meta';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate metadata for PhpStorm.';

    /**
     * The console command help message.
     *
     * @var string
     */
    protected $help = '';

    /**
     * Gets the phpstorm mate file.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . "/Stubs/.phpstorm.meta.stub";
    }

    /**
     * Execute the console command.
     *
     * @throws \ReflectionException
     * @throws \Foris\Easy\Support\Exceptions\FileNotFountException
     */
    protected function handle()
    {
        $map = "";
        foreach ($this->app()->keys() as $id) {
            $map .= "\n\t\t'" . $id . "' => \\" . get_class($this->app()->get($id)) . "::class,";
        }

        $file = str_replace("'dummy_service'", $map, Filesystem::get($this->getStub()));
        Filesystem::put($this->app()->getRootPath() . '/.phpstorm.meta.php', $file);

        $this->info('A new meta file was written to .phpstorm.meta.php');
    }
}

