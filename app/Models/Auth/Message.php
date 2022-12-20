<?php

namespace App\Models\Auth;

use App\Models\BaseModel;

/**
 * Class User.
 */
class Message extends BaseModel
{

    protected $fillable = [
        'firebase_id',
        'friend_id',
        'user_id',
        'msg',
        'is_read',
        'type'
    ];

    public $maps = [
        'friend_id' => 'reciever',
        'user_id' => 'sender'
    ];

    public $appends = [
        'sender',
        'reciever'
    ];

    protected $hidden = ['friend_id', 'user_id'];

    public function getSenderAttribute()
    {
        return $this->attributes['user_id'];
    }
    public function getRecieverAttribute()
    {
        return $this->attributes['friend_id'];
    }


    public function friend()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
