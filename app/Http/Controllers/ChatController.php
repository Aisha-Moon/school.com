<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Chat;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ChatController extends Controller
{
    public function chat(Request $request){
        $data['header_title'] ='My Chat';

        $sender_id=Auth::user()->id;
        if(!empty($request->receiver_id)){
            $receiver_id=base64_decode($request->receiver_id);
            if($receiver_id==$sender_id){
                return redirect()->back()->with('error','Error occured,Please try again.');
                exit();
            }
            Chat::updateCount($sender_id,$receiver_id);
            $data['getReceiver']=User::getSingle($receiver_id);
            $data['getChat']=Chat::getChat($receiver_id,$sender_id);
            // dd($data['getChat']);
        }
        $data['getChatUser']=Chat::getChatUser($sender_id);
        return view('chat.list',$data);


    }
    public function submit_message(Request $request){

        $chat=new Chat();
        $chat->sender_id=Auth::user()->id;
        $chat->receiver_id=$request->receiver_id;
        $chat->message=$request->message;
        $chat->created_date=time();
        $chat->save();

        $getChat=Chat::where('id','=',$chat->id)->get();
        return response()->json([
            "status"=>true,
            "success"=>view('chat._single',[
                "getChat"=>$getChat,

            ])->render(),

        ],200);

    }
}
