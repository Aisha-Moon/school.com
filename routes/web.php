<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AssignClassTeacherController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\ClassSubjectController;
use App\Http\Controllers\ClassTimetableController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExamintaionController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\CommunicateController;
use App\Http\Controllers\FeesCollectionController;
use App\Http\Controllers\HomeworkController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/',[AuthController::class,'login']);
Route::post('/login',[AuthController::class,'Authlogin']);
Route::get('/logout',[AuthController::class,'logout']);
Route::get('/forgot-password',[AuthController::class,'forgotPassword']);
Route::post('/forgot-password',[AuthController::class,'postforgotPassword']);
Route::get('/reset/{token}',[AuthController::class,'reset']);
Route::post('/reset/{token}',[AuthController::class,'postResetPass']);


Route::get('admin/admin/list', function () {
    return view('admin.admin.list');
});

Route::group(['middleware'=> 'admin'], function () {
    Route::get('admin/account', [UserController::class,'myAccount']);
    Route::post('admin/account', [UserController::class,'updateMyAccountAdmin']);


    Route::get('/admin/dashboard', [DashboardController::class,'dashboard']);
    Route::get('/admin/admin/list', [AdminController::class,'list']);
    Route::get('/admin/admin/add', [AdminController::class,'add']);
    Route::post('/admin/admin/add', [AdminController::class,'insert']);
    Route::get('/admin/admin/edit/{id}', [AdminController::class,'edit']);
    Route::post('/admin/admin/edit/{id}', [AdminController::class,'update']);
    Route::get('/admin/admin/delete/{id}', [AdminController::class,'delete']);

    //class url
    Route::get('admin/class/list/', [ClassController::class,'list']);
    Route::get('admin/class/add/', [ClassController::class,'add']);
    Route::post('admin/class/add/', [ClassController::class,'insert']);
    Route::get('/admin/class/edit/{id}', [ClassController::class,'edit']);
    Route::post('/admin/class/edit/{id}', [ClassController::class,'update']);
    Route::get('/admin/class/delete/{id}', [ClassController::class,'delete']);

    //subject url
    Route::get('admin/subject/list/', [SubjectController::class,'list']);
    Route::get('admin/subject/add/', [SubjectController::class,'add']);
    Route::post('admin/subject/add/', [SubjectController::class,'insert']);
    Route::get('/admin/subject/edit/{id}', [SubjectController::class,'edit']);
    Route::post('/admin/subject/edit/{id}', [SubjectController::class,'update']);
    Route::get('/admin/subject/delete/{id}', [SubjectController::class,'delete']);

    //assign subject
    Route::get('admin/assign_subject/list/', [ClassSubjectController::class,'list']);
    Route::get('admin/assign_subject/add/', [ClassSubjectController::class,'add']);
    Route::post('admin/assign_subject/add/', [ClassSubjectController::class,'insert']);
    Route::get('/admin/assign_subject/edit/{id}', [ClassSubjectController::class,'edit']);
    Route::post('/admin/assign_subject/edit/{id}', [ClassSubjectController::class,'update']);
    Route::get('/admin/assign_subject/delete/{id}', [ClassSubjectController::class,'delete']);
    Route::get('/admin/assign_subject/edit_single/{id}', [ClassSubjectController::class,'edit_single']);
    Route::post('/admin/assign_subject/edit_single/{id}', [ClassSubjectController::class,'update_single']);

    //change password
    Route::get('admin/change_password', [UserController::class,'change_password']);
    Route::post('admin/change_password', [UserController::class,'update_change_password']);
 //student add
 Route::get('admin/student/list/', [StudentController::class,'list']);
 Route::get('admin/student/add/', [StudentController::class,'add']);
 Route::post('admin/student/add/', [StudentController::class,'insert']);
 Route::get('admin/student/edit/{id}', [StudentController::class,'edit']);
 Route::post('admin/student/edit/{id}', [StudentController::class,'update']);
 Route::get('admin/student/delete/{id}', [StudentController::class,'delete']);
 //teacher add
 Route::get('admin/teacher/list/', [TeacherController::class,'list']);
 Route::get('admin/teacher/add/', [TeacherController::class,'add']);
 Route::post('admin/teacher/add/', [TeacherController::class,'insert']);
 Route::get('admin/teacher/edit/{id}', [TeacherController::class,'edit']);
 Route::post('admin/teacher/edit/{id}', [TeacherController::class,'update']);
 Route::get('admin/teacher/delete/{id}', [TeacherController::class,'delete']);
//parent add
Route::get('admin/parent/list/', [ParentController::class,'list']);
Route::get('admin/parent/add/', [ParentController::class,'add']);
Route::post('admin/parent/add/', [ParentController::class,'insert']);
Route::get('admin/parent/edit/{id}', [ParentController::class,'edit']);
Route::post('admin/parent/edit/{id}', [ParentController::class,'update']);
Route::get('admin/parent/delete/{id}', [ParentController::class,'delete']);
Route::get('admin/parent/my-student/{id}', [ParentController::class,'myStudent']);
Route::get('admin/parent/assign-student-parent/{student_id}/{parent_id}', [ParentController::class,'assignStudentParent']);
Route::get('admin/parent/assign-student-parent-delete/{student_id}', [ParentController::class,'assignStudentParentDelete']);

//assign class teacher
Route::get('admin/assign_class_teacher/list/', [AssignClassTeacherController::class,'list']);
Route::get('admin/assign_class_teacher/add/', [AssignClassTeacherController::class,'add']);
Route::post('admin/assign_class_teacher/add/', [AssignClassTeacherController::class,'insert']);
Route::get('admin/assign_class_teacher/edit/{id}', [AssignClassTeacherController::class,'edit']);
Route::post('admin/assign_class_teacher/edit/{id}', [AssignClassTeacherController::class,'update']);
Route::get('admin/assign_class_teacher/delete/{id}', [AssignClassTeacherController::class,'delete']);
Route::get('/admin/assign_class_teacher/edit_single/{id}', [AssignClassTeacherController::class,'edit_single']);
Route::post('/admin/assign_class_teacher/edit_single/{id}', [AssignClassTeacherController::class,'update_single']);

//class timetable
Route::get('admin/class_timetable/list/', [ClassTimetableController::class,'list']);
Route::post('admin/class_timetable/get_subject', [ClassTimetableController::class,'get_subject']);
Route::post('admin/class_timetable/add', [ClassTimetableController::class,'insert_update']);


//examinations
Route::get('admin/examinations/exam/list', [ExamintaionController::class,'exam_list']);
Route::get('admin/examinations/exam/add', [ExamintaionController::class,'exam_add']);
Route::post('admin/examinations/exam/add', [ExamintaionController::class,'exam_insert']);
Route::get('admin/examinations/exam/edit/{id}', [ExamintaionController::class,'exam_edit']);
Route::post('admin/examinations/exam/edit/{id}', [ExamintaionController::class,'exam_update']);
Route::get('admin/examinations/exam/delete/{id}', [ExamintaionController::class,'exam_delete']);

Route::get('admin/examinations/exam_schedule', [ExamintaionController::class,'exam_schedule']);
Route::post('admin/examinations/exam_schedule_insert', [ExamintaionController::class,'exam_schedule_insert']);

Route::get('admin/examinations/marks_register', [ExamintaionController::class,'marks_register']);
Route::post('admin/examinations/submit_marks_register', [ExamintaionController::class,'submit_marks_register']);
Route::post('admin/examinations/single_submit_marks_register', [ExamintaionController::class,'single_submit_marks_register']);

//marks grade
Route::get('admin/examinations/marks_grade/list', [ExamintaionController::class,'marks_grade']);
Route::get('admin/examinations/marks_grade_add', [ExamintaionController::class,'marks_grade_add']);
Route::post('admin/examinations/marks_grade_add', [ExamintaionController::class,'marks_grade_insert']);
Route::get('admin/examinations/marks_grade_edit/{id}', [ExamintaionController::class,'marks_grade_edit']);
Route::post('admin/examinations/marks_grade_edit/{id}', [ExamintaionController::class,'marks_grade_update']);
Route::get('admin/examinations/marks_grade_delete/{id}', [ExamintaionController::class,'marks_grade_delete']);

//attendance
Route::get('admin/attendance/student', [AttendanceController::class,'AttendanceStudent']);
Route::post('admin/attendance/student/save', [AttendanceController::class,'AttendanceStudentSave']);
Route::get('admin/attendance/report', [AttendanceController::class,'AttendanceReport']);
Route::get('admin/communicate/notice_board', [CommunicateController::class,'noticeBoard']);
Route::get('admin/communicate/notice_board/add', [CommunicateController::class,'AddNoticeBoard']);
Route::post('admin/communicate/notice_board/add', [CommunicateController::class,'InsertNoticeBoard']);
Route::get('admin/communicate/notice_board/edit/{id}', [CommunicateController::class,'EditNoticeBoard']);
Route::post('admin/communicate/notice_board/edit/{id}', [CommunicateController::class,'UpdateNoticeBoard']);
Route::get('admin/communicate/notice_board/delete/{id}', [CommunicateController::class,'DeleteNoticeBoard']);
Route::get('admin/communicate/send_email', [CommunicateController::class,'SendEmail']);
Route::post('admin/communicate/send_email', [CommunicateController::class,'SendEmailUser']);
Route::get('admin/communicate/search_user', [CommunicateController::class,'SearchUser']);

//homework
Route::get('admin/homework/homework', [HomeworkController::class,'homework']);
Route::get('admin/homework/homework/add', [HomeworkController::class,'AddHomework']);
Route::post('admin/homework/homework/add', [HomeworkController::class,'insertHomework']);
Route::get('admin/homework/homework/edit/{id}', [HomeworkController::class,'EditHomework']);
Route::post('admin/homework/homework/edit/{id}', [HomeworkController::class,'updateHomework']);
Route::get('admin/homework/homework/delete/{id}', [HomeworkController::class,'deleteHomework']);
Route::post('admin/ajax_get_subject', [HomeworkController::class,'ajax_get_subject']);
Route::get('admin/homework/homework/submitted/{id}', [HomeworkController::class,'submitted']);
Route::get('admin/homework/homework_report', [HomeworkController::class,'HomeworkReport']);
Route::get('admin/fees_collection/collect_fees', [FeesCollectionController::class,'CollectFees']);
Route::get('admin/fees_collection/collect_fees_report', [FeesCollectionController::class,'CollectFeesReport']);
Route::get('admin/fees_collection/collect_fees/add_fees/{student_id}', [FeesCollectionController::class,'AddCollectFees']);
Route::post('admin/fees_collection/collect_fees/add_fees/{student_id}', [FeesCollectionController::class,'InsertCollectFees']);
Route::get('admin/setting', [UserController::class,'Setting']);
Route::post('admin/setting', [UserController::class,'UpdateSetting']);



});
Route::group(['middleware'=> 'student'], function () {
    Route::get('/student/dashboard', [DashboardController::class,'dashboard']);
        //change password
        Route::get('student/change_password', [UserController::class,'change_password']);
        Route::post('student/change_password', [UserController::class,'update_change_password']);
        Route::get('student/account', [UserController::class,'myAccount']);
        Route::get('student/my_subject', [SubjectController::class,'mySubject']);
        Route::post('student/account', [UserController::class,'updateMyAccountStudent']);
        Route::get('student/my_timetable', [ClassTimetableController::class,'myTimetable']);
        Route::get('student/my_exam_timetable', [ExamintaionController::class,'myExamTimetable']);
        Route::get('student/my_exam_result', [ExamintaionController::class,'myExamResult']);
        Route::get('print/my_Exam_result/print', [ExamintaionController::class,'myExamResultPrint']);
        Route::get('student/my_calendar', [CalendarController::class,'myCalendar']);
        Route::get('student/my_attendance', [AttendanceController::class,'myAttendanceStudent']);
        Route::get(' student/my_notice_board', [CommunicateController::class,'myNoticeStudent']);
        Route::get('student/my_homework', [HomeworkController::class,'HomeworkStudent']);
        Route::get('student/my_homework/submit_homework/{id}', [HomeworkController::class,'SubmitHomework']);
        Route::post('student/my_homework/submit_homework/{id}', [HomeworkController::class,'InsertSubmitHomework']);
        Route::get('student/my_submitted_homework', [HomeworkController::class,'SubmittedHomeworkStudent']);
        Route::get('student/fees_collection', [FeesCollectionController::class,'CollectFeesStudent']);
        Route::post('student/fees_collection', [FeesCollectionController::class,'CollectFeesStudentPayment']);
        Route::get('student/paypal/payment_error', [FeesCollectionController::class,'PaymentError']);
        Route::get('student/paypal/payment_success', [FeesCollectionController::class,'PaymentSuccess']);
        Route::get('student/stripe/payment_success', [FeesCollectionController::class,'PaymentSuccessStripe']);
        Route::get('student/stripe/payment_error', [FeesCollectionController::class,'PaymentError']);




});
Route::group(['middleware'=> 'teacher'], function () {
    Route::get('/teacher/dashboard', [DashboardController::class,'dashboard']);
        //change password
        Route::get('teacher/change_password', [UserController::class,'change_password']);
        Route::post('teacher/change_password', [UserController::class,'update_change_password']);
        Route::get('teacher/account', [UserController::class,'myAccount']);
        Route::post('teacher/account', [UserController::class,'updateMyAccountTeacher']);
        Route::get('teacher/my_class_subject', [AssignClassTeacherController::class,'myClassSubject']);
        Route::get('teacher/my_student', [StudentController::class,'myStudent']);
        Route::get('teacher/my_class_subject/class_timetable/{class_id}/{subject_id}', [ClassTimetableController::class,'myTimetableTeacher']);

        Route::get('teacher/my_exam_timetable', [ExamintaionController::class,'myExamTimetableTeacher']);
        Route::get('teacher/my_calendar', [CalendarController::class,'myCalendarTeacher']);
        Route::get('teacher/marks_register', [ExamintaionController::class,'marks_register_teacher']);
        Route::post('teacher/submit_marks_register', [ExamintaionController::class,'submit_marks_register']);
        Route::post('teacher/single_submit_marks_register', [ExamintaionController::class,'single_submit_marks_register']);

        Route::get('teacher/attendance/student', [AttendanceController::class,'AttendanceStudentTeacher']);
        Route::post('teacher/attendance/student/save', [AttendanceController::class,'AttendanceStudentSave']);
        Route::get('teacher/attendance/report', [AttendanceController::class,'AttendanceReportTeacher']);
        Route::get('teacher/my_notice_board', [CommunicateController::class,'myNoticeTeacher']);


       //homework
        Route::get('teacher/homework/homework', [HomeworkController::class,'homeworkTeacher']);
        Route::get('teacher/homework/homework/add', [HomeworkController::class,'AddHomeworkTeacher']);
        Route::post('teacher/homework/homework/add', [HomeworkController::class,'insertHomeworkTeacher']);
        Route::get('teacher/homework/homework/edit/{id}', [HomeworkController::class,'EditHomeworkTeacher']);
        Route::post('teacher/homework/homework/edit/{id}', [HomeworkController::class,'updateHomeworkTeacher']);
        Route::get('teacher/homework/homework/delete/{id}', [HomeworkController::class,'deleteHomework']);
        Route::post('teacher/ajax_get_subject', [HomeworkController::class,'ajax_get_subject']);
        Route::get('teacher/homework/homework/submitted/{id}', [HomeworkController::class,'submittedTeacher']);




});
Route::group(['middleware'=> 'parent'], function () {
    Route::get('/parent/dashboard', [DashboardController::class,'dashboard']);
        //change password
        Route::get('parent/change_password', [UserController::class,'change_password']);
        Route::post('parent/change_password', [UserController::class,'update_change_password']);
        Route::get('parent/account', [UserController::class,'myAccount']);
        Route::post('parent/account', [UserController::class,'updateMyAccountParent']);
        Route::get('parent/my-student', [ParentController::class,'myStudentParent']);
        Route::get('parent/my_student/calendar/{student_id}', [CalendarController::class,'myCalendarParent']);
        Route::get('parent/my_student/subject/{student_id}', [SubjectController::class,'parentStudentSubject']);
        Route::get('parent/my_student/exam_timetable/{student_id}', [ExamintaionController::class,'MyExamTimetableparent']);
        Route::get('parent/my_student/exam_result/{student_id}', [ExamintaionController::class,'MyExamResultparent']);
        Route::get('parent/my_student/subject/class_timetable/{class_id}/{subject_id}/{student_id}', [ClassTimetableController::class,'MyTimetableparent']);
        Route::get('parent/my_student_attendance/{student_id}', [AttendanceController::class,'myAttendanceParent']);
        Route::get('parent/my_notice_board', [CommunicateController::class,'myNoticeParent']);
        Route::get('parent/my_student_notice_board', [CommunicateController::class,'myStudentNoticeParent']);
        Route::get('parent/my_student_homework/{id}', [HomeworkController::class,'HomeworkParent']);
        Route::get('parent/my_student_submitted_homework/{id}', [HomeworkController::class,'SubmittedHomeworkParent']);
        Route::get('parent/my_student/fees_collection/{student_id}', [FeesCollectionController::class,'CollectFeesStudentParent']);
        Route::post('parent/my_student/fees_collection/{student_id}', [FeesCollectionController::class,'CollectFeesStudentPaymentParent']);


        Route::get('parent/paypal/payment_success/{student_id}', [FeesCollectionController::class,'PaymentSuccessParent']);
        Route::get('parent/paypal/payment_error/{student_id}', [FeesCollectionController::class,'PaymentErrorParent']);

        Route::get('parent/stripe/payment_success/{student_id}', [FeesCollectionController::class,'PaymentSuccessStripeParent']);
        Route::get('parent/stripe/payment_error/{student_id}', [FeesCollectionController::class,'PaymentErrorParent']);

});

Route::group(['middleware'=> 'common'], function () {
    Route::get('chat', [ChatController::class,'chats']);
    Route::post('submit_message', [ChatController::class,'submit_message']);
    Route::post('get_chat_window', [ChatController::class,'get_chat_window']);
    Route::post('get_chat_search_user', [ChatController::class,'get_chat_search_user']);

});
