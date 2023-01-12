<?php

declare(strict_types=1);

namespace Model;

use DateTime;

class Transaction extends BaseModel
{
    public function __construct(public int $id, public int $from_account_id, public int $to_account_id, public float $amount, public DateTime $timestamp)
    {
    }

    public static function all(): array
    {
        $connection = Database::getConnection();

        $statement = $connection->prepare("SELECT * FROM transactions");
        $statement->execute();
        $result = $statement->fetchAll();

        $transactions = [];
        foreach ($result as $row) {
            $transactions[] = new Transaction($row['id'], $row['from_account_id'], $row['to_account_id'], $row['amount'], new DateTime($row['timestamp']));
        }

        return $transactions;
    }

    public static function allOfSender(int $sender_id): array
    {
        $connection = Database::getConnection();

        $statement = $connection->prepare("SELECT * FROM transactions WHERE from_account_id = :from_account_id");
        $statement->execute(['from_account_id' => $sender_id]);
        $result = $statement->fetchAll();

        $transactions = [];
        foreach ($result as $row) {
            $transactions[] = new Transaction($row['id'], $row['from_account_id'], $row['to_account_id'], $row['amount'], new DateTime($row['timestamp']));
        }

        return $transactions;
    }

    public static function allOfReceiver(int $receiver_id): array
    {
        $connection = Database::getConnection();

        $statement = $connection->prepare("SELECT * FROM transactions WHERE to_account_id = :to_account_id");
        $statement->execute(['to_account_id' => $receiver_id]);
        $result = $statement->fetchAll();

        $transactions = [];
        foreach ($result as $row) {
            $transactions[] = new Transaction($row['id'], $row['from_account_id'], $row['to_account_id'], $row['amount'], new DateTime($row['timestamp']));
        }

        return $transactions;
    }

    public static function find(int $id): Transaction
    {
        $connection = Database::getConnection();

        $statement = $connection->prepare("SELECT * FROM transactions WHERE id = :id");
        $statement->execute(['id' => $id]);
        $result = $statement->fetch();

        return new Transaction($result['id'], $result['from_account_id'], $result['to_account_id'], $result['amount'], new DateTime($result['timestamp']));
    }

    public static function create(Transaction $transaction): Transaction
    {
        $connection = Database::getConnection();

        $statement = $connection->prepare("INSERT INTO transactions (from_account_id, to_account_id, amount, timestamp) VALUES (:from_account_id, :to_account_id, :amount, :timestamp)");
        $statement->execute(['from_account_id' => $transaction->from_account_id, 'to_account_id' => $transaction->to_account_id, 'amount' => $transaction->amount, 'timestamp' => $transaction->timestamp->format('Y-m-d H:i:s')]);

        $transaction->id = $connection->lastInsertId();
        return $transaction;
    }

    public function update(): Transaction
    {
        $connection = Database::getConnection();

        $statement = $connection->prepare("UPDATE transactions SET from_account_id = :from_account_id, to_account_id = :to_account_id, amount = :amount, timestamp = :timestamp WHERE id = :id");
        $statement->execute(['id' => $this->id, 'from_account_id' => $this->from_account_id, 'to_account_id' => $this->to_account_id, 'amount' => $this->amount, 'timestamp' => $this->timestamp->format('Y-m-d H:i:s')]);

        return $this;
    }

    public static function delete(int $id): void
    {
        $connection = Database::getConnection();

        $statement = $connection->prepare("DELETE FROM transactions WHERE id = :id");
        $statement->execute(['id' => $id]);
    }
}
