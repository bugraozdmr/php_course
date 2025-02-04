<?php

function exceptionHandler(Throwable $e): void
{
    $message = "Uncaught " . get_class($e) . " with message '{$e->getMessage()}' in {$e->getFile()}:{$e->getLine()}";
    error_log($message);
    
    // dont display errors to the user
    serverError("An unexpected error occurred. Please try again later.");
}

function errorHandler(int $errno, string $errstr, string $errfile, int $errline): bool
{
    $message = "Error [$errno] $errstr in $errfile:$errline";
    error_log($message);
    
    // dont display errors to the user
    serverError("An unexpected error occurred. Please try again later.");

    return true;
}