<?php declare(strict_types=1);

namespace Controller\API;

use Model\Transaction;

class TransactionController extends BaseController {
    public function index() {
        $transactions = Transaction::all();
    }

    public function indexOfSender($id) {
        $transactions = Transaction::allOfSender($id);
    }

    public function indexOfReceiver($id) {
        $transactions = Transaction::allOfReceiver($id);
    }

    public function show($id) {
        $transaction = Transaction::find($id);
    }

    public function create(Transaction $transaction) {
        $transaction = Transaction::create($transaction);
    }

    public function update(Transaction $transaction) {
        $transaction = Transaction::update($transaction);
    }

    public function delete($id) {
        $deleted = Transaction::delete($id);
    }
}