<?php

namespace Model;

class UserDto
{
    public function __construct(
        public int $id,
        public string $name,
        public string $email,
        public string $password,
    ) {
    }
}