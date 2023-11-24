<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class Exam extends Model
{
    use HasFactory;
    protected $table = 'exams';

    static public function getRecord(){
        $return= self::select('exams.*','users.name as created_name')
        ->join('users','users.id','=','exams.created_by');
        if(!empty(Request::get('name'))){
            $return->where('exams.name','LIKE','%'.Request::get('name').'%');
           }
           if(!empty(Request::get('date'))){
            $return->whereDate('exams.created_at','=',Request::get('date'));
           }
        $return =$return->where('exams.is_delete','=',0)
        ->orderBy('exams.id','desc')
        ->paginate(20);
        return $return;

    }
    static public function getSingle($id){
        return self::find($id);

      }
      static public function getExam(){
        return self::select('exams.*')
        ->join('users','users.id','=','exams.created_by')
        ->where('exams.is_delete','=',0)
        ->orderBy('exams.name','desc')
        ->get();
    }
      static public function totalExam(){
        return self::select('exams.*')
        ->join('users','users.id','=','exams.created_by')
        ->where('exams.is_delete','=',0)
        ->count();


    }
}
