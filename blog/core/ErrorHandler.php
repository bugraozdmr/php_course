<?php

namespace Core;

class ErrorHandler
{
    public static function handleException(\Throwable $exception)
    {
        // Log the error
        static::logError($exception);

        if(php_sapi_name() == 'cli') {
            static::renderCliError($exception);
        } else {
            static::renderErrorPage($exception);
        }
    }

    public static function handleError($level, $message, $file, $line)
    {
        $exception = new \ErrorException($message, 0, $level, $file, $line);
    }

    private static function formatErrorMessage(\Throwable $exception,string $format) : string
    {
        return sprintf(
            $format, 
            date('Y-m-d H:i:s'),
            get_class($exception),
            $exception->getMessage(), 
            $exception->getFile(), 
            $exception->getLine());
    }

    private static function renderCliError(\Throwable $exception)
    {
        $isDebug = App::get('config')['app']['debug'] ?? false;

        if ($isDebug) 
        {
            $errorMessage = static::formatErrorMessage(
                $exception,
                 "\033[31m[%s] Error:\033[0m %s: %s in %s:%d\n"
            );
            $trace = $exception->getTraceAsString();
        }
        else 
        {
            $errorMessage = static::formatErrorMessage(
                $exception,
                "\033An unexpected array occured. Please check error log for details.\033\n"
            );
            $trace = '';
        }

        fwrite(STDERR, $errorMessage);
        if ($trace) {
            fwrite(STDERR, "\nStack trace:\n" . $trace);
        }

        exit(1);
    }

    private static function logError(\Throwable $exception) : void
    {
        $logMessage = static::formatErrorMessage(
            $exception,
            "[%s] Error: %s: %s in %s:%d\n"
        );

        error_log($logMessage, 3, __DIR__ . '/../logs/error.log');
    }

    private static function renderErrorPage(\Throwable $exception)
    {
        $isDebug = App::get('config')['app']['debug'] ?? false;

        if ($isDebug) 
        {
            $errorMessage = static::formatErrorMessage(
                $exception,
                 "[%s] Error: %s: %s in %s:%d\n"
            );
            $trace = $exception->getTraceAsString();
        }
        else 
        {
            $errorMessage = static::formatErrorMessage(
                $exception,
                "An unexpected array occured. Please check error log for details.\n"
            );
            $trace = '';
        }

        http_response_code(500);
        echo View::render('errors/500', [
            'errorMessage' => $errorMessage,
            'trace' => $trace,
            'isDebug' => $isDebug
        ], 'layouts/main');

        exit();
    }
}