<?php

namespace App\Controllers;

use App\Services\Auth;
use App\Services\CSRF;
use Core\Router;
use Core\View;

class AuthController
{
    public function create()
    {
        return View::render(
            template: 'auth/create',
            layout: 'layouts/main'
        );
    }

    public function store()
    {
        if(!CSRF::verify())
        {
            Router::pageExpired();
        }

        $email = $_POST['email'];
        $password = $_POST['password'];
        $remember = isset($_POST['remember']) ? (bool)$_POST['remember'] : false;

        // attempt authentication
        if(Auth::attempt($email, $password, $remember))
        {
            Router::redirect('/');
        }

        return View::render(            
            template: 'auth/create',
            layout: 'layouts/main',
            data: [
                'error' => 'Invalid credentials'
            ]
        );
    }

    public function destroy(): void
    {
        Auth::logout();
        Router::redirect('/login');
    }
}