<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class ClassModel extends Model
{
    use HasFactory;
    protected $table='class';
    static public function getSingle($id){
        return self::find($id);

      }
  static public function getRecord(){
    $return=ClassModel::select('class.*','users.name as created_by_name')
                        ->join('users','users.id','class.created_by');
                       if(!empty(Request::get('name'))){
                        $return->where('class.name','LIKE','%'.Request::get('name').'%');
                       }
                       if(!empty(Request::get('date'))){
                        $return->whereDate('class.created_at','LIKE','%'.Request::get('date').'%');
                       }
         $return=$return->where('class.is_delete','=',0)
                        ->orderBy('class.id','desc')->paginate(5);
     return $return;
  }

  static public function getClass(){
    $return=ClassModel::select('class.*')
                            ->join('users','users.id','class.created_by')
                            ->where('class.is_delete','=',0)
                            ->where('class.status','=',0)
                            ->orderBy('class.name','asc')->get();
    return $return;
  }
  static public function totalClass(){
    $return=ClassModel::select('class.id')
                            ->join('users','users.id','class.created_by')
                            ->where('class.is_delete','=',0)
                            ->where('class.status','=',0)
                            ->count();
    return $return;
  }

}
