<?php

namespace App\Models;
use Core\Model;
use Core\App;

class Post extends Model
{
    protected static string $table = 'posts';

    public static function getRecent(?int $limit = null, ?int $page = null, ?string $search = null)
    {
        /**
         * @var \Core\Database $db
         */
        $db = App::get('db');

        $query = "SELECT * FROM " . static::$table;
        $params = [];

        if ($search !== null) {
            $query .= " WHERE title LIKE ? OR content LIKE ?";
            $params[] = "%$search%";
            $params[] = "%$search%";
        }

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
        $params = [];

        if ($search !== null) {
            $query .= " WHERE title LIKE ? OR content LIKE ?";
            $params[] = "%$search%";
            $params[] = "%$search%";
        }

        return (int)$db->query(
            $query,
            $params
        )->fetchColumn();
    }

    public static function incrementViews($id) : void
    {
        $db = App::get('db');
        $db->query(
            "UPDATE posts SET views = views + 1 WHERE id = ?",
            [$id]
        );
    }
}
