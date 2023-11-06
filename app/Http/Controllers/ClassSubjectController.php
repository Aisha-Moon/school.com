<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use App\Models\ClassSubject;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClassSubjectController extends Controller
{
   public function list(Request $request){

        $data['header_title']='Assign Subject List';
        $data['getRecord']=ClassSubject::getRecord();
        return view('admin.assign_subject.list',$data);
   }
   public function add(Request $request){

    $data['getClass']= ClassModel::getClass();
    $data['getSubject']= Subject::getSubject();
    $data['header_title']='Add Assign Subject ';
    return view('admin.assign_subject.add',$data);
  }
  public function insert(Request $request){
    if(!empty($request->subject_id)){
        foreach ($request->subject_id as $subject_id) {

            $getAlreadyFirst=ClassSubject::getAlreadyFirst($request->class_id,$subject_id);
            if(!empty($getAlreadyFirst)){
                $getAlreadyFirst->status=$request->status;
                $getAlreadyFirst->save();
            }else{
                $classSubject=new ClassSubject();
                $classSubject->subject_id=$subject_id;
                $classSubject->class_id=$request->class_id;
                $classSubject->created_by=Auth::user()->id;
                $classSubject->save();
            }

        }
        return redirect('admin/assign_subject/list')->with('success','Subject successfully Assignd to class');

    }else{
        return redirect('')->with('error','An error occurred, please try again');
    }
  }
  public function delete($id){
    $classSubject=ClassSubject::getSingle($id);
    $classSubject->is_delete=1;
    $classSubject->save();
    return redirect()->back()->with('success','Assigned Subject deleted Successfully');
}
public function edit($id){
    $getRecord=ClassSubject::getSingle($id);
    if(!empty($getRecord)){
        $data['getRecord']=$getRecord;
        $data['getAssignSubjectId']=ClassSubject::getAssignSubjectId($getRecord->class_id);
        $data['getClass']= ClassModel::getClass();
        $data['getSubject']= Subject::getSubject();
        $data['header_title']='Edit Assign Subject ';
    return view('admin.assign_subject.edit',$data);
    }else{
        abort(404);
    }

}
public function update(Request $request){
    ClassSubject::deleteSubject($request->class_id);
    if(!empty($request->subject_id)){
        foreach ($request->subject_id as $subject_id) {

            $getAlreadyFirst=ClassSubject::getAlreadyFirst($request->class_id,$subject_id);
            if(!empty($getAlreadyFirst)){
                $getAlreadyFirst->status=$request->status;
                $getAlreadyFirst->save();
            }else{
                $classSubject=new ClassSubject();
                $classSubject->subject_id=$subject_id;
                $classSubject->class_id=$request->class_id;
                $classSubject->created_by=Auth::user()->id;
                $classSubject->save();
            }

        }
    }

        return redirect('admin/assign_subject/list')->with('success','Subject successfully Assignd to class');



}

public function edit_single($id){
    $getRecord=ClassSubject::getSingle($id);
    
    if(!empty($getRecord)){
        $data['getRecord']=$getRecord;
        $data['getClass']= ClassModel::getClass();
        $data['getSubject']= Subject::getSubject();
        $data['header_title']='Edit Single Assign Subject ';
    return view('admin.assign_subject.edit_single',$data);
    }else{
        abort(404);
    }
}
public function update_single($id,Request $request){

            $getAlreadyFirst=ClassSubject::getAlreadyFirst($request->class_id,$request->subject_id);
            if(!empty($getAlreadyFirst)){
                $getAlreadyFirst->status=$request->status;
                $getAlreadyFirst->save();
                return redirect('admin/assign_subject/list')->with('success','Status successfully updated');

            }else{
                $classSubject=ClassSubject::getSingle($id);
                $classSubject->subject_id=$request->subject_id;
                $classSubject->class_id=$request->class_id;
                $classSubject->save();
                return redirect('admin/assign_subject/list')->with('success','Subject successfully Assignd to class');


    }


  }
}
