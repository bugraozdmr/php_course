<?php
use Core\App;
use App\Models\User;
use App\Models\Comment;
use App\Models\Post;

require_once __DIR__. '/../bootstrap.php';


$users = [
    ['username' => 'Admin User', 'email' => 'admin@example.com', 'password' => password_hash('admin123', PASSWORD_DEFAULT), 'role' => 'admin'],
    ['username' => 'John Doe', 'email' => 'john@example.com', 'password' => password_hash('password123', PASSWORD_DEFAULT), 'role' => 'user'],
    ['username' => 'Jane Smith', 'email' => 'jane@example.com', 'password' => password_hash('password123', PASSWORD_DEFAULT), 'role' => 'user'],
];
$posts = [
    ['user_id' => 1, 'title' => 'Welcome to Our Blog', 'content' => 'This is our first blog post. We hope you enjoy it!'],
    ['user_id' => 2, 'title' => 'PHP Tips and Tricks', 'content' => 'Here are some useful PHP tips and tricks for beginners...'],
    ['user_id' => 3, 'title' => 'Web Development Best Practices', 'content' => 'In this post, we\'ll discuss some web development best practices...'],
];
$comments = [
    ['post_id' => 1, 'user_id' => 2, 'content' => 'Great first post! Looking forward to more.'],
    ['post_id' => 1, 'user_id' => 3, 'content' => 'Welcome to the blogosphere!'],
    ['post_id' => 2, 'user_id' => 1, 'content' => 'These are some really useful tips, thanks!'],
    ['post_id' => 3, 'user_id' => 2, 'content' => 'I\'ve been using these practices and they really help.'],
];

$db = App::get('db');

// clear existing data?
$db->query('SET FOREIGN_KEY_CHECKS=0');
$db->query('TRUNCATE TABLE comments');
$db->query('TRUNCATE TABLE posts');
$db->query('TRUNCATE TABLE users');
$db->query('SET FOREIGN_KEY_CHECKS=1');


foreach ($users as $user)
{
    User::create($user);
}
foreach ($posts as $post)
{
    Post::create($post);
}
foreach ($comments as $comment)
{
    Comment::create($comment);
}

echo "Fixtures loaded successfully";