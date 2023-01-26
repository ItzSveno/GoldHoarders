<?php

declare(strict_types=1);

namespace Model;

class User implements BaseModel
{

    public function __construct(public int $id, public string $name, public string $email, public string $password)
    {
    }

    public static function all(): array
    {
        $connection = Database::getConnection();

        $statement = $connection->prepare("SELECT * FROM users");
        $statement->execute();
        $result = $statement->fetchAll();

        $users = [];
        foreach ($result as $row) {
            $users[] = new User($row['id'], $row['name'], $row['email'], $row['password']);
        }

        return $users;
    }

    public static function find(int $id): User
    {
        $connection = Database::getConnection();

        $statement = $connection->prepare("SELECT * FROM users WHERE id = :id");
        $statement->execute(['id' => $id]);
        $result = $statement->fetch();

        if (!$result) {
            throw new \Exception("User not found");
        }

        return new User($result['id'], $result['name'], $result['email'], $result['password']);
    }

    public static function create($user): User
    {
        $connection = Database::getConnection();

        // check if email exists already
        $statement = $connection->prepare("SELECT * FROM users WHERE email = :email");
        $statement->execute(['email' => $user->email]);
        $result = $statement->fetch();

        if ($result) {
            throw new \Exception("Email already exists");
        }

        $hashedPass = password_hash($user->password, PASSWORD_ARGON2ID);

        $statement = $connection->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        $statement->execute(['name' => $user->name, 'email' => $user->email, 'password' => $hashedPass]);

        $user->id = $connection->lastInsertId();
        return $user;
    }

    public function update(): User
    {
        $connection = Database::getConnection();

        $statement = $connection->prepare("UPDATE users SET name = :name, email = :email, password = :password WHERE id = :id");
        $statement->execute(['name' => $this->name, 'email' => $this->email, 'password' => $this->password, 'id' => $this->id]);

        return $this;
    }

    public static function delete(int $id): void
    {
        $connection = Database::getConnection();

        $statement = $connection->prepare("DELETE FROM users WHERE id = :id");
        $statement->execute(['id' => $id]);
    }

    public static function login(string $email, string $password): void
    {
        $connection = Database::getConnection();

        $statement = $connection->prepare("SELECT * FROM users WHERE email = :email");
        $statement->execute(['email' => $email]);
        $result = $statement->fetch();

        if ($result && password_verify($password, $result['password'])) {
            $_SESSION['id'] = $result['id'];
        } else {
            throw new \Exception("Invalid credentials");
        }
    }

    public static function logout(): void
    {
        session_destroy();
    }

    public static function register(string $name, string $email, string $password): void
    {
        $user = User::create(new User(0, $name, $email, $password));

        $_SESSION['id'] = $user->id;
    }
}
