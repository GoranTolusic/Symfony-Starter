<?php

namespace App\MessageHandler;

use App\Message\UserRegistered;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class UserRegisteredEmailHandler
{
    public function __invoke(UserRegistered $message)
    {
        // Sending email simulation
        consoleLog("Simulate sending email to registered user for example.... {$message->email}: {$message->title}");
    }
}
