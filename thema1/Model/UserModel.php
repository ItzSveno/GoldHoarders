<?php declare(strict_types=1);
namespace Model;

class User extends BaseModel {

    public function __construct(int $id, string $name, string $email, string $password) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    public static function all() : array {
        return [];
    }

    public static function find(int $id) : User {
        return new User($id, "name", "email", "security");
    }

    public static function create(User $user) : User {
        return $user;
    }

    public static function update(User $user) : User {
        return $user;
    }

    public static function delete(int $id) : bool { // return true if deleted, false if not
        return true;
    }

    public static function login(string $email, string $password) : User {
        return new User(0, "name", "email", "security");
    }

    public static function logout() : bool {
        return true;
    }

    public static function register(string $name, string $email, string $password) : User {
        return new User(0, "name",
        "email", "security");
    }
}