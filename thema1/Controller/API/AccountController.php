<?php

declare(strict_types=1);

namespace Controller\API;

use Model\Account;
use Enum\Type;

class AccountController extends BaseController
{
    public function index()
    {
        $accounts = Account::all();

        foreach($accounts as $account) {
            echo json_encode(['balance' => $account->balance, 'type' => $account->type->toString(), 'user_id' => $account->user_id, 'timestamp' => $account->timestamp]);
        }
    }

    public function indexOfUser($id)
    {
        if (!isset($id)) {
            $id = $_GET['id'];
        }

        $accounts = Account::allOfUser($id);

        foreach($accounts as $account) {
            echo json_encode(['balance' => $account->balance, 'type' => $account->type->toString(), 'user_id' => $account->user_id, 'timestamp' => $account->timestamp]);
        }
        
    }

    public function show($id)
    {
        if (!isset($id)) {
            $id = $_GET['id'];
        }

        $account = Account::find($id);
        echo json_encode(['balance' => $account->balance, 'type' => $account->type->toString(), 'user_id' => $account->user_id, 'timestamp' => $account->timestamp]);
    }

    public function create(Account $account)
    {
        if (isset($account)) {
            $data = json_decode(file_get_contents('php://input'), true);
            $account = new Account($data['id'], $data['balance'],  Type::fromString($data['type']), $data['user_id'], $data['timestamp']);
        }

        $account = Account::create($account);
        echo json_encode(['balance' => $account->balance, 'type' => $account->type->toString(), 'user_id' => $account->user_id, 'timestamp' => $account->timestamp]);
    }

    public function update(Account $account)
    {
        if (isset($account)) {
            $data = json_decode(file_get_contents('php://input'), true);
            $account = new Account($data['id'], $data['balance'],  Type::fromString($data['type']), $data['user_id'], $data['timestamp']);
        }

        $account = $account->update();
        echo json_encode(['balance' => $account->balance, 'type' => $account->type->toString(), 'user_id' => $account->user_id, 'timestamp' => $account->timestamp]);
    }

    public function delete($id)
    {
        if (!isset($id)) {
            $id = $_GET['id'];
        }

        Account::delete($id);

        echo json_encode(['deleted' => "$id deleted"]);
    }
}
