<?php

declare(strict_types=1);

namespace BotAcademy\Core\Console\Command;

use BotAcademy\Users\Models\Strategy;
use BotAcademy\Users\Models\User;
use Illuminate\Console\Command;

class CreateStrategyCommand extends Command
{
    protected $signature = 'create:strategy';

    public function handle(): void
    {
        $email = (string)$this->ask('Введіть email: ');
        /** @var User|null $user */
        $user = User::query()->where('email', $email)->first();
        if (!$user) {
            $this->output->error('Не знайдено такого користувача');
            return;
        }

        $coin = (string)$this->ask('Ввеідть монету: ');
        if (!$coin) {
            $this->output->error('Не знайдено такого користувача');
            return;
        }

        $target = (float)$this->ask('Введіть відсоток: ');
        if (!$target) {
            $this->output->error('Дані не вірні');
            return;
        }

        /** @var Strategy|null $strategy */
        $strategy = Strategy::query()
            ->where('user_id', $user->id)
            ->where('coin', $coin)
            ->first();
        if (!$strategy) {
            $strategy = new Strategy();
            $strategy->user_id = $user->id;
            $strategy->coin = $coin;
        }
        $strategy->target = $target;
        $strategy->save();

        $this->output->success('Стратегія була оновлена');
    }
}
