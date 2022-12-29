<?php

namespace App\Http\Controllers\Api\V1;

use App\Exceptions\GeneralException;
use App\Http\Requests\Backend\Auth\User\ManageUserRequest;
use App\Http\Requests\Backend\Auth\User\StoreUserRequest;
use App\Http\Requests\Backend\Auth\User\UpdateUserRequest;
use App\Http\Requests\Backend\Api\ApiRequest;
use App\Http\Resources\UserResource;
use App\Models\Auth\Advertisement;
use App\Models\Auth\User;
use App\Models\Auth\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Backend\Auth\UserRepository;
use Validator;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Exists;
use App\Models\Auth\Plan;
use App\Models\Auth\Message;
use App\Models\Auth\Frindship;
use App\Models\Auth\PasswordHistory;

define('_500MB', 500000000);

/**
 * @group Authentication
 *
 * Class AuthController
 *
 * Fullfills all aspects related to authenticate a user.
 */
class UserController extends APIController
{
    protected $repository;
    /**
     * __construct.
     *
     * @param $repository
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(ApiRequest $request)
    {
        $collection = $this->repository->retrieveList($request->all());

        return UserResource::collection($collection);
    }

    public function show(ApiRequest $request, User $user)
    {
        return new UserResource($user);
    }

    public function addFriend(ApiRequest $request, $friend_id)
    {
        $is_demand = $this->repository->addFriend($friend_id);

        if ($is_demand == -1) {
            return response()->json(["msg" => "This friend isn't subscribed to any package", "success" => false]);
        }

        if ($is_demand == 1) {
            return response()->json(["msg" => "you are friends", "success" => true]);
        } else if ($is_demand == 0) {


            //notify the reciever "" that the sender(user login) sent to you a friend request "".
            $reciever = User::find($friend_id);
            $senderName = User::find(auth()->user()->id)->first_name;
            $msg = $senderName .' send to you a friend request .' ; 
            $notificationType = 'friendRequest'; 
            $this->sendWebNotification($notificationType , $reciever , $msg);


            return response()->json(["msg" => "wait for acceptance", "success" => false]);
        } else {
            return response()->json(["msg" => "you asked before, wait for acceptance", "success" => false]);
        }
    }

    public function acceptFriend(ApiRequest $request, $friend_id)
    {
        $res = $this->repository->acceptFriend($friend_id);
        if ($res == 1) {


             //notify the reciever "" that the sender(user login) accept your friend request "".
             $reciever = User::find($friend_id);
             $senderName = User::find(auth()->user()->id)->first_name;
             $msg ='You and '. $senderName .' become friends .' ; 
             $notificationType = 'acceptFriendRequest'; 
             $this->sendWebNotification($notificationType , $reciever, $msg);


            return response()->json(["msg" => "you become friends", "success" => true]);
        } else {
            return response()->json(["msg" => "wait for acceptance", "success" => false]);
        }
    }

    public function cancelFriend(ApiRequest $request, $friend_id)
    {
        $this->repository->cancelFriend($friend_id);

         //notify the reciever "" that the sender(user login) cancel your friend request "".
         $reciever = User::find($friend_id);
         $senderName = User::find(auth()->user()->id)->first_name;
         $msg = $senderName .' cancel your friend request .' ; 
         $notificationType = 'acceptFriendRequest'; 
         $this->sendWebNotification($notificationType , $reciever, $msg);

        return response()->json(["msg" => "you canceled friendship", "success" => true]);
    }

    public function checkFriendRequest(ApiRequest $request)
    {
        $friend_request = $this->repository->checkFriendRequest();
        return $friend_request;
    }

    public function store(StoreUserRequest $request)
    {
        $request->last_name = ' ';
        $user = $this->repository->create($request->validated(), $request->file('avatar_location'));

        $images_folder = __DIR__ . '/../../../../../storage/app/public/' . $user->id . '/' . $request->type . '/Images/Default';
        $files_folder = __DIR__ . '/../../../../../storage/app/public/' . $user->id . '/' . $request->type . '/Files/Default';
        $videos_folder = __DIR__ . '/../../../../../storage/app/public/' . $user->id . '/' . $request->type . '/Videos/Default';

        if (!file_exists($images_folder)) {
            File::makeDirectory($images_folder, 0777, true, true);
        }

        if (!file_exists($files_folder)) {
            File::makeDirectory($files_folder, 0777, true, true);
        }

        if (!file_exists($videos_folder)) {
            File::makeDirectory($videos_folder, 0777, true, true);
        }

        return (new UserResource($user))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function readNotification(ApiRequest $request)
    {
        $this->repository->readNotification($request->id);
        return response()->json(["success" => true]);
    }

    public function deleteFriend(ApiRequest $request)
    {
        $this->repository->deleteFriend($request->id);
        return response()->json(["success" => true]);
    }

    public function usedSpace(ApiRequest $request)
    {
        $user_folder = storage_path('app/public/' . auth()->user()->id);
        $used_size = $this->repository->getfolderSize($user_folder);
        $user = Package::where('user_id', auth()->user()->id)->first();
        $limit_size = _500MB;

        if ($user) {
            if ($user->size_bytes) {
                $limit_size = (int) $user->size_bytes;
            }
        }

        return response()->json(["success" => true, "used_size" => $used_size, "total_size" => $limit_size]);
    }

    public function uploadFile(ApiRequest $request)
    {
        $user_folder = storage_path('app/public/' . auth()->user()->id);
        $limit_size = _500MB;
        $user = Package::where('user_id', auth()->user()->id)->first();
        if ($user) {
            if ($user->size_bytes) {
                $limit_size = (int) $user->size_bytes;
            }
        }

        // Folder should be not more than 500MB
        if ($this->repository->getfolderSize($user_folder) >= $limit_size) {
            return response()->json([
                "message" =>  "Your free space has been excceded, please subscribe for more space.",
                "success" => "false",
                "IsSpaceError" => true
            ], 400);
        }
        clearstatcache();
        $files = $request->file('files');
        $paths = "";
        if (isset($files)) {
            foreach ($files as $file) {
                $fileName = $file->getClientOriginalName();
                $paths .= \Storage::putFileAs('public/' . auth()->user()->id . '/Files/' . $request->folder_name, $file, $fileName);
                $paths .= ",";
            }

            return '{"message": "uploaded successfully"}';
        } else {
            return '{"message": "Error, there is no file to upload"}';
        }
    }

    public function getAllFilesInDir(ApiRequest $request, $type)
    {
        $file = '';
        $link = '';
        if (isset($type)) {
            $file = __DIR__ . '/../../../../../storage/app/public/' . auth()->user()->id . '/' . $type;
            $link = 'storage/' . auth()->user()->id . '/' . $type . "/";
        } else {
            $file = __DIR__ . '/../../../../../storage/app/public/' . auth()->user()->id;
            $link = 'storage/' . auth()->user()->id . "/";
        }
        if (file_exists($file)) {
            // $files = [];
            $filess = [];
            $count = 0;

            $all_files = array();
            foreach (scandir($file) as $fil) {
                if ($fil != '.' && $fil != '..') {

                    // Files count in Folder
                    $directory = $file . "/" . $fil;
                    $files2 = glob($directory . "/*");
                    if ($files2) {
                        $count += count($files2);

                        // return 4 files from directory
                        $internal_files = scandir($directory);
                        foreach ($internal_files as $internal_file) {
                            if ($internal_file == '.' || $internal_file == '..') {
                                continue;
                            }
                            $file_ = asset($link . $fil . '/' . ($internal_file ?? null)); // because [0] = "." [1] = ".." 
                            array_push($all_files, array('file' => $file_, 'date' => date("F d Y H:i:s.", filemtime($file . '/' . $fil))));
                        }

                        // array_push($files, array('file' => $fil, 'link' => asset($link . $fil), 'count' => $filecount, 'files' => $all_files, 'date' => date("F d Y H:i:s.", filemtime($file . '/' . $fil))));
                    }
                }
            }
            $filess +=  ["total" => $count];
            $filess += ["data" => $all_files];
            return response()->json($filess);
        }
        return response()->json(["message" => "Folder Not Found!"]);
    }

    public function getFiles(ApiRequest $request)
    {
        $file = '';
        $link = '';
        if (isset($request->path)) {
            $file = __DIR__ . '/../../../../../storage/app/public/' . auth()->user()->id . '/' . $request->path;
            $link = 'storage/' . auth()->user()->id . '/' . $request->path . "/";
        } else {
            $file = __DIR__ . '/../../../../../storage/app/public/' . auth()->user()->id;
            $link = 'storage/' . auth()->user()->id . "/";
        }
        if (file_exists($file)) {
            $files = [];
            $filess = [];
            $count = 0;
            foreach (scandir($file) as $fil) {
                if ($fil != '.' && $fil != '..') {

                    // Files count in Folder
                    $directory = $file . "/" . $fil;
                    $files2 = glob($directory . "/*");
                    if ($files2) {
                        $filecount = count($files2);

                        // return 4 files from directory
                        $internal_files = scandir($directory);
                        $file_1 = asset($link . $fil . '/' . ($internal_files[2] ?? null)); // because [0] = "." [1] = ".." 
                        $file_2 = asset($link . $fil . '/' . ($internal_files[3] ?? null));
                        $file_3 = asset($link . $fil . '/' . ($internal_files[4] ?? null));
                        $file_4 = asset($link . $fil . '/' . ($internal_files[5] ?? null));

                        $four_files = [$file_1, $file_2, $file_3, $file_4];
                        array_push($files, array('file' => $fil, 'link' => asset($link . $fil), 'count' => $filecount, 'internal_files' => $four_files, 'date' => date("F d Y H:i:s.", filemtime($file . '/' . $fil))));
                    } else {
                        $filecount = 0;
                        array_push($files, array('file' => $fil, 'link' => asset($link . $fil), 'count' => 0, 'internal_files' => [],  'date' => date("F d Y H:i:s.", filemtime($file . '/' . $fil))));
                    }

                    $count++;
                }
            }
            $filess +=  ["total" => $count];
            $filess += ["data" => $files];
            return response()->json($filess);
        }
        return response()->json(["message" => "Folder Not Found!"]);
    }

    public function DeleteFiles(ApiRequest $request)
    {
        if (\Hash::check($request->password, auth()->user()->password)) {
            foreach ($request->paths as $path) {
                $path_ = __DIR__ . '/../../../../../storage/app/public/' . auth()->user()->id . '/' . $path;
                if (!is_dir($path_)) {
                    // file
                    file_exists($path_) ? unlink($path_) : null;
                    return response()->json(["message" =>  "removed successfully"]);
                } else {
                    // Directory
                    Storage::deleteDirectory('public/' . auth()->user()->id . '/' . $path);
                    return response()->json(["message" => "removed successfully"]);
                }
            }
        } else {
            return response()->json(["message" => "Password mismatch"], 422);
        }
    }

    public function getstatistic(ApiRequest $request)
    {
        $images_count = 0;
        $images_path = __DIR__ . '/../../../../../storage/app/public/' . auth()->user()->id . '/Images';
        // if (file_exists($images_path)) {
        //     $images = new \FilesystemIterator($images_path, \FilesystemIterator::SKIP_DOTS);
        //     $images_count = iterator_count($images);
        // }

        $files_count = 0;
        $files_path = __DIR__ . '/../../../../../storage/app/public/' . auth()->user()->id . '/Files';
        // if (file_exists($files_path)) {
        //     $files = new \FilesystemIterator($files_path, \FilesystemIterator::SKIP_DOTS);
        //     $files_count = iterator_count($files);
        // }

        $videos_count = 0;
        $videos_path = __DIR__ . '/../../../../../storage/app/public/' . auth()->user()->id . '/Videos';
        // if (file_exists($videos_path)) {
        //     $videos = new \FilesystemIterator($videos_path, \FilesystemIterator::SKIP_DOTS);
        //     $videos_count = iterator_count($videos);
        // }

        $images_count = $this->repository->getInternalFilesCount($images_path);
        $files_count = $this->repository->getInternalFilesCount($files_path);
        $videos_count = $this->repository->getInternalFilesCount($videos_path);

        return response()->json([
            "images" => $images_count,
            "files" => $files_count,
            "videos" => $videos_count,
            "friends" => count(auth()->user()->getMyFriends())
        ]);
    }

    public function uploadImage(ApiRequest $request)
    {
        $user_folder = storage_path('app/public/' . auth()->user()->id);
        $limit_size = _500MB;
        $user = Package::where('user_id', auth()->user()->id)->first();
        if ($user) {
            $limit_size = (int) $user->size_bytes;
        }
        // Folder should be not more than 500MB
        if ($this->repository->getfolderSize($user_folder) >= $limit_size) {
            return response()->json([
                "message" =>  "Your free space has been excceded, please subscribe for more space.",
                "success" => "false",
                "IsSpaceError" => true
            ], 400);
        }
        clearstatcache();

        $images = $request->file('images');
        $paths = "";
        if (isset($images)) {
            foreach ($images as $image) {
                $fileName = $image->getClientOriginalName();
                $paths .= \Storage::putFileAs('public/' . auth()->user()->id . '/Images/' . $request->folder_name, $image, $fileName);
                $paths .= ",";
            }
            return '{"message": "uploaded successfully"}';
        } else {
            return '{"message": "Error, there is no file to upload"}';
        }
    }

    public function uploadVedio(ApiRequest $request)
    {
        $user_folder = storage_path('app/public/' . auth()->user()->id);
        $limit_size = _500MB;
        $user = Package::where('user_id', auth()->user()->id)->first();
        if ($user) {
            $limit_size = (int) $user->size_bytes;
        }
        // Folder should be not more than 500MB
        if ($this->repository->getfolderSize($user_folder) >= $limit_size) {
            return response()->json([
                "message" =>  "Your free space has been excceded, please subscribe for more space.",
                "success" => "false",
                "IsSpaceError" => true
            ], 400);
        }
        clearstatcache();

        $videos = $request->file('videos');
        $paths = "";
        if (isset($videos)) {
            foreach ($videos as $vedio) {
                $fileName = $vedio->getClientOriginalName();
                $paths .= \Storage::putFileAs('public/' . auth()->user()->id . '/Videos/' . $request->folder_name, $vedio, $fileName);
                $paths .= ",";
            }

            return '{"message": "uploaded successfully"}';
        } else {
            return '{"message": "Error, there is no file to upload"}';
        }
    }

    public function createFolder(ApiRequest $request)
    {
        $folder = __DIR__ . '/../../../../../storage/app/public/' . auth()->user()->id . '/' . $request->type . '/' . $request->folder_name;
        if (!file_exists($folder)) {
            File::makeDirectory($folder, 0777, true, true);

            return '{"message": "Folder created successfully"}';
        } else {
            return '{"message": "Folder already exist"}';
        }
    }

    public function renameFolder(ApiRequest $request)
    {
        $gg = __DIR__ . '/../../../../../storage/app/public/' . auth()->user()->id . '/' .  $request->path;
        $folder = 'public/' . auth()->user()->id . '/' .  $request->path;
        $old_name = $folder . '/' . $request->old_name;
        if (file_exists($gg)) {
            \Storage::move($old_name, $folder . '/' . $request->new_name);

            return '{"message": "Folder renamed successfully", "success" : true}';
        } else {
            return '{"message": ' . storage_path() . ', "success" : false}';
        }
    }

    public function searchUser(ApiRequest $request, $name)
    {
        $collection = $this->repository->RetrieveSearchList([], $name);

        return $collection;
    }

    public function updateMyInfo(Request $request)
    {
        $user = User::find(auth()->user()->id);
        $user_ = $this->repository->update($user, $request->toArray(), $request->file('avatar_location'));

        return new UserResource($user_);
    }

    public function destroyAccount(ApiRequest $request)
    {
        $user = auth()->user();
        $user_id = $user->id;
        
        if (!\Hash::check($password, auth()->user()->password)) {
            throw new GeneralException(__('exceptions.backend.access.users.delete_error'));
        }

        $user_password_history = PasswordHistory::where(['user_id'=>$user_id])->delete() ;
        $friends_requeset = Frindship::where('second_user_id', auth()->user()->id)
        ->whereIn('accept', [0 , 1 ,-1])
        ->orWhere(function ($q) {
            $q->where('fisrt_user_id', auth()->user()->id);
            $q->whereIn('accept', [0 , 1 ,-1]);
        })->delete();
        $messages = Message::where(['user_id'=>$user_id])->orWhere(['friend_id'=>$user_id])->delete();
        $package = Package::where(['user_id'=>$user_id])->delete();

        
        $this->repository->delete($user, $request->password);

        $dir = __DIR__ . '/../../../../../storage/app/public/' . $user_id;
        // $it = new \RecursiveDirectoryIterator($dir, \RecursiveDirectoryIterator::SKIP_DOTS);
        // $files = new \RecursiveIteratorIterator(
        //     $it,
        //     \RecursiveIteratorIterator::CHILD_FIRST
        // );
        // foreach ($files as $file) {
        //     if ($file->isDir()) {
        //         rmdir($file->getRealPath());
        //     } else {
        //         unlink($file->getRealPath());
        //     }
        // }
        // rmdir($dir);
        if (is_dir($dir)) { 
            $objects = scandir($dir);
            foreach ($objects as $object) { 
              if ($object != "." && $object != "..") { 
                if (is_dir($dir. DIRECTORY_SEPARATOR .$object) && !is_link($dir."/".$object))
                  rrmdir($dir. DIRECTORY_SEPARATOR .$object);
                else
                  unlink($dir. DIRECTORY_SEPARATOR .$object); 
              } 
            }
            rmdir($dir); 
          } 
        return response()->json(["msg" => "Your Account removed", "success" => true]);
    }

    // --------------------
    public function createOrUpdatePackage(ApiRequest $request)
    {

        $price = 0 ;
        $plan = Plan::find($request->plan_id);
        // $storage = ( (int)$plan->storage + (int)$plan->free_storage ) * 1073741824 ;//to cnvert form GB to bytes
        // dd($storage);
        switch ($request['plan_type']) {
            case '1':
                $price = $plan->price_year;
                break;
            
            default:
                $price = $plan->price_month;
                break;
        }

                
        // $data =[
        //     'price' => $price,
        //     'size_bytes' => $storage
        // ] ;

        // $package = Package::updateOrCreate(["user_id" => auth()->user()->id], $data);

        // if (isset($data['plan_id'])) {
        //     $user = User::find(auth()->user()->id);
        //     $user->plan_id = $data['plan_id'];
        //     $user->save();
        // }


        switch ($request['brand_id']) {

            case '2':
                $url = "https://app.private-me.net/mada/payment/";
                break;
            case '3':
                $url = "https://app.private-me.net/apple/payment/";
                break;
            
            default:
                $url = "https://app.private-me.net/payment/";
                break;
        }

        $url .=$price.'/'.$request['plan_id'].'/'.$request['plan_type'].'/'.auth()->user()->id;

        return response()->json(["msg" => "created successfully" , "url" => $url , "success" => true]);
    }

    public function deletePackage(ApiRequest $request)
    {
        Storage::deleteDirectory('public/' . $request->user_id);

        $this->repository->deletePackage($request->user_id);

        $images_folder = __DIR__ . '/../../../../../storage/app/public/' . $request->user_id . '/' . $request->type . '/Images/Default';
        $files_folder = __DIR__ . '/../../../../../storage/app/public/' . $request->user_id . '/' . $request->type . '/Files/Default';
        $videos_folder = __DIR__ . '/../../../../../storage/app/public/' . $request->user_id . '/' . $request->type . '/Videos/Default';

        if (!file_exists($images_folder)) {
            File::makeDirectory($images_folder, 0777, true, true);
        }

        if (!file_exists($files_folder)) {
            File::makeDirectory($files_folder, 0777, true, true);
        }

        if (!file_exists($videos_folder)) {
            File::makeDirectory($videos_folder, 0777, true, true);
        }

        return response()->json(["msg" => "user package deleted successfully", "success" => true]);
    }


    /////////////send messags//////////////
    public function send(ApiRequest $request){
        
        $user = User::find(auth()->user()->id);
        $message = Message::where([
            'user_id'=>auth()->user()->id,
            'friend_id'=>$request->friendId,
            'is_read'=>0
            ])->first();

        if(! isset( $message ) ){
            $friend = User::find($request->friendId);
            $friend_deviceToken = (array) json_decode($friend->device_token) ;

            $message=  Message::create([
                'firebase_id'=>strtotime($request->firebase_id),
                'user_id'=>auth()->user()->id,
                'friend_id'=>$request->friendId,
                'msg'=>$request->msg,
                'is_read'=>0,
                'type'=>$request->type
            ]);


        }else{
            $message->update(['msg'=>$request->msg,'firebase_id'=>strtotime($request->firebase_id)]);
        }

        $type = $message->type;

        switch ($type) {
        
         case '1':
             $message_type = 'file';
             break;
 
         case '2':
             $message_type = 'video';
             break;

         case '3':
             $message_type = 'image';
             break;
         
         default:
             $message_type =  substr($message->msg, 0, 5).'....';
             break;
        }
 
        $reciever = User::find($message->friend_id);
        $userName = User::find($message->user_id)->first_name;

        $msg =  $userName.' send you '.$message_type;
        $notificationType = 'message'; 
        $this->sendWebNotification($notificationType , $reciever, $msg);


        return response()->json(["msg" => "message sent successfully", "success" => true]);

    }
    //////////////////////////////////////


    public function sendWebNotification($notificationType , $reciever , $message)
    {

        $url = 'https://fcm.googleapis.com/fcm/send';
        $serverKey='AAAAGIXjgfY:APA91bGtS4VfEcC3r90nHGBG_0bTzszhSYgl2UwE1W3SitQjgbkPHle7fwaerx27RNeKY2szc0WAMzEvDHbRRad8EjnHsY1w8xgCqb2_XJKtpO_SSIeIDuCvz1cv50TSGDjhSlhG536K';

        switch ($notificationType) {
            case 'message':
                $type = 0;
                break;
            
            default:
                $type = 1;//notification acceptFriendRequest or friendRequest
                break;
        }
        
       $devices= ( array)(json_decode($reciever->device_token));
       $devs=[];
       foreach ($devices as $device) {
           array_push($devs, $device);
       }

      
        $data = [
            "registration_ids" =>array_values( $devs),
            "notification" => [
                "body" =>$message,
                "title" =>'Private me',
                "sound" => "notify.mp3",
            ],
            "data" => ["type"=>$type]
        ];
        $encodedData = json_encode($data);

        $headers = [
            'Authorization:key=' . $serverKey,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);

        // Execute post
        $result = curl_exec($ch);

        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }

        // Close connection
        curl_close($ch);

        // FCM response
        return($result);
    }


    //////////////////////get all messasges///////////////////
    /// الاصدفاء و نفس الوقت مشتركين ف باقه
    public function getMessages(ApiRequest $request){

        $subscribed_friends = Package::pluck('user_id');

        $messagses = Message::where(['user_id' => auth()->user()->id])->whereIn('friend_id' , $subscribed_friends  )->with('friend')
            // ->orderBy('id', 'DESC')
            // ->orderBy('is_read', 'ASC')
            ->get();
        
        return response()->json(["success" => true, "messagses" => $messagses]);
        
    }
    /////////////////////////////////////////////////////////


    public function readMessage($id) {

        $message = Message::find($id);
        if(isset( $message)){
            $message->update(['is_read'=>1]);

            return response()->json(["msg" => "message read successfully", "success" => true]);      
        }

        return response()->json(["msg" => "wrong id", "success" => true]);

    }

    public function deleteMessage(ApiRequest $request){

        $message = Message::where(['firebase_id'=>strtotime($request->firebase_id)])->first();

        if(isset( $message)){
            $message->delete();

            return response()->json(["msg" => "message deleted successfully", "success" => true]);      
        }
       

        return response()->json(["msg" => "wrong id", "success" => true]);

    }

    public function advertisements(){
        $advertisements = Advertisement::all();
        return response()->json(["success" => true, "advertisements" => $advertisements]);

    }

}
