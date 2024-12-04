<?php

namespace BotAcademy\Core\Console\Command;

use BotAcademy\Users\Http\Requests\Auth\DTO\SignUpUserDTO;
use BotAcademy\Users\Models\BinanceToken;
use BotAcademy\Users\Services\User\UserCreator;
use Illuminate\Console\Command;

class CreateUserCommand extends Command
{
    protected $signature = 'create:user';

    public function handle(UserCreator $creator): void
    {
        $name = (string)$this->output->ask("Введіть ім'я: ");
        $email = (string)$this->output->ask("Введіть email: ");
        $password = (string)$this->output->ask('Введіть пароль: ');
        $apiToken = (string)$this->output->ask('Введіть api key: ');
        $apiSecret = (string)$this->output->ask('Введіть api secret: ');
        if (!$email || !$password || !$name || !$apiToken || !$apiSecret) {
            $this->error('Дані не вірні');
            return;
        }
        $dto = new SignUpUserDTO($name, $email, $password, false);

        $user = $creator->createFromDTO($dto);
        $token = new BinanceToken();
        $token->user_id = $user->id;
        $token->api_key = $apiToken;
        $token->api_secret = $apiSecret;
        $token->save();

        $this->output->success('Користувач створений успішно');
    }
}
