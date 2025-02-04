<?php
declare(strict_types=1);

require_once __DIR__.'/error_handler.php';

error_reporting(E_ALL);
// ini_set('display_errors', '1');
set_exception_handler('exceptionHandler');
set_error_handler('errorHandler');

const INCLUDES_DIR = __DIR__ . '/includes/';
const ROUTES_DIR = __DIR__ . '/routes/';
const TEMPLATES_DIR = __DIR__ . '/templates/';
const DB_DIR = __DIR__ . '/db/';

require INCLUDES_DIR . 'router.php';
require INCLUDES_DIR . 'view.php';
require INCLUDES_DIR . 'db.php';
require INCLUDES_DIR . 'flash.php';
require INCLUDES_DIR . 'csrf.php';
