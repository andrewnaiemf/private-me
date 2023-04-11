<?php

namespace App\Repositories\Backend\Auth;

use App\Events\Backend\Auth\User\UserConfirmed;
use App\Events\Backend\Auth\User\UserCreated;
use App\Events\Backend\Auth\User\UserDeactivated;
use App\Events\Backend\Auth\User\UserDeleted;
use App\Events\Backend\Auth\User\UserPasswordChanged;
use App\Events\Backend\Auth\User\UserPermanentlyDeleted;
use App\Events\Backend\Auth\User\UserReactivated;
use App\Events\Backend\Auth\User\UserRestored;
use App\Events\Backend\Auth\User\UserUnconfirmed;
use App\Events\Backend\Auth\User\UserUpdated;
use App\Exceptions\GeneralException;
use App\Models\Auth\User;
use App\Models\Auth\Frindship;
use App\Models\Auth\Package;
use App\Models\Auth\Message;
use App\Notifications\Backend\Auth\UserAccountActive;
use App\Notifications\Frontend\Auth\UserNeedsConfirmation;
use App\Repositories\BaseRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;

/**
 * Class UserRepository.
 */
class UserRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = User::class;

    public function addFriend($friend_id)
    {
        // fisrt_user_id is the person who ask for friend relation
        // second_user_id is the person who has been asked for friend relation
        $user = auth()->user();
        $asked_for_frined = Frindship::where(["fisrt_user_id" => $user->id, "second_user_id" => $friend_id])->first();
        if ($asked_for_frined === null) {
            $friend_package = Package::where(['user_id'=>$friend_id])->first();
            if(! isset($friend_package)){
                return -1 ;
            }
            Frindship::create(["fisrt_user_id" => $user->id, "second_user_id" => $friend_id]);
            return 0;
        }

        if ($asked_for_frined->accept == -1) {
            $asked_for_frined->update(['accept'=>0]);
            return 0;
        }

        if ($asked_for_frined->accept == 1) {
            return 1;
        }

        if ($asked_for_frined->accept == 0) {
            return 2;
        }
    }

    public function acceptFriend($friend_id)
    {
        // fisrt_user_id is the person who ask for friend relation
        // second_user_id is the person who has been asked for friend relation
        $user = auth()->user();
        $relation = Frindship::where(["fisrt_user_id" => $friend_id, "second_user_id" => $user->id])->first();
        if ($relation) {
            $relation->accept = 1;
            $relation->save();
            return 1;
        }
        return 0;
    }

    public function cancelFriend($friend_id)
    {
        // $user = auth()->user();
        // $relation = Frindship::whereIn('fisrt_user_id', [auth()->user()->id, $friend_id])
        //     ->orwhereIn('second_user_id', [auth()->user()->id, $friend_id])->first();

        // $relation->update([ 'accept' => -1 ]);
        $user = auth()->user();
        $relation = Frindship::where(["fisrt_user_id" => $friend_id, "second_user_id" => $user->id])->first();

        $relation->update([ 'accept' => -1 ]);
        $relation->save();
    }

    // public function checkFriendRequest()
    // {
    //     $user = auth()->user();
    //     // people send freind request to me and i have not accept yet, and people who i request and they accept my request
    //     $freiends_requeset = Frindship::where('second_user_id', auth()->user()->id)
    //         ->where('accept', 0)
    //         ->orWhere(function ($q) {
    //             $q->where('fisrt_user_id', auth()->user()->id);
    //             $q->where('accept', 1);
    //         })
    //         ->get(['id AS Friend_ship_id', 'is_read', 'accept', 'fisrt_user_id AS sender_id', 'second_user_id AS reciver_id']);
    //     $friends = [];
    //     $reciver_ = [];
    //     $is_read = [];
    //     $friend_ship_id = [];

    //     foreach ($freiends_requeset as $friend) {
    //         if ($friend->accept == true) {
    //             array_push($friends, $friend->reciver_id);
    //             array_push($reciver_, $friend->reciver_id);
    //             array_push($is_read, $friend->is_read);
    //             array_push($friend_ship_id, $friend->Friend_ship_id);
    //         } else {
    //             array_push($friends, $friend->sender_id);
    //             array_push($is_read, $friend->is_read);
    //             array_push($friend_ship_id, $friend->Friend_ship_id);
    //         }
    //     }
    //     $all_friends_request = User::find($friends);

    //     $arr = $all_friends_request->toArray();
    //     foreach ($arr as $key => $item) {
    //         if (in_array($item['id'], $reciver_)) {
    //             $arr[$key]['msg'] = 1;
    //             $arr[$key]['friend_ship_id'] = $friend_ship_id[$key];
    //             $arr[$key]['is_read'] = $is_read[$key];
    //         } else {
    //             // some one ask you for accept freindship
    //             $arr[$key]['msg'] = 0;
    //             $arr[$key]['friend_ship_id'] = $friend_ship_id[$key];
    //             $arr[$key]['is_read'] = $is_read[$key];
    //         }
    //     }
    //     return $arr;
    // }

    // public function checkFriendRequest()
    // {
    //     $user = auth()->user();
    //     // people send freind request to me and i have not accept yet, and people who i request and they accept my request
    //     $freiends_requeset = Frindship::where('second_user_id', auth()->user()->id)
    //         ->whereIn('accept', [0 , 1 ,-1])
    //         ->orWhere(function ($q) {
    //             $q->where('fisrt_user_id', auth()->user()->id);
    //             $q->whereIn('accept', [0 , 1 ,-1]);
    //         })
    //         ->get(['id AS Friend_ship_id', 'is_read', 'accept', 'fisrt_user_id AS sender_id', 'second_user_id AS reciver_id']);
    //     $friends = [];
    //     $reciver_ = [];
    //     $is_read = [];
    //     $friend_ship_id = [];

    //     $friend_And_request_for_sent_requests_status = [];//relationId:friendId
    //     $friend_And_request_for_recieved_requests_status = [];//relationId:friendId
    //     foreach ($freiends_requeset as $friend) {
    //         if ($friend->sender_id == auth()->user()->id) {//i send the request
                
    //             $friend_And_request_for_sent_requests_status[$friend->accept] = $friend->reciver_id;
    //             array_push($friends, $friend->reciver_id);
    //             array_push($reciver_, $friend->reciver_id);
    //             array_push($is_read, $friend->is_read);
    //             array_push($friend_ship_id, $friend->Friend_ship_id);
    //         } else {//i recieved the request

    //             $friend_And_request_for_recieved_requests_status[$friend->accept] = $friend->sender_id;
    //             array_push($friends, $friend->sender_id);
    //             array_push($is_read, $friend->is_read);
    //             array_push($friend_ship_id, $friend->Friend_ship_id);
    //         }
    //     }

    //     $all_friends_request = User::find($friends);
    //     $arr = $all_friends_request->toArray();
    //     foreach ($arr as $key => $item) {
    //         // dd($friend_And_request_for_recieved_requests_status);
    //         if (in_array($item['id'], $friend_And_request_for_sent_requests_status)) {
    //             if(! empty(array_keys($friend_And_request_for_sent_requests_status,$item['id']))){

    //                 $friendShipStatus = array_keys($friend_And_request_for_sent_requests_status,$item['id'])[0];
    //                 if( $friendShipStatus == 1 ){
    //                     $arr[$key]['msg'] = 1;
    //                 }
    //                 // else{
    //                 //     $arr[$key]['msg'] = 0;
    //                 // }
    //                 $arr[$key]['friend_ship_id'] = $friend_ship_id[$key];
    //                 $arr[$key]['is_read'] = $is_read[$key];
    //             }
    //         } else if(! empty($friend_And_request_for_recieved_requests_status)) {
    //             // some one ask you for accept freindship
    //             if(! empty(array_keys($friend_And_request_for_recieved_requests_status,$item['id']))){
    //                 $friendShipStatus = array_keys($friend_And_request_for_recieved_requests_status,$item['id'])[0];
    //                 if( $friendShipStatus == -1 ){
    //                     $arr[$key]['msg'] = 3;
    //                 }else if( $friendShipStatus == 1){
    //                     $arr[$key]['msg'] = 2;
    //                 }else{
    //                     $arr[$key]['msg'] = 0;
    //                 }
    //                 $arr[$key]['friend_ship_id'] = $friend_ship_id[$key];
    //                 $arr[$key]['is_read'] = $is_read[$key];
    //             }
    //         }
    //     }
    //     return $arr;
    // }
    public function checkFriendRequest()
    {
        $user = auth()->user();
        $package = Package::where(["user_id" => $user->id])->first();
        
        // people send freind request to me and i have not accept yet, and people who i request and they accept my request
        $freiends_requeset = Frindship::where('second_user_id', auth()->user()->id)
            ->whereIn('accept', [0 , 1 ,-1])
            ->orWhere(function ($q) {
                $q->where('fisrt_user_id', auth()->user()->id);
                $q->where('accept', 1);
            })
            ->get(['id AS Friend_ship_id', 'is_read', 'accept', 'fisrt_user_id AS sender_id', 'second_user_id AS reciver_id']);
        $friends = [];
        $reciver_ = [];
        $is_read = [];
        $friend_ship_id = [];

        $friend_And_request_for_sent_requests_status = [];//relationId:friendId
        $friend_And_request_for_recieved_requests_status = [];//relationId:friendId
        foreach ($freiends_requeset as $friend) {
            if ($friend->sender_id == auth()->user()->id) {//i send the request
                
                $friend_And_request_for_sent_requests_status[$friend->reciver_id] = $friend->accept;
                array_push($friends, $friend->reciver_id);
                array_push($reciver_, $friend->reciver_id);
                array_push($is_read, $friend->is_read);
                array_push($friend_ship_id, $friend->Friend_ship_id);
            } else {//i recieved the request

                $friend_And_request_for_recieved_requests_status[$friend->sender_id] = $friend->accept;
                array_push($friends, $friend->sender_id);
                array_push($is_read, $friend->is_read);
                array_push($friend_ship_id, $friend->Friend_ship_id);
            }
        }

        $all_friends_request = User::find($friends);
        $arr = $all_friends_request->toArray();
        // dd($arr, $friend_And_request_for_sent_requests_status,$friend_ship_id);
        foreach ($arr as $key => $item) {
            // dd($friend_And_request_for_recieved_requests_status);

            if (in_array($item['id'], array_keys($friend_And_request_for_sent_requests_status))) {
                // dd(in_array($item['id'] , array_keys($friend_And_request_for_sent_requests_status)));
                if(in_array($item['id'] , array_keys($friend_And_request_for_sent_requests_status))){

                    // $friendShipStatus = array_keys($friend_And_request_for_sent_requests_status,$item['id'])[0];
                    $friendShipStatus = $friend_And_request_for_sent_requests_status[$item['id']];

                    if( $friendShipStatus == 1 ){
                        $arr[$key]['msg'] = 1;
                    }
                    // else{
                    //     $arr[$key]['msg'] = 0;
                    // }
                    $arr[$key]['friend_ship_id'] = $friend_ship_id[$key];
                    $arr[$key]['is_read'] = $is_read[$key];
                }
            } else {
                // some one ask you for accept freindship
                // if(! empty(array_keys($friend_And_request_for_recieved_requests_status,$item['id']))){
                    $friendShipStatus = $friend_And_request_for_recieved_requests_status[$item['id']];
                    if( $friendShipStatus == -1 ){
                        $arr[$key]['msg'] = 3;
                    }else if( $friendShipStatus == 1){
                        $arr[$key]['msg'] = 2;
                    }else{
                        $arr[$key]['msg'] = 0;
                    }
                    $arr[$key]['friend_ship_id'] = $friend_ship_id[$key];
                    $arr[$key]['is_read'] = $is_read[$key];
                // }
            }
            $arr[$key]['is_subscribed'] = isset($package) ? true : false;
        }
        return $arr;
    }

    function getfolderSize($dir)
    {
        $size = 0;

        foreach (glob(rtrim($dir, '/') . '/*', GLOB_NOSORT) as $each) {
            $size += is_file($each) ? filesize($each) : $this->getfolderSize($each);
        }

        return $size;
    }

    function getInternalFilesCount($dir)
    {
        $files_count = 0;
        foreach (glob("${dir}/*") as $fn) {
            if (is_dir($fn)) {
                $files_count  += $this->getInternalFilesCount($fn);
            } else {
                $files_count += 1;
            }
        }

        return $files_count;
    }

    function readNotification($id)
    {
        $frindship = Frindship::find($id);
        $frindship->is_read = 1;
        $frindship->save();
        return 1;
    }

    function deleteFriend($id)
    {
        $frindship = Frindship::where(["fisrt_user_id" => auth()->user()->id, "second_user_id" => $id])->first();
        if ($frindship) {
            $frindship->delete();
        }
        $frindship = Frindship::where(["fisrt_user_id" => $id, "second_user_id" => auth()->user()->id])->first();
        if ($frindship) {
            $frindship->delete();
        }

        $messages = Message::where(['user_id' => $id])->delete();

        return 1;
    }

    /**
     * @param int  $status
     * @param bool $trashed
     *
     * @return mixed
     */
    public function getForDataTable($status = 1, $trashed = false)
    {
        /**
         * Note: You must return deleted_at or the User getActionButtonsAttribute won't
         * be able to differentiate what buttons to show for each row.
         */
        $dataTableQuery = $this->query()
            ->select([
                'users.id',
                'users.first_name',
                'users.last_name',
                'users.email',
                'users.question_id',
                'users.answer',
                'users.status',
                'users.confirmed',
                'users.created_at',
                'users.updated_at',
                'users.deleted_at',
            ]);

        if ($trashed == 'true') {
            return $dataTableQuery->onlyTrashed();
        }

        // active() is a scope on the UserScope trait
        return $dataTableQuery->active($status);
    }

    public function retrieveList(array $options = [])
    {
        $perPage = isset($options['per_page']) ? (int) $options['per_page'] : 20;
        $orderBy = isset($options['order_by']) && in_array($options['order_by'], $this->sortable) ? $options['order_by'] : 'created_at';
        $order = isset($options['order']) && in_array($options['order'], ['asc', 'desc']) ? $options['order'] : 'desc';
        $query = $this->query()
            ->orderBy($orderBy, $order);

        if ($perPage == -1) {
            return $query->get();
        }

        return $query->paginate($perPage);
    }

    public function RetrieveSearchList(array $options = [], String $user_name)
    {
        $perProduct = isset($options['per_page']) ? (int) $options['per_page'] : 20;
        $orderBy = isset($options['order_by']) && in_array($options['order_by'], $this->sortable) ? $options['order_by'] : 'created_at';
        $order = isset($options['order']) && in_array($options['order'], ['asc', 'desc']) ? $options['order'] : 'desc';
        $query = $this->query()
            ->select([
                'users.id',
                'users.uuid',
                'users.first_name',
                'users.avatar_location',
                'users.email',
            ])
            //  ->where('status',0) // avilable products => 0 , disabled products => 1
            ->where('email','!=',auth()->user()->email)
            ->where('first_name', 'like', "%{$user_name}%")
            // ->orderBy('sort')
            ->orderBy('updated_at', $order)
            ->orderBy($orderBy, $order);

            return  Datatables::of($query)
            ->addColumn('is_friend', function ($user) {
                $friendShip = Frindship::whereIn('fisrt_user_id', [auth()->user()->id, $user->id])
                    ->whereIn('second_user_id', [auth()->user()->id, $user->id])
                    ->whereIn('accept',[0,1])->first();
                if(isset($friendShip['accept']) && $friendShip['accept'] == 1){
                    return 1;

                }else if(isset($friendShip['accept']) && $friendShip['accept'] == 0){
                    return 2;

                }else{
                    return 0;
                }
            })->make(true);


            // $freiends_requeset = Frindship::where('second_user_id', auth()->user()->id)
            // ->whereIn('accept', [0 , 1 ,-1])
            // ->orWhere(function ($q) {
            //     $q->where('fisrt_user_id', auth()->user()->id);
            //     $q->where('accept', 1);
            // })


        //     $friendShip =  Frindship::whereIn('fisrt_user_id', [auth()->user()->id])
        //         ->whereIn('second_user_id', [auth()->user()->id])
        //         ->exists();
        //         dd( $friendShip);
        //    
        // return  Datatables::of($query)
        //     ->addColumn('is_friend',  $friendShipStatus)->make(true);
        // if ($perProduct == -1) {
        //     return $query->get();
        // }

        // return $query->paginate($perProduct);
    }

    /**
     * @param array $data
     *
     * @throws \Exception
     * @throws \Throwable
     * @return User
     */
    public function create(array $data, $img = null)
    {
        //// $roles = $data['assignees_roles'];
        $roles = 1;
        ////$permissions = $data['permissions'];
        $permissions = 1;
        ////unset($data['assignees_roles']);
        ////unset($data['permissions']);

        $user = $this->createUserStub($data);

        if (isset($img)) {
            $path = $img->storePublicly('public/profile_photo');
            $user['avatar_location'] = str_replace("public", "public/storage", $path);
        }

        return DB::transaction(function () use ($user, $data, $roles, $permissions) {
            if ($user->save()) {
                //Attach new roles
                ////$user->attachRoles($roles);

                // Attach New Permissions
                ////$user->attachPermissions($permissions);

                //Send confirmation email if requested and account approval is off
                if (isset($data['confirmation_email']) && $user->confirmed == 0) {
                    $user->notify(new UserNeedsConfirmation($user->confirmation_code));
                }

                event(new UserCreated($user));

                return $user;
            }

            throw new GeneralException(__('exceptions.backend.access.users.create_error'));
        });
    }

    /**
     * @param \App\Models\Auth\User  $user
     * @param array $data
     *
     * @throws GeneralException
     * @throws \Exception
     * @throws \Throwable
     * @return \App\Models\Auth\User
     */
    public function update(User $user, array $data, $img = null)
    {
        //// $roles = $data['assignees_roles'];
        $roles = 1;
        ////$permissions = $data['permissions'];
        $permissions = 1;
        ////unset($data['assignees_roles']);
        ////unset($data['permissions']);

        if (isset($img)) {
            $path = $img->storePublicly('public/profile_photo');
            $data['avatar_location'] = str_replace("public", "public/storage", $path);
        }
       

        return DB::transaction(function () use ($user, $data, $roles, $permissions) {
            if (isset($data['question_id'])) {
                $user->question_id = $data['question_id'];
            }

            if (isset($data['answer'])) {
                $user->answer = $data['answer'];
            }
            $user->save();
            $user->status = isset($data['status']) && $data['status'] == '1' ? 1 : 0;
            $user->confirmed = isset($data['confirmed']) && $data['confirmed'] == '1' ? 1 : 0;

            if ($user->update($data)) {
                $user->roles()->sync($roles);
                $user->permissions()->sync($permissions);

                event(new UserUpdated($user));

                return $user;
            }

            throw new GeneralException(__('exceptions.backend.access.users.update_error'));
        });
    }

    /**
     * Delete User.
     *
     * @param App\Models\Auth\User $user
     *
     * @throws GeneralException
     *
     * @return bool
     */
    public function delete(User $user, $password)
    {
        if (!\Hash::check($password, auth()->user()->password)) {
            throw new GeneralException(__('exceptions.backend.access.users.delete_error'));
        }

        // if (access()->id() == $user->id) {
        //     throw new GeneralException(__('exceptions.backend.access.users.cant_delete_self'));
        // }
// dd($user->delete());
        if ($user->delete()) {
            event(new UserDeleted($user));

            Storage::deleteDirectory('public/' . auth()->user()->id);
            return true;
        }

        throw new GeneralException(__('exceptions.backend.access.users.delete_error'));
    }

    /**
     * @param \App\Models\Auth\User $user
     * @param      $input
     *
     * @throws GeneralException
     * @return \App\Models\Auth\User
     */
    public function updatePassword($input): User
    {
        $user = User::find(auth()->user()->id);
        if (\Hash::check($input['old_password'], auth()->user()->password)) {
            if ($user->update(['password' => bcrypt($input['password'])])) {
                event(new UserPasswordChanged($user));

                return $user;
            }

            throw new GeneralException(__('exceptions.backend.access.users.update_password_error'));
        } else {
            throw new GeneralException('password mismatch');
        }
    }

    /**
     * @param \App\Models\Auth\User $user
     * @param int $status
     *
     * @throws GeneralException
     * @return \App\Models\Auth\User
     */
    public function mark(User $user, $status): User
    {
        if (access()->id() == $user->id && $status == 0) {
            throw new GeneralException(__('exceptions.backend.access.users.cant_deactivate_self'));
        }

        $user->status = $status;

        switch ($status) {
            case 0:
                event(new UserDeactivated($user));
                break;
            case 1:
                event(new UserReactivated($user));
                break;
        }

        if ($user->save()) {
            return $user;
        }

        throw new GeneralException(__('exceptions.backend.access.users.mark_error'));
    }

    /**
     * @param \App\Models\Auth\User $user
     *
     * @throws GeneralException
     * @return \App\Models\Auth\User
     */
    public function confirm(User $user): User
    {
        if ($user->confirmed) {
            throw new GeneralException(__('exceptions.backend.access.users.already_confirmed'));
        }

        $user->confirmed = true;
        $confirmed = $user->save();

        if ($confirmed) {
            event(new UserConfirmed($user));

            // Let user know their account was approved
            if (config('access.users.requires_approval')) {
                $user->notify(new UserAccountActive);
            }

            return $user;
        }

        throw new GeneralException(__('exceptions.backend.access.users.cant_confirm'));
    }

    /**
     * @param \App\Models\Auth\User $user
     *
     * @throws GeneralException
     * @return \App\Models\Auth\User
     */
    public function unconfirm(User $user): User
    {
        if (!$user->confirmed) {
            throw new GeneralException(__('exceptions.backend.access.users.not_confirmed'));
        }

        if ($user->id === 1) {
            // Cant un-confirm admin
            throw new GeneralException(__('exceptions.backend.access.users.cant_unconfirm_admin'));
        }

        if ($user->id === auth()->id()) {
            // Cant un-confirm self
            throw new GeneralException(__('exceptions.backend.access.users.cant_unconfirm_self'));
        }

        $user->confirmed = false;
        $unconfirmed = $user->save();

        if ($unconfirmed) {
            event(new UserUnconfirmed($user));

            return $user;
        }

        throw new GeneralException(__('exceptions.backend.access.users.cant_unconfirm'));
    }

    /**
     * @param \App\Models\Auth\User $user
     *
     * @throws GeneralException
     * @throws \Exception
     * @throws \Throwable
     * @return \App\Models\Auth\User
     */
    public function forceDelete(User $user)
    {
        if ($user->deleted_at === null) {
            throw new GeneralException(__('exceptions.backend.access.users.delete_first'));
        }

        return DB::transaction(function () use ($user) {
            // Delete associated relationships
            $user->passwordHistories()->delete();
            $user->providers()->delete();

            if ($user->forceDelete()) {
                event(new UserPermanentlyDeleted($user));

                return true;
            }

            throw new GeneralException(__('exceptions.backend.access.users.delete_error'));
        });
    }

    /**
     * @param \App\Models\Auth\User $user
     *
     * @throws GeneralException
     * @return \App\Models\Auth\User
     */
    public function restore(User $user): User
    {
        if ($user->deleted_at === null) {
            throw new GeneralException(__('exceptions.backend.access.users.cant_restore'));
        }

        if ($user->restore()) {
            event(new UserRestored($user));

            return $user;
        }

        throw new GeneralException(__('exceptions.backend.access.users.restore_error'));
    }

    /**
     * @param  $input
     *
     * @return mixed
     */
    protected function createUserStub($input)
    {
        $user = self::MODEL;
        $user = new $user();
        $user->first_name = $input['first_name'];
        // $user->last_name = $input['last_name'];
        $user->question_id = $input['question_id'];
        $user->answer = $input['answer'];
        $user->email = $input['email'];
        $user->password = bcrypt($input['password']);
        $user->status = isset($input['status']) ? 1 : 0;
        $user->confirmation_code = md5(uniqid(mt_rand(), true));
        $user->confirmed = isset($input['confirmed']) ? 1 : 0;
        $user->created_by = null;

        return $user;
    }

    /**
     * @param  $roles
     *
     * @throws GeneralException
     */
    protected function checkUserRolesCount($roles)
    {
        //User Updated, Update Roles
        //Validate that there's at least one role chosen
        if (count($roles) == 0) {
            throw new GeneralException(__('exceptions.backend.access.users.role_needed'));
        }
    }

    /**
     * @return mixed
     */
    public function getUnconfirmedCount(): int
    {
        return $this->query()
            ->where('confirmed', false)
            ->count();
    }

    /**
     * @param int    $paged
     * @param string $orderBy
     * @param string $sort
     *
     * @return mixed
     */
    public function getActivePaginated($paged = 25, $orderBy = 'created_at', $sort = 'desc'): LengthAwarePaginator
    {
        return $this->query()
            ->with('roles', 'permissions', 'providers')
            ->active()
            ->orderBy($orderBy, $sort)
            ->paginate($paged);
    }

    /**
     * @param int    $paged
     * @param string $orderBy
     * @param string $sort
     *
     * @return LengthAwarePaginator
     */
    public function getInactivePaginated($paged = 25, $orderBy = 'created_at', $sort = 'desc'): LengthAwarePaginator
    {
        return $this->query()
            ->with('roles', 'permissions', 'providers')
            ->active(false)
            ->orderBy($orderBy, $sort)
            ->paginate($paged);
    }

    /**
     * @param int    $paged
     * @param string $orderBy
     * @param string $sort
     *
     * @return LengthAwarePaginator
     */
    public function getDeletedPaginated($paged = 25, $orderBy = 'created_at', $sort = 'desc'): LengthAwarePaginator
    {
        return $this->query()
            ->with('roles', 'permissions', 'providers')
            ->onlyTrashed()
            ->orderBy($orderBy, $sort)
            ->paginate($paged);
    }

    // -------------
    public function createOrUpdatePackage($data)
    {
        Package::updateOrCreate(["user_id" => auth()->user()->id], $data);
        if (isset($data['plan_id'])) {
            $user = User::find(auth()->user()->id);
            $user->plan_id = $data['plan_id'];
            $user->save();
        }
    }

    public function deletePackage($user_id)
    {
        $package = Package::where(["user_id" => $user_id])->first();
        if ($package) {
            $package->delete();
        } else {
            throw new GeneralException("User have no package");
        }
    }
}
