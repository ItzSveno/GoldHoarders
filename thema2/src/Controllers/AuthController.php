<?php

declare(strict_types=1);

namespace GoldHoarders\Controllers;

use GoldHoarders\Models\User;
use GoldHoarders\ORM\EM;

class AuthController
{
    // (string $email, string $password)
    public function login()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $email = $data['email'];
        $password = $data['password'];

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
        $data = json_decode(file_get_contents('php://input'), true);

        $name =  $data['name'];
        $email =  $data['email'];
        $password =  $data['password'];

        $user = new User();
        $user->setName($name);
        $user->setEmail($email);
        $user->setPassword(password_hash($password, PASSWORD_ARGON2I));

        EM::getEntityManager()->persist($user);
        EM::getEntityManager()->flush();

        $_SESSION['id'] = $user->getId();
    }
}
