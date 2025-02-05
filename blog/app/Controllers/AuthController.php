<?php

namespace App\Controllers;

use App\Services\Auth;
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
        //TODO: CSRF token

        $email = $_POST['email'];
        $password = $_POST['password'];

        // attempt authentication
        if(Auth::attempt($email, $password))
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
}