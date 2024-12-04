<?php

declare(strict_types=1);

namespace BotAcademy\Users\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property string $api_key
 * @property string $api_secret
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class BinanceToken extends Model
{

}
