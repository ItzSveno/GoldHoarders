<?php

declare(strict_types=1);

namespace Controller\API;

use Model\User;

class UserController extends BaseController
{
    public function index()
    {
        $users = User::all();
        //return res
    }

    public function show($id)
    {
        if (!isset($id)) {
            $id = $_GET['id'];
        }

        $user = User::find($id);
        //return res
    }

    public function create(User $user)
    {
        if(isset($user)) {
            $data = json_decode(file_get_contents('php://input'), true);
            $user = new User($data['id'], $data['name'], $data['email'], $data['password']);
        }

        $user = User::create($user);
        //return res
    }

    public function update(User $user)
    {
        if (isset($user)) {
            $data = json_decode(file_get_contents('php://input'), true);
            $user = new User($data['id'], $data['name'], $data['email'], $data['password']);
        }

        $res = $user->update();
        //return res
    }

    public function delete($id)
    {
        if (!isset($id)) {
            $id = $_GET['id'];
        }
        
        User::delete($id);
    }
}
