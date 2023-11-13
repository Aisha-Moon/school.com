<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard(){
        $data['header_title']='Dashboard';
        $data['getRecord']=User::getSingle(Auth::user()->id);

        $profile=Auth::user()->profile_pic;
        if(!empty(Auth::check())){
            if(Auth::user()->user_type==1){

                return view('admin.dashboard',$data,compact('profile'));
            }else if(Auth::user()->user_type== 2){

                return view('teacher.dashboard',$data,compact('profile'));

            }else if(Auth::user()->user_type== 3){
                return view('student.dashboard',$data,compact('profile'));

            }else if(Auth::user()->user_type== 4){
                return view('parent.dashboard',$data,compact('profile'));

            }
    }
}
}
