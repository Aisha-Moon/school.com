<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddFeesStudent extends Model
{
    use HasFactory;
    protected $table='add_fees_students';
    static public function getSingle($id){
        return self::find($id);

      }
      static public function  getFees($student_id){
        return self::select('add_fees_students.*','class.name as class_name'
        ,'users.name as created_name')
        ->join('class','class.id','=','add_fees_students.class_id')
        ->join('users','users.id','=','add_fees_students.created_by')
        ->where('add_fees_students.is_paid','=',1)
        ->where('add_fees_students.student_id',$student_id)
        ->get();
      }
      static public function  getPaidAmount($student_id,$class_id){
            return self::where('add_fees_students.class_id',$class_id)
            ->where('add_fees_students.student_id',$student_id)
            ->where('add_fees_students.is_paid','=',1)
            ->sum('add_fees_students.paid_amount');
      }
}
