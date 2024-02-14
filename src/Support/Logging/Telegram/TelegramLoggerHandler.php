<?php
declare(strict_types=1);

namespace Src\Support\Logging\Telegram;

use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;
use Monolog\LogRecord;
use Src\Services\Telegram\TelegramBotApi;

class TelegramLoggerHandler extends AbstractProcessingHandler
{
    private ?string $token;
    private ?int $chatId;

    public function __construct(array $config)
    {
        $level = Logger::toMonologLevel($config['level']);
        parent::__construct($level);

        $this->token = $config['token'];
        $this->chatId = (int) $config['chat_id'];
    }

    protected function write(LogRecord $record): void
    {
        TelegramBotApi::sendMessage($this->token, $this->chatId, $record->formatted);
    }
}
