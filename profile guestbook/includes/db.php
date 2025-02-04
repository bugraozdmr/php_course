<?php

function db_connect(): PDO 
{
    $pdo = new PDO('sqlite:' . DB_DIR . 'db.sqlite');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
}

function loadSchema(PDO $pdo, string $schemaFile): void
{
    $sql = file_get_contents($schemaFile);
    if ($sql === false) 
    {
        die('Error opening schema file: ' . $schemaFile);
    }
    $pdo->exec($sql);
    echo 'Schema loaded successfully' . PHP_EOL;
}

function insertMessage(PDO $pdo,string $name, string $email, string $message) : bool
{
    $sql = 'INSERT INTO messages (name, email, message) VALUES (:name, :email, :message)';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':message', $message);

    return $stmt->execute();
}

function getMessages(PDO $pdo) : array
{
    $sql = 'SELECT * FROM messages ORDER BY created_at DESC';
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}