<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class Subject extends Model
{
    use HasFactory;
    protected $table='subjects';
    static public function getRecord(){
        $return=Subject::select('subjects.*','users.name as created_by_name')
                        ->join('users','users.id','subjects.created_by');
                        if(!empty(Request::get('name'))){
                            $return->where('subjects.name','LIKE','%'.Request::get('name').'%');
                           }
                        if(!empty(Request::get('type'))){
                            $return->where('subjects.type','LIKE','%'.Request::get('type').'%');
                           }
                        if(!empty(Request::get('date'))){
                            $return->whereDate('subjects.created_at','LIKE','%'.Request::get('date').'%');
                           }

         $return=$return->where('subjects.is_delete','=',0)
                        ->orderBy('subjects.id','desc')->paginate(5);
     return $return;
    }

    static public function getSingle($id){
        return self::find($id);

      }
      static public function getSubject(){
        $return=Subject::select('subjects.*')
        ->join('users','users.id','subjects.created_by')
        ->where('subjects.is_delete','=',0)
        ->where('subjects.status','=',0)
        ->orderBy('subjects.name','asc')->get();
return $return;
      }
}
