<?php
declare(strict_types=1);

namespace Src\Services\Telegram;

use Illuminate\Support\Facades\Http;
use Src\Support\Exceptions\TelegramBotApiException;
use Throwable;

class TelegramBotApi
{
    public const string HOST = 'api.telegram.org/bot';

    public static function sendMessage(string $token, int $chatId, string $message): bool
    {
        try {
            $response = Http::get(self::HOST . $token . '/sendMessage', [
                'chat_id' => $chatId,
                'text' => $message
            ])
                ->throw()
                ->json();

            return $response['ok'] ?? false;
        } catch (Throwable $e) {
            report(new TelegramBotApiException($e->getMessage() . '. status code: ' . $e->getCode()));

            return false;
        }
    }
}
