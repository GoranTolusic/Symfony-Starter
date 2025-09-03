<?php

namespace App\Message;

class UserRegistered
{
    public function __construct(
        public string $email,
        public string $title,
        public string $notification
    ) {}
}
