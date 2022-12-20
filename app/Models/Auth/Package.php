<?php

namespace App\Models\Auth;

use App\Models\BaseModel;

/**
 * Class User.
 */
class Package extends BaseModel
{

    protected $fillable = [
        'name',
        'month',
        'year',
        'price',
        'size_bytes',
        'card_holder_name',
        'card_number',
        'security_code',
        'user_id'
    ];
}
