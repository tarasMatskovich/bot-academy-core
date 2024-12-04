<?php

declare(strict_types=1);

namespace BotAcademy\Core\Console\Command;

use BotAcademy\Core\Services\Binance\Trader;
use BotAcademy\Users\Models\BinanceToken;
use BotAcademy\Users\Models\Strategy;
use BotAcademy\Users\Models\User;
use Illuminate\Console\Command;

class TradeCommand extends Command
{
    protected $signature = 'trade';

    public function handle(Trader $trader): void
    {
        $email = 'matskovich.taras@gmail.com';
        $coin = 'HMSTR';
        /** @var User|null $user */
        $user = User::query()->where('email', $email)->first();
        if (!$user) {
            $this->output->error('User not found');
            return;
        }

        /** @var BinanceToken|null $token */
        $token = BinanceToken::query()->where('user_id', $user->id)->first();
        if (!$token) {
            $this->output->error('Token was not found');
            return;
        }

        /** @var Strategy|null $strategy */
        $strategy = Strategy::query()
            ->where('user_id', $user->id)
            ->where('coin', $coin)
            ->first();
        if (!$strategy) {
            $this->output->error('Стратегію не знайдено');
            return;
        }

        $trader->trade($strategy, $token);
    }
}
