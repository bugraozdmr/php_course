<?php

namespace App\Models;
use Core\App;
use Core\Model;

class User extends Model
{
    // necessary for Auth.php or it wont see params
    public $id;
    public $name;
    public $email;
    public $password;
    public $role;
    public $created_at;

    protected static $table = 'users';

    public static function findByEmail(string $email) : ?User
    {
        $db = App::get('db');
        $result = $db->fetch('SELECT * FROM users WHERE email = ?',
                [$email],
                static::class);

        return $result ? $result : null;
    }
}