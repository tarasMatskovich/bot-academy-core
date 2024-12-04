<?php

declare(strict_types=1);

namespace BotAcademy\Users\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property int $strategy_id
 * @property int $amount
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Attempt extends Model
{
    protected $table = 'attempts';
}
