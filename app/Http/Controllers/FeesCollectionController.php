<?php

namespace App\Http\Controllers;

use App\Models\AddFeesStudent;
use App\Models\ClassModel;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Session;



class FeesCollectionController extends Controller
{
    public function CollectFees(Request $request){
        $data['getClass']=ClassModel::getClass();
        if(!empty($request->all())){
            $data['getRecord']=User::getCollectFeesStudent();
        }
        $data['header_title']='Fees Collection';
        return view('admin.fees_collection.collect_fees',$data);

    }
    public function AddCollectFees($student_id){

        $data['getFees']=AddFeesStudent::getFees($student_id);
        $getStudent =User::getSingleClass($student_id);
        $data['getStudent']=$getStudent;
        $data['header_title']='Add Fees Collection';
        $data['paid_amount']=AddFeesStudent::getPaidAmount($student_id,$getStudent->class_id);
        return view('admin.fees_collection.add_collect_fees',$data);
    }
    public function InsertCollectFees($student_id,Request $request){
        $getStudent =User::getSingleClass($student_id);
        $paid_amount=AddFeesStudent::getPaidAmount($student_id,$getStudent->class_id);

        if(!empty($request->amount)){
            $RemainingAmount =$getStudent->amount- $paid_amount;
            if($RemainingAmount>=$request->amount){
                $remaining_amount_user=$RemainingAmount-$request->amount;
                $payment=new AddFeesStudent();
                $payment->student_id=$student_id;
                $payment->class_id=$getStudent->class_id;
                $payment->paid_amount=$request->amount;
                $payment->total_amount=$RemainingAmount;
                $payment->remaining_amount=$remaining_amount_user;
                $payment->payment_type=$request->payment_type;
                $payment->remark=$request->remark;
                $payment->is_paid=1;
                $payment->created_by=Auth::user()->id;
                $payment->save();
                return redirect()->back()->with('success','Fees Added Successfully');

            }else{
                return redirect()->back()->with('error','Amount is Greater than Remaining amount');

            }
        }else{
            return redirect()->back()->with('error','Amount must be at least $1');

        }


    }
    //student side work
    public function CollectFeesStudent(Request $request){
        $student_id=Auth::user()->id;
        $data['getFees']=AddFeesStudent::getFees($student_id);
        $getStudent =User::getSingleClass($student_id);
        $data['getStudent']=$getStudent;
        $data['header_title']='Fees Collection';
        $data['paid_amount']=AddFeesStudent::getPaidAmount($student_id,$getStudent->class_id);
        return view('student.my_fees_collection',$data);

    }
    public function CollectFeesStudentPayment(Request $request){
        $getStudent =User::getSingleClass(Auth::user()->id);
        $paid_amount=AddFeesStudent::getPaidAmount(Auth::user()->id,Auth::user()->class_id);

        if(!empty($request->amount)){
            $RemainingAmount=$getStudent->amount-$paid_amount;
            if($RemainingAmount>=$request->amount){
                $remaining_amount_user=$RemainingAmount-$request->amount;
                $payment=new AddFeesStudent();
                $payment->student_id=Auth::user()->id;
                $payment->class_id=Auth::user()->class_id;
                $payment->paid_amount=$request->amount;
                $payment->total_amount=$RemainingAmount;
                $payment->remaining_amount=$remaining_amount_user;
                $payment->payment_type=$request->payment_type;
                $payment->remark=$request->remark;
                $payment->created_by=Auth::user()->id;
                $payment->save();

                $getSetting=Setting::getSingle();


                if($request->payment_type=='Paypal'){
                    $payPalId=
                    $query=array();
                    $query['business']=$getSetting->paypal_email;
                    $query['cmd']='_xclick';
                    $query['item_name']='Student Fees';
                    $query['no_shipping']='1';
                    $query['item_number']=$payment->id;
                    $query['amount']=$request->amount;
                    $query['currency_code']='USD';
                    $query['cancel_return']=url('student/paypal/payment_error');
                    $query['return']=url('student/paypal/payment_success');
                    $query_string=http_build_query($query);

                    header('Location:https://www.sandbox.paypal.com/cgi-bin/webscr?'.$query_string);
                    exit();
                }
                else if($request->payment_type=='Stripe'){
                    $setApiKey=$getSetting->stripe_secret;
                    $setPublicKey=$getSetting->stripe_key;

                    Stripe::setApiKey($setApiKey);
                    $finalprice=$request->amount*100;

                    $session=\Stripe\Checkout\Session::create([
                        'customer_email'=>Auth::user()->email,
                        'payment_method_types'=>['card'],
                        'line_items' => [
                            [
                                'price_data' => [
                                    'currency' => 'USD',
                                    'product_data' => [
                                        'name' => 'Student Fees',
                                        'description' => 'Student Fees',
                                        'images' => [url('')],
                                    ],
                                    'unit_amount' => intval($finalprice),  // Amount in cents
                                ],
                                'quantity' => 1,
                            ],
                        ],
                        'mode' => 'payment',  // Specify 'payment' or 'subscription' based on your use case


                        'success_url'=>url('student/stripe/payment_success'),
                        'cancel_url'=>url('student/stripe/payment_error'),

                        ]);
                        $payment->stripe_session_id=$session['id'];
                        $payment->save();

                        $data['session_id']=$session['id'];
                        Session::put('stripe_session_id',$session['id']);
                        $data['setPublicKey']=$setPublicKey;
                        return view('stripe_charge',$data);

                }

            }else{
                return redirect()->back()->with('error','Amount is Greater than Remaining amount');

            }
        }else{
            return redirect()->back()->with('error','Amount must be at least $1');

        }

    }
    public function PaymentError(){
        return redirect('student/fees_collection')->with('error','An Error Occurred,Please Try Again Later');
    }
    public function PaymentSuccess(Request $request){

        if(!empty($request->item_number) && !empty($request->st) && !empty($request->st)=='Completed'){
            $fees=AddFeesStudent::getSingle($request->item_number);
            if(!empty($fees)){
                $fees->is_paid=1;
                $fees->payment_data=json_encode($request->all());
                $fees->save();
                return redirect('student/fees_collection')->with('success','Payment Successful');

            }else{
                return redirect('student/fees_collection')->with('error','An Error Occurred,Please Try Again Later');

            }
        }else{
            return redirect('student/fees_collection')->with('error','An Error Occurred,Please Try Again Later');

        }
    }
    public function PaymentSuccessStripe(Request $request){
        $getSetting=Setting::getSingle();
        $setApiKey=$getSetting->stripe_secret;
        $setPublicKey=$getSetting->stripe_key;

        $trans_id=Session::get('stripe_session_id');
        $getFees=AddFeesStudent::where('stripe_session_id',$trans_id)->first();

        \Stripe\Stripe::setApiKey($setApiKey);
        $getData=\Stripe\Checkout\Session::retrieve($trans_id);
        if(!empty($getData->id) && !empty($getData->id==$trans_id) && !empty($getFees) && $getData->status=='complete'){
            $getFees->is_paid=1;
            $getFees->payment_data=json_encode($request->all());
            $getFees->save();
            Session::forget('stripe_session_id');

            return redirect('student/fees_collection')->with('success','Payment Successful');

        }else{
            return redirect('student/fees_collection')->with('error','An Error Occurred,Please Try Again Later');

        }
    }
    //parent side
    public function CollectFeesStudentParent($student_id,Request $request){

        $data['getFees']=AddFeesStudent::getFees($student_id);
        $getStudent =User::getSingleClass($student_id);
        $data['getStudent']=$getStudent;
        $data['header_title']='Fees Collection';
        $data['paid_amount']=AddFeesStudent::getPaidAmount($student_id,$getStudent->class_id);
        return view('parent.my_fees_collection',$data);

    }
    public function PaymentSuccessStripeParent($student_id,Request $request){
        $getSetting=Setting::getSingle();
        $setApiKey=$getSetting->stripe_secret;
        $setPublicKey=$getSetting->stripe_key;

        $trans_id=Session::get('stripe_session_id');
        $getFees=AddFeesStudent::where('stripe_session_id',$trans_id)->first();

        \Stripe\Stripe::setApiKey($setApiKey);
        $getData=\Stripe\Checkout\Session::retrieve($trans_id);
        if(!empty($getData->id) && !empty($getData->id==$trans_id) && !empty($getFees) && $getData->status=='complete'){
            $getFees->is_paid=1;
            $getFees->payment_data=json_encode($request->all());
            $getFees->save();
            Session::forget('stripe_session_id');

            return redirect('parent/my_student/fees_collection/'.$student_id)->with('success','Payment Successful');

        }else{
            return redirect('parent/my_student/fees_collection/'.$student_id)->with('error','An Error Occurred,Please Try Again Later');

        }
    }


