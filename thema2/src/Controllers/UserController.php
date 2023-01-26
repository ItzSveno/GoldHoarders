<?php

declare(strict_types=1);

namespace GoldHoarders\Controllers;

use GoldHoarders\Models\User;
use GoldHoarders\ORM\EM;

class UserController implements BaseController
{
    public function index()
    {
        $users = EM::getEntityManager()->getRepository(User::class)->findAll();

        foreach ($users as $user) {
            echo json_encode(['id' => $user->getId(), 'name' => $user->getName(), 'email' => $user->getEmail(), 'password' => $user->getPassword()]);
        }
    }

    // (int $id)
    public function show()
    {
        $id = (int)$_GET['id'];

        $user = EM::getEntityManager()->getRepository(User::class)->find($id);

        echo json_encode(['id' => $user->getId(), 'name' => $user->getName(), 'email' => $user->getEmail(), 'password' => $user->getPassword()]);
    }

    // (User $user)
    public function create()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $user = new User();
        $user->setName($data['name']);
        $user->setEmail($data['email']);
        $user->setPassword($data['password']);

        EM::getEntityManager()->persist($user);
        EM::getEntityManager()->flush();

        echo json_encode(['id' => $user->getId(), 'name' => $user->getName(), 'email' => $user->getEmail(), 'password' => $user->getPassword()]);
    }

    // (User $user)
    public function update()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $user = new User();
        $user->setId((int)$data['id']);
        $user->setName($data['name']);
        $user->setEmail($data['email']);
        $user->setPassword($data['password']);

        $entity = EM::getEntityManager()->getRepository(User::class)->find($user->getId());
        $entity->setName($user->getName());
        $entity->setEmail($user->getEmail());
        $entity->setPassword($user->getPassword());
        
        EM::getEntityManager()->flush();

        echo json_encode(['id' => $user->getId(), 'name' => $user->getName(), 'email' => $user->getEmail(), 'password' => $user->getPassword()]);
    }

    //  (int $id)
    public function delete()
    {
        $id = (int)$_GET['id'];

        EM::getEntityManager()->remove($id);
        EM::getEntityManager()->flush();

        echo json_encode(['deleted' => "$id deleted"]);
    }

}
