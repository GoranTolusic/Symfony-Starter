<?php

namespace App\Message;

class SendEmailMessage
{
    public function __construct(
        public string $to,
        public string $subject,
        public string $body
    ) {}
}
