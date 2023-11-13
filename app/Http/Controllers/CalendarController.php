<?php

namespace App\Http\Controllers;

use App\Models\AssignClassTeacher;
use App\Models\ClassSubject;
use App\Models\ClassSubjectTimetable;
use App\Models\ExamSchedule;
use App\Models\User;
use App\Models\Week;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    //student
    public function myCalendar(){


        $data['getMyTimeTable']=$this->getTimetable(Auth::user()->class_id);
        $data['getExamTimeTable']=$this->getExamTimeTable(Auth::user()->class_id);
        $data['header_title']='My Calendar';
        return view('student.my_calendar',$data);

    }
    public function getExamTimeTable($class_id){
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
        return $result;
    }
    public function  getTimetable($class_id){
        $result=array();
        $getRecord=ClassSubject::mySubject($class_id);
        foreach ($getRecord as $record) {
            $dataS['name']= $record->subject_name;
            $getWeek=Week::getRecord();
            $week=array();
            foreach($getWeek as $valueW){
                $dataW=array();
                $dataW['week_name']=$valueW->name;
                $dataW['fullcalendar_day']=$valueW->fullcalendar_day;
                $classSubject=ClassSubjectTimetable::getRecordClassSubject($record->class_id,$record->subject_id,$valueW->id);
                    if(!empty($classSubject)){
                        $dataW['start_time']=$classSubject->start_time;
                        $dataW['end_time']=$classSubject->end_time;
                        $dataW['room_number']=$classSubject->room_number;
                        $week[]=$dataW;
                    }
            }
            $dataS['week']=$week;
            $result[]= $dataS;
        }
        return $result;
    }
    public function myCalendarParent($student_id){
        $getStudent=User::getSingle($student_id);
        $data['getMyTimeTable']=$this->getTimetable($getStudent->class_id);
        $data['getExamTimeTable']=$this->getExamTimeTable($getStudent->class_id);

        $data['getStudent']= $getStudent;
        $data['header_title']='My Student Calendar';
        return view('parent.my_calendar',$data);

    }
    //teacher side
    public function myCalendarTeacher(){
        $teacher_id=Auth::user()->id;
        $data['getClassTimetable']=AssignClassTeacher::getCalendarTeacher($teacher_id);
        $data['getExamTimeTable']=ExamSchedule::getExamTimeTableTeacher($teacher_id);
        $data['header_title']='My Calendar';
        return view('teacher.my_calendar',$data);

    }

}
