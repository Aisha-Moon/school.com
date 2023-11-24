<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function myAccount(){
        $data['getRecord']=User::getSingle(Auth::user()->id);
        $data['header_title']='My Account';
       if(Auth::user()->user_type==1){
        return view('admin.my_account',$data);
       }
       if(Auth::user()->user_type==2){
        return view('teacher.my_account',$data);
       }
       else if(Auth::user()->user_type==3){
        return view('student.my_account',$data);
       }
       else if(Auth::user()->user_type==4){
        return view('parent.my_account',$data);
       }

    }
    public function updateMyAccountTeacher(Request $request){
        $id=Auth::user()->id;
        $request->validate([
            'email'=> 'required|email|unique:users,email,'.$id,
            'marital_status'=>'max:20',
            'religion'=>'max:10',
            'mobile_number'=>'max:11',

        ]);

        $student=User::getSingle($id);
        $student->name=trim($request->name);
        $student->last_name=trim($request->last_name);
        $student->gender=trim($request->gender);
        if(!empty($request->date_of_birth)){
            $student->date_of_birth=trim($request->date_of_birth);
        }

        if(!empty($request->file('profile_pic'))){
            if(!empty($student->getProfilepic())){
                unlink('users/images/'.$student->profile_pic);
            }
            $file=$request->file('profile_pic');
            $extension=$file->getClientOriginalExtension();
            $filename=time().'.'.$extension;
            $file->move('users/images',$filename);
            $student->profile_pic=$filename;

        }
        $student->religion=trim($request->religion);
        $student->mobile_number=trim($request->mobile_number);
        $student->marital_status=trim($request->marital_status);
        $student->address=trim($request->address);
        $student->permanent_address=trim($request->permanent_address);
        $student->qualification=trim($request->qualification);
        $student->work_experience=trim($request->work_experience);
        $student->email=trim($request->email);
        if(!empty($request->password)){
            $student->password=Hash::make($request->password);

        }    $student->user_type=2;
        $student->save();
        return redirect()->back()->with('success','Account updated successfully',);


    }
    public function updateMyAccountStudent(Request $request){
        $id=Auth::user()->id;
        $request->validate([
            'email'=> 'required|email|unique:users,email,'.$id,
            'weight'=>'max:10',
            'height'=>'max:10',
            'blood_group'=>'max:10',

            'caste'=>'max:10',
            'religion'=>'max:10',
            'mobile_number'=>'max:11',


        ]);

        $student=User::getSingle($id);
        $student->name=trim($request->name);
        $student->last_name=trim($request->last_name);
        $student->gender=trim($request->gender);
        if(!empty($request->date_of_birth)){
            $student->date_of_birth=trim($request->date_of_birth);
        }
        if(!empty($request->file('profile_pic'))){
            if(!empty($student->getProfilepic())){
                unlink('users/images/'.$student->profile_pic);
            }
            $file=$request->file('profile_pic');
            $extension=$file->getClientOriginalExtension();
            $filename=time().'.'.$extension;
            $file->move('users/images',$filename);
            $student->profile_pic=$filename;

        }
        $student->caste=trim($request->caste);
        $student->religion=trim($request->religion);
        $student->mobile_number=trim($request->mobile_number);
         $student->blood_group=trim($request->blood_group);
        $student->height=trim($request->height);
        $student->weight=trim($request->weight);
        $student->email=trim($request->email);

        $student->user_type=3;
        $student->save();
        return redirect()->back()->with('success','Account Updated successfully',);


    }
    public function updateMyAccountParent(Request $request){
        $id=Auth::user()->id;
        $request->validate([
            'email'=> 'required|email|unique:users,email,'.$id,
            'address'=>'max:255',
            'occupation'=>'max:255',
            'mobile_number'=>'max:11',


        ]);

         $parent=User::getSingle($id);
         $parent->name=trim($request->name);
         $parent->last_name=trim($request->last_name);
         $parent->gender=trim($request->gender);
        if(!empty($request->file('profile_pic'))){
            if(!empty( $parent->getProfilepic())){
                unlink('users/images/'. $parent->profile_pic);
            }
            $file=$request->file('profile_pic');
            $extension=$file->getClientOriginalExtension();
            $filename=time().'.'.$extension;
            $file->move('users/images',$filename);
             $parent->profile_pic=$filename;

        }
         $parent->religion=trim($request->religion);
         $parent->mobile_number=trim($request->mobile_number);
         $parent->email=trim($request->email);
         $parent->user_type=4;
         $parent->save();
        return redirect()->back()->with('success','Account Updated successfully',);


    }
    public function updateMyAccountAdmin(Request $request){
        $id=Auth::user()->id;
        $request->validate([
            'email'=> 'required|email|unique:users,email,'.$id,
        ]);
        $user=User::getSingle($id);
        $user->name=trim($request->name);
        $user->email=trim($request->email);

        $user->save();
        return redirect()->back()->with('success','Account updated Successfully');
    }
    public function change_password(){
        $data['header_title']='Change Password';
        return view('profile.change_password',$data);
    }
    public function update_change_password(Request $request){
        $user=User::getSingle(Auth::user()->id);
        if(Hash::check($request->old_password,$user->password)){
            $user->password = Hash::make($request->new_password);
            $user->save();
            return redirect()->back()->with('success','Passwords updated successfully');
        }else{
            return redirect()->back()->with('error','Old password is incorrect');
        }
    }
    public function Setting(){
        $data['getRecord']=Setting::getSingle();
        $data['header_title']='My Settings';
        return view('admin.my_setting',$data);

    }
    public function UpdateSetting(Request $request){
        $setting=Setting::getSingle();
        $setting->paypal_email=trim($request->paypal_email);
        $setting->stripe_key=trim($request->stripe_key);
        $setting->stripe_secret=trim($request->stripe_secret);
        if(!empty($request->file('logo'))){
            $file=$request->file('logo');
            $extension=$file->getClientOriginalExtension();
            $filename=time().'.'.$extension;
            $file->move('users/settings',$filename);
            $setting->logo=$filename;

        }
        if(!empty($request->file('fevicon_icon'))){
            $file=$request->file('fevicon_icon');
            $extension=$file->getClientOriginalExtension();
            $fevicon=time().'.'.$extension;
            $file->move('users/settings',$fevicon);
            $setting->fevicon_icon=$fevicon;

        }
      
        $setting->save();
        return redirect()->back()->with('success','Settings updated successfully');

    }
}
