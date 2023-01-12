<?php declare(strict_types=1);

namespace Controller\API;

use Model\Transaction;

class TransactionController extends BaseController {
    public function index() {
        $transactions = Transaction::all();
    }

    public function indexOfSender($id) {
        if(!isset($id)) {
            $id = $_GET['id'];
        }

        $transactions = Transaction::allOfSender($id);
    }

    public function indexOfReceiver($id) {
        if (!isset($id)) {
            $id = $_GET['id'];
        }

        $transactions = Transaction::allOfReceiver($id);
    }

    public function show($id) {
        if (!isset($id)) {
            $id = $_GET['id'];
        }

        $transaction = Transaction::find($id);
    }

    public function create(Transaction $transaction) {
        if (!isset($transaction)) {
            $data = json_decode(file_get_contents('php://input'), true);
            $transaction = new Transaction($data['id'], $data['from_account_id'], $data['to_account_id'], $data['amount'], $data['timestamp']);
        }

        $transaction = Transaction::create($transaction);
    }

    public function update(Transaction $transaction) {
        if (!isset($transaction)) {
            $data = json_decode(file_get_contents('php://input'), true);
            $transaction = new Transaction($data['id'], $data['from_account_id'], $data['to_account_id'], $data['amount'], $data['timestamp']);
        }

        $res = $transaction->update();
    }

    public function delete($id) {
        if (!isset($id)) {
            $id = $_GET['id'];
        }
        
        $deleted = Transaction::delete($id);
    }
}