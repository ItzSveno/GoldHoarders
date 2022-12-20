<?php declare(strict_types=1);

namespace Controller\API;

use Model\User;

class UserController extends BaseController {
    public function index() {
        $users = User::all();
    }

    public function show($id) {
        $user = User::find($id);
    }

    public function create(User $user) {
        $user = User::create($user);
    }

    public function update(User $user) {
        $user = User::update($user);
    }

    public function delete($id) {
        $deleted = User::delete($id);
    }
}