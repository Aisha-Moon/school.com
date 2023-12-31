<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClassController extends Controller
{
    public function list(){
        $data['header_title']='Class List';
        $data['getRecord']=ClassModel::getRecord();
        return view('admin.class.list',$data);
    }
    public function add(){
        $data['header_title']='Add Class ';


        return view('admin.class.add',$data);
    }
    public function insert(Request $request){

       $class=new ClassModel;
       $class->name=$request->name;
       $class->amount=$request->amount;
       $class->status=$request->status;
       $class->created_by=Auth::user()->id;
       $class->save();
       return redirect('admin/class/list')->with('success','Class Added Successfully');


    }
    public function edit($id){

        $data['getRecord']=ClassModel::getSingle($id);
        if(!empty($data['getRecord'])){
            $data['header_title']="Edit Class";
            return view('admin.class.edit',$data);
        }else{
            abort(404);
        }

    }
    public function update($id,Request $request){
        $class=ClassModel::getSingle($id);
        $class->name=$request->name;
        $class->amount=$request->amount;
        $class->status=$request->status;
        $class->save();
        return redirect('admin/class/list')->with('success','Class updated Successfully');

    }
    public function delete($id){
        $class=ClassModel::getSingle($id);
        $class->is_delete=1;
        $class->save();
        return redirect()->back()->with('success','Class deleted Successfully');
    }
}
