<?php

declare(strict_types=1);

namespace Model;

use DateTime;

class Transaction
{
    public function __construct(public int $id, public int $from_account_id, public int $to_account_id, public float $amount, public ?DateTime $timestamp)
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
            $transactions[] = new Transaction($row['id'], $row['from_account'], $row['to_account'], (float)$row['amount'], new DateTime($row['timestamp']));
        }

        return $transactions;
    }

    public static function allOfAccount(int $account_id): array
    {
        $connection = Database::getConnection();

        $statement = $connection->prepare("CALL UserTransactions(:account_id)");
        $statement->execute(['account_id' => $account_id]);
        $result = $statement->fetchAll();

        $transactions = [];
        foreach ($result as $row) {
            $transactions[] = new Transaction($row['id'], $row['from_account'], $row['to_account'], (float)$row['amount'], new DateTime($row['timestamp']));
        }

        return $transactions;
    }

    public static function find(int $id): Transaction
    {
        $connection = Database::getConnection();

        $statement = $connection->prepare("SELECT * FROM transactions WHERE id = :id");
        $statement->execute(['id' => $id]);
        $result = $statement->fetch();

        return new Transaction($result['id'], $result['from_account'], $result['to_account'], (float)$result['amount'], new DateTime($result['timestamp']));
    }

    public static function create($transaction): string
    {
        $connection = Database::getConnection();

        $statement = $connection->prepare("CALL TransferAmount(:from_account_id, :to_account_id, :amount)");

        $statement->execute(['from_account_id' => $transaction->from_account_id, 'to_account_id' => $transaction->to_account_id, 'amount' => $transaction->amount]);


        return "transaction created";
    }
}
