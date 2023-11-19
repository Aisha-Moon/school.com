<?php

namespace App\Http\Controllers;

use App\Models\AssignClassTeacher;
use App\Models\ClassModel;
use App\Models\StudentAttendance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function AttendanceStudent(Request $request){
        $data['getClass']=ClassModel::getClass();

        if(!empty($request->get('class_id')) && !empty($request->get('attendance_date'))){
            $data['getStudent']=User::getStudentClass($request->get('class_id'));

        }
        $data['header_title']='Student Attendance';
        return view('admin.attendance.student',$data);

    }
    public function  AttendanceStudentSave(Request $request){
        $check_attendance=StudentAttendance::CheckAlreadyAttendance($request->student_id,$request->class_id,$request->attendance_date);
        if(!empty($check_attendance)){
            $attendance=$check_attendance;
        }else{
            $attendance=new StudentAttendance();
            $attendance->class_id=$request->class_id;
            $attendance->student_id=$request->student_id;
            $attendance->attendance_date=$request->attendance_date;
            $attendance->created_by=Auth::user()->id;

        }
        $attendance->attendance_type=$request->attendance_type;
        $attendance->save();



        $json['message']='Attendance saved successfully';
        echo json_encode($json);
    }
    public function AttendanceReport(Request $request){

        $data['getClass']=ClassModel::getClass();
        $data['getRecord']=StudentAttendance::getRecord();

        $data['header_title']=' Attendance Report';
        return view('admin.attendance.report',$data);

    }
    public function AttendanceReportTeacher(Request $request){
        $getClass=AssignClassTeacher::getMyClassSubjectGroup(Auth::user()->id);
        $class_array=array();
        foreach($getClass as $value){
            $class_array[]=$value->class_id;
        }
        $data['getClass']=$getClass;
        $data['getRecord']=StudentAttendance::getRecordTeacher($class_array);

        $data['header_title']=' Attendance Report';
        return view('teacher.attendance.report',$data);



    }
    public function AttendanceStudentTeacher(Request $request){
        $data['getClass']=AssignClassTeacher::getMyClassSubjectGroup(Auth::user()->id);

        if(!empty($request->get('class_id')) && !empty($request->get('attendance_date'))){
            $data['getStudent']=User::getStudentClass($request->get('class_id'));

        }
        $data['header_title']='Student Attendance';
        return view('teacher.attendance.student',$data);

    }
    //student side work
    public function myAttendanceStudent(){
        $data['getClass']=StudentAttendance::getMyClassStudent(Auth::user()->id);

        $data['getRecord']=StudentAttendance::getRecordStudent(Auth::user()->id);
        $data['header_title']='My Attendance';
        return view('student.my_attendance',$data);

    }
    //parent side work
    public function myAttendanceParent($student_id)
    {
        $data['getStudent']=User::getSingle($student_id);
        $data['getClass']=StudentAttendance::getMyClassStudent($student_id);

        $data['getRecord']=StudentAttendance::getRecordStudent($student_id);
        $data['header_title']="My Student's Attendance";
        return view('parent.my_attendance',$data);
    }
}
