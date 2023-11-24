<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class StudentController extends Controller
{
    public function list(){
        $data['header_title']='Student List';
        $data['getRecord']=User::getStudent();
        return view('admin.student.list',$data);
    }
    public function add(){
        $data['header_title']='Add Student ';
        $data['getClass']=ClassModel::getClass();
        return view('admin.student.add',$data);

    }
    public function insert(Request $request){
        $request->validate([
            'email'=> 'required|email|unique:users',
            'weight'=>'max:10',
            'height'=>'max:10',
            'blood_group'=>'max:10',
            'admission_number'=>'max:50',
            'roll_number'=>'max:10',
            'caste'=>'max:10',
            'religion'=>'max:10',
            'mobile_number'=>'max:11',


        ]);

        $student=new User();
        $student->name=trim($request->name);
        $student->last_name=trim($request->last_name);
        $student->admission_number=trim($request->admission_number);
        $student->roll_number=trim($request->roll_number);
        $student->class_id=trim($request->class_id) ;
        $student->gender=trim($request->gender);
        if(!empty($request->date_of_birth)){
            $student->date_of_birth=trim($request->date_of_birth);
        }
        if(!empty($request->file('profile_pic'))){
            $file=$request->file('profile_pic');
            $extension=$file->getClientOriginalExtension();
            $filename=time().'.'.$extension;
            $file->move('users/images',$filename);
            $student->profile_pic=$filename;

        }
        $student->caste=trim($request->caste);
        $student->religion=trim($request->religion);
        $student->mobile_number=trim($request->mobile_number);
        if(!empty($request->admission_date)){
            $student->admission_date=trim($request->admission_date);
        }
         $student->blood_group=trim($request->blood_group);
        $student->height=trim($request->height);
        $student->weight=trim($request->weight);
        $student->status=trim($request->status);
        $student->email=trim($request->email);
        $student->password=Hash::make($request->password);
        $student->user_type=3;
        $student->save();
        return redirect('admin/student/list')->with('success','Student created successfully',);


    }
    public function edit($id){

        $data['getRecord']=User::getSingle($id);

        if(!empty( $data['getRecord'])){

            $data['header_title']='Edit Student ';

            $data['getClass']=ClassModel::getClass();
            return view('admin.student.edit',$data);
        }else{
            abort(404);
        }

    }
    public function update($id,Request $request){
        $request->validate([
            'email'=> 'required|email|unique:users,email,'.$id,
            'weight'=>'max:10',
            'height'=>'max:10',
            'blood_group'=>'max:10',
            'admission_number'=>'max:50',
            'roll_number'=>'max:10',
            'caste'=>'max:10',
            'religion'=>'max:10',
            'mobile_number'=>'max:11',


        ]);

        $student=User::getSingle($id);
        $student->name=trim($request->name);
        $student->last_name=trim($request->last_name);
        $student->admission_number=trim($request->admission_number);
        $student->roll_number=trim($request->roll_number);
       $student->class_id=trim($request->class_id) ;
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
        if(!empty($request->admission_date)){
            $student->admission_date=trim($request->admission_date);
        }
         $student->blood_group=trim($request->blood_group);
        $student->height=trim($request->height);
        $student->weight=trim($request->weight);
        $student->status=trim($request->status);
        $student->email=trim($request->email);
        if(!empty($request->password)){
            $student->password=Hash::make($request->password);

        }
        $student->user_type=3;
        $student->save();
        return redirect('admin/student/list')->with('success','Student Updated successfully',);

    }
    public function delete($id){
        $getRecord=User::getSingle($id);

        if(!empty( $getRecord)){

            $getRecord->is_delete=1;
            $getRecord->save();

            return redirect('admin/student/list')->with('success','Student Deleted successfully');
        }else{
            abort(404);
        }

    }
    public function myStudent(){
        $data['header_title']='My Student List';
        $data['getRecord']=User::getTeacherStudent(Auth::user()->id);
        return view('teacher.my_student',$data);
    }
}
