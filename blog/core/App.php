<?php

namespace Core;

class App
{
    protected static $container = [];

    public static function bind(string $key, mixed $value): void
    {
        static::$container[$key] = $value;
    }

    public static function get(string $key): mixed
    {
        if (!array_key_exists($key, static::$container)) {
            throw new \Exception("Error: Key $key not found in container");
        }
        return static::$container[$key];
    }
}