<?php

declare(strict_types=1);

namespace BotAcademy\Users\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $action
 * @property string $data
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Log extends Model
{
    protected $table = 'logs';
}
