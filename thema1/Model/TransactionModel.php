<?php declare(strict_types=1);

namespace Model;

use DateTime;

class Transaction extends BaseModel {
        public function __construct(int $id, int $from_account_id, int $to_account_id, float $amount, DateTime $timestamp) {
            $this->id = $id;
            $this->from_account_id = $from_account_id;
            $this->to_account_id = $to_account_id;
            $this->amount = $amount;
            $this->timestamp = $timestamp;
        }
    
        public static function all() : array {
            return [];
        }

        public static function allOfSender(int $sender_id) : array {
            return [];
        }

        public static function allOfReceiver(int $receiver_id) : array {
            return [];
        } 
    
        public static function find(int $id) : Transaction {
            return new Transaction($id, 0, 0, 0.0, new DateTime());
        }
    
        public static function create(Transaction $transaction) : Transaction {
            return $transaction;
        }
    
        public static function update(Transaction $transaction) : Transaction {
            return $transaction;
        }
    
        public static function delete(int $id) : bool { // return true if deleted, false if not
            return true;
        }
}