<?php

namespace Core;


abstract class Model
{
    protected static $table;

    public static function all() : array
    {
        $db = App::get('db');

        return $db->fetchAll("SELECT * FROM ".static::$table, [], static::class);
    }

    public static function find(mixed $id) : static | null
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
}