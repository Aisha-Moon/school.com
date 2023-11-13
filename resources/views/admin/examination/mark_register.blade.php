
@extends('layout.app')
@section('style')
<style type="text/css">
.span{

color:white;
background:blue;
padding:10px;
}
</style>
@endsection
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Marks Register</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="col-md-12">
        <div class="card">
            <div class="card-header">
              <h3 class="card-title">Search Marks Register</h3>
            </div>
            <form method="get" action="">
                <div class="card-body">
                    <div class="row">
                  <div class="form-group col-md-3">
                    <label for="exampleInputEmail1">Exam</label>
                    <select name="exam_id" required class="form-control">
                        <option  value="">Select Exam</option>
                        @foreach ($getExam as $exam)
                        <option {{ (Request::get('exam_id')==$exam->id) ? 'selected' :'' }} value="{{ $exam->id }}">{{ $exam->name }}</option>
                        @endforeach
                    </select>
                  </div>
                  <div class="form-group col-md-3">
                    <label for="ss">Class</label>
                    <select name="class_id" required class="form-control">
                        <option value="">Select Class</option>
                        @foreach ($getClass as $class)
                        <option {{ (Request::get('class_id')==$class->id) ? 'selected' :'' }} value="{{ $class->id }}">{{ $class->name }}</option>

                        @endforeach
                    </select>
                  </div>
                  <div class="form-group col-md-3" style="margin-top: 10px;">
                    <button type="submit" class="btn btn-primary" style="margin-top: 22px;">Search</button>
                    <a href="{{ url('admin/examinations/exam_schedule') }}" class="btn btn-danger" style="margin-top: 20px;">Clear</a>
                  </div>
                </div>
                </div>
                <!-- /.card-body -->
              </form>
        </div>
        </div>
          <!-- /.col -->
          <div class="col-md-12">
            @if(!empty(session('error')))
            <div class="alert alert-danger " role="alert">
              {{ session('error') }}
          </div>
          @endif
            @if(!empty(session('success')))
            <div class="alert alert-success " role="alert">
              {{ session('success') }}
          </div>
          @endif

         @if(!empty($getSubject) && !empty($getSubject->count()))
         <div class="card">
            <div class="card-header">
              <h3 class="card-title">Marks Register</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
              <table class="table table-striped">
                <thead>
                  <tr>

                    <th>STUDENT NAME</th>
                    @foreach ($getSubject as $subject)
                    <th>
                        {{ $subject->subject_name }} <br>
                        ({{ $subject->subject_type }} : {{ $subject->pass_marks }} / {{ $subject->full_marks }})
                    </th>

                    @endforeach
                    <th>ACTION</th>
                  </tr>
                </thead>
                <tbody>
                    @if(!empty($getStudent) && !empty($getStudent->count()))
                        @foreach ($getStudent as $student)
                        <form name="post" class="submitForm">
                            {{ csrf_field() }}
                            <input type="hidden" name="student_id" value="{{ $student->id }}">
                            <input type="hidden" name="exam_id" value="{{ Request::get('exam_id') }}">
                            <input type="hidden" name="class_id" value="{{  Request::get('class_id') }}">
                        <tr>
                            <td><span class="span">{{ $student->name }} {{ $student->last_name }}</span></td>
                            @php
                                $i=1;
                                $totalStudentMark=0;
                                $totalFullMark=0;
                                $totalPassMark=0;
                                $pass_fail_valid=0;
                            @endphp
                            @foreach ($getSubject as $subject)
                            @php
                                $totalMark=0;
                                $totalFullMark= $totalFullMark+$subject->full_marks;
                                $totalPassMark= $totalPassMark+$subject->pass_marks;
                                $getMark=$subject->getMark($student->id,Request::get('exam_id'),Request::get('class_id'),$subject->subject_id);
                                if(!empty($getMark)){
                                    $totalMark=$getMark->class_work+$getMark->home_work+$getMark->test_work+$getMark->exam;
                                }
                                $totalStudentMark=$totalStudentMark+$totalMark;
                            @endphp
                            <td>
                                <div style="margin-bottom:10px;">
                                    Class Work
                                    <input type="hidden" name="mark[{{ $i }}][full_marks]" class="form-control" value="{{ $subject->full_marks }}" >
                                    <input type="hidden" name="mark[{{ $i }}][pass_marks]" class="form-control" value="{{ $subject->pass_marks }}" >
                                    <input type="hidden" name="mark[{{ $i }}][id]" class="form-control" value="{{ $subject->id }}" >
                                    <input type="hidden" name="mark[{{ $i }}][subject_id]" class="form-control" value="{{ $subject->subject_id }}" >
                                   <input type="text" name="mark[{{ $i }}][class_work]" id="class_work_{{ $student->id }}{{ $subject->subject_id }}" class="form-control" value="{{ !empty($getMark->class_work) ? $getMark->class_work : ''  }}" placeholder="Enter Marks" >
                                </div>
                                <div style="margin-bottom:10px;">
                                    Home Work
                                   <input type="text" name="mark[{{ $i }}][home_work] "id="home_work_{{ $student->id }}{{ $subject->subject_id }}"  class="form-control" placeholder="Enter Marks"  value="{{ !empty($getMark->home_work) ? $getMark->home_work : '' }}">
                                </div>
                                <div style="margin-bottom:10px;">
                                    Test Mark
                                   <input type="text" name="mark[{{ $i }}][test_work]" id="test_work_{{ $student->id }}{{ $subject->subject_id }}" class="form-control" placeholder="Enter Marks" value="{{ !empty($getMark->test_work) ? $getMark->test_work : '' }}">
                                </div>
                                <div style="margin-bottom:10px;">
                                    Exam
                                   <input type="text" name="mark[{{ $i }}][exam]" id="exam_{{ $student->id }}{{ $subject->subject_id }}" class="form-control" placeholder="Enter Marks" value="{{ !empty($getMark->exam) ? $getMark->exam : '' }}">
                                </div>
                                <div style="margin-bottom:10px;">
                                  <button type="button" class="btn btn-primary SaveSingleSubject" id="{{ $student->id }}" data-val="{{ $subject->subject_id }}"
                                    data-exam="{{ Request::get('exam_id') }}" data-class="{{ Request::get('class_id') }}" data-schedule="{{ $subject->id }}">Save</button>
                                </div>
                              @if(!empty($getMark))
                                    <div style="margin-bottom:10px;">
                                        <b>Total Mark :</b>{{ $totalMark }} <br>
                                        <b>Passing mark :</b> {{ $subject->pass_marks }}
                                        <br>
                                            @if ($totalMark>=$subject->pass_marks)
                                            <span style="color:green;font-weight:bold;">Passed</span>
                                            @else
                                            <span style="color:red;font-weight:bold;">Failed</span>
                                                @php
                                                    $pass_fail_valid=1;
                                                @endphp

                                            @endif
                                    </div>
                              @endif

                                <br>
                            </td>
                            @php
                              $i++;
                            @endphp
                            @endforeach
                            <td style="">
                                <button type="submit" href="" class="btn btn-success ">Save</button>
                               @if (!empty($totalStudentMark))
                                    <br><br>
                                    <b>Total Marks : </b>{{ $totalFullMark }} <br>
                                    <b>Total Passing Marks : </b>{{ $totalPassMark }} <br>
                                    <b>Obtained Marks : </b> {{ $totalStudentMark }} <br>
                                    @php
                                        $percentage=($totalStudentMark * 100)/ $totalFullMark;
                                    @endphp
                                    <br>
                                    <b>Percentage :</b> {{ round($percentage,2) }}% <br>
                                    @if ($pass_fail_valid==0)
                                    <b>Result : </b><span style="color:green;font-weight:bold;">Passed</span>

                                    @else
                                    <b>Result : </b><span style="color:red;font-weight:bold;">Failed</span>

                                    @endif
                               @endif

                            </td>
                        </tr>
                    </form>
                        @endforeach
                    @endif
                </tbody>

              </table>

            </div>
            <!-- /.card-body -->
          </div>
          @endif


          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
