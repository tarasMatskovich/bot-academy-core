<?php

declare(strict_types=1);

namespace BotAcademy\Users\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property string $coin
 * @property float $target
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Strategy extends Model
{
    protected $table = 'strategies';

    public function getDefaultConvert(): string
    {
        return 'USDT';
    }
}
