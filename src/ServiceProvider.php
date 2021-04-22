<?php

namespace Foris\Easy\Sdk\Develop;

use Foris\Easy\Sdk\Develop\Commands\IdeHelper\PhpStormMeta;
use Foris\Easy\Sdk\Develop\Exceptions\RegistersExceptionHandlers;

/**
 * Class ServiceProvider
 */
class ServiceProvider extends \Foris\Easy\Sdk\ServiceProvider
{
    use RegistersExceptionHandlers;

    /**
     * Register component to application.
     */
    public function register()
    {
        $this->registerErrorHandling();

        $this->app()->singleton('ide-helper.phpstorm.meta', function () {
            return new PhpStormMeta();
        });

        $this->app()->commands(['ide-helper.phpstorm.meta']);
    }
}