@endsection
@section('script')
<script type="text/javascript">

$('.submitForm').submit(function(e) {
    e.preventDefault();
    $.ajax({
        type: "POST",
        url:"{{ url('admin/examinations/submit_marks_register') }}",
        data:$(this).serialize(),
        dataType: "JSON",
        success: function (data){
            alert(data.message);
        }
    });
});
$('.SaveSingleSubject').click(function(e){
  var student_id = $(this).attr('id');
  var subject_id = $(this).attr('data-val');
  var exam_id = $(this).attr('data-exam');
  var class_id = $(this).attr('data-class');
  var id= $(this).attr('data-schedule');

  var class_work=$('#class_work_'+student_id+subject_id).val();
  var home_work=$('#home_work_'+student_id+subject_id).val();
  var test_work=$('#test_work_'+student_id+subject_id).val();
  var exam=$('#exam_'+student_id+subject_id).val();

  $.ajax({

        type: "POST",
        url:"{{ url('admin/examinations/single_submit_marks_register') }}",
        data:{
                "_token":"{{ csrf_token() }}",
                id:id,
                student_id: student_id,
                subject_id:subject_id,
                exam_id:exam_id,
                class_id:class_id,
                class_work:class_work,
                home_work:home_work,
                test_work:test_work,
                exam:exam,
        },
        dataType: "JSON",
        success: function (data){
            alert(data.message);
        }
    });
});

</script>
@endsection
