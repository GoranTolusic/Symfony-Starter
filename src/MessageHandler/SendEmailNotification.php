<?php

namespace App\MessageHandler;

use App\Message\SendEmailMessage;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class SendEmailNotification
{
    public function __invoke(SendEmailMessage $message)
    {
        // Fire some event on mqtt/socket/redis/elastic/service
        consoleLog("Notify system that email has been sent to someone.... {$message->to}: {$message->subject}");
    }
}
