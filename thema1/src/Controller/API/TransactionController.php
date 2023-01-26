<?php declare(strict_types=1);

namespace Controller\API;

use DateTime;
use Model\Transaction;

class TransactionController
{
    public function index() {
        $transactions = Transaction::all();

        foreach ($transactions as $transaction) {
            echo json_encode(['from_account_id' => $transaction->from_account_id, 'to_account_id' => $transaction->to_account_id, 'amount' => $transaction->amount, 'timestamp' => $transaction->timestamp]);
        }
    }

    // (int $id)
    public function indexOfSender() {
        $id = (int)$_GET['id'];

        $transactions = Transaction::allOfAccount($id);

        foreach ($transactions as $transaction) {
            echo json_encode(['from_account_id' => $transaction->from_account_id, 'to_account_id' => $transaction->to_account_id, 'amount' => $transaction->amount, 'timestamp' => $transaction->timestamp]);
        }
    }

    // (int $id)
    public function indexOfReceiver() {
        $id = (int)$_GET['id'];

        $transactions = Transaction::allOfAccount($id);

        foreach ($transactions as $transaction) {
            echo json_encode(['from_account_id' => $transaction->from_account_id, 'to_account_id' => $transaction->to_account_id, 'amount' => $transaction->amount, 'timestamp' => $transaction->timestamp]);
        }
    }

    // (int $id)
    public function show() {
        $id = (int)$_GET['id'];

        $transaction = Transaction::find($id);

        echo json_encode(['from_account_id' => $transaction->from_account_id, 'to_account_id' => $transaction->to_account_id, 'amount' => $transaction->amount, 'timestamp' => $transaction->timestamp]);
    }

    // (Transaction $transaction)
    public function create() {
        $data = json_decode(file_get_contents('php://input'), true);
        $transaction = new Transaction(0, (int)$data['from_account_id'],  (int)$data['to_account_id'], (float)$data['amount'], new DateTime());

        $result = Transaction::create($transaction);

        echo $result;
    }

}