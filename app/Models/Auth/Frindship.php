<?php

namespace App\Models\Auth;

use App\Models\BaseModel;

/**
 * Class User.
 */
class Frindship extends BaseModel
{

    protected $fillable = [
        'fisrt_user_id',
        'second_user_id',
        'accept'
    ];

    public function user1()
    {
        return $this->belongsTo(User::class, 'fisrt_user_id');
    }

    public function user2()
    {
        return $this->belongsTo(User::class, 'second_user_id');
    }
}
