<?php

declare(strict_types=1);

namespace BotAcademy\Users\JsonApi\V1\Users\Fields;

use BotAcademy\Core\Components\Encoder\Encoder;
use BotAcademy\Users\Models\User;
use LaravelJsonApi\Contracts\Schema\IdEncoder;
use LaravelJsonApi\Eloquent\Fields\ID as BaseID;
use function resolve;

class ID extends BaseID implements IdEncoder
{
    public function encode($modelKey): string
    {
        return $this->getEncoder()->encode((int)$modelKey, User::ENTITY_TYPE);
    }

    public function decode(string $resourceId)
    {
        return $this->getEncoder()->decode($resourceId, User::ENTITY_TYPE);
    }

    /**
     * @return Encoder
     */
    private function getEncoder(): Encoder
    {
        return resolve(Encoder::class);
    }
}
