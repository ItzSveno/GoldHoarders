<?php declare(strict_types=1);

namespace Controller\API;

use Model\Account;

class AccountController extends BaseController {
    public function index() {
        $accounts = Account::all();
    }

    public function indexOfUser($id) {
        $accounts = Account::allOfUser($id);
    }

    public function show($id) {
        $account = Account::find($id);
    }

    public function create(Account $account) {
        $account = Account::create($account);
    }

    public function update(Account $account) {
        $account = Account::update($account);
    }

    public function delete($id) {
        $deleted = Account::delete($id);
    }
}