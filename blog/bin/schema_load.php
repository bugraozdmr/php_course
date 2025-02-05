<?php
require_once __DIR__ . '/../bootstrap.php';
use Core\App;

$db = App::get('db');

$schemaFile = __DIR__ . '/../database/schema.sql';
$sql = file_get_contents($schemaFile);

// no need to try catch we have error handler
$parts = array_filter(
    array_map('trim', explode(';', $sql))
);

foreach ($parts as $part)
{
    $db->query($part);
}

echo 'Schema loaded successfully.\n';