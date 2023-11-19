<?php

namespace App\Http\Controllers;

use App\Mail\SendEmailUserMail;
use App\Models\NoticeBoardMessage;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\NoticeBoard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CommunicateController extends Controller
{
    public function SendEmail(){
        $data['getRecord']=NoticeBoard::getRecord();
        $data['header_title']='Send Email';
        return view('admin.communicate.send_email',$data);
    }
    public function SendEmailUser(Request $request){
        if(!empty($request->user_id)){
            $user=User::getSingle($request->user_id);
            $user->send_message=$request->message;
            $user->send_subject=$request->subject;
            Mail::to($user->email)->send(new SendEmailUserMail($user));

        }
        if(!empty($request->message_to)){
            foreach ($request->message_to as  $user_type) {
                $getUser=User::getUser($user_type);
                foreach($getUser as $user){
                    $user->send_message=$request->message;
                    $user->send_subject=$request->subject;

                    Mail::to($user->email)->send(new SendEmailUserMail($user));

                }
            }
        }
        return redirect()->back()->with('success', 'Email sent successfully');
    }
    public function SearchUser(Request $request){

        $json=array();
        if(!empty($request->search)){
            $getUser=User::SearchUser($request->search);
            foreach ($getUser as  $value) {
                $type='';
                if($value->user_type==1){
                    $type= 'Admin';
                }else if($value->user_type== 2){
                    $type= 'Teacher';

                }else if($value->user_type== 3){
                    $type= 'Student';
                }else if($value->user_type== 4){
                    $type= 'Parent';
                }
                $name=$value->name.' '.$value->last_name.' - '.$type;
                $json[]=['id'=>$value->id, 'text'=>$name];
            }
        }
        echo json_encode($json);
    }
    public function noticeBoard(){
        $data['getRecord']=NoticeBoard::getRecord();
        $data['header_title']='Notice Board';
        return view('admin.communicate.noticeboard.list',$data);
    }
    public function AddNoticeBoard(){
        $data['header_title']='Add New Notice Board';
        return view('admin.communicate.noticeboard.add',$data);
    }
    public function InsertNoticeBoard(Request $request){
        $notice=new NoticeBoard();
        $notice->title=$request->title;
        $notice->notice_date=$request->notice_date;
        $notice->publish_date=$request->publish_date;
        $notice->message=$request->message;
        $notice->created_by=Auth::user()->id;
        $notice->save();
       if(!empty($request->message_to)){
        foreach ($request->message_to as $message_to) {
            $message=new NoticeBoardMessage();
            $message->notice_board_id=$notice->id;
            $message->message_to=$message_to;
            $message->save();
        }
       }

        return redirect('admin/communicate/notice_board')->with('success','Notice Created Successfully');
    }
    public function EditNoticeBoard($id){
        $data['getRecord']=NoticeBoard::getSingle($id);
        $data['header_title']='Edit Notice Board';
        return view('admin.communicate.noticeboard.edit',$data);

    }

    public function UpdateNoticeBoard($id,Request $request){
        $notice= NoticeBoard::getSingle($id);
        $notice->title=$request->title;
        $notice->notice_date=$request->notice_date;
        $notice->publish_date=$request->publish_date;
        $notice->message=$request->message;
        $notice->save();

        NoticeBoardMessage::DeleteRecord($id);

       if(!empty($request->message_to)){
        foreach ($request->message_to as $message_to) {
            $message=new NoticeBoardMessage();
            $message->notice_board_id=$notice->id;
            $message->message_to=$message_to;
            $message->save();
        }
       }

        return redirect('admin/communicate/notice_board')->with('success','Notice Updated Successfully');
    }
    public function DeleteNoticeBoard($id){
        $save=NoticeBoard::getSingle($id);
        $save->delete();

        return redirect()->back()->with('success','Notice Deleted Successfully');
    }
    //student side
    public function myNoticeStudent(){
        $data['getRecord']=NoticeBoard::getRecordUser(Auth::user()->user_type);
        $data['header_title']='My Notice Board';
        return view('student.my_notice_board',$data);

    }
    //teacher side
    public function myNoticeTeacher(){
        $data['getRecord']=NoticeBoard::getRecordUser(Auth::user()->user_type);
        $data['header_title']='My Notice Board';
        return view('teacher.my_notice_board',$data);

    }
    //parent side
    public function myNoticeParent(){
        $data['getRecord']=NoticeBoard::getRecordUser(Auth::user()->user_type);
        $data['header_title']='My Notice Board';
        return view('parent.my_notice_board',$data);

    }
    public function myStudentNoticeParent(){
        $data['getRecord']=NoticeBoard::getRecordUser(3);
        $data['header_title']='My Student Notice Board';
        return view('parent.my_student_notice',$data);

    }

}
