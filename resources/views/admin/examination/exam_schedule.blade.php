
@extends('layout.app')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Exam Schedule</h1>
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
              <h3 class="card-title">Search Exam Schedule</h3>
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

            <!-- /.card -->

          @if (!empty($getRecord))
          <form action="{{ url('admin/examinations/exam_schedule_insert') }}" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="exam_id" value="{{ Request::get('exam_id') }}">
            <input type="hidden" name="class_id" value="{{ Request::get('class_id') }}">

          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Exam Schedule </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
              <table class="table table-striped">
                <thead>
                  <tr>

                    <th>Subject Name</th>
                    <th>Date</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Room Number</th>
                    <th>Full Marks</th>
                    <th>Pass Marks</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                    @php
                        $i=1;
                    @endphp
                    @foreach ($getRecord as $value)
                    <tr>
                        <td>
                            {{ $value['subject_name'] }}
                            <input type="hidden" class="form-control" name="schedule[{{ $i }}][subject_id]" value="{{ $value['subject_id'] }}">
                        </td>
                        <td>
                            <input type="date"  class="form-control" name="schedule[{{ $i }}][exam_date]" value="{{ $value['exam_date'] }}">
                        </td>
                        <td>
                            <input type="time" class="form-control" name="schedule[{{ $i }}][start_time]" value="{{ $value['start_time'] }}">
                        </td>
                        <td>
                            <input type="time" class="form-control" name="schedule[{{ $i }}][end_time]" value="{{ $value['end_time'] }}">

                        </td>
                        <td>
                            <input type="text" class="form-control" name="schedule[{{ $i }}][room_number]" value="{{ $value['room_number'] }}">
                        </td>
                        <td>
                            <input type="text" class="form-control" name="schedule[{{ $i }}][full_marks]" value="{{ $value['full_marks'] }}">
                        </td>
                        <td>
                            <input type="text" class="form-control" name="schedule[{{ $i }}][pass_marks]" value="{{ $value['pass_marks'] }}">
                        </td>
                    </tr>
                    @php
                        $i++;
                    @endphp
                    @endforeach
                </tbody>

              </table>
              <div style="text-align: center; padding:20px;">
                <button class="btn btn-primary">Submit</button>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          </form>

          @endif
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->

        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
@endsection
