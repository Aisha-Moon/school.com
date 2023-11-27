<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ChatController extends Controller
{
    public function chats(Request $request){
        $data['header_title'] ='My Chat';

        $sender_id=Auth::user()->id;
        if(!empty($request->receiver_id)){
            $receiver_id=base64_decode($request->receiver_id);

            if($receiver_id==$sender_id){
                return redirect()->back()->with('error','Error occured,Please try again.');
            }
            Chat::updateCount($sender_id,$receiver_id);
            $data['receiver_id']=$receiver_id;
            $data['getReceiver']=User::getSingle($receiver_id);
            $data['getChat']=Chat::getChat($receiver_id,$sender_id);
            // dd($data['getChat']);
        }else{
            $data['getReceiver']='';
        }
        $data['getChatUser']=Chat::getChatUser($sender_id);
        return view('chat.list', $data);

    }
    public function submit_message(Request $request){

        $chat=new Chat();
        $chat->sender_id=Auth::user()->id;
        $chat->receiver_id=$request->receiver_id;
        $chat->message=$request->message;
        $chat->created_date=time();
        if(!empty($request->file('file_name'))){
            $file=$request->file('file_name');
            $extension=$file->getClientOriginalExtension();
            $filename=time().'.'.$extension;
            $file->move('chating/images',$filename);
            $chat->file=$filename;

        }
        $chat->save();

        $getChat=Chat::where('id','=',$chat->id)->get();
        return response()->json([
            "status"=>true,
            "success"=>view('chat._single',[
                "getChat"=>$getChat,

            ])->render(),

        ],200);

    }
    public function get_chat_window(Request $request){

        $receiver_id=$request->receiver_id;
        $sender_id=Auth::user()->id;

        Chat::updateCount($sender_id,$receiver_id);

        $getReceiver=User::getSingle($receiver_id);
        $getChat=Chat::getChat($receiver_id,$sender_id);
        return response()->json([
            "status"=>true,
            "receiver_id"=>base64_encode($receiver_id),
            "success"=>view('chat._message',[
                "getReceiver"=>$getReceiver,
                "getChat"=>$getChat,

            ])->render(),

        ],200);

}
public function get_chat_search_user(Request $request){
    $receiver_id=$request->receiver_id;
    $sender_id=Auth::user()->id;
    $getChatUser=Chat::getChatUser($sender_id);

    return response()->json([
        "status"=>true,
        "success"=>view('chat._user',[
            "getChatUser"=>$getChatUser,
            "receiver_id"=>$receiver_id,

        ])->render(),

    ],200);
}
}
