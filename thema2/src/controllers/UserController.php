<?php

declare(strict_types=1);

namespace Controller\API;

use Model\User;
use Model\UserDto;
use ORM\EM;

class UserController implements BaseController
{
    public function index()
    {
        $users = EM::getEntityManager()->getRepository(User::class)->findAll();

        foreach ($users as $user) {
            echo json_encode(['id' => $user->id, 'name' => $user->name, 'email' => $user->email, 'password' => $user->password]);
        }
    }

    // (int $id)
    public function show()
    {
        $id = $_GET['id'];

        $user = EM::getEntityManager()->getRepository(User::class)->find($id);

        echo json_encode(['id' => $user->id, 'name' => $user->name, 'email' => $user->email, 'password' => $user->password]);
    }

    // (User $user)
    public function create()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $user = new UserDto(0, $data['name'], $data['email'], $data['password']);

        $user = EM::getEntityManager()->getRepository(User::class)->create($user);

        echo json_encode(['id' => $user->id, 'name' => $user->name, 'email' => $user->email, 'password' => $user->password]);
    }

    // (User $user)
    public function update()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $user = new UserDto($data['id'], $data['name'], $data['email'], $data['password']);

        $user = EM::getEntityManager()->getRepository(User::class)->update($user);

        echo json_encode(['id' => $user->id, 'name' => $user->name, 'email' => $user->email, 'password' => $user->password]);
    }

    //  (int $id)
    public function delete()
    {
        $id = $_GET['id'];

        EM::getEntityManager()->getRepository(User::class)->delete($id);

        echo json_encode(['deleted' => "$id deleted"]);
    }
}
