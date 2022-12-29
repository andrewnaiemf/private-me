<?php

namespace App\Http\Controllers\Backend\Auth\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Auth\Advertisement;
class AdvertisementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $advertisements = Advertisement::all();
        return view('backend.auth.advertisement.index',compact('advertisements'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.auth.advertisement.create');

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
            "ad_ar" => 'required',
            "ad_en" => 'required',
        ]);

        $fileName_ar ='';
        $fileName_en = '';

        $images = $request->except('_token');
        foreach ($images as $index => $image) {
            if($index == 'ad_ar'){
                $fileName_ar = time() . '0.' . $image->getClientOriginalExtension();
                $path_ar = 'public/Advertising/Files/';
                \Storage::putFileAs($path_ar, $image, $fileName_ar);
            }else{
                $fileName_en = time() . '1.' . $image->getClientOriginalExtension();
                $path_en = 'public/Advertising/Files/';
                \Storage::putFileAs( $path_en, $image,$fileName_en);
            }
        }

        Advertisement::create([
            'ad_ar' => $fileName_ar,
            'ad_en' => $fileName_en
        ]);
        return redirect('/admin/auth/advertisement');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

        $advertisement = Advertisement::find($id);

        $delete_add_ar = \File::delete('storage/Advertising/Files/'.$advertisement->ad_ar);
        $delete_add_en = \File::delete('storage/Advertising/Files/'.$advertisement->ad_en);

        if( $delete_add_ar &&  $delete_add_en) {
            $advertisement->delete();
            \Session::flash('message', 'تم حذف الاعلان بنجاح');
            return  back();
        }

    }
}
