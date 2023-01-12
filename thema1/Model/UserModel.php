<?php

declare(strict_types=1);

namespace Model;

class User extends BaseModel
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

    public static function create(User $user): User
    {
        $connection = Database::getConnection();

        // check if email exists already
        $statement = $connection->prepare("SELECT * FROM users WHERE email = :email");
        $statement->execute(['email' => $user->email]);
        $user = $statement->fetch();

        if ($user) {
            throw new \Exception("Email already exists");
        }

        $statement = $connection->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        $statement->execute(['name' => $user->name, 'email' => $user->email, 'password' => $user->password]);

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

    public static function delete(int $id) : void
    {
        $connection = Database::getConnection();

        $statement = $connection->prepare("DELETE FROM users WHERE id = :id");
        $statement->execute(['id' => $id]);
    }

    public static function login(string $email, string $password): User
    {
        $connection = Database::getConnection();

        $statement = $connection->prepare("SELECT * FROM users WHERE email = :email AND password = :password");
        $statement->execute(['email' => $email, 'password' => $password]);
        $result = $statement->fetch();

        if ($result) {
            return new User($result['id'], $result['name'], $result['email'], $result['password']);
                    //TODO: Create session
        } else {
            throw new \Exception("Invalid credentials");
        }
    }

    public static function logout(): void
    {
        //TODO: Destroy session
    }

    public static function register(string $name, string $email, string $password): User
    {
        $connection = Database::getConnection();

        $user = User::create(new User(0, $name, $email, $password));

        //TODO: Create session
        return $user;
    }
}
