<?php

namespace Foris\Easy\Sdk\Develop;

use Foris\Easy\Sdk\Develop\Commands\IdeHelper\PhpStormMeta;

/**
 * Class ServiceProvider
 */
class ServiceProvider extends \Foris\Easy\Sdk\ServiceProvider
{

    /**
     * Register component to application.
     */
    public function register()
    {
        $this->app()->singleton('ide-helper.phpstorm.meta', function () {
            return new PhpStormMeta();
        });

        $this->app()->commands(['ide-helper.phpstorm.meta']);
    }
}
