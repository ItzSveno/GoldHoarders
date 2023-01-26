<?php

declare(strict_types=1);

namespace GoldHoarders\Controllers;

use DateTime;
use GoldHoarders\Models\Account;
use GoldHoarders\Enums\Type;
use GoldHoarders\ORM\EM;

class AccountController
{
    public function index()
    {
        $accounts = EM::getEntityManager()->getRepository(Account::class)->findAll();

        foreach($accounts as $account) {
            echo json_encode(['id' => $account->getId(), 'balance' => $account->getBalance(), 'type' => $account->getType(), 'user_id' => $account->getUserId(), 'timestamp' => $account->getTimeStamp()]);
        }
    }

    // (int $id)
    public function indexOfUser()
    {
        $id = (int)$_GET['id'];

        $accounts = EM::getEntityManager()->getRepository(Account::class)->findBy(['user_id' => $id]);

        foreach($accounts as $account) {
            echo json_encode(['id' => $account->getId(), 'balance' => $account->getBalance(), 'type' => $account->getType(), 'user_id' => $account->getUserId(), 'timestamp' => $account->getTimeStamp()]);
        }
        
    }

    // (int $id)
    public function show()
    {
        $id = (int)$_GET['id'];

        $account = EM::getEntityManager()->getRepository(Account::class)->find($id);
        echo json_encode(['id' => $account->getId(), 'balance' => $account->getBalance(), 'type' => $account->getType(), 'user_id' => $account->getUserId(), 'timestamp' => $account->getTimeStamp()]);
    }

    // (Account $account)
    public function create()
    {
        $data = json_decode(file_get_contents('php://input'), true);

        $account = new Account();
        $account->setBalance($data['balance']);
        $account->setType(strtoupper($data['type']));
        $account->setUserId($data['user_id']);
        $account->setTimeStamp(new DateTime());

        EM::getEntityManager()->persist($account);
        EM::getEntityManager()->flush();

        echo json_encode(['id' => $account->getId(), 'balance' => $account->getBalance(), 'type' => $account->getType(), 'user_id' => $account->getUserId(), 'timestamp' => $account->getTimeStamp()]);
    }

    // (Account $account)
    public function update()
    {
        $data = json_decode(file_get_contents('php://input'), true);

        $account = EM::getEntityManager()->getRepository(Account::class)->find($data['id']);
        $account->setBalance($data['balance']);
        $account->setType(strtoupper($data['type']));
        $account->setUserId($data['user_id']);
        $account->setTimeStamp(new DateTime());

        EM::getEntityManager()->flush();

        echo json_encode(['id' => $account->getId(), 'balance' => $account->getBalance(), 'type' => $account->getType(), 'user_id' => $account->getUserId(), 'timestamp' => $account->getTimeStamp()]);
    }

    // (int $id)
    public function delete()
    {
        $id = (int)$_GET['id'];

        $account = EM::getEntityManager()->getRepository(Account::class)->find($id);
        EM::getEntityManager()->remove($account);
        EM::getEntityManager()->flush();
        
        echo json_encode(['deleted' => "$id deleted"]);
    }
}