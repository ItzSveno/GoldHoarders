<?php

declare(strict_types=1);

namespace Controller\API;

use DateTime;
use Model\Account;
use Enums\Type;

class AccountController implements BaseController
{
    public function index()
    {
        $accounts = Account::all();

        foreach($accounts as $account) {
            echo json_encode(['balance' => $account->balance, 'type' => $account->type->toString(), 'user_id' => $account->user_id, 'timestamp' => $account->timestamp]);
        }
    }

    // (int $id)
    public function indexOfUser()
    {
        $id = (int)$_GET['id'];

        $accounts = Account::allOfUser($id);

        foreach($accounts as $account) {
            echo json_encode(['balance' => $account->balance, 'type' => $account->type->toString(), 'user_id' => $account->user_id, 'timestamp' => $account->timestamp]);
        }
        
    }

    // (int $id)
    public function show()
    {
        $id = (int)$_GET['id'];

        $account = Account::find($id);
        echo json_encode(['balance' => $account->balance, 'type' => $account->type->toString(), 'user_id' => $account->user_id, 'timestamp' => $account->timestamp]);
    }

    // (Account $account)
    public function create()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $account = new Account(0, $data['balance'],  Type::fromString(strtoupper($data['type'])), $data['user_id'], new DateTime());

        $account = Account::create($account);
        echo json_encode(['balance' => $account->balance, 'type' => $account->type->toString(), 'user_id' => $account->user_id, 'timestamp' => $account->timestamp]);
    }

    // (Account $account)
    public function update()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $account = new Account($data['id'], $data['balance'],  Type::fromString(strtoupper($data['type'])), $data['user_id'], new DateTime());

        $account = $account->update();
        echo json_encode(['balance' => $account->balance, 'type' => strtoupper($account->type->toString()), 'user_id' => $account->user_id, 'timestamp' => $account->timestamp]);
    }

    // (int $id)
    public function delete()
    {
        $id = (int)$_GET['id'];

        Account::delete($id);

        echo json_encode(['deleted' => "$id deleted"]);
    }
}
