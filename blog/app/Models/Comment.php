<?php

namespace App\Models;

use Core\Model;
use Core\App;

class Comment extends Model
{
    protected static string $table = 'comments';

    public static function forPost($postId) : array
    {
        /**
         * @var \Core\Database $db
         */
        $db = App::get('db');
        return $db->fetchAll(
            "SELECT * FROM comments WHERE post_id = ? ORDER BY created_at DESC",
            [$postId],
            static::class
        );
    }

    
}