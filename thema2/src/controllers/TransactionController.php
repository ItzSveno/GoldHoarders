<?php declare(strict_types=1);

namespace Controller\API;

use Model\Transaction;

class TransactionController extends BaseController {
    public function index() {
        $transactions = Transaction::all();

        foreach ($transactions as $transaction) {
            echo json_encode(['from_account_id' => $transaction->from_account_id, 'to_account_id' => $transaction->to_account_id, 'amount' => $transaction->amount, 'timestamp' => $transaction->timestamp]);
        }
    }

    public function indexOfSender($id) {
        if(!isset($id)) {
            $id = $_GET['id'];
        }

        $transactions = Transaction::allOfAccount($id);

        foreach ($transactions as $transaction) {
            echo json_encode(['from_account_id' => $transaction->from_account_id, 'to_account_id' => $transaction->to_account_id, 'amount' => $transaction->amount, 'timestamp' => $transaction->timestamp]);
        }
    }

    public function indexOfReceiver($id) {
        if (!isset($id)) {
            $id = $_GET['id'];
        }

        $transactions = Transaction::allOfAccount($id);

        foreach ($transactions as $transaction) {
            echo json_encode(['from_account_id' => $transaction->from_account_id, 'to_account_id' => $transaction->to_account_id, 'amount' => $transaction->amount, 'timestamp' => $transaction->timestamp]);
        }
    }

    public function show($id) {
        if (!isset($id)) {
            $id = $_GET['id'];
        }

        $transaction = Transaction::find($id);

        echo json_encode(['from_account_id' => $transaction->from_account_id, 'to_account_id' => $transaction->to_account_id, 'amount' => $transaction->amount, 'timestamp' => $transaction->timestamp]);
    }

    public function create(Transaction $transaction) {
        if (!isset($transaction)) {
            $data = json_decode(file_get_contents('php://input'), true);
            $transaction = new Transaction($data['id'], $data['from_account_id'], $data['to_account_id'], $data['amount'], $data['timestamp']);
        }

        $transaction = Transaction::create($transaction);

        echo json_encode(['from_account_id' => $transaction->from_account_id, 'to_account_id' => $transaction->to_account_id, 'amount' => $transaction->amount, 'timestamp' => $transaction->timestamp]);
    }

    public function update(Transaction $transaction) {
        if (!isset($transaction)) {
            $data = json_decode(file_get_contents('php://input'), true);
            $transaction = new Transaction($data['id'], $data['from_account_id'], $data['to_account_id'], $data['amount'], $data['timestamp']);
        }

        $transaction = $transaction->update();

        echo json_encode(['from_account_id' => $transaction->from_account_id, 'to_account_id' => $transaction->to_account_id, 'amount' => $transaction->amount, 'timestamp' => $transaction->timestamp]);
    }

    public function delete($id) {
        if (!isset($id)) {
            $id = $_GET['id'];
        }

        Transaction::delete($id);

        echo json_encode(['deleted' => "$id deleted"]);
    }
}