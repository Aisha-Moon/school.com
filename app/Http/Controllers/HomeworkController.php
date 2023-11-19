<?php

namespace App\Http\Controllers;

use App\Models\AssignClassTeacher;
use App\Models\SubmitHomework;
use Illuminate\Http\Request;
use App\Models\ClassModel;
use App\Models\ClassSubject;
use App\Models\Homework;
use App\Models\User;
use Illuminate\Support\Facades\Auth;



class HomeworkController extends Controller
{
    public function HomeworkReport(){
        $data['getRecord']=SubmitHomework::getHomeworkReport();
        $data['getClass']=ClassModel::getClass();
        $data['header_title'] = 'Homework report';
        return view('admin.homework.report',$data);
    }
    public function homework(){
        $data['getRecord']=Homework::getRecord();
        $data['getClass']=ClassModel::getClass();

        $data['header_title'] = 'Homework';
        return view('admin.homework.list',$data);

    }

    public function AddHomework(){
        $data['getClass']=ClassModel::getClass();
        $data['header_title'] = 'Add New Homework';
        return view('admin.homework.add',$data);

    }
    public function ajax_get_subject(Request $request){
       $class_id=$request->class_id;
       $getSubject=ClassSubject::mySubject($class_id);
       $html='';
       foreach ($getSubject as  $subject) {
        $html .= '<option value="' . $subject->subject_id . '">' . $subject->subject_name . '</option>';

       }
       $json['success']=$html;
       echo json_encode($json);
    }
    public function insertHomework(Request $request){
        $homework=new Homework();
        $homework->class_id=trim($request->class_id);
        $homework->subject_id=trim($request->subject_id);
        $homework->homework_date=trim($request->homework_date);
        $homework->submission_date=trim($request->submission_date);
        $homework->description=trim($request->description);
        $homework->created_by=Auth::user()->id;
        if(!empty($request->file('document'))){
            $file=$request->file('document');
            $extension=$file->getClientOriginalExtension();
            $filename=time().'.'.$extension;
            $file->move('homework/images',$filename);
            $homework->document=$filename;

        }
        $homework->save();
        return redirect('admin/homework/homework')->with('success','Homework Created successfully');


    }
    public function EditHomework($id){
        $getRecord=$data['getRecord']=Homework::getSingle($id);
        $data['getClass']=ClassModel::getClass();
        $data['getSubject']=ClassSubject::mySubject($getRecord->class_id);


        if(!empty($data['getRecord'])){
            $data['header_title']="Edit Homework";
            return view('admin.homework.edit',$data);
        }else{
            abort(404);
        }
    }
    public function updateHomework($id,Request $request){
        $homework=Homework::getSingle($id);
        $homework->class_id=trim($request->class_id);
        $homework->subject_id=trim($request->subject_id);
        $homework->homework_date=trim($request->homework_date);
        $homework->submission_date=trim($request->submission_date);
        $homework->description=trim($request->description);
        $homework->created_by=Auth::user()->id;
        if(!empty($request->file('document'))){
            if(!empty($homework->getDocument())){
                unlink('homework/images/'.$homework->document);
            }
            $file=$request->file('document');
            $extension=$file->getClientOriginalExtension();
            $filename=time().'.'.$extension;
            $file->move('homework/images',$filename);
            $homework->document=$filename;

        }
        $homework->save();
        return redirect('admin/homework/homework')->with('success','Homework Updated successfully');


    }
    public function deleteHomework($id){
        $homework=Homework::getSingle($id);

        $homework->is_delete== 1;
        $homework->save();
        return redirect()->back()->with('success','Homework Deleted successfully');
    }
    public function submitted($homework_id){
        $homework=Homework::getSingle($homework_id);
        if(!empty($homework)){
            $data['homework_id']=$homework_id;

            $data['getRecord']=SubmitHomework::getRecord($homework_id);
            $data['header_title'] = 'Submitted Homework';
            return view('admin.homework.submitted',$data);
        }else{
            abort(404);
        }
    }

