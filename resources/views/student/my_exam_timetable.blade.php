
@extends('layout.app')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>My Exam Timetable </h1>
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

          @foreach ($getRecord as $value)


           <div class="card">
            <div class="card-header" style="text-align: center;">
              <h2 class="card-title" ><b>{{ $value['name'] }}</b> </h2>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
              <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Subject Name</th>
                        <th>Day</th>
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
                    @foreach ($value['exam'] as $valueS)
                    <tr>
                        <td>{{ $valueS['subject_name'] }}</td>
                    <td>{{ date('l',strtotime($valueS['exam_date'] ))}}</td>
                    <td>{{ date('d-m-y',strtotime($valueS['exam_date'] ))}}</td>
                    <td>{{ date('h:i A',strtotime($valueS['start_time'] ))}}</td>
                    <td>{{ date('h:i A',strtotime($valueS['end_time'] ))}}</td>
                    <td>{{ $valueS['room_number'] }}</td>
                    <td>{{ $valueS['full_marks'] }}</td>
                    <td>{{ $valueS['pass_marks'] }}</td>
                    </tr>
                    @endforeach

                </tbody>

              </table>


            </div>
            <!-- /.card-body -->
          </div>
          @endforeach

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

