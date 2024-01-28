<?php

namespace App\Logging\Telegram;

use Monolog\Logger;

class TelegramLoggerFactory
{
    public function __invoke(array $config): Logger
    {
        $logger = new Logger(
            'telegram',
            [new TelegramLoggerHandler($config)]
        );

        return $logger;
    }
}
