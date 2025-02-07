<?php

namespace Core;


abstract class Model
{
    protected static string $table;

    public $id;

    public static function all() : array
    {
        $db = App::get('db');

        return $db->fetchAll("SELECT * FROM ".static::$table, [], static::class);
    }

    public static function find(mixed $id) : ?static
    {
        $db = App::get('db');
        return $db->fetch("SELECT * FROM " .static::$table . " WHERE id = ?", [$id],
            static::class);
    }

    public static function create(array $data) : static
    {
        $db = App::get('db');

        // get the table names of columns inside $data
        $columns = implode(', ', array_keys($data));

        // create an array of ? with the same length of $data
        $values = implode(', ', array_fill(0, count($data), '?'));

        // create the query
        $table = static::$table;
        $query = "INSERT INTO $table ($columns) VALUES ($values)";

        // 
        $db->query($query, array_values($data));

        return static::find($db->lastInsertId());
    }

    protected static function createFromArray(array $data) : static
    {
        $model = new static;
        foreach ($data as $key => $value) {
            if(property_exists($model, $key)) {
                $model->$key = $value;
            }
        }
        return $model;
    }

    public function save() : static
    {
        $db = App::get('db');
        $data = get_object_vars($this);

        if(!isset($this->id))
        {
            unset($data['id']);
            return static::create($data);
        }

        unset($data['id']);
        $setParts = array_map(fn($column) => "$column = ?", array_keys($data));
        $sql = "UPDATE "
        . static::$table 
        . " SET " 
        . implode(', ', $setParts) 
        . " WHERE id = ?";
        $params = array_values($data);
        $params[] = $this->id;
        $db->query($sql, $params);

        return $this;
    }

    public function delete()
    {
        if(!isset($this->id))
        {
            return;
        }

        $db = App::get('db');
        // the table which has called this method
        $sql = "DELETE FROM " . static::$table . " WHERE id = ?";
        $db->query($sql, [$this->id]);
    }

    public static function getRecent(?int $limit = null, ?int $page = null)
    {
        /**
         * @var \Core\Database $db
         */
        $db = App::get('db');

        $query = "SELECT * FROM " . static::$table;
        $params = [];

        $query .= " ORDER BY created_at DESC";

        if ($limit !== null) {
            $query .= " LIMIT " . intval($limit); // PDO'da `LIMIT ?` çalışmaz
        }

        if($page !== null && $limit !== null)
        {
            $offset = ($page - 1) * $limit;
            $query .= " OFFSET ?";
            $params[] = $offset;
        }

        return $db->fetchAll(
            $query,
            $params, // Burada sadece `$params` geçiyoruz
            static::class
        );
    }

    public static function count(?string $search = null) : int
    {
        /**
         * @var \Core\Database $db
         */
        $db = App::get('db');

        $query = "SELECT COUNT(*) FROM " . static::$table;


        return (int)$db->query(
            $query,
            []
        )->fetchColumn();
    }
}