    public function CollectFeesStudentPaymentParent($student_id,Request $request){
        $getStudent =User::getSingleClass($student_id);
        $getStudentInfo =User::getSingleClass($student_id);

        $paid_amount=AddFeesStudent::getPaidAmount($student_id,$getStudent->class_id);

        if(!empty($request->amount)){
            $RemainingAmount=$getStudent->amount-$paid_amount;
            if($RemainingAmount>=$request->amount){
                $remaining_amount_user=$RemainingAmount-$request->amount;
                $payment=new AddFeesStudent();
                $payment->student_id= $getStudent->id;
                $payment->class_id= $getStudent->class_id;
                $payment->paid_amount=$request->amount;
                $payment->total_amount=$RemainingAmount;
                $payment->remaining_amount=$remaining_amount_user;
                $payment->payment_type=$request->payment_type;
                $payment->remark=$request->remark;
                $payment->created_by=Auth::user()->id;
                $payment->save();

                $getSetting=Setting::getSingle();


                if($request->payment_type=='Paypal'){
                    $payPalId=
                    $query=array();
                    $query['business']=$getSetting->paypal_email;
                    $query['cmd']='_xclick';
                    $query['item_name']='Student Fees';
                    $query['no_shipping']='1';
                    $query['item_number']=$payment->id;
                    $query['amount']=$request->amount;
                    $query['currency_code']='USD';
                    $query['cancel_return']=url('parent/paypal/payment_error/'.$student_id);
                    $query['return']=url('parent/paypal/payment_success/'.$student_id);
                    $query_string=http_build_query($query);

                    header('Location:https://www.sandbox.paypal.com/cgi-bin/webscr?'.$query_string);
                    exit();
                }
                else if($request->payment_type=='Stripe'){
                    $setApiKey=$getSetting->stripe_secret;
                    $setPublicKey=$getSetting->stripe_key;

                    Stripe::setApiKey($setApiKey);
                    $finalprice=$request->amount*100;

                    $session=\Stripe\Checkout\Session::create([
                        'customer_email'=>Auth::user()->email,
                        'payment_method_types'=>['card'],
                        'line_items' => [
                            [
                                'price_data' => [
                                    'currency' => 'USD',
                                    'product_data' => [
                                        'name' => 'Student Fees',
                                        'description' => 'Student Fees',
                                        'images' => [url('')],
                                    ],
                                    'unit_amount' => intval($finalprice),  // Amount in cents
                                ],
                                'quantity' => 1,
                            ],
                        ],
                        'mode' => 'payment',  // Specify 'payment' or 'subscription' based on your use case


                        'success_url'=>url('parent/stripe/payment_success/'.$student_id),
                        'cancel_url'=>url('parent/stripe/payment_error/'.$student_id),

                        ]);
                        $payment->stripe_session_id=$session['id'];
                        $payment->save();

                        $data['session_id']=$session['id'];
                        Session::put('stripe_session_id',$session['id']);
                        $data['setPublicKey']=$setPublicKey;
                        return view('stripe_charge',$data);

                }

            }else{
                return redirect()->back()->with('error','Amount is Greater than Remaining amount');

            }
        }else{
            return redirect()->back()->with('error','Amount must be at least $1');

        }

    }
    public function PaymentErrorParent($student_id){
        return redirect('parent/my_student/fees_collection/'.$student_id)->with('error','An Error Occurred,Please Try Again Later');
    }
    public function PaymentSuccessParent($student_id,Request $request){

        if(!empty($request->item_number) && !empty($request->st) && !empty($request->st)=='Completed'){
            $fees=AddFeesStudent::getSingle($request->item_number);
            if(!empty($fees)){
                $fees->is_paid=1;
                $fees->payment_data=json_encode($request->all());
                $fees->save();
                return redirect('parent/my_student/fees_collection/'.$student_id)->with('success','Payment Successful');

            }else{
                return redirect('parent/my_student/fees_collection/'.$student_id)->with('error','An Error Occurred,Please Try Again Later');

            }
        }else{
            return redirect('parent/my_student/fees_collection/'.$student_id)->with('error','An Error Occurred,Please Try Again Later');

        }
    }



}
