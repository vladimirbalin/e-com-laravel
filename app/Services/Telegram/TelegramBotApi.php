<?php

namespace App\Services\Telegram;

use Illuminate\Support\Facades\Http;

class TelegramBotApi
{
    private const string HOST = 'api.telegram.org/bot';

    public static function sendMessage(string $token, int $chatId, string $message): void
    {
        Http::get(self::HOST . $token . '/sendMessage',
            [
                'chat_id' => $chatId,
                'text' => $message
            ]);
    }
}
