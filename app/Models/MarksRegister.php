<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarksRegister extends Model
{
    use HasFactory;
    protected $table='marks_registers';
    static public function CheckAlreadyMark($student_id,$exam_id,$class_id,$subject_id){
        return self::where('student_id',$student_id)->where('exam_id',$exam_id)->where('class_id',$class_id)->where('subject_id',$subject_id)->first();
    }
    static public function getExam($student_id){
        return self::select('marks_registers.*','exams.name as exam_name')
        ->join('exams','exams.id','=','marks_registers.exam_id')
        ->where('marks_registers.student_id',$student_id)
        ->groupBy('marks_registers.exam_id')
        ->get();
    }
    static public function getExamSubject($exam_id,$student_id){
        return self::select('marks_registers.*','exams.name as exam_name','subjects.name as subject_name')
        ->join('exams','exams.id','=','marks_registers.exam_id')
        ->join('subjects','subjects.id','=','marks_registers.subject_id')
        ->where('marks_registers.exam_id',$exam_id)
        ->where('marks_registers.student_id',$student_id)
        ->get();
    }
    static public function getClass($exam_id,$student_id){
        return self::select('class.name as class_name')
        ->join('exams','exams.id','=','marks_registers.exam_id')
        ->join('class','class.id','=','marks_registers.class_id')
        ->join('subjects','subjects.id','=','marks_registers.subject_id')
        ->where('marks_registers.exam_id', $exam_id)
        ->where('marks_registers.student_id', $student_id)
        ->first();

    }
}
