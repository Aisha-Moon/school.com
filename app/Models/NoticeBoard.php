<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\NoticeBoardMessage;
use Illuminate\Support\Facades\Request;


class NoticeBoard extends Model
{
    use HasFactory;
   protected $table= 'notice_boards';
  static public function getSingle($id){
    return self::find($id);
  }
   static public function getRecord(){
    $return= self::select('notice_boards.*','users.name as created_by_name')
    ->join('users','users.id','=','notice_boards.created_by');
    if(!empty(Request::get('title'))){
        $return=$return->where('notice_boards.title','like', '%' .Request::get('title'). '%');
    }
    if(!empty(Request::get('notice_date_from'))){
        $return=$return->where('notice_boards.notice_date','>=',Request::get('notice_date_from'));
    }
    if(!empty(Request::get('notice_date_to'))){
        $return=$return->where('notice_boards.notice_date','<=',Request::get('notice_date_to'));
    }
    if(!empty(Request::get('publish_date_from'))){
        $return=$return->where('notice_boards.publish_date_from','>=',Request::get('publish_date_from'));
    }
    if(!empty(Request::get('publish_date_to'))){
        $return=$return->where('notice_boards.publish_date_to','<=',Request::get('publish_date_to'));
    }
    if(!empty(Request::get('message_to'))){
        $return=$return->join('notice_board_messages','notice_board_messages.notice_board_id','=','notice_boards.id');
        $return =$return->where('notice_board_messages.message_to','=',Request::get('message_to'));
    }

    $return=$return->orderBy('notice_boards.id','desc')

    ->paginate(10);
    return $return;

   }
  public function getMessage(){
    return $this->hasMany(NoticeBoardMessage::class,'notice_board_id');
   }
  public function getMessageToSingle($notice_board_id,$message_to){
    return NoticeBoardMessage::where('notice_board_id' , $notice_board_id)
    ->where('message_to', $message_to)
    ->first();
   }

   static public function getRecordUser($message_to){

    $return= self::select('notice_boards.*','users.name as created_by_name')
    ->join('users','users.id','=','notice_boards.created_by');
    $return=$return->join('notice_board_messages','notice_board_messages.notice_board_id','=','notice_boards.id');
    if(!empty(Request::get('title'))){
        $return=$return->where('notice_boards.title','like', '%' .Request::get('title'). '%');
    }
    if(!empty(Request::get('notice_date_from'))){
        $return=$return->where('notice_boards.notice_date','>=',Request::get('notice_date_from'));
    }
    if(!empty(Request::get('notice_date_to'))){
        $return=$return->where('notice_boards.notice_date','<=',Request::get('notice_date_to'));
    }
    $return =$return->where('notice_board_messages.message_to','=',$message_to);
    $return =$return->where('notice_boards.publish_date','<=',date('Y-m-d'));
    $return=$return->orderBy('notice_boards.id','desc')

    ->paginate(5);
    return $return;

   }
}
