<?php

declare(strict_types=1);

namespace Controller\API;

use Model\User;

class AuthController
{
    public function login($email, $password)
    {
        if (!isset($email) || !isset($password)) {
            $email = $_POST['email'];
            $password = $_POST['password'];
        }

        User::login($email, $password);
    }

    public function logout()
    {
        User::logout();
    }

    public function register($user)
    {
        if (!isset($user)) {
            $user->name = $_POST['name'];
            $user->email = $_POST['email'];
            $user->password = $_POST['password'];
        }

        User::register($user->name, $user->email, $user->password);
    }
}
