<?php declare(strict_types=1);

namespace Model;

use DateTime;

class Account extends BaseModel {

    public function __construct(int $id, float $balance, Type $type, int $user_id, DateTime $timestamp ) {
        $this->id = $id;
        $this->balance = $balance;
        $this->type = $type;
        $this->user_id = $user_id;
        $this->timestamp = $timestamp;
    }

    public static function all() : array {
        return [];
    }

    public static function allOfUser(int $user_id) : array {
        return [];
    }

    public static function find(int $id) : Account {
        return new Account($id, 0.0, Type::SAVINGS, 0, new DateTime());
    }

    public static function create(Account $account) : Account {
        return $account;
    }

    public static function update(Account $account) : Account {
        return $account;
    }

    public static function delete(int $id) : bool { // return true if deleted, false if not
        return true;
    }
}

enum Type {
    case SAVINGS;
    case CHECKING;
}