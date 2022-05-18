<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function index(Request $request){

        //check if the userr is logged in
        if(!Auth::check() && $request->path() != 'login'){
            return redirect('login');
        }

    }
}
