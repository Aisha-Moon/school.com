
@extends('layout.app')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>My Student </h1>
          </div>


        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">


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
          </div>

            <!-- /.card -->

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Parent Student List </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0" style="overflow:auto;">
                <table class="table table-striped">
                    <thead>
                      <tr>

                            <th>Profile Pic</th>
                            <th>Student Name</th>
                            <th>Email</th>
                            <th>Admission Number</th>
                            <th>Roll Number</th>
                            <th>Class</th>
                            <th>Gender</th>
                            <th>Date Of Birth</th>
                            <th>Caste</th>
                            <th>Religion</th>
                            <th>Mobile Number</th>
                            <th>Admission Date</th>
                            <th>Blood Group</th>
                            <th>Height</th>
                            <th>Weight</th>
                            <th>Created Date</th>
                            <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($getRecord as $user)
                        <tr>

                            <td>
                                @if(!empty($user->getProfilepic()))
                                <img src="{{ $user->getProfilepic() }}" alt="" style="height:100px;">
                                @endif
                            </td>
                            <td>{{ $user->name }} {{ $user->last_name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->admission_number }}</td>
                            <td>{{ $user->roll_number }}</td>
                            <td>{{ $user->class_name }}</td>
                            <td>{{ $user->gender }}</td>
                            <td> @if(!empty($user->date_of_birth))
                              {{ date('d-m-y',strtotime($user->date_of_birth)) }}
                            @endif</td>


                            <td>{{ $user->caste }}</td>
                            <td>{{ $user->religion }}</td>
                            <td>{{ $user->mobile_number }}</td>
                            <td> @if(!empty($user->admission_date))
                              {{ date('d-m-y',strtotime($user->admission_date)) }}
                               @endif</td>
                            <td>{{ $user->blood_group }}</td>
                            <td>{{ $user->height }}</td>
                            <td>{{ $user->weight }}</td>
                            <td>{{ date('d-m-y ,H:i A',strtotime($user->created_at)) }}</td>
                           <td style="min-width:500px;">
                            <a class="btn btn-primary btn-sm" href="{{ url('parent/my_student/subject/'.$user->id) }}">Subject</a>
                            <a class="btn btn-info btn-sm" href="{{ url('parent/my_student/exam_timetable/'.$user->id) }}">Exam Timetable</a>
                            <a class="btn btn-secondary btn-sm" href="{{ url('parent/my_student/exam_result/'.$user->id) }}">Exam Result</a>
                            <a class="btn btn-success btn-sm" href="{{ url('parent/my_student/calendar/'.$user->id) }}">Calendar</a>
                           </td>
                        </tr>
                      @endforeach

                      </tbody>
                  </table>
                <div style="padding:10px;float:right;">

                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        </div>
        <!-- /.row -->

        <!-- /.row -->

    </section>
    <!-- /.content -->
  </div>
@endsection
