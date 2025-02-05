<?php

namespace Core;

use PDO;
use PDOException;
use Exception;
use PDOStatement;

class Database
{
    protected PDO $pdo;

    public function __construct(array $config)
    {
        try {
            $this->pdo = new PDO(
                $config['dsn'],
                $config['username'] ?? null,
                $config['password'] ?? null,
                $config['options'] ?? $this->defaultOptions()
            );

            // Bağlantının başarılı olduğunu logla (Opsiyonel)
            if ($config['debug'] ?? false) {
                error_log('Database connection established.');
            }
        } catch (PDOException $e) {
            error_log('Database connection failed: ' . $e->getMessage());

            throw new Exception('Database connection error. Please check the configuration.');
        }
    }

    private function defaultOptions(): array
    {
        return [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
    }

    public function getPdo(): PDO
    {
        return $this->pdo;
    }

    public function query(string $query, array $params = []): PDOStatement
    {
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);

        return $stmt;
    }

    public function fetchAll(string $query, array $params = [], ?string $className = null): array
    {
        $stmt = $this->query($query ,$params);
        return $className ?
            $stmt->fetchAll(PDO::FETCH_CLASS, $className)
            : $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetch(string $query, array $params = [] , ?string $className = null): mixed
    {
        $stmt = $this->query($query, $params);
        $stmt->setFetchMode($className ? PDO::FETCH_CLASS : PDO::FETCH_ASSOC, $className);
        return $stmt->fetch();
    }

    public function lastInsertId(): string|false
    {
        return $this->pdo->lastInsertId();
    }
}