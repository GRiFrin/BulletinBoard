<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Advert extends Model
{
    const TABLE_NAME                = 'adverts';

    const FIELD_ID                  = 'id';
    const FIELD_TITLE               = 'title';
    const FIELD_CONTENT             = 'content';
    const FIELD_USER_ID             = 'user_id';
    const FIELD_CATEGORY_ID         = 'category_id';
    const FIELD_CREATED_AT          = 'created_at';
    const FIELD_UPDATED_AT          = 'updated_at';

    const R_FIELD_USER              = 'user';
    const R_FIELD_CATEGORY          = 'category';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        self::FIELD_TITLE, self::FIELD_CONTENT, self::FIELD_USER_ID, self::FIELD_CATEGORY_ID, self::FIELD_CREATED_AT,
        self::FIELD_UPDATED_AT
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function categoryWithAncestors()
    {
        $category = $this->{$this::R_FIELD_CATEGORY}->ancestors;

        return $this->{$this::R_FIELD_CATEGORY};
    }
}
