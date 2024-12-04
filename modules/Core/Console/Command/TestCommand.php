<?php

declare(strict_types=1);

namespace BotAcademy\Core\Console\Command;

use Illuminate\Console\Command;

class TestCommand extends Command
{
    protected $signature = 'test';

    public function handle(): void
    {
        file_put_contents('/var/www/test.log', "TEST\r\n", FILE_APPEND);
    }
}
