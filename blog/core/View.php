<?php

namespace Core;

use Exception;

class View
{
    protected static $globals =[];

    public static function share(string $key, mixed $value) : void
    {
        static::$globals[$key] = $value;
    }

    public static function render(string $template, array $data = [], ?string $layout = null): string {
        $data = [...static::$globals, ...$data];
        $content = static::renderTemplate(
            $template,
            $data
        );
        return static::renderLayout($layout, $data, $content);
    }

    public static function partial(string $template, array $data): string
    {
        return static::renderTemplate("/partials/$template", $data);
    }

    protected static function renderTemplate(string $template, array $data): string
    {
        extract($data);
        // root directory is the parent directory of the current directory
        $path = dirname(__DIR__) . "/app/Views/$template.php";
        if (!file_exists($path)) {
            throw new Exception("Error: Template file not found: $path");
        }
        ob_start();
        require $path;
        return ob_get_clean();
    }
    protected static function renderLayout(?string $template, array $data, string $content): string {
        if (null === $template) {
            return $content;
        }
        extract([...$data, 'content' => $content]);
        $path = dirname(__DIR__) . "/app/Views/$template.php";
        if (!file_exists($path)) {
            throw new Exception("Error: Layout file not found: $path");
        }
        ob_start();
        require $path;
        return ob_get_clean();
    }
}