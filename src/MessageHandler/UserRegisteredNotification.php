<?php

namespace App\MessageHandler;

use App\Message\UserRegistered;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class UserRegisteredNotification
{
    public function __invoke(UserRegistered $message)
    {
        // Fire some event on mqtt/socket/redis/elastic/service...
        consoleLog("Notify system about registration for example.... {$message->notification}");
    }
}
