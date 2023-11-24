<?php

namespace App\Models;

use App\Models\Week;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;


class AssignClassTeacher extends Model
{
    use HasFactory;
    protected $table='assign_class_teachers';
    static public function getAlreadyFirst($class_id,$teacher_id){
        return self::where('class_id','=',$class_id)->where('teacher_id','=',$teacher_id)->first();
    }
    static public function getRecord(){
        $return =self::select('assign_class_teachers.*','class.name as class_name','teacher.name as teacher_name','users.name as created_by_name')
                    ->join('users as teacher','teacher.id','=','assign_class_teachers.teacher_id')
                    ->join('class','class.id','=','assign_class_teachers.class_id')
                    ->join('users','users.id','=','assign_class_teachers.created_by')
                    ->where('assign_class_teachers.is_delete','=',0);
                    if(!empty(Request::get('teacher_name'))){
                        $return->where('teacher.name','LIKE','%'.Request::get('teacher_name').'%');
                       }
                    if(!empty(Request::get('class_name'))){
                        $return->where('class.name','LIKE','%'.Request::get('class_name').'%');
                       }
                    if(!empty(Request::get('date'))){
                        $return->whereDate('assign_class_teachers.created_at','=',Request::get('date'));
                       }
                    if(!empty(Request::get('status'))){
                        $status=(Request::get('status') == 100?0:1);
                        $return=$return->where('assign_class_teachers.status','=',$status);
                    }

        $return=$return->orderBy('assign_class_teachers.id','desc')->paginate(5);
        return $return;

    }

    static public function getSingle($id){
        return self::find($id);

      }
      static public function getAssignTeacherId($class_id){
        return self::where('class_id','=',$class_id)->where('is_delete','=',0)->get() ;


      }
      static public function deleteTeacher($class_id){
        return self::where('class_id','=',$class_id)->delete();
      }

      static public function getMyClassSubject($teacher_id){
        return AssignClassTeacher::select('assign_class_teachers.*','class.name as class_name',
        'subjects.name as subject_name','subjects.type as subject_type','class.id as class_id','subjects.id as subject_id')
        ->join('class','class.id','=','assign_class_teachers.class_id')
        ->join('class_subjects','class_subjects.class_id','=','class.id')
        ->join('subjects','subjects.id','=','class_subjects.subject_id')
        ->where('assign_class_teachers.is_delete','=',0)
        ->where('assign_class_teachers.status','=',0)
        ->where('subjects.status','=',0)
        ->where('subjects.is_delete','=',0)
        ->where('class_subjects.status','=',0)
        ->where('class_subjects.is_delete','=',0)
        ->where('assign_class_teachers.teacher_id','=',$teacher_id)
        ->get();
      }
      static public function getMyClassSubjectCount($teacher_id){
        return AssignClassTeacher::select('assign_class_teachers.id')
        ->join('class','class.id','=','assign_class_teachers.class_id')
        ->join('class_subjects','class_subjects.class_id','=','class.id')
        ->join('subjects','subjects.id','=','class_subjects.subject_id')
        ->where('assign_class_teachers.is_delete','=',0)
        ->where('assign_class_teachers.status','=',0)
        ->where('subjects.status','=',0)
        ->where('subjects.is_delete','=',0)
        ->where('class_subjects.status','=',0)
        ->where('class_subjects.is_delete','=',0)
        ->where('assign_class_teachers.teacher_id','=',$teacher_id)
        ->count();
      }
      static public function getMyClassSubjectGroup($teacher_id){
        return AssignClassTeacher::select('assign_class_teachers.*','class.name as class_name','class.id as class_id')
        ->join('class','class.id','=','assign_class_teachers.class_id')
        ->where('assign_class_teachers.is_delete','=',0)
        ->where('assign_class_teachers.status','=',0)
        ->where('assign_class_teachers.teacher_id','=',$teacher_id)
        ->groupBy('assign_class_teachers.class_id')
        ->get();
      }
      static public function getMyClassSubjectGroupCount($teacher_id){
        return AssignClassTeacher::select('assign_class_teachers.id')
        ->join('class','class.id','=','assign_class_teachers.class_id')
        ->where('assign_class_teachers.is_delete','=',0)
        ->where('assign_class_teachers.status','=',0)
        ->where('assign_class_teachers.teacher_id','=',$teacher_id)
        ->count();
      }
      static public function getMyTimeTable($class_id,$subject_id){
        $getWeek=Week::getWeekUsingName(date('l'));
        return ClassSubjectTimetable::getRecordClassSubject($class_id,$subject_id,$getWeek->id);


      }
      static public function getCalendarTeacher($teacher_id){
        return self::select('class_subject_timetable.*','class.name as class_name','subjects.name as subject_name'
        ,'weeks.name as week_name','weeks.fullcalendar_day')
        ->join('class','class.id','=','assign_class_teachers.class_id')
        ->join('class_subjects','class_subjects.class_id','=','class.id')
        ->join('class_subject_timetable','class_subject_timetable.subject_id','=','class_subjects.subject_id')
        ->join('subjects','subjects.id','=','class_subject_timetable.subject_id')
        ->join('weeks','weeks.id','=','class_subject_timetable.week_id')
        ->where('assign_class_teachers.teacher_id','=',$teacher_id)
        ->where('assign_class_teachers.is_delete','=',0)
        ->where('assign_class_teachers.status','=',0)
        ->get();
      }


}
