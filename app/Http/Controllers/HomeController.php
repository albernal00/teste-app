<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{
    public function index(){
        $user = Auth::User();

        $folder = $user->folders()->first();

        if(is_null($folder)){
            return view('home');
        }else{

        return redirect()->route('tasks.index',[
            'id'=>$folder->id,
        ]);}
    }
}
