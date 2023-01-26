<?php

declare(strict_types=1);

namespace Controller\API;

use Model\User;

class AuthController
{
    // (string $email, string $password)
    public function login()
    {
        $email = $_POST['email'];
        $password = $_POST['password'];

        User::login($email, $password);
    }

    public function logout()
    {
        User::logout();
    }

    // (User $user)
    public function register()
    {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        User::register($name, $email, $password);
    }
}
