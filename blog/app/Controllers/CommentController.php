<?php
namespace App\Controllers;

use App\Models\Comment;
use App\Services\CSRF;
use Core\Router;
use App\Services\Auth;

class CommentController
{
    public static function store($id)
    {
        

        $content = htmlspecialchars(trim($_POST['content'] ?? ''), ENT_QUOTES, 'UTF-8');

        if (!$content) {
            die("Comment content cannot be empty.");
        }

        Comment::create([
            'post_id' => $id,
            'user_id' => Auth::user()->id,
            'content' => $content
        ]);

        return Router::redirect("/posts/{$id}#comments");
    }
}