
@extends('layout.app')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Marks Grade</h1>
          </div>
          <div class="col-sm-6" style="text-align: right;">
           <a href="{{ url('admin/examinations/marks_grade_add') }}" class="btn btn-primary">Add new Marks Grade</a>
          </div>

        </div>
      </div><!-- /.container-fluid -->
    </section>
    <section class="content">
      <div class="container-fluid">
        <div class="col-md-12">
        </div>
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

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Marks Grade List </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-striped">
                  <thead>
                    <tr>

                      <th>Grade Name</th>
                      <th>Percent From</th>
                      <th>Percent To</th>
                      <th>Created By</th>
                      <th>Created Date</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($getRecord as $user)
                    <tr>

                        <td>{{ $user->name }}</td>
                        <td>{{ $user->percent_from}}</td>
                        <td>{{ $user->percent_to}}</td>
                        <td>{{ $user->created_by}}</td>
                        <td>{{ date('d-m-y ,H:i A',strtotime($user->created_at)) }}</td>
                        <td>
                            <a href="{{ url('admin/examinations/marks_grade_edit/'.$user->id) }}" class="btn btn-primary">Edit</a>
                            <a href="{{ url('admin/examinations/exam/delete'.$user->id) }}" class="btn btn-danger">Delete</a>
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
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
@endsection
