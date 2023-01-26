<?php

declare(strict_types=1);

namespace Controller\API;

use Model\Account;
use Enums\Type;
use Model\AccountDto;
use ORM\EM;

class AccountController implements BaseController
{
    public function index()
    {
        $accounts = EM::getEntityManager()->getRepository(Account::class)->findAll();

        foreach($accounts as $account) {
            echo json_encode(['balance' => $account->balance, 'type' => $account->type->toString(), 'user_id' => $account->user_id, 'timestamp' => $account->timestamp]);
        }
    }

    // (int $id)
    public function indexOfUser()
    {
        $id = $_GET['id'];

        $accounts = EM::getEntityManager()->getRepository(Account::class)->findBy(['user_id' => $id]);

        foreach($accounts as $account) {
            echo json_encode(['balance' => $account->balance, 'type' => $account->type->toString(), 'user_id' => $account->user_id, 'timestamp' => $account->timestamp]);
        }
        
    }

    // (int $id)
    public function show()
    {
        $id = $_GET['id'];

        $account = EM::getEntityManager()->getRepository(Account::class)->find($id);
        echo json_encode(['balance' => $account->balance, 'type' => $account->type->toString(), 'user_id' => $account->user_id, 'timestamp' => $account->timestamp]);
    }

    // (Account $account)
    public function create()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $account = new AccountDto(0, $data['balance'],  Type::fromString($data['type']), $data['user_id'], null);

        $account = EM::getEntityManager()->getRepository(Account::class)->create($account);
        echo json_encode(['balance' => $account->balance, 'type' => $account->type->toString(), 'user_id' => $account->user_id, 'timestamp' => $account->timestamp]);
    }

    // (Account $account)
    public function update()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $account = new AccountDto($data['id'], $data['balance'],  Type::fromString($data['type']), $data['user_id'], null);

        $account = EM::getEntityManager()->getRepository(Account::class)->update($account);
        echo json_encode(['balance' => $account->balance, 'type' => $account->type->toString(), 'user_id' => $account->user_id, 'timestamp' => $account->timestamp]);
    }

    // (int $id)
    public function delete()
    {
        $id = $_GET['id'];

        EM::getEntityManager()->getRepository(Account::class)->delete($id);

        echo json_encode(['deleted' => "$id deleted"]);
    }
}
