<?php

namespace App\Models\Auth\Traits\Relationships;

use App\Models\Auth\PasswordHistory;
use App\Models\Auth\Permission;
use App\Models\Auth\Role;
use App\Models\Auth\User;
use App\Models\Auth\SocialAccount;
use App\Models\Auth\Frindship;
use App\Models\Auth\Package;
use App\Models\Auth\Plan;

trait UserRelationships
{
    /**
     * @return mixed
     */
    public function providers()
    {
        return $this->hasMany(SocialAccount::class);
    }

    /**
     * @return mixed
     */
    public function passwordHistories()
    {
        return $this->hasMany(PasswordHistory::class);
    }

    /**
     * @return mixed
     */
    public function sessions()
    {
        return $this->hasMany(Session::class);
    }

    /**
     * Many-to-Many relations with Role.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * Many-to-Many relations with Permission.
     * ONLY GETS PERMISSIONS ARE NOT ASSOCIATED WITH A ROLE.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function friends1()
    {
        return $this->hasMany(Frindship::class, 'fisrt_user_id');
    }

    public function friends2()
    {
        return $this->hasMany(Frindship::class, 'second_user_id');
    }

    public function package()
    {
        return $this->hasOne(Package::class, 'user_id');
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
