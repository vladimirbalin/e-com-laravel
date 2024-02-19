<?php
declare(strict_types=1);

namespace Tests\Unit\Services;

use Illuminate\Support\Facades\Http;
use Src\Services\Telegram\TelegramBotApi;
use Tests\TestCase;

class TelegramApiBotTest extends TestCase
{
    public function testSendMessageSuccess()
    {
        Http::fake([
            TelegramBotApi::HOST . '*' => Http::response(['ok' => true], 200)
        ]);

        $result = TelegramBotApi::sendMessage('', 1, 'Testing msg');

        $this->assertTrue($result);
    }
}
