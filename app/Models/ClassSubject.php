<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class ClassSubject extends Model
{
    use HasFactory;
    protected $table='class_subjects';
    static public function getRecord(){
        $return =self::select('class_subjects.*','class.name as class_name','subjects.name as subject_name','users.name as created_by_name')
                    ->join('subjects','subjects.id','=','class_subjects.subject_id')
                    ->join('class','class.id','=','class_subjects.class_id')
                    ->join('users','users.id','=','class_subjects.created_by')
                    ->where('class_subjects.is_delete','=',0);
                    if(!empty(Request::get('subject_name'))){
                        $return->where('subjects.name','LIKE','%'.Request::get('subject_name').'%');
                       }
                    if(!empty(Request::get('class_name'))){
                        $return->where('class.name','LIKE','%'.Request::get('class_name').'%');
                       }
                    if(!empty(Request::get('date'))){
                        $return->whereDate('class_subjects.created_at','LIKE','%'.Request::get('date').'%');
                       }
        $return=$return->orderBy('class_subjects.id','desc')->paginate(10);
        return $return;

    }
    static public function getAlreadyFirst($class_id,$subject_id){
        return self::where('class_id','=',$class_id)->where('subject_id','=',$subject_id)->first();
    }

static public function getSingle($id){
        return self::find($id);

      }
      static public function getAssignSubjectId($class_id){
        return self::where('class_id','=',$class_id)->where('is_delete','=',0)->get() ;


      }
      static public function deleteSubject($class_id){
        return self::where('class_id','=',$class_id)->delete();
      }
      static public function mySubject($class_id){

      return self::select('class_subjects.*','subjects.name as subject_name','subjects.type as subject_type')
      ->join('subjects','subjects.id','=','class_subjects.subject_id')
      ->join('class','class.id','=','class_subjects.class_id')
      ->join('users','users.id','=','class_subjects.created_by')
      ->where('class_subjects.class_id','=',$class_id)
      ->where('class_subjects.is_delete','=',0)
      ->where('class_subjects.status','=',0)
     ->orderBy('class_subjects.id','desc')->get();

      }
}
