<?php

namespace Model;

use Enum\Type;

class AccountDto
{
    public function __construct(
        public int $id,
        public float $balance,
        public Type $type,
        public int $user_id,
        public string $timestamp
    ) {
    }
}
