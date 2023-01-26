<?php

declare(strict_types=1);

namespace Controller\API;

use Model\User;

class UserController implements BaseController
{
    public function index()
    {
        $users = User::all();

        foreach ($users as $user) {
            echo json_encode(['id' => $user->id, 'name' => $user->name, 'email' => $user->email, 'password' => $user->password]);
        }
    }

    public function show($id)
    {
        if (!isset($id)) {
            $id = $_GET['id'];
        }

        $user = User::find($id);

        echo json_encode(['id' => $user->id, 'name' => $user->name, 'email' => $user->email, 'password' => $user->password]);
    }

    public function create($user)
    {
        if(isset($user)) {
            $data = json_decode(file_get_contents('php://input'), true);
            $user = new User($data['id'], $data['name'], $data['email'], $data['password']);
        }

        $user = User::create($user);

        echo json_encode(['id' => $user->id, 'name' => $user->name, 'email' => $user->email, 'password' => $user->password]);
    }

    public function update($user)
    {
        if (isset($user)) {
            $data = json_decode(file_get_contents('php://input'), true);
            $user = new User($data['id'], $data['name'], $data['email'], $data['password']);
        }

        $user = $user->update();

        echo json_encode(['id' => $user->id, 'name' => $user->name, 'email' => $user->email, 'password' => $user->password]);
    }

    public function delete($id)
    {
        if (!isset($id)) {
            $id = $_GET['id'];
        }

        User::delete($id);

        echo json_encode(['deleted' => "$id deleted"]);
    }
}
