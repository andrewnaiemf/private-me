<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    protected $fillable = [
        'ad_ar',
        'ad_en',
    ];
}
