<?php

namespace App\Models\Auth;

use App\Models\Auth\Traits\Access\UserAccess;
use App\Models\Auth\Traits\Attributes\UserAttributes;
use App\Models\Auth\Traits\Methods\UserMethods;
use App\Models\Auth\Traits\Relationships\UserRelationships;
use App\Models\Auth\Traits\Scopes\UserScopes;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

/**
 * Class User.
 */
class User extends BaseUser
{
    use HasApiTokens, Notifiable, UserAttributes, UserScopes, UserAccess, UserRelationships, UserMethods;
}
