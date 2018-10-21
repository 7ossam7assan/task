<?php

namespace App\Http\Controllers\Admin\admin;

use App\Enums\AdvertiseActiveEnum;
use App\Models\Advertiser\Advertises;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class AdvertisementController extends Controller
{



    private $admin;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {

            // fetch  session here
            $this->admin = Auth::user();
            return $next($request);
        });
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $advs = Advertises::paginate(5);
        return view('Admin.admin.all-advertisments',['advs' => $advs]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // i handled that admin can also create advertisement if he need that
        return view('Admin.admin.advertisement-edit');
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
        $adv->user_id=$this->admin->id;


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
        $adv->is_active=AdvertiseActiveEnum::ACTIVE;
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
        return view('Admin.admin.advertisement-edit',['adv' => $adv]);
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
        $adv->user_id=$this->admin->id;

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

    public function accept($id){
        Advertises::where('id',$id)->update(['is_active' => 1]);
        return back();
    }
}
