<?php

namespace App\Http\Controllers;

use App\Models\AssignClassTeacher;
use App\Models\ClassModel;
use App\Models\ClassSubject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AssignClassTeacherController extends Controller
{

   public function list(Request $request){

    $data['header_title']='Assign Class Teacher';
    $data['getRecord']=AssignClassTeacher::getRecord();

    return view('admin.assign_class_teacher.list',$data);
}
public function add(Request $request){

    $data['getClass']= ClassModel::getClass();
    $data['getTeacher']= User::getTeacherClass();
    $data['header_title']='Add Assign Class Teacher';
    return view('admin.assign_class_teacher.add',$data);
  }
  public function insert(Request $request){
    if(!empty($request->teacher_id)){
        foreach ($request->teacher_id as $teacher_id) {

            $getAlreadyFirst=AssignClassTeacher::getAlreadyFirst($request->class_id,$teacher_id);
            if(!empty($getAlreadyFirst)){
                $getAlreadyFirst->status=$request->status;
                $getAlreadyFirst->save();
            }else{
                $classSubject=new AssignClassTeacher();
                $classSubject->teacher_id=$teacher_id;
                $classSubject->class_id=$request->class_id;
                $classSubject->created_by=Auth::user()->id;
                $classSubject->save();
            }

        }
        return redirect('admin/assign_class_teacher/list')->with('success','Teacher successfully Assignd to class');

    }else{
        return redirect('')->with('error','An error occurred, please try again');
    }
  }
  public function edit($id){
    $getRecord=AssignClassTeacher::getSingle($id);
    if(!empty($getRecord)){
        $data['getRecord']=$getRecord;
        $data['getAssignTeacherId']=AssignClassTeacher::getAssignTeacherId($getRecord->class_id);
        $data['getClass']= ClassModel::getClass();
        $data['getTeacher']= User::getTeacherClass();
        $data['header_title']='Edit Assign Class Teacher ';
    return view('admin.assign_class_teacher.edit',$data);
    }else{
        abort(404);
    }

  }
  public function update(Request $request){
    AssignClassTeacher::deleteTeacher($request->class_id);
    if(!empty($request->teacher_id)){
        foreach ($request->teacher_id as $teacher_id) {

            $getAlreadyFirst=AssignClassTeacher::getAlreadyFirst($request->class_id,$teacher_id);
            if(!empty($getAlreadyFirst)){
                $getAlreadyFirst->status=$request->status;
                $getAlreadyFirst->save();
            }else{
                $classSubject=new AssignClassTeacher();
                $classSubject->teacher_id=$teacher_id;
                $classSubject->class_id=$request->class_id;
                $classSubject->created_by=Auth::user()->id;
                $classSubject->save();
            }

        }
    }

        return redirect('admin/assign_class_teacher/list')->with('success','Teacher successfully Updated Assignd to class');



}

public function edit_single($id){
    $getRecord=AssignClassTeacher::getSingle($id);

    if(!empty($getRecord)){
        $data['getRecord']=$getRecord;
        $data['getClass']= ClassModel::getClass();
        $data['getTeacher']= User::getTeacherClass();
        $data['header_title']='Edit Single Assign Class Teacher ';
    return view('admin.assign_class_teacher.edit_single',$data);
    }else{
        abort(404);
    }
}
public function update_single($id,Request $request){

            $getAlreadyFirst=AssignClassTeacher::getAlreadyFirst($request->class_id,$request->teacher_id);
            if(!empty($getAlreadyFirst)){
                $getAlreadyFirst->status=$request->status;
                $getAlreadyFirst->save();
                return redirect('admin/assign_class_teacher/list')->with('success','Status successfully updated');

            }else{
                $classSubject=AssignClassTeacher::getSingle($id);
                $classSubject->teacher_id=$request->teacher_id;
                $classSubject->class_id=$request->class_id;
                $classSubject->save();
                return redirect('admin/assign_class_teacher/list')->with('success','Teacher successfully Assignd to class');


    }


  }
  public function delete($id){
    $classSubject=AssignClassTeacher::getSingle($id);
    $classSubject->delete();
    return redirect()->back()->with('success','Assigned class Teacher deleted Successfully');
  }
  public function myClassSubject(){
    $data['getRecord']=AssignClassTeacher::getMyClassSubject(Auth::user()->id);
    $data['header_title']='My Class & Subject';
    return view('teacher.my_class_subject',$data);


  }
}

