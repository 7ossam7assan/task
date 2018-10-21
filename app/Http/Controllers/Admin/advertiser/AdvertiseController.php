<?php

namespace App\Http\Controllers\Admin\advertiser;

use App\Enums\AdvertiseActiveEnum;
use App\Models\Advertiser\Advertises;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class AdvertiseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $advertiser;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {

            // fetch  session here
            $this->advertiser = Auth::user();
            return $next($request);
        });
    }

    public function index()
    {
        $advs=Advertises::where('user_id',$this->advertiser->id)->paginate(5);
        return view('Admin.advertiser.all-advertisments',['advs' => $advs]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.advertiser.advertisement-edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $adv=new  Advertises();
        $adv->title=$request->get('title');
        $adv->content=$request->get('content');
        $adv->rate=0;
        $adv->price=$request->get('price');
        $adv->user_id=$this->advertiser->id;


        if($request->hasFile('im')) {
            $img=$request->get('upload_image');
            $img=preg_replace('#^data:image/\w+;base64,#i', '',$img);
            $fileData = base64_decode($img);
            $image=Image::make($fileData);
            $name='image_' . time() . '.' .$request->file('im')->getClientOriginalExtension();

            $image->save((public_path('images/advs/photo/'.$name)));
            $adv->photo =$name ;

        }else{
            $adv->photo ='defaultAdvertise.jpg' ;
        }
        $adv->is_active=AdvertiseActiveEnum::NOT_ACTIVE;
        $adv->save();
        return back();

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
        $adv=Advertises::where('id',$id)->first();
        return view('Admin.advertiser.advertisement-edit',['adv' => $adv]);
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
        $adv=Advertises::where('id',$id)->first();
        $adv->title=$request->get('title');
        $adv->content=$request->get('content');
        $adv->rate=$request->get('rate');
        $adv->price=$request->get('price');
        $adv->user_id=$this->advertiser->id;

        if($request->hasFile('im')) {
            $img=$request->get('upload_image');
            $img=preg_replace('#^data:image/\w+;base64,#i', '',$img);
            $fileData = base64_decode($img);
            $image=Image::make($fileData);
            $name='image_' . time() . '.' .$request->file('im')->getClientOriginalExtension();

            $image->save((public_path('images/advs/photo/'.$name)));
            $adv->photo =$name ;

        }
        $adv->is_active=$request->get('isActive');
        $adv->save();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Advertises::destroy($id);
        return back();
    }
}
