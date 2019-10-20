<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Category extends Model
{
    use NodeTrait;

    const TABLE_NAME                = 'categories';

    const FIELD_ID                  = 'id';
    const FIELD_TITLE               = 'title';
    const FIELD_LEFT                = '_lft';
    const FIELD_RIGHT               = '_rgt';
    const FIELD_PARENT_ID           = 'parent_id';
    const FIELD_CREATED_AT          = 'created_at';
    const FIELD_UPDATED_AT          = 'updated_at';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        self::FIELD_LEFT, self::FIELD_RIGHT, self::FIELD_PARENT_ID, self::FIELD_CREATED_AT, self::FIELD_UPDATED_AT,
    ];


}