    //teacher side
    public function homeworkTeacher(){
        $class_ids=array();
        $getClass=AssignClassTeacher::getMyClassSubjectGroup(Auth::user()->id);
        $data['getClass']=$getClass;
        foreach($getClass as $class){
            $class_ids[]=$class->class_id;
        }
        $data['getRecord']=HomeWork::getRecordTeacher($class_ids);
        $data['header_title'] = 'Homework';
        return view('teacher.homework.list',$data);

    }
    public function AddHomeworkTeacher(){
        $data['getClass']=AssignClassTeacher::getMyClassSubjectGroup(Auth::user()->id);
        $data['header_title'] = 'Add New Homework';
        return view('teacher.homework.add',$data);

    }
    public function insertHomeworkTeacher(Request $request){
        $homework=new Homework();
        $homework->class_id=trim($request->class_id);
        $homework->subject_id=trim($request->subject_id);
        $homework->homework_date=trim($request->homework_date);
        $homework->submission_date=trim($request->submission_date);
        $homework->description=trim($request->description);
        $homework->created_by=Auth::user()->id;
        if(!empty($request->file('document'))){
            $file=$request->file('document');
            $extension=$file->getClientOriginalExtension();
            $filename=time().'.'.$extension;
            $file->move('homework/images',$filename);
            $homework->document=$filename;

        }
        $homework->save();
        return redirect('teacher/homework/homework')->with('success','Homework Created successfully');


    }
    public function EditHomeworkTeacher($id){
        $getRecord=$data['getRecord']=Homework::getSingle($id);
        $data['getClass']=AssignClassTeacher::getMyClassSubjectGroup(Auth::user()->id);
        $data['getSubject']=ClassSubject::mySubject($getRecord->class_id);


        if(!empty($data['getRecord'])){
            $data['header_title']="Edit Homework";
            return view('teacher.homework.edit',$data);
        }else{
            abort(404);
        }
    }

    public function updateHomeworkTeacher($id,Request $request){
        $homework=Homework::getSingle($id);
        $homework->class_id=trim($request->class_id);
        $homework->subject_id=trim($request->subject_id);
        $homework->homework_date=trim($request->homework_date);
        $homework->submission_date=trim($request->submission_date);
        $homework->description=trim($request->description);
        $homework->created_by=Auth::user()->id;
        if(!empty($request->file('document'))){
            if(!empty($homework->getDocument())){
                unlink('homework/images/'.$homework->document);
            }
            $file=$request->file('document');
            $extension=$file->getClientOriginalExtension();
            $filename=time().'.'.$extension;
            $file->move('homework/images',$filename);
            $homework->document=$filename;

        }
        $homework->save();
        return redirect('teacher/homework/homework')->with('success','Homework Updated successfully');


    }

    //student side
    public function HomeworkStudent(){

        $data['getRecord']=HomeWork::getRecordStudent(Auth::user()->class_id,Auth::user()->id);

        $data['header_title'] = 'My Homework';
        return view('student.homework.list',$data);
    }
    public function  SubmitHomework($homework_id){
        $data['getRecord']=HomeWork::getSingle($homework_id);

        $data['header_title'] = 'Submit Homework';
        return view('student.homework.submit',$data);

    }
    public function InsertSubmitHomework($homework_id,Request $request){
        $homework=new SubmitHomework();
        $homework->homework_id=$homework_id;
        $homework->student_id=Auth::user()->id;
        $homework->description=trim($request->description);
        if(!empty($request->file('document_file'))){
            $file=$request->file('document_file');
            $extension=$file->getClientOriginalExtension();
            $filename=time().'.'.$extension;
            $file->move('homework/images',$filename);
            $homework->document_file=$filename;

        }
        $homework->save();
        return redirect('student/my_homework')->with('success','Homework Submitted successfully');


    }
    public function SubmittedHomeworkStudent(Request $request){
        $data['getRecord']=SubmitHomework::getRecordStudent(Auth::user()->id);
        $data['header_title'] = 'My Submitted Homework';
        return view('student.homework.submited_list',$data);

    }
    public function submittedTeacher($homework_id){
        $homework=Homework::getSingle($homework_id);
        if(!empty($homework)){
            $data['homework_id']=$homework_id;

            $data['getRecord']=SubmitHomework::getRecord($homework_id);
            $data['header_title'] = 'Submitted Homework';
            return view('teacher.homework.submitted',$data);
        }else{
            abort(404);
        }
    }

    //parent side
    public function HomeworkParent($student_id){
        $getStudent=User::getSingle($student_id);
        $data['getStudent']=$getStudent;
        $data['getRecord']=Homework::getRecordStudent($getStudent->class_id,$getStudent->id);
        $data['header_title'] = 'Student Homework';
        return view('parent.homework.list',$data);

    }
    public function SubmittedHomeworkParent($student_id){

        $getStudent=User::getSingle($student_id);
        $data['getStudent']=$getStudent;
        $data['getRecord']=SubmitHomework::getRecordStudent($getStudent->id);
        $data['header_title'] = 'Submitted Homework';
        return view('parent.homework.submited_list',$data);


    }
}
