<?php declare(strict_types=1);

namespace GoldHoarders\Controllers;

use DateTime;
use GoldHoarders\Models\Transaction;
use GoldHoarders\Models\Account;
use GoldHoarders\ORM\EM;

class TransactionController
{
    public function index() {
        $transactions = EM::getEntityManager()->getRepository(Transaction::class)->findAll();

        foreach ($transactions as $transaction) {
            echo json_encode(['from_account_id' => $transaction->getFromAccountId(), 'to_account_id' => $transaction->getToAccountId(), 'amount' => $transaction->getAmount(), 'timestamp' => $transaction->getTimestamp()]);
        }
    }

    // (int $id)
    public function indexOfSender() {
        $id = (int)$_GET['id'];

        $transactions = EM::getEntityManager()->getRepository(Transaction::class)->findBy(['from_account_id' => $id]);

        foreach ($transactions as $transaction) {
            echo json_encode(['from_account_id' => $transaction->getFromAccountId(), 'to_account_id' => $transaction->getToAccountId(), 'amount' => $transaction->getAmount(), 'timestamp' => $transaction->getTimestamp()]); 
        }
    }

    // (int $id)
    public function indexOfReceiver() {
        $id = (int)$_GET['id'];

        $transactions = EM::getEntityManager()->getRepository(Transaction::class)->findBy(['to_account_id' => $id]);

        foreach ($transactions as $transaction) {
            echo json_encode(['from_account_id' => $transaction->getFromAccountId(), 'to_account_id' => $transaction->getToAccountId(), 'amount' => $transaction->getAmount(), 'timestamp' => $transaction->getTimestamp()]);
        }
    }

    // (int $id)
    public function show() {
        $id = (int)$_GET['id'];

        $transaction = EM::getEntityManager()->getRepository(Transaction::class)->find($id);

        echo json_encode(['from_account_id' => $transaction->getFromAccountId(), 'to_account_id' => $transaction->getToAccountId(), 'amount' => $transaction->getAmount(), 'timestamp' => $transaction->getTimestamp()]);
    }

    // (Transaction $transaction)
    public function create() {
        $data = json_decode(file_get_contents('php://input'), true);
        $transaction = new Transaction();
        $transaction->setFromAccountId($data['from_account_id']);
        $transaction->setToAccountId($data['to_account_id']);
        $transaction->setAmount($data['amount']);
        $transaction->setTimestamp(new DateTime());

        EM::getEntityManager()->persist($transaction);

        if($transaction->getFromAccountId() == $transaction->getToAccountId()) {
            throw new \Exception("Cannot transfer money to the same account");
        }
        else if($transaction->getAmount() <= 0) {
            throw new \Exception("Amount must be greater than 0");
        }



        // subtract amount from sender
        $sender = EM::getEntityManager()->getRepository(Account::class)->find($transaction->getFromAccountId());

        if($sender->getBalance() < $transaction->getAmount()) {
            throw new \Exception("Insufficient funds");
        }
        $sender->setBalance($sender->getBalance() - $transaction->getAmount());

        // add amount to receiver
        $receiver = EM::getEntityManager()->getRepository(Account::class)->find($transaction->getToAccountId());
        $receiver->setBalance($receiver->getBalance() + $transaction->getAmount());

        EM::getEntityManager()->flush();

        echo json_encode(['from_account_id' => $transaction->getId(), 'to_account_id' => $transaction->getToAccountId(), 'amount' => $transaction->getAmount(), 'timestamp' => $transaction->getTimestamp()]);
    }

}