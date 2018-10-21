<?php

namespace App\Http\Controllers\Admin\admin;

use App\Enums\UserTypeEnum;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdvertiserController extends Controller
{

    public function index(){
        $advertisers = User::where('type',UserTypeEnum::ADVERTISER)->paginate(5);
        return view('Admin.admin.all-advertisers',['advertisers' => $advertisers]);
    }

    public  function delete($advertiserId){

        User::destroy($advertiserId);
        return back();
    }
}
