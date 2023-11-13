<?php

namespace App\Http\Controllers;

use App\Models\ClassSubject;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubjectController extends Controller
{
    public function list(){
        $data['header_title']='Subject List';
        $data['getRecord']=Subject::getRecord();
        return view('admin.subject.list',$data);
    }
    public function add(){
        $data['header_title']= 'Add Subject';
        return view('admin.subject.add',$data);
    }
    public function insert(Request $request){

        $subject=new Subject();
        $subject->name=trim($request->name);
        $subject->type=trim($request->type);
        $subject->status=trim($request->status);
        $subject->created_by=Auth::user()->id;

        $subject->save();
        return redirect('admin/subject/list')->with('success','Subject created successfully');


    }
    public function edit($id){
        $data['getRecord']=Subject::getSingle($id);
        if(!empty($data['getRecord'])){
            $data['header_title']= 'Edit Subject';
            return view('admin.subject.edit',$data);
        }else{
            abort(404);
        }

    }
    public function update($id,Request $request){
        $subject=Subject::getSingle($id);
        $subject->name=trim($request->name);
        $subject->type=trim($request->type);
        $subject->status=trim($request->status);
        $subject->save();
        return redirect('admin/subject/list')->with('success','Subject updated Successfully');

    }
    public function delete($id){
        $subject=Subject::getSingle($id);
        $subject->is_delete=1;
        $subject->save();
        return redirect()->back()->with('success','Subject deleted Successfully');
    }
    public function mySubject(){

        $data['getRecord']=ClassSubject::mySubject(Auth::user()->class_id);


        $data['header_title']='My Subject ';
        return view('student.my_subject',$data);
    }
    public function parentStudentSubject($student_id){
        $user=User::getSingle($student_id);
        $data['getUser']=$user;
        $data['getRecord']=ClassSubject::mySubject($user->class_id);

        $data['header_title']='My Subject ';
        return view('parent.my_student_subject',$data);



    }
}
