<?php

declare(strict_types=1);

namespace BotAcademy\Users\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property int $type 0 - sell coin, 1 - buy coin | 0 | 1 | 0
 * @property string $coin HMSTR | HMSTR | HMSTR
 * @property int $amount 1300 | 1400 | 1400
 * @property float $total 4 | 4 | 5
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Trade extends Model
{
    protected $casts = [
        'total' => 'float',
        'amount' => 'integer',
    ];
    public const SELL = 0;
    public const BUY = 1;

    protected $table = 'trades';

    public function isSell(): bool
    {
        return $this->type === self::SELL;
    }

    public function isBuy(): bool
    {
        return !$this->isSell();
    }


}
