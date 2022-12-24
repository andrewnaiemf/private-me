<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use App\Models\Auth\Frindship;

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
        // $friends = Frindship::where(['fisrt_user_id' => auth()->user()->id, 'accept' => 1])
        //     ->orWhere(['second_user_id' => auth()->user()->id, 'accept' => 1])->get();

        // // who ask my for friend relation
        // $friend_requests = Frindship::where(['second_user_id' => auth()->user()->id, 'accept' => 0])->get();

        $freiends_1 = auth()->user()->friends1->where('accept', 1)->toArray();
        $freiends_2 = auth()->user()->friends2->where('accept', 1)->toArray();
        $freiends = array_merge($freiends_1, $freiends_2);

        //who asked my for frien relation
        $friend_requests = auth()->user()->friends2->where('accept', 0)->toArray();

        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            // 'last_name' => $this->last_name,
            'email' => $this->email,
            'picture' => $this->avatar_location,
            'question_id' => $this->question_id,
            'answer' => $this->answer,
            'confirmed' => $this->confirmed,
            'role' => optional($this->roles()->first())->name,
            //'permissions' => $this->permissions()->get(),
            'friends' => $freiends,
            'friend-requests' => $friend_requests,
            'status' => $this->status,
            'created_at' => $this->created_at->toIso8601String(),
            'updated_at' => $this->updated_at->toIso8601String(),
        ];
    }
}
