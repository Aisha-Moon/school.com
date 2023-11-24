<?php

namespace App\Http\Controllers;

use App\Models\AddFeesStudent;
use App\Models\AssignClassTeacher;
use App\Models\ClassModel;
use App\Models\ClassSubject;
use App\Models\Exam;
use App\Models\NoticeBoard;
use App\Models\Subject;
use App\Models\Homework;
use App\Models\StudentAttendance;
use App\Models\SubmitHomework;
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
                $data['getTotalTodayfees']=AddFeesStudent::getTotalTodayfees();
                $data['getTotalfees']=AddFeesStudent::getTotalfees();
                $data['totalExam']=Exam::totalExam();
                $data['totalClass']=ClassModel::totalClass();
                $data['totalSubject']=Subject::totalSubject();
                $data['totalStudents']=User::getTotalUser(3);
                $data['totalAdmin']=User::getTotalUser(1);
                $data['totalTeacher']=User::getTotalUser(2);
                $data['totalParent']=User::getTotalUser(4);


                return view('admin.dashboard',$data,compact('profile'));
            }else if(Auth::user()->user_type== 2){

                $data['totalStudents']=User::getTeacherStudentCount(Auth::user()->id);
                $data['totalClass']=AssignClassTeacher::getMyClassSubjectGroupCount(Auth::user()->id);
                $data['totalSubject']=AssignClassTeacher::getMyClassSubjectCount(Auth::user()->id);
                $data['totalNotice']=NoticeBoard::getRecordUserCount(Auth::user()->user_type);

                return view('teacher.dashboard',$data,compact('profile'));

            }else if(Auth::user()->user_type== 3){
                $data['TotalPaidAmount']=AddFeesStudent::TotalPaidAmountStudent(Auth::user()->id);
                $data['totalSubjects']=ClassSubject::mySubjectCount(Auth::user()->class_id);
                $data['totalNotice']=NoticeBoard::getRecordUserCount(Auth::user()->user_type);
                $data['totalHomework']=Homework::getRecordStudentCount(Auth::user()->class_id,Auth::user()->id);
                $data['totalSubmittedHomework']=SubmitHomework::getSubmittedHomework(Auth::user()->id);
                $data['totalAttendance']=StudentAttendance::getRecordStudentCount(Auth::user()->id);


                return view('student.dashboard',$data,compact('profile'));

            }else if(Auth::user()->user_type== 4){

                $student_ids=User::getMyStudentId(Auth::user()->id);
                $class_ids=User::getMyStudentClassId(Auth::user()->id);
                if(!empty($class_ids) && !empty($student_ids)){
                    $data['totalHomework']=Homework::getRecordStudentCount($class_ids,$student_ids);

                }else{
                    $data['totalHomework']=0;

                }

                if(!empty($student_ids)){
                    $data['TotalPaidAmount']=AddFeesStudent::TotalPaidAmountStudentParent( $student_ids);
                    $data['totalAttendance']=StudentAttendance::getRecordStudentCountParent( $student_ids);
                    $data['totalSubmittedHomework']=SubmitHomework::getSubmittedHomeworkParent($student_ids);

                }else{
                    $data['TotalPaidAmount']=0;
                    $data['totalAttendance']=0;
                    $data['totalSubmittedHomework']=0;


                }

                $data['getTotalfees']=AddFeesStudent::getTotalfees();
                $data['totalStudents']=User::getMyStudentCount(Auth::user()->id);
                $data['totalNotice']=NoticeBoard::getRecordUserCount(Auth::user()->user_type);

                return view('parent.dashboard',$data,compact('profile'));

            }
    }
}
}
