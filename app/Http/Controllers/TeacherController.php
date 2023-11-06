<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    public function list(){
        $data['header_title']='Teacher List';
        $data['getRecord']=User::getTeacher();
        return view('admin.teacher.list',$data);
    }
    public function add(){
        $data['header_title']='Add Teacher ';
        return view('admin.teacher.add',$data);

    }
    public function insert(Request $request){
        $request->validate([
            'email'=> 'required|email|unique:users',
           'marital_status'=>'max:20',
            'religion'=>'max:10',
            'mobile_number'=>'max:11',


        ]);

        $student=new User();
        $student->name=trim($request->name);
        $student->last_name=trim($request->last_name);
        $student->gender=trim($request->gender);
        if(!empty($request->date_of_birth)){
            $student->date_of_birth=trim($request->date_of_birth);
        }
        if(!empty($request->admission_date)){
            $student->admission_date=trim($request->admission_date);
        }
        if(!empty($request->file('profile_pic'))){
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
        $student->note=trim($request->note);
        $student->status=trim($request->status);
        $student->email=trim($request->email);
        $student->password=Hash::make($request->password);
        $student->user_type=2;
        $student->save();
        return redirect('admin/teacher/list')->with('success','Teacher created successfully',);


    }
    public function edit($id){

        $data['getRecord']=User::getSingle($id);

        if(!empty( $data['getRecord'])){

            $data['header_title']='Edit Teacher ';

            return view('admin.teacher.edit',$data);
        }else{
            abort(404);
        }


}
public function update($id,Request $request){
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
    if(!empty($request->admission_date)){
        $student->admission_date=trim($request->admission_date);
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
    $student->note=trim($request->note);
    $student->status=trim($request->status);
    $student->email=trim($request->email);
    if(!empty($request->password)){
        $student->password=Hash::make($request->password);

    }    $student->user_type=2;
    $student->save();
    return redirect('admin/teacher/list')->with('success','Teacher updated successfully',);


}
public function delete($id){
    $getRecord=User::getSingle($id);

    if(!empty( $getRecord)){

        $getRecord->is_delete=1;
        $getRecord->save();

        return redirect('admin/teacher/list')->with('success','Teacher Deleted successfully');
    }else{
        abort(404);
    }

}
}
