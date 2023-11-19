<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;


class SubmitHomework extends Model
{
    use HasFactory;
    protected $table='submit_homework';

    static public function getRecord($homework_id){
        $return=self::select('submit_homework.*','users.name as first_name','users.last_name')
            ->join('users','users.id','=','submit_homework.student_id')
            ->where('submit_homework.homework_id','=', $homework_id);
            if(!empty(Request::get('first_name'))){
                $return=$return->where('users.name','like','%'.Request::get('first_name').'%');
            }
            if(!empty(Request::get('last_name'))){
                $return=$return->where('users.last_name','like','%'.Request::get('last_name').'%');
            }

            if(!empty(Request::get('created_date'))){
                $return=$return->where('homework.created_date','>=',Request::get('created_date'));
            }
            if(!empty(Request::get('created_date_to'))){
                $return=$return->where('homework.created_date','<=',Request::get('created_date_to'));
            }


        $return=$return->orderBy('submit_homework.id','desc');
        $return=$return->paginate(5);
        return $return;

    }
    static public function getRecordStudent($student_id){
        $return= self::select('submit_homework.*','class.name as class_name','subjects.name as subject_name')
        ->join('homework','homework.id','=','submit_homework.homework_id')
        ->join('class','class.id','=','homework.class_id')
        ->join('subjects','subjects.id','=','homework.subject_id')
        ->where('submit_homework.student_id', $student_id);
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


        $return=$return->orderBy('submit_homework.id','desc')
        ->paginate(10);
        return $return;

    }
    static public function getHomeworkReport(){
        $return= self::select('submit_homework.*','class.name as class_name','subjects.name as subject_name',
        'users.name as first_name','users.last_name as last_name')
        ->join('users','users.id','=','submit_homework.student_id')
        ->join('homework','homework.id','=','submit_homework.homework_id')
        ->join('class','class.id','=','homework.class_id')
        ->join('subjects','subjects.id','=','homework.subject_id');
        if(!empty(Request::get('class_id'))){
            $return=$return->where('homework.class_id',Request::get('class_id'));
        }
        if(!empty(Request::get('first_name'))){
            $return=$return->where('users.name','like','%'.Request::get('first_name').'%');
        }
        if(!empty(Request::get('last_name'))){
            $return=$return->where('users.last_name','like','%'.Request::get('last_name').'%');
        }
        if(!empty(Request::get('subject_name'))){
            $return=$return->where('subjects.name','like','%'.Request::get('subject_name').'%');
        }
        if(!empty(Request::get('class_name'))){
            $return=$return->where('class.name','like','%'.Request::get('class_name').'%');
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



        $return=$return->orderBy('submit_homework.id','desc')
        ->paginate(3);
        return $return;

    }
    public function getDocument(){
        if(!empty($this->document_file) && file_exists('homework/images/'.$this->document_file)){
            return url('homework/images/'.$this->document_file);
        }else{
            return "";
        }
    }
    public function getHomework(){
        return $this->belongsTo(Homework::class,"homework_id");
    }
    public function getStudent(){
        return $this->belongsTo(User::class,"student_id");
    }
}
