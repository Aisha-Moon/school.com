
@extends('layout.app')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>My Class & Subject </h1>
          </div>


        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="col-md-12">

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

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">My Class & Subject </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-striped">
                  <thead>
                    <tr>

                      <th>Class Name</th>
                      <th>Subject Name</th>
                      <th>Subject Type</th>
                      <th>My Class Timetable</th>
                      <th>Created Date</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($getRecord as $teacher)
                    <tr>

                        <td>{{ $teacher->class_name }}</td>
                        <td>{{ $teacher->subject_name }}</td>
                        <td>{{ $teacher->subject_type }}</td>
                        <td>
                            @php
                                $classSubject=$teacher->getMyTimeTable($teacher->class_id,$teacher->subject_id);
                            @endphp
                            @if (!empty($classSubject))
                            {{ date('h:i A',strtotime($classSubject->start_time)) }} - {{ date('h:i A',strtotime($classSubject->end_time)) }}
                            <br>
                            Room Number : <b>{{$classSubject->room_number  }}</b>
                            @endif
                        </td>

                        <td>{{ date('d-m-y H:i A',strtotime($teacher->created_at)) }}</td>
                        <td>
                            <a href="{{ url('teacher/my_class_subject/class_timetable/'.$teacher->class_id.'/'.$teacher->subject_id) }}" class="btn btn-primary">My Class Timetable</a>
                        </td>

                    </tr>

                    @endforeach
                </tbody>
              </table>

              </div>
              <!-- /.card-body -->
            </div>
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
