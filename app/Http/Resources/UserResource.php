<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        $user = parent::toArray($request);
        $user['group'] = $this->group;
        return $user;
    }
}