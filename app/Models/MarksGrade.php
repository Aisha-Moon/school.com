<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarksGrade extends Model
{
    use HasFactory;
    protected $table='marks_grades';

    static public function getRecord(){
        return self::select('marks_grades.*','users.name as created_by')
        ->join('users','users.id','=','marks_grades.created_by')
        ->get();
    }
    static public function getSingle($id){
        return self::find($id);

      }
    static public function getGrade($percentage){
        $return= self::select('marks_grades.*')
        ->where('percent_from','<=', $percentage)
        ->where('percent_to','>=', $percentage)
        ->first();
        return !empty($return->name) ? $return->name : '';
    }
}
