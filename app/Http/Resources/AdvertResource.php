<?php

namespace App\Http\Resources;

use App\Models\Advert;
use Illuminate\Http\Resources\Json\JsonResource;

class AdvertResource extends JsonResource
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
            'id'            => $this->{Advert::FIELD_ID},
            'title'         => $this->{Advert::FIELD_TITLE},
            'content'       => $this->{Advert::FIELD_CONTENT},
            'category'      => $this->categoryWithAncestors(),
            'created_at'    => $this->{Advert::FIELD_CREATED_AT},
            'updated_at'    => $this->{Advert::FIELD_UPDATED_AT}
        ];
    }
}
