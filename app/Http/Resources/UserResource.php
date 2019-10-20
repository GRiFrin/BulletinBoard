<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->{User::FIELD_ID},
            'name' => $this->{User::FIELD_NAME},
            'email' => $this->{User::FIELD_EMAIL},
            'created_at' => $this->{User::FIELD_CREATED_AT},
            'updated_at' => $this->{User::FIELD_UPDATED_AT},
        ];
    }
}
