<?php

namespace App\Models\Auth\Traits\Methods;

use App\Models\Auth\Frindship;
use App\Models\Auth\User;

trait UserMethods
{
    /**
     * @return mixed
     */
    public function canChangeEmail()
    {
        return config('access.users.change_email');
    }

    /**
     * @return bool
     */
    public function canChangePassword()
    {
        return !app('session')->has(config('access.socialite_session_name'));
    }

    /**
     * @param bool $size
     *
     * @throws \Illuminate\Container\EntryNotFoundException
     * @return bool|\Illuminate\Contracts\Routing\UrlGenerator|mixed|string
     */
    public function getPicture($size = false)
    {
        switch ($this->avatar_type) {
            case 'gravatar':
                if (!$size) {
                    $size = config('gravatar.default.size');
                }

                return gravatar()->get($this->email, ['size' => $size]);

            case 'storage':
                return url('storage/' . $this->avatar_location);
        }

        $social_avatar = $this->providers()->where('provider', $this->avatar_type)->first();

        if ($social_avatar && strlen($social_avatar->avatar)) {
            return $social_avatar->avatar;
        }

        return false;
    }

    /**
     * @param $provider
     *
     * @return bool
     */
    public function hasProvider($provider)
    {
        foreach ($this->providers as $p) {
            if ($p->provider == $provider) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return mixed
     */
    public function isAdmin()
    {
        return $this->hasRole(config('access.users.admin_role'));
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->status;
    }

    /**
     * @return bool
     */
    public function isConfirmed()
    {
        return $this->confirmed;
    }

    /**
     * @return bool
     */
    public function isPending()
    {
        return config('access.users.requires_approval') && !$this->confirmed;
    }

    public function getMyFriends()
    {
        $freiends_1 = Frindship::where('fisrt_user_id', auth()->user()->id)->where('accept', 1)->get(['second_user_id AS id']);
        $freiends_2 = Frindship::where('second_user_id', auth()->user()->id)->where('accept', 1)->get(['fisrt_user_id AS id']);
        $friends = [];
        foreach ($freiends_1 as $friend) {
            array_push($friends, $friend->id);
        }

        foreach ($freiends_2 as $friend) {
            array_push($friends, $friend->id);
        }

        $all_friends = User::find($friends);

        return $all_friends;
    }
}
