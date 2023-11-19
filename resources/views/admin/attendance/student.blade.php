
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
            <h1>Student Attendance</h1>
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
              <h3 class="card-title">Search Student Attendance</h3>
            </div>
            <form method="get" action="">
                <div class="card-body">
                    <div class="row">

                  <div class="form-group col-md-3">
                    <label for="ss">Class</label>
                    <select name="class_id" required class="form-control" id="getClass">
                        <option value="">Select Class</option>
                        @foreach ($getClass as $class)
                        <option {{ (Request::get('class_id')==$class->id) ? 'selected' :'' }} required value="{{ $class->id }}">{{ $class->name }}</option>

                        @endforeach
                    </select>
                  </div>
                  <div class="form-group col-md-3" >
                    <label for="attendance_date">Attendance Date</label>
                    <input type="date" name="attendance_date"  value="{{Request::get('attendance_date') }}" id="getAttendanceDate" class="form-control" required>
                  </div>
                  <div class="form-group col-md-3" style="margin-top: 10px;">
                    <button type="submit" class="btn btn-primary" style="margin-top: 22px;">Search</button>
                    <a href="{{ url('admin/attendance/student') }}" class="btn btn-danger" style="margin-top: 20px;">Clear</a>
                  </div>
                </div>
                </div>
                <!-- /.card-body -->
              </form>
        </div>
        @if(!empty(Request::get('class_id')) && !empty(Request::get('attendance_date')))

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Student List</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Student ID</th>
                            <th>Student Name</th>
                            <th>Attendance</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!empty($getStudent) && !empty($getStudent->count()))
                            @foreach ($getStudent as $value)
                            @php
                                $attendance_type='';
                                $getAttendance = $value->getAttendance($value->id,Request::get('class_id'),Request::get('attendance_date'));
                                if(!empty($getAttendance)){
                                    $attendance_type=$getAttendance->attendance_type;
                                }
                            @endphp
                                <tr>
                                    <td>{{ $value->id }}</td>
                                    <td>{{ $value->name }}{{ $value->last_name }}</td>
                                    <td>
                                        <label style="margin-right: 10px;" for=""><input type="radio" {{ ($attendance_type)=='1' ? 'checked' : '' }} value="1" id="{{ $value->id }}" class="saveAttendance" name="attendance{{ $value->id }}">Present</label>
                                        <label style="margin-right: 10px;" for=""><input type="radio" {{ ($attendance_type)=='2' ? 'checked' : '' }} value="2" id="{{ $value->id }}" class="saveAttendance" name="attendance{{ $value->id }}">Late</label>
                                        <label style="margin-right: 10px;" for=""><input type="radio" {{ ($attendance_type)=='3' ? 'checked' : '' }} value="3" id="{{ $value->id }}" class="saveAttendance" name="attendance{{ $value->id }}">Absent</label>
                                        <label style="margin-right: 10px;" for=""><input type="radio" {{ ($attendance_type)=='4' ? 'checked' : '' }} value="4" id="{{ $value->id }}" class="saveAttendance" name="attendance{{ $value->id }}">Half Day</label>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
          </div>
        </div>
        @endif
        </div>
          <!-- /.col -->

        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
@endsection
@section('script')
<script type="text/javascript">

$('.saveAttendance').change(function(e){
  var student_id = $(this).attr('id');
  var attendance_type= $(this).val();
  var class_id = $('#getClass').val();
  var attendance_date= $('#getAttendanceDate').val();


  $.ajax({

        type: "POST",
        url:"{{ url('admin/attendance/student/save') }}",
        data:{
                "_token":"{{ csrf_token() }}",

                student_id:student_id,
                attendance_type:attendance_type,
                class_id:class_id,
                attendance_date:attendance_date,

        },
        dataType: "JSON",
        success: function (data){
            alert(data.message);
        }
    });
});



</script>
@endsection
