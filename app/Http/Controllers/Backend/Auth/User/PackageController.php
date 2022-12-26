<?php

namespace App\Http\Controllers\Backend\Auth\User;

use App\Http\Controllers\Controller;
use App\Models\Auth\Package;
use Illuminate\Http\Request;
use App\Models\Auth\Plan;
use App\Models\Auth\User;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $packages = Plan::all();
        return view('backend.auth.package.index',compact('packages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.auth.package.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            "name" => 'required',
//            "duration" => 'required',
            "description" => 'required',
            "price_year" => 'required',
            "price_month" => 'required',
            "storage" => 'required',
            "free_storage" => 'required',
//            "chat" => 'required',
//            "friends" => 'required',
        ]);

        Plan::create([
            'name' => $request->name ,
            'description' => $request->description ,
            'price_year' => $request->price_year ,
            'price_month' => $request->price_month ,
            'storage' => $request->storage ,
            'free_storage' =>$request->free_storage,
            'chat' => 'Available',
            'friends' => -1,
            'duration' => 'duration',

        ]);
        return redirect('/admin/auth/package');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id,$type)
    {

        $plan= Plan::find($id);

        if($type == 'm'){
            $price = $plan->price_month;
        }else{
            $price = $plan->price_year;
        }

        $users_subscribe = Package::where('price',$price)->pluck('user_id');
        $users = User::whereIn('id',$users_subscribe)->paginate(10);

        return view('backend.auth.user.package.index',compact('users'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
