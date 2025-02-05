<?php
declare (strict_types = 1);

use Core\Router;

require_once __DIR__ . '/../bootstrap.php';

// order matters
$router = new Router();

// do not need to use these later in files but dont forget to call functions directly "partial" not like View::partial
require_once __DIR__ . '/../routes.php';
require_once __DIR__ . '/../helpers.php';

$uri = parse_url($_SERVER['REQUEST_URI'])[ 'path' ];
$method = $_SERVER['REQUEST_METHOD'];

echo $router->dispatch($uri, $method);

