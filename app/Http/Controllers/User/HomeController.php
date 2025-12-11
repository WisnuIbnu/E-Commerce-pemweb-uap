<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index(){
        return view('user.dashboard');
    }

    // public function profile(){
    //     return view('user.profile');
    // }

}