<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

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
      static public function getRecord()
{
    $return = self::select(
        'add_fees_students.*',
        'class.name as class_name',
        'users.name as created_name',
        'student.name as student_first_name',
        'student.last_name as student_last_name'
    )
    ->join('class', 'class.id', '=', 'add_fees_students.class_id')
    ->join('users as student', 'student.id', '=', 'add_fees_students.student_id')
    ->join('users', 'users.id', '=', 'add_fees_students.created_by')
    ->where('add_fees_students.is_paid', '=', 1)
    ->orderBy('add_fees_students.id', 'desc');

    if (!empty(Request::get('class_id'))) {
        $return = $return->where('add_fees_students.class_id', Request::get('class_id'));
    }

    if (!empty(Request::get('student_id'))) {
        $return = $return->where('add_fees_students.student_id', Request::get('student_id'));
    }

    if (!empty(Request::get('student_name'))) {
        $return = $return->where('student.name', 'like', '%' . Request::get('student_name') . '%');
    }

    if (!empty(Request::get('student_last_name'))) {
        $return = $return->where('student.last_name', 'like', '%' . Request::get('student_last_name') . '%');
    }
    if(!empty(Request::get('start_created_date'))){
        $return=$return->where('add_fees_students.created_at','>=',Request::get('start_created_date'));
    }
    if(!empty(Request::get('end_created_date'))){
        $return=$return->where('add_fees_students.created_at','<=',Request::get('end_created_date'));
    }
    if(!empty(Request::get('payment_type'))){
        $return=$return->where('add_fees_students.payment_type',Request::get('payment_type'));
    }

    // ... other conditions

    $return = $return->paginate(5);

    return $return;
}
      static public function  getPaidAmount($student_id,$class_id){
            return self::where('add_fees_students.class_id',$class_id)
            ->where('add_fees_students.student_id',$student_id)
            ->where('add_fees_students.is_paid','=',1)
            ->sum('add_fees_students.paid_amount');
      }

      static public function  getTotalTodayfees(){
            return self::where('add_fees_students.is_paid','=',1)
            ->whereDate('add_fees_students.created_at','=',date('Y-m-d'))
            ->sum('add_fees_students.paid_amount');
      }
      static public function  getTotalfees(){
            return self::where('add_fees_students.is_paid','=',1)
            ->sum('add_fees_students.paid_amount');
      }
      static public function  TotalPaidAmountStudent($student_id){
            return self::where('add_fees_students.is_paid','=',1)
            ->where('add_fees_students.student_id','=',$student_id)
            ->sum('add_fees_students.paid_amount');
      }
      static public function  TotalPaidAmountStudentParent($student_ids){
            return self::where('add_fees_students.is_paid','=',1)
            ->whereIn('add_fees_students.student_id',$student_ids)
            ->sum('add_fees_students.paid_amount');
      }

      public function class() {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'student_id');
    }
}
