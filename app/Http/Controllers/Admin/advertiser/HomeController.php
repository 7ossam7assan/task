<?php

namespace App\Http\Controllers\Admin\advertiser;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public  function index(){

        return view('Admin.advertiser.home');

    }
}
