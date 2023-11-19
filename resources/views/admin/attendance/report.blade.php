
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
            <h1>Attendance Report : <span style="color:blue;">(Total:{{ $getRecord->total() }})</span></h1>
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
              <h3 class="card-title">Search Attendance Report</h3>
            </div>
            <form method="get" action="">
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-2" >
                            <label for="student_id">Student ID</label>
                            <input type="text" name="student_id" placeholder="Enter Student ID"  value="{{Request::get('student_id') }}"  class="form-control" >
                        </div>
                        <div class="form-group col-md-2" >
                            <label for="student_name">Student Name</label>
                            <input type="text" name="student_name" placeholder="Enter Student's Name" value="{{Request::get('student_name') }}"  class="form-control" >
                        </div>
                        <div class="form-group col-md-2" >
                            <label for="last_name"> Last Name</label>
                            <input type="text" name="student_last_name" placeholder="Student's Last Name" value="{{Request::get('student_last_name') }}"  class="form-control" >
                        </div>

                  <div class="form-group col-md-2">
                    <label for="ss">Class</label>
                    <select name="class_id"  class="form-control" >
                        <option value="">Select Class</option>
                        @foreach ($getClass as $class)
                        <option {{ (Request::get('class_id')==$class->id) ? 'selected' :'' }} required value="{{ $class->id }}">{{ $class->name }}</option>

                        @endforeach
                    </select>
                  </div>
                  <div class="form-group col-md-3" >
                    <label for="attendance_date">Start Attendance Date</label>
                    <input type="date" name="start_attendance_date"  value="{{Request::get('start_attendance_date') }}"  class="form-control" >
                  </div>
                  <div class="form-group col-md-3" >
                    <label for="attendance_date">End Attendance Date</label>
                    <input type="date" name="end_attendance_date"  value="{{Request::get('end_attendance_date') }}"  class="form-control" >
                  </div>
                  <div class="form-group col-md-1" >
                    <label for="attendance_date">Attendance Type</label>
                    <select name="attendance_type" class="form-control">
                        <option  value="">Select</option>
                        <option {{ (Request::get('attendance_type')==1) ? 'selected' :'' }} value="1">Present</option>
                        <option {{ (Request::get('attendance_type')==2) ? 'selected' :'' }} value="2">Late</option>
                        <option {{ (Request::get('attendance_type')==3) ? 'selected' :'' }} value="3">Absent</option>
                        <option {{ (Request::get('attendance_type')==4) ? 'selected' :'' }} value="4">Half Day</option>
                    </select>
                  </div>
                  <div class="form-group col-md-2" style="margin-top: 10px;min-width:300px;">
                    <button type="submit" class="btn btn-primary" style="margin-top: 22px;">Search</button>
                    <a href="{{ url('admin/attendance/report') }}" class="btn btn-danger" style="margin-top: 20px;">Clear</a>
                  </div>
                </div>
                </div>
                <!-- /.card-body -->
              </form>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Attendance List</h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Student ID</th>
                            <th>Student Name</th>
                            <th>Class Name</th>
                            <th>Attendance Type</th>
                            <th>Attendance Type</th>
                            <th>Created By</th>
                            <th>Created Date</th>
                        </tr>
                    </thead>
                   <tbody>
                    @forelse  ($getRecord as $value)
                    <tr>
                        <td>{{ $value->student_id }}</td>
                        <td>{{ $value->student_name }}{{ $value->student_last_name }}</td>
                        <td>{{ $value->class_name }}</td>
                        <td>
                            @if ($value->attendance_type==1)
                            Present

                            @elseif ($value->attendance_type==2)
                            Late
                            @elseif ($value->attendance_type==3)
                            Absent
                            @elseif ($value->attendance_type==4)
                            Half day

                            @endif
                        </td>
                        <td>{{ date('d-m-y',strtotime($value->attendance_date)) }}</td>
                        <td>{{ $value->created_name }}</td>
                        <td>{{ date('d-m-y H:i A',strtotime($value->created_at)) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="100%">Record Not Found</td>
                    </tr>

                    @endforelse


                   </tbody>
                </table>
                <div style="padding:10px;float:right;">
                    {!! $getRecord->appends(Illuminate\Support\Facades\Request::except('page'))->links() !!}

                </div>
          </div>
        </div>
        </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
@endsection
@section('script')
<script type="text/javascript">



</script>
@endsection
