<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class StudentAttendance extends Model
{
    use HasFactory;
    protected $table='student_attendances';
    static public function CheckAlreadyAttendance($student_id,$class_id,$attendance_date){
        return self::where('student_id',$student_id)->where('class_id',$class_id)->where('attendance_date',$attendance_date)->first();
    }
    static public function getRecord(){
        $return= self::select('student_attendances.*','class.name as class_name',
        'students.name as student_name','students.last_name as student_last_name','createdBy.name as created_name'
        )
        ->join('class','class.id','=','student_attendances.class_id')
        ->join('users as students','students.id','=','student_attendances.student_id')
        ->join('users as createdBy','createdBy.id','=','student_attendances.created_by');
        if(!empty(Request::get('class_id'))){
            $return=$return->where('student_attendances.class_id',Request::get('class_id'));
        }
        if(!empty(Request::get('student_id'))){
            $return=$return->where('student_attendances.student_id',Request::get('student_id'));
        }
        if (!empty(Request::get('student_name'))) {
            $return = $return->where('students.name', 'like', '%' . Request::get('student_name') . '%');
        }
        if (!empty(Request::get('student_last_name'))) {
            $return = $return->where('students.last_name', 'like', '%' . Request::get('student_last_name') . '%');
        }

        if(!empty(Request::get('start_attendance_date'))){
            $return=$return->where('student_attendances.attendance_date','>=',Request::get('start_attendance_date'));
        }
        if(!empty(Request::get('end_attendance_date'))){
            $return=$return->where('student_attendances.attendance_date','<=',Request::get('end_attendance_date'));
        }
        if(!empty(Request::get('attendance_type'))){
            $return=$return->where('student_attendances.attendance_type',Request::get('attendance_type'));
        }

        $return=$return->orderBy('student_attendances.id','desc')
        ->paginate(10);
        return $return;
    }
    static public function getRecordTeacher($class_id){

        if(!empty($class_id)){
            $return= self::select('student_attendances.*','class.name as class_name',
            'students.name as student_name','students.last_name as student_last_name','createdBy.name as created_name'
            )
            ->join('class','class.id','=','student_attendances.class_id')
            ->join('users as students','students.id','=','student_attendances.student_id')
            ->join('users as createdBy','createdBy.id','=','student_attendances.created_by')
            ->whereIn('student_attendances.class_id',$class_id);
            if(!empty(Request::get('class_id'))){
                $return=$return->where('student_attendances.class_id',Request::get('class_id'));
            }
            if(!empty(Request::get('student_id'))){
                $return=$return->where('student_attendances.student_id',Request::get('student_id'));
            }
            if (!empty(Request::get('student_name'))) {
                $return = $return->where('students.name', 'like', '%' . Request::get('student_name') . '%');
            }
            if (!empty(Request::get('student_last_name'))) {
                $return = $return->where('students.last_name', 'like', '%' . Request::get('student_last_name') . '%');
            }

            if(!empty(Request::get('start_attendance_date'))){
                $return=$return->where('student_attendances.attendance_date','>=',Request::get('start_attendance_date'));
            }
            if(!empty(Request::get('end_attendance_date'))){
                $return=$return->where('student_attendances.attendance_date','<=',Request::get('end_attendance_date'));
            }
            if(!empty(Request::get('attendance_type'))){
                $return=$return->where('student_attendances.attendance_type',Request::get('attendance_type'));
            }

            $return=$return->orderBy('student_attendances.id','desc')
            ->paginate(10);
            return $return;
        }

        else{
            return "";
        }
 }
 static public function getRecordStudent($student_id){
    $return= self::select('student_attendances.*','class.name as class_name')
            ->join('class','class.id','=','student_attendances.class_id')
            ->where('student_attendances.student_id','=',$student_id);
            if(!empty(Request::get('class_id'))){
                $return=$return->where('student_attendances.class_id',Request::get('class_id'));
            }

            if(!empty(Request::get('start_attendance_date'))){
                $return=$return->where('student_attendances.attendance_date','>=',Request::get('start_attendance_date'));
            }
            if(!empty(Request::get('end_attendance_date'))){
                $return=$return->where('student_attendances.attendance_date','<=',Request::get('end_attendance_date'));
            }
            if(!empty(Request::get('attendance_type'))){
                $return=$return->where('student_attendances.attendance_type',Request::get('attendance_type'));
            }

    $return=$return->orderBy('student_attendances.id','desc')
            ->paginate(10);
            return $return;
 }
 static public function getRecordStudentCount($student_id){
    $return= self::select('student_attendances.id')
            ->join('class','class.id','=','student_attendances.class_id')
            ->where('student_attendances.student_id','=',$student_id)
            ->count();
    return $return;
 }
 static public function getRecordStudentCountParent($student_ids){
    $return= self::select('student_attendances.id')
            ->join('class','class.id','=','student_attendances.class_id')
            ->whereIn('student_attendances.student_id',$student_ids)
            ->count();
    return $return;
 }
 static public function getMyClassStudent($student_id){
    return self::select('student_attendances.*','class.name as class_name')
    ->join('class','class.id','=','student_attendances.class_id')
    ->where('student_attendances.student_id',$student_id)
    ->groupBy('student_attendances.class_id')
    ->get();

 }
}
