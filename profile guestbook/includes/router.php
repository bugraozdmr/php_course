<?php
declare(strict_types=1);
const ALLOWED_METHODS = ['GET', 'POST'];
const INDEX_URI = '';
const INDEX_ROUTE= 'index';

function normalizeUri(string $uri) : string
{
    $uri = strtok($uri, '?');
    $uri = strtolower(trim($uri, '/'));
    return $uri === INDEX_URI ? INDEX_ROUTE : $uri;
}

function getFilePath(string $uri, string $method) : string
{
    return ROUTES_DIR . normalizeUri($uri) . '_' . strtolower($method) . '.php';
}

function notFound() : void
{
    http_response_code(404);
    echo 'Not Found';
    exit;
}

function badRequest(string $message) : void
{
    http_response_code(400);
    echo $message;
    exit;
}

function serverError(string $message) : void
{
    http_response_code(500);
    echo $message;
    exit;
}

function redirect(string $uri) : void
{
    header("Location: $uri");
    exit;
}

function dispatch(string $uri, string $method) : void
{
    // 1) normalize URI : GET /guestbook -> routes/guestbook.php
    $uri = normalizeUri($uri);
    $method = strtoupper($method);
    // 2) GET|POST - return 404 if no route found
    if (!in_array($method, ALLOWED_METHODS)) {
        notFound();
    }
    // 3) file path - PHP file path
    $filePath = getFilePath($uri,$method);
    if (file_exists($filePath)) {
        include $filePath;
        return;
    }
    notFound();
    // 4) require route file
    // 5) Handle the route by including the file
}
