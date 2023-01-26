<?php

declare(strict_types=1);

namespace Controller\API;

use Model\User;

class AuthController
{
    // (string $email, string $password)
    public function login()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $email = $data['email'];
        $password = $data['password'];

        User::login($email, $password);
    }

    public function logout()
    {
        User::logout();
    }

    // (User $user)
    public function register()
    {
        $data = json_decode(file_get_contents('php://input'), true);

        $name =  $data['name'];
        $email =  $data['email'];
        $password =  $data['password'];

        User::register($name, $email, $password);
    }
}
