<?php

declare(strict_types=1);

namespace Controller\API;

use Model\User;
use Model\UserDto;
use ORM\EM;

class AuthController
{
    // (string $email, string $password)
    public function login()
    {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $result = EM::getEntityManager()->getRepository(User::class)->findOneBy(['email' => $email]);

        if ($result && password_verify($password, $result['password'])) {
            $_SESSION['id'] = $result['id'];
        } else {
            throw new \Exception("Invalid credentials");
        }

    }

    public function logout()
    {
        session_destroy();
    }

    // (User $user)
    public function register()
    {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        $user = EM::getEntityManager()->getRepository(User::class)->findOneBy(['email' => $email]);

        if ($user) {
            throw new \Exception("Email already exists");
        }

        $hashedPass = password_hash($password, PASSWORD_ARGON2ID);

        $user = new UserDto(0, $name, $email, $hashedPass);
        EM::getEntityManager()->persist($user);
        EM::getEntityManager()->flush();

        $_SESSION['id'] = $user->id;
    }
}
