<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Backend\Auth\User\UserPasswordController;
use App\Http\Controllers\Frontend\Auth\ForgotPasswordController;
use App\Http\Controllers\Frontend\Auth\ResetPasswordController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::group(['namespace' => 'Api\V1', 'prefix' => 'v1', 'as' => 'v1.'], function () {    

    Route::group(['prefix' => 'auth', 'middleware' => ['guest']], function () {
        // Route::post('register', 'RegisterController@register');
        Route::post('login', 'AuthController@login');

        // Password Reset
        // Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail');
    });

    Route::group(['middleware' => ['auth:api']], function () {
        Route::group(['prefix' => 'auth'], function () {
            Route::post('logout', 'AuthController@logout');
            Route::get('me', 'AuthController@me');
            Route::post('upload-file', 'UserController@uploadFile');
            Route::post('upload-image', 'UserController@uploadImage');
            Route::post('upload-vedio', 'UserController@uploadVedio');
            Route::patch('password/change', [UserPasswordController::class, 'update']);
            Route::post('delete-account', 'UserController@destroyAccount');
            Route::post('updat-my-info', 'UserController@updateMyInfo');
        });

        // Page
        //Route::apiResource('pages', 'PagesController');
        Route::get('search-user/{user_name}', 'UserController@searchUser');
        Route::post('add-friend/{friend_id}', 'UserController@addFriend');
        Route::post('accept-friend/{friend_id}', 'UserController@acceptFriend');
        Route::post('cancel-friend/{friend_id}', 'UserController@cancelFriend');
        Route::post('check-friend-request', 'UserController@checkFriendRequest');
        Route::get('files', 'UserController@getFiles');
        Route::get('statistic', 'UserController@getstatistic');
        Route::post('create-folder', 'UserController@createFolder');
        Route::post('rename-folder', 'UserController@renameFolder');
        Route::post('delete', 'UserController@DeleteFiles');

        Route::get('get-plans', 'PlanController@index');
        Route::post('add-plans', 'PlanController@add');
        Route::post('remove-plans', 'PlanController@remove');

        Route::get('get-all-files/{type}', 'UserController@getAllFilesInDir');
        Route::post('read-notification', 'UserController@readNotification');
        Route::post('delete-friend', 'UserController@deleteFriend');
        Route::get('used-space', 'UserController@usedSpace');

        Route::post('create-update-package', 'UserController@createOrUpdatePackage');
        Route::post('delete-package', 'UserController@deletePackage');


        Route::post('sendMessage', 'UserController@send');
        Route::get('allMessage', 'UserController@getMessages');
        Route::get('readMessage/{id}', 'UserController@readMessage');
        Route::post('deleteMessage', 'UserController@deleteMessage');

        Route::get('advertisements', 'UserController@advertisements');

    });

    // forgot & reset password
    Route::post('reset-password', [ForgotPasswordController::class, 'sendResetLinkEmail']);
    Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.reset');

    Route::apiResource('users', 'UserController');
});
