<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ParentController extends Controller
{
    public function list(){
        $data['header_title']='Parent List';
        $data['getRecord']=User::getParent();
        return view('admin.parent.list',$data);
    }
    public function add(){
        $data['header_title']='Add Parent ';
        return view('admin.parent.add',$data);
    }
    public function insert(Request $request){
        $request->validate([
            'email'=> 'required|email|unique:users',
            'address'=>'max:255',
            'occupation'=>'max:255',
            'mobile_number'=>'max:11',


        ]);

         $parent=new User();
         $parent->name=trim($request->name);
         $parent->last_name=trim($request->last_name);
         $parent->gender=trim($request->gender);
         $parent->occupation=trim($request->occupation);
         $parent->address=trim($request->address);
        if(!empty($request->file('profile_pic'))){
            $file=$request->file('profile_pic');
            $extension=$file->getClientOriginalExtension();
            $filename=time().'.'.$extension;
            $file->move('users/images',$filename);
             $parent->profile_pic=$filename;

        }
         $parent->mobile_number=trim($request->mobile_number);

         $parent->status=trim($request->status);
         $parent->email=trim($request->email);
         $parent->password=Hash::make($request->password);
         $parent->user_type=4;
         $parent->save();
        return redirect('admin/parent/list')->with('success','Parent created successfully',);


    }
    public function edit($id){

        $data['getRecord']=User::getSingle($id);

        if(!empty( $data['getRecord'])){

            $data['header_title']='Edit Parent ';

            return view('admin.parent.edit',$data);
        }else{
            abort(404);
        }

    }
    public function update($id,Request $request){
        $request->validate([
            'email'=> 'required|email|unique:users,email,'.$id,
            'address'=>'max:255',
            'occupation'=>'max:255',
            'mobile_number'=>'max:11',


        ]);

         $parent=User::getSingle($id);
         $parent->name=trim($request->name);
         $parent->last_name=trim($request->last_name);
         $parent->gender=trim($request->gender);
        if(!empty($request->file('profile_pic'))){
            if(!empty( $parent->getProfilepic())){
                unlink('users/images/'. $parent->profile_pic);
            }
            $file=$request->file('profile_pic');
            $extension=$file->getClientOriginalExtension();
            $filename=time().'.'.$extension;
            $file->move('users/images',$filename);
             $parent->profile_pic=$filename;

        }
         $parent->religion=trim($request->religion);
         $parent->mobile_number=trim($request->mobile_number);
         $parent->status=trim($request->status);
         $parent->email=trim($request->email);
        if(!empty($request->password)){
             $parent->password=Hash::make($request->password);

        }
         $parent->user_type=4;
         $parent->save();
        return redirect('admin/parent/list')->with('success','Parent Updated successfully',);

    }
    public function delete($id){
        $getRecord=User::getSingle($id);

        if(!empty( $getRecord)){

            $getRecord->is_delete=1;
            $getRecord->save();

            return redirect('admin/parent/list')->with('success','Parent Deleted successfully');
        }else{
            abort(404);
        }

    }
    public function myStudent($id){
        $data['getParent']=User::getSingle($id);

        $data['parent_id'] = $id;
        $data['header_title']='Parent Student List';
        $data['getSearchStudent']=User::getSearchStudent();
        $data['getRecord']=User::getMyStudent($id);
        return view('admin.parent.my_Student',$data);
    }
    public function assignStudentParent($student_id,$parent_id){
        $student=User::getSingle($student_id);
        $student->parent_id=$parent_id;
        $student->save();
        return redirect()->back()->with('success','Student Successfully Assigned to parent');
    }
    public function assignStudentParentDelete($student_id){
        $student=User::getSingle($student_id);
        $student->parent_id=null;
        $student->save();
        return redirect()->back()->with('success','Student Successfully Assigned to Delete');
    }
}
