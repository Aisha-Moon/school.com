<?php

namespace App\Http\Controllers;

use App\Models\AssignClassTeacher;
use App\Models\ClassModel;
use App\Models\ClassSubject;
use App\Models\Exam;
use App\Models\ExamSchedule;
use App\Models\MarksGrade;
use App\Models\MarksRegister;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamintaionController extends Controller
{
    public function exam_list(){
        $data['getRecord']=Exam::getRecord();
        $data['header_title']='Exam List';
        return view('admin.examination.exam.list',$data);
    }
    public function exam_add(){

        $data['header_title']='Add New Exam ';
        return view('admin.examination.exam.add',$data);
    }
    public function marks_register(Request $request){
        $data['getClass']= ClassModel::getClass();
        $data['getExam']= Exam::getExam();
        if(!empty($request->get('exam_id')) && !empty($request->get('class_id'))){
            $data['getSubject']=ExamSchedule::getSubject($request->get('exam_id'),$request->get('class_id'));
            $data['getStudent']=User::getStudentClass($request->get('class_id'));
        }
        $data['header_title']='Marks Register';
        return view('admin.examination.mark_register',$data);
    }
    public function marks_register_teacher(Request $request){
        $data['getClass']= AssignClassTeacher::getMyClassSubjectGroup(Auth::user()->id);
        $data['getExam']= ExamSchedule::getExamTeacher(Auth::user()->id);
        if(!empty($request->get('exam_id')) && !empty($request->get('class_id'))){
            $data['getSubject']=ExamSchedule::getSubject($request->get('exam_id'),$request->get('class_id'));
            $data['getStudent']=User::getStudentClass($request->get('class_id'));
        }
        $data['header_title']='Marks Register';
        return view('teacher.mark_register',$data);
    }
    public function submit_marks_register(Request $request){
        $validation=0;
        if(!empty($request->mark)){
            foreach ($request->mark as  $mark) {
                $getExamSchedule=ExamSchedule::getSingle($mark['id']);
                $full_marks=$getExamSchedule->full_marks;

                $class_work=!empty($mark['class_work']) ? $mark['class_work'] :0;
                $home_work=!empty($mark['home_work']) ? $mark['home_work'] :0;
                $test_work=!empty($mark['test_work']) ? $mark['test_work'] :0;
                $exam=!empty($mark['exam']) ? $mark['exam'] :0;
                $full_marks=!empty($mark['full_marks']) ? $mark['full_marks'] :0;
                $pass_marks=!empty($mark['pass_marks']) ? $mark['pass_marks'] :0;

                $total_mark= $class_work+$home_work+$test_work+$exam;

              if($full_marks>=$total_mark){
                $getMark=MarksRegister::CheckAlreadyMark($request->student_id,$request->exam_id,$request->class_id,$mark['subject_id']);
                if(!empty($getMark)){
                    $save=$getMark;
                }else{
                    $save=new MarksRegister();
                    $save->created_by=Auth::user()->id;
                }
                $save->student_id=$request->student_id;
                $save->exam_id=$request->exam_id;
                $save->class_id=$request->class_id;
                $save->subject_id=$mark['subject_id'];
                $save->class_work=$class_work;
                $save->home_work=$home_work;
                $save->test_work=$test_work;
                $save->exam=$exam;
                $save->full_marks=$full_marks;
                $save->pass_marks=$pass_marks;
                $save->save();
              }else{
                $validation=1;
              }
            }
          }
          if($validation==0){
            $json['message']='Marks Register Save Successfully';

          }else{
            $json['message']='Marks Register Saved but some subjects are greater than total marks';
          }
        echo json_encode($json);
    }
    public function exam_insert(Request $request){
        $exam=new Exam();
        $exam->name=trim($request->name);
        $exam->note=trim($request->note);
        $exam->created_by=Auth::user()->id;
        $exam->save();
        return redirect('admin/examinations/exam/list')->with('success','Exam Created Successfully');
    }
    public function exam_edit($id){
        $data['getRecord']=Exam::getSingle($id);
        if(!empty($data['getRecord'])){
            $data['header_title']="Edit Exam";
            return view('admin.examination.exam.edit',$data);
        }else{
            abort(404);
        }
    }
    public function exam_update($id,Request $request){
        $exam=Exam::getSingle($id);
        $exam->name=trim($request->name);
        $exam->note=trim($request->note);
        $exam->save();
        return redirect('admin/examinations/exam/list')->with('success','Exam updated Successfully');


    }
    public function exam_delete($id){
        $data['getRecord']=Exam::getSingle($id);
       if(!empty($getRecord)){
        $getRecord->is_delete=1;
        $getRecord->save();
        return redirect()->back()->with('success','Exam deleted Successfully');
       }else{
        abort(404);
       }
    }
    public function exam_schedule(Request $request){

        $data['getClass']= ClassModel::getClass();
        $data['getExam']= Exam::getExam();
        $result=array();
        if(!empty($request->get('exam_id')) && !empty($request->get('class_id'))){
            $getSubject=ClassSubject::mySubject($request->get('class_id'));
            foreach ($getSubject as  $value) {
                $dataS=array();
                $dataS['subject_id']=$value->subject_id;
                $dataS['class_id']=$value->class_id;
                $dataS['subject_name']=$value->subject_name;
                $dataS['subject_type']=$value->subject_type;
                $examschedule=ExamSchedule::getRecordSingle($request->get('exam_id'),$request->get('class_id'),$value->subject_id);
                if(!empty($examschedule)){
                    $dataS['exam_date']=$examschedule->exam_date;
                    $dataS['start_time']=$examschedule->start_time;
                    $dataS['end_time']=$examschedule->end_time;
                    $dataS['room_number']=$examschedule->room_number;
                    $dataS['full_marks']=$examschedule->full_marks;
                    $dataS['pass_marks']=$examschedule->pass_marks;
                }else{
                    $dataS['exam_date']='';
                    $dataS['start_time']='';
                    $dataS['end_time']='';
                    $dataS['room_number']='';
                    $dataS['full_marks']='';
                    $dataS['pass_marks']='';
                }
                $result[]=$dataS;
            }

        }
        $data['getRecord']=$result;
        $data['header_title']='Exam Schedule';
        return view('admin.examination.exam_schedule',$data);
    }


   public function single_submit_marks_register(Request $request){

        $id=$request->id;
        $getExamSchedule=ExamSchedule::getSingle($id);
        $full_marks=$getExamSchedule->full_marks;
        $pass_marks=$getExamSchedule->pass_marks;
        $class_work=!empty($request->class_work) ? $request->class_work :0;
        $home_work=!empty($request->home_work) ? $request->home_work :0;
        $test_work=!empty($request->test_work) ? $request->test_work :0;
        $exam=!empty($request->exam) ? $request->exam :0;

        $total_mark= $class_work+$home_work+$test_work+$exam;
        if($full_marks>=$total_mark){
            $getMark=MarksRegister::CheckAlreadyMark($request->student_id,$request->exam_id,$request->class_id,$request->subject_id);
            if(!empty($getMark)){
                $save=$getMark;
            }else{
                $save=new MarksRegister();
                $save->created_by=Auth::user()->id;


            }
            $save->student_id=$request->student_id;
            $save->exam_id=$request->exam_id;
            $save->class_id=$request->class_id;
            $save->subject_id=$request->subject_id;
            $save->class_work=$class_work;
            $save->home_work=$home_work;
            $save->test_work=$test_work;
            $save->exam=$exam;
            $save->full_marks=$full_marks;
            $save->pass_marks=$pass_marks;

            $save->save();
            $json['message']='Marks Register Save Successfully';

        }else{
            $json['message']='Total Marks should be Less Than Full Marks';

        }


        echo json_encode($json);

   }
    public function exam_schedule_insert(Request $request){
        ExamSchedule::deleteRecord($request->exam_id,$request->class_id);

        if(!empty($request->schedule)){
            foreach($request->schedule as $schedule){
                if(!empty($schedule['subject_id']) && !empty($schedule['exam_date']) && !empty($schedule['start_time'])
                 && !empty($schedule['end_time']) && !empty($schedule['room_number']) && !empty($schedule['full_marks'])
                 && !empty($schedule['pass_marks']))
                  {
                    $exam=new ExamSchedule();
                    $exam->exam_id=$request->exam_id;
                    $exam->class_id=$request->class_id;
                    $exam->subject_id=$schedule['subject_id'];
                    $exam->exam_date=$schedule['exam_date'];
                    $exam->start_time=$schedule['start_time'];
                    $exam->end_time=$schedule['end_time'];
                    $exam->room_number=$schedule['room_number'];
                    $exam->full_marks=$schedule['full_marks'];
                    $exam->pass_marks=$schedule['pass_marks'];
                    $exam->created_by=Auth::user()->id;
                    $exam->save();

                 }

            }
        }
        return redirect()->back()->with('success','Exam Schedule Saved Successfully');

    }
    //student side
    public function myExamTimetable(Request $request){

        $class_id=Auth::user()->class_id;
        $getExam=ExamSchedule::getExam($class_id);
        $result=array();

        foreach($getExam as $value){

            $dataE=array();
            $dataE['name']=$value->exam_name;
            $getExamTimetable=ExamSchedule::getExamTimetable($value->exam_id,$class_id);
            $resultS=array();
        foreach($getExamTimetable as $valueS){

                $dataS=array();
                $dataS['subject_name']=$valueS->subject_name;
                $dataS['exam_date']=$valueS->exam_date;
                $dataS['start_time']=$valueS->start_time;
                $dataS['end_time']=$valueS->end_time;
                $dataS['room_number']=$valueS->room_number;
                $dataS['full_marks']=$valueS->full_marks;
                $dataS['pass_marks']=$valueS->pass_marks;
                $resultS[]=$dataS;

            }
            $dataE['exam']=$resultS;
            $result[]=$dataE;
        }
        $data['getRecord']=$result;

        $data['header_title'] = 'My Exam Timetable';
        return view('student.my_exam_timetable',$data);
    }
      //student side result show
      public function myExamResult(){
        $result=array();
        $getExam=MarksRegister::getExam(Auth::user()->id);
        foreach($getExam as $value){
            $dataE=array();
            $dataE['exam_name']=$value->exam_name;
            $dataE['exam_id']=$value->exam_id;
            $getExamSubject=MarksRegister::getExamSubject($value->exam_id,Auth::user()->id);

            $dataSubject=array();
            foreach($getExamSubject as $exam){
                $total_marks=$exam['class_work'] + $exam['home_work'] + $exam['test_work'] + $exam['exam'];
                $dataS=array();
                $dataS['subject_name']=$exam['subject_name'];
                $dataS['class_work']=$exam['class_work'];
                $dataS['home_work']=$exam['home_work'];
                $dataS['test_work']=$exam['test_work'];
                $dataS['exam']=$exam['exam'];
                $dataS['total_marks']=$total_marks;
                $dataS['full_marks']=$exam['full_marks'];
                $dataS['pass_marks']=$exam['pass_marks'];
                $dataSubject[]=$dataS;
            };
            $dataE['subject']=$dataSubject;
            $result[]=$dataE;


        }
        $data['getRecord']=$result;
        $data['header_title'] = 'My Exam Result';
        return view('student.my_exam_result',$data);

      }
      public function myExamResultPrint(Request $request){
        $exam_id=$request->exam_id;
        $student_id=$request->student_id;
        $data['getExam']=Exam::getSingle($exam_id);
        $data['getStudent']=User::getSingle($student_id);
        $data['getClass']=MarksRegister::getClass($exam_id,$student_id);
        $data['getSetting']=Setting::getSingle();
        $getExamSubject=MarksRegister::getExamSubject($exam_id,$student_id);

        $dataSubject=array();
        foreach($getExamSubject as $exam){
            $total_marks=$exam['class_work'] + $exam['home_work'] + $exam['test_work'] + $exam['exam'];
            $dataS=array();
            $dataS['subject_name']=$exam['subject_name'];
            $dataS['class_work']=$exam['class_work'];
            $dataS['home_work']=$exam['home_work'];
            $dataS['test_work']=$exam['test_work'];
            $dataS['exam']=$exam['exam'];
            $dataS['total_marks']=$total_marks;
            $dataS['full_marks']=$exam['full_marks'];
            $dataS['pass_marks']=$exam['pass_marks'];
            $dataSubject[]=$dataS;
        };
        $data['getExamMark']=$dataSubject;

        return view('exam_result_print',$data);
      }
    //teacher side
    public function myExamTimetableTeacher(){
        $result=array();
        $getClass=AssignClassTeacher::getMyClassSubjectGroup(Auth::user()->id);
     foreach($getClass as  $class) {
            $dataC=array();
            $dataC['class_name']=$class->class_name;
            $getExam=ExamSchedule::getExam($class->class_id);
        $examArray=array();
          foreach($getExam as $exam){
            $dataE=array();
            $dataE['exam_name']=$exam->exam_name;
            $getExamTimetable=ExamSchedule::getExamTimetable($exam->exam_id,$class->class_id);
            $subjectArray=array();
           foreach($getExamTimetable as $valueS){

                $dataS=array();
                $dataS['subject_name']=$valueS->subject_name;
                $dataS['exam_date']=$valueS->exam_date;
                $dataS['start_time']=$valueS->start_time;
                $dataS['end_time']=$valueS->end_time;
                $dataS['room_number']=$valueS->room_number;
                $dataS['full_marks']=$valueS->full_marks;
                $dataS['pass_marks']=$valueS->pass_marks;
                $subjectArray[]=$dataS;

            }
            $dataE['subject']=$subjectArray;
            $examArray[]= $dataE;

          }
          $dataC['exam']=$examArray;
            $result[]=$dataC;
        }
        $data['getRecord']=$result;

        $data['header_title'] = 'My Exam Timetable';
        return view('teacher.my_exam_timetable',$data);
    }
    //parent side
    public function MyExamTimetableparent($student_id){

        $getUser=User::getSingle($student_id);
        $class_id=$getUser->class_id;
        $getExam=ExamSchedule::getExam($class_id);
        $result=array();

        foreach($getExam as $value){

            $dataE=array();
            $dataE['name']=$value->exam_name;
            $getExamTimetable=ExamSchedule::getExamTimetable($value->exam_id,$class_id);
            $resultS=array();
        foreach($getExamTimetable as $valueS){

                $dataS=array();
                $dataS['subject_name']=$valueS->subject_name;
                $dataS['exam_date']=$valueS->exam_date;
                $dataS['start_time']=$valueS->start_time;
                $dataS['end_time']=$valueS->end_time;
                $dataS['room_number']=$valueS->room_number;
                $dataS['full_marks']=$valueS->full_marks;
                $dataS['pass_marks']=$valueS->pass_marks;
                $resultS[]=$dataS;

            }
            $dataE['exam']=$resultS;
            $result[]=$dataE;
        }
        $data['getRecord']=$result;
        $data['getUser']=$getUser;

        $data['header_title'] = 'Exam Timetable';
        return view('parent.my_exam_timetable',$data);

    }
    public function myExamResultParent($student_id){
        $data['getStudent']=User::getSingle($student_id);

        $result=array();
        $getExam=MarksRegister::getExam($student_id);
        foreach($getExam as $value){
            $dataE=array();
            $dataE['exam_name']=$value->exam_name;
            $getExamSubject=MarksRegister::getExamSubject($value->exam_id,$student_id);

            $dataSubject=array();
            foreach($getExamSubject as $exam){
                $total_marks=$exam['class_work'] + $exam['home_work'] + $exam['test_work'] + $exam['exam'];
                $dataS=array();
                $dataS['subject_name']=$exam['subject_name'];
                $dataS['class_work']=$exam['class_work'];
                $dataS['home_work']=$exam['home_work'];
                $dataS['test_work']=$exam['test_work'];
                $dataS['exam']=$exam['exam'];
                $dataS['total_marks']=$total_marks;
                $dataS['full_marks']=$exam['full_marks'];
                $dataS['pass_marks']=$exam['pass_marks'];
                $dataSubject[]=$dataS;
            };
            $dataE['subject']=$dataSubject;
            $result[]=$dataE;


        }
        $data['getRecord']=$result;
        $data['header_title'] = 'Exam Result';
        return view('parent.my_exam_result',$data);

      }
      public function marks_grade(){
        $data['getRecord']=MarksGrade::getRecord() ;
        $data['header_title'] = 'Marks Grade';
        return view('admin.examination.marks_grade.list',$data);
      }
      public function marks_grade_add(){
        $data['header_title'] = 'Add new Marks Grade';
        return view('admin.examination.marks_grade.add',$data);
      }
      public function marks_grade_insert(Request $request){
        $grade=new MarksGrade();
        $grade->name=trim($request->name);
        $grade->percent_from=trim($request->percent_from);
        $grade->percent_to=trim($request->percent_to);
        $grade->created_by=Auth::user()->id;
        $grade->save();

        return redirect('admin/examinations/marks_grade/list')->with('success','Marks grade added successfully');
      }
      public function marks_grade_edit($id){
        $data['getRecord']=MarksGrade::getSingle($id);
        $data['header_title'] = 'Edit Marks Grade';
        return view('admin.examination.marks_grade.edit',$data);

      }
      public function marks_grade_update($id,Request $request){
        $grade=MarksGrade::getSingle($id);
        $grade->name=trim($request->name);
        $grade->percent_from=trim($request->percent_from);
        $grade->percent_to=trim($request->percent_to);
        $grade->created_by=Auth::user()->id;
        $grade->save();

        return redirect('admin/examinations/marks_grade/list')->with('success','Marks grade updated successfully');

      }
      public function marks_grade_delete($id){
        $grade=MarksGrade::getSingle($id);
        $grade->delete();
        return redirect('admin/examinations/marks_grade/list')->with('success','Marks grade deleted successfully');


      }

}
