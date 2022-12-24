<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Auth\Frindship;
use App\Models\Auth\User;

class UserResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     *
     * @return array
     */
    public function toArray($request)
    {
        $freiends_1 = Frindship::where('fisrt_user_id', $this->id)->where('accept', 1)->get(['second_user_id AS id']);
        $freiends_2 = Frindship::where('second_user_id', $this->id)->where('accept', 1)->get(['fisrt_user_id AS id']);
        $friends = [];
        foreach ($freiends_1 as $friend) {
            array_push($friends, $friend->id);
        }

        foreach ($freiends_2 as $friend) {
            array_push($friends, $friend->id);
        }

        $all_friends = User::select(['id', 'uuid', 'first_name', 'avatar_location'])->whereIn('id', $friends)->get();


        $freiends_3 = Frindship::where('fisrt_user_id', $this->id)->where('accept', 0)->get(['second_user_id AS id']);
        $freiends_4 = Frindship::where('second_user_id', $this->id)->where('accept', 0)->get(['fisrt_user_id AS id']);
        $friends_request = [];
        foreach ($freiends_3 as $friend) {
            array_push($friends_request, $friend->id);
        }

        foreach ($freiends_4 as $friend) {
            array_push($friends_request, $friend->id);
        }

        $all_friends_request = User::select(['id', 'uuid', 'first_name', 'avatar_location'])->whereIn('id', $friends_request)->get();

        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'first_name' => $this->first_name,
            // 'last_name' => $this->last_name,
            'email' => $this->email,
            'package' => $this->package,
            'plan' => $this->plan_id,
            'picture' => $this->avatar_location,
            'question_id' => $this->question_id,
            'answer' => $this->answer,
            'confirmed' => $this->confirmed,
            'role' => optional($this->roles()->first())->name,
            //'permissions' => $this->permissions()->get(),
            'friends' => $all_friends,
            'friend-requests' => $all_friends_request,
            'status' => $this->status,
            'created_at' => $this->created_at->toIso8601String(),
            'updated_at' => $this->updated_at->toIso8601String(),
        ];
    }
}
