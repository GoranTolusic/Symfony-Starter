<?php

namespace App\MessageHandler;

use App\Message\SendEmailMessage;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class SendEmailMessageHandler
{
    public function __invoke(SendEmailMessage $message)
    {
        // Sending email simulation
        consoleLog("Simulated sending email to {$message->to}: {$message->subject}");
    }
}
