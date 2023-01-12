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
    }

    public function indexOfUser($id)
    {
        if (!isset($id)) {
            $id = $_GET['id'];
        }

        $accounts = Account::allOfUser($id);
    }

    public function show($id)
    {
        if (!isset($id)) {
            $id = $_GET['id'];
        }

        $account = Account::find($id);
    }

    public function create(Account $account)
    {
        if (isset($account)) {
            $data = json_decode(file_get_contents('php://input'), true);
            $account = new Account($data['id'], $data['balance'],  Type::fromString($data['type']), $data['user_id'], $data['timestamp']);
        }

        $account = Account::create($account);
    }

    public function update(Account $account)
    {
        if (isset($account)) {
            $data = json_decode(file_get_contents('php://input'), true);
            $account = new Account($data['id'], $data['balance'],  Type::fromString($data['type']), $data['user_id'], $data['timestamp']);
        }

        $res = $account->update();
    }

    public function delete($id)
    {
        if (!isset($id)) {
            $id = $_GET['id'];
        }

        $deleted = Account::delete($id);
    }
}
