<?php

declare(strict_types=1);

namespace Model;

use DateTime;
use Enums\Type;

class Account implements BaseModel
{

    public function __construct(public int $id, public float $balance, public Type $type, public int $user_id, public ?DateTime $timestamp)
    {
    }

    public static function all(): array
    {
        $connection = Database::getConnection();

        $statement = $connection->prepare("SELECT * FROM accounts");
        $statement->execute();
        $result = $statement->fetchAll();

        $accounts = [];
        foreach ($result as $row) {
            $accounts[] = new Account($row['id'], (float)$row['balance'], Type::fromString(strtoupper($row['type'])), $row['user_id'], new DateTime($row['timestamp']));
        }

        return $accounts;
    }

    public static function allOfUser(int $user_id): array
    {
        $connection = Database::getConnection();

        $statement = $connection->prepare("SELECT * FROM accounts WHERE user_id = :user_id");
        $statement->execute(['user_id' => $user_id]);
        $result = $statement->fetchAll();

        $accounts = [];
        foreach ($result as $row) {
            $accounts[] = new Account($row['id'], (float)$row['balance'], Type::fromString(strtoupper($row['type'])), (int)$row['user_id'], new DateTime($row['timestamp']));
        }

        return $accounts;
    }

    public static function find(int $id): Account
    {
        $connection = Database::getConnection();

        $statement = $connection->prepare("SELECT * FROM accounts WHERE id = :id");
        $statement->execute(['id' => $id]);
        $result = $statement->fetch();

        return new Account($result['id'], (float)$result['balance'], Type::fromString(strtoupper($result['type'])), $result['user_id'], new DateTime($result['timestamp']));
    }

    public static function create($account): Account
    {
        $connection = Database::getConnection();

        $statement = $connection->prepare("INSERT INTO accounts (balance, type, user_id, timestamp) VALUES (:balance, :type, :user_id, :timestamp)");
        $statement->execute([
            'balance' => $account->balance,
            'type' => strtoupper($account->type->toString()),
            'user_id' => $account->user_id,
            'timestamp' => $account->timestamp->format('Y-m-d H:i:s'),
        ]);

        $account->id = (int)$connection->lastInsertId();

        return $account;
    }

    public function update(): Account
    {
        $connection = Database::getConnection();

        $statement = $connection->prepare("UPDATE accounts SET balance = :balance, type = :type, user_id = :user_id, timestamp = :timestamp WHERE id = :id");
        $statement->execute([
            'id' => $this->id,
            'balance' => $this->balance,
            'type' => $this->type->toString(),
            'user_id' => $this->user_id,
            'timestamp' => $this->timestamp->format('Y-m-d H:i:s'),
        ]);

        return $this;
    }

    public static function delete(int $id): void
    {
        $connection = Database::getConnection();

        $statement = $connection->prepare("DELETE FROM accounts WHERE id = :id");
        $statement->execute(['id' => $id]);
    }
}
