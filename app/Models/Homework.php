<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;


class Homework extends Model
{
    use HasFactory;
    protected $table='homework';
    static public function getRecord(){
        $return=self::select('homework.*','class.name as class_name','subjects.name as subject_name',
        'users.name as created_by_name')
        ->join('users','users.id','=','homework.created_by')
        ->join('class','class.id','=','homework.class_id')
        ->join('subjects','subjects.id','=','homework.subject_id')
        ->where('homework.is_delete','=',0);
        if(!empty(Request::get('class_id'))){
            $return=$return->where('homework.class_id',Request::get('class_id'));
        }
        if(!empty(Request::get('subject_name'))){
            $return=$return->where('subjects.name','like','%'.Request::get('subject_name').'%');
        }
        if(!empty(Request::get('homework_date'))){
            $return=$return->where('homework.homework_date','>=',Request::get('homework_date'));
        }
        if(!empty(Request::get('homework_date_to'))){
            $return=$return->where('homework.homework_date','<=',Request::get('homework_date_to'));
        }
        if(!empty(Request::get('submission_date'))){
            $return=$return->where('homework.submission_date','>=',Request::get('submission_date'));
        }
        if(!empty(Request::get('submission_date_to'))){
            $return=$return->where('homework.submission_date','<=',Request::get('submission_date_to'));
        }
        if(!empty(Request::get('created_date'))){
            $return=$return->where('homework.created_date','>=',Request::get('created_date'));
        }
        if(!empty(Request::get('created_date_to'))){
            $return=$return->where('homework.created_date','<=',Request::get('created_date_to'));
        }
        $return=$return->orderBy('homework.id','desc')
        ->paginate(5);
        return $return;
    }
    static public function getRecordTeacher($class_ids){
        $return=self::select('homework.*','class.name as class_name','subjects.name as subject_name',
        'users.name as created_by_name')
        ->join('users','users.id','=','homework.created_by')
        ->join('class','class.id','=','homework.class_id')
        ->join('subjects','subjects.id','=','homework.subject_id')
        ->whereIn('homework.class_id', $class_ids)
        ->where('homework.is_delete','=',0);
        if(!empty(Request::get('class_id'))){
            $return=$return->where('homework.class_id',Request::get('class_id'));
        }
        if(!empty(Request::get('subject_name'))){
            $return=$return->where('subjects.name','like','%'.Request::get('subject_name').'%');
        }
        if(!empty(Request::get('homework_date'))){
            $return=$return->where('homework.homework_date','>=',Request::get('homework_date'));
        }
        if(!empty(Request::get('homework_date_to'))){
            $return=$return->where('homework.homework_date','<=',Request::get('homework_date_to'));
        }
        if(!empty(Request::get('submission_date'))){
            $return=$return->where('homework.submission_date','>=',Request::get('submission_date'));
        }
        if(!empty(Request::get('submission_date_to'))){
            $return=$return->where('homework.submission_date','<=',Request::get('submission_date_to'));
        }
        if(!empty(Request::get('created_date'))){
            $return=$return->where('homework.created_date','>=',Request::get('created_date'));
        }
        if(!empty(Request::get('created_date_to'))){
            $return=$return->where('homework.created_date','<=',Request::get('created_date_to'));
        }
        $return=$return->orderBy('homework.id','desc')
        ->paginate(5);
        return $return;
    }
    static public function getRecordStudent($class_ids,$student_id){
        $return=self::select('homework.*','class.name as class_name','subjects.name as subject_name',
        'users.name as created_by_name')
        ->join('users','users.id','=','homework.created_by')
        ->join('class','class.id','=','homework.class_id')
        ->join('subjects','subjects.id','=','homework.subject_id')
        ->where('homework.class_id','=', $class_ids)
        ->where('homework.is_delete','=',0)
        ->whereNotIn('homework.id', function ($query) use ($student_id) {
            $query->select('submit_homework.homework_id')
                ->from('submit_homework')
                ->where('submit_homework.student_id', $student_id);
        });
        if(!empty(Request::get('class_id'))){
            $return=$return->where('homework.class_id',Request::get('class_id'));
        }
        if(!empty(Request::get('subject_name'))){
            $return=$return->where('subjects.name','like','%'.Request::get('subject_name').'%');
        }
        if(!empty(Request::get('homework_date'))){
            $return=$return->where('homework.homework_date','>=',Request::get('homework_date'));
        }
        if(!empty(Request::get('homework_date_to'))){
            $return=$return->where('homework.homework_date','<=',Request::get('homework_date_to'));
        }
        if(!empty(Request::get('submission_date'))){
            $return=$return->where('homework.submission_date','>=',Request::get('submission_date'));
        }
        if(!empty(Request::get('submission_date_to'))){
            $return=$return->where('homework.submission_date','<=',Request::get('submission_date_to'));
        }
        if(!empty(Request::get('created_date'))){
            $return=$return->where('homework.created_date','>=',Request::get('created_date'));
        }
        if(!empty(Request::get('created_date_to'))){
            $return=$return->where('homework.created_date','<=',Request::get('created_date_to'));
        }
        $return=$return->orderBy('homework.id','desc')
        ->paginate(5);
        return $return;
    }
    public function getDocument(){
        if(!empty($this->document) && file_exists('homework/images/'.$this->document)){
            return url('homework/images/'.$this->document);
        }else{
            return "";
        }
    }
    static public function getSingle($id){
        return self::find($id);

      }


}
