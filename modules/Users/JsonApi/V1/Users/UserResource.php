<?php

namespace BotAcademy\Users\JsonApi\V1\Users;

use BotAcademy\Users\Models\User;
use Illuminate\Http\Request;
use LaravelJsonApi\Core\Resources\JsonApiResource;

/**
 * @property User $resource
 */
class UserResource extends JsonApiResource
{

    /**
     * Get the resource's attributes.
     *
     * @param Request|null $request
     * @return iterable
     */
    public function attributes($request): iterable
    {
        return [
            'name' => $this->resource->name,
            'email' => $this->resource->email,
            'email_verified_at' => $this->resource->email_verified_at?->format('Y-m-d h:m:s'),
            'created_at' => $this->resource->created_at->format('Y-m-d h:m:s'),
            'updated_at' => $this->resource->updated_at?->format('Y-m-d h:m:s'),
        ];
    }

    public function id(): string
    {
        return parent::id(); // TODO: Change the autogenerated stub
    }

    /**
     * Get the resource's relationships.
     *
     * @param Request|null $request
     * @return iterable
     */
    public function relationships($request): iterable
    {
        return [
            // @TODO
        ];
    }
}
