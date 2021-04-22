<?php

namespace Foris\Easy\Sdk\Develop\Exceptions;

use ErrorException;
use Psr\Log\LoggerInterface;
use Symfony\Component\Debug\Exception\FatalErrorException;

/**
 * Trait RegistersExceptionHandlers
 */
trait RegistersExceptionHandlers
{
    /**
     * Gets the sdk application instance
     *
     * @return \Foris\Easy\Sdk\Application
     */
    abstract function app();

    /**
     * Set the error handling for the application.
     *
     * @return void
     */
    protected function registerErrorHandling()
    {
        error_reporting(-1);

        set_error_handler(function ($level, $message, $file = '', $line = 0) {
            if (error_reporting() & $level) {
                throw new ErrorException($message, 0, $level, $file, $line);
            }
        });

        set_exception_handler(function ($e) {
            $this->handleException($e);
        });

        register_shutdown_function(function () {
            $this->handleShutdown();
        });
    }

    /**
     * Handle an uncaught exception instance.
     *
     * @param  \Throwable  $e
     * @return void
     */
    public function handleException($e)
    {
        $logger = $this->app()->get('logger');

        if ($logger instanceof LoggerInterface) {
            $logger->error($e->getMessage(), ['exception' => $e]);
        }
    }

    /**
     * Handle the PHP shutdown event.
     *
     * @return void
     */
    public function handleShutdown()
    {
        if (!is_null($error = error_get_last()) && $this->isFatal($error['type'])) {
            $this->handleException($this->fatalExceptionFromError($error, 0));
        }
    }

    /**
     * Create a new fatal exception instance from an error array.
     *
     * @param  array  $error
     * @param  int|null  $traceOffset
     * @return \Symfony\Component\Debug\Exception\FatalErrorException
     */
    protected function fatalExceptionFromError(array $error, $traceOffset = null)
    {
        return new FatalErrorException(
            $error['message'], $error['type'], 0, $error['file'], $error['line'], $traceOffset
        );
    }

    /**
     * Determine if the error type is fatal.
     *
     * @param  int  $type
     * @return bool
     */
    protected function isFatal($type)
    {
        return in_array($type, [E_COMPILE_ERROR, E_CORE_ERROR, E_ERROR, E_PARSE]);
    }
}
