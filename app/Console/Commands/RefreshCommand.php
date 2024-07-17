<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class RefreshCommand extends Command
{
    protected $signature = 'app:refresh';

    protected $description = 'Command description';

    public function handle(): int
    {
        if (app()->isProduction()) {
            return self::FAILURE;
        }

        Storage::deleteDirectory('/images');

        $this->call('migrate:fresh', ['--seed' => true]);
        $this->call('optimize:clear');

        return self::SUCCESS;
    }
}
