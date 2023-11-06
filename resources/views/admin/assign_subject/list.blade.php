
@extends('layout.app')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Assign Subject List</h1>
          </div>
          <div class="col-sm-6" style="text-align: right;">
           <a href="{{ url('admin/assign_subject/add') }}" class="btn btn-primary">Add new Assign Subject</a>
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
              <h3 class="card-title">Search Assign Subject </h3>
            </div>
            <form method="get" action="">

                <div class="card-body">
                    <div class="row">
                  <div class="form-group col-md-3">
                    <label for="exampleInputEmail1">Class Name</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter class Name" name="class_name" value="{{ Request::get('class_name') }}">

                  </div>
                  <div class="form-group col-md-3">
                    <label for="exampleInputEmail">Subject Name</label>
                    <input type="text" class="form-control" id="exampleInputEmail" placeholder="Enter Subject Name" name="subject_name" value="{{ Request::get('subject_name') }}">

                  </div>


                  <div class="form-group col-md-3">
                    <label for="date">Date</label>
                    <input type="date" class="form-control" id="date"  name="date" value="{{ Request::get('date') }}"">
                  </div>

                  <div class="form-group col-md-3" style="margin-top: 10px;">
                    <button type="submit" class="btn btn-primary" style="margin-top: 22px;">Search</button>
                    <a href="{{ url('admin/class_subject/list') }}" class="btn btn-danger" style="margin-top: 20px;">Reset</a>
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

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Assign Subject List </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>Id</th>
                      <th>Class Name</th>
                      <th>Subject Name</th>

                      <th>Status</th>
                      <th>Created By</th>
                      <th>Created Date</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach ($getRecord as $class)
                  <tr>
                      <td>{{ $class->id }}</td>
                      <td>{{ $class->class_name }}</td>
                      <td>{{ $class->subject_name }}</td>
                     <td>
                      @if ($class->status==0)
                      Active
                      @else
                      Inactive
                      @endif
                     </td>

                      <td>{{ $class->created_by_name }}</td>
                      <td>{{ date('d-m-y H:i A',strtotime($class->created_at)) }}</td>
                      <td>
                          <a href="{{ url('admin/assign_subject/edit/'.$class->id) }}" class="btn btn-primary">Edit</a>
                          <a href="{{ url('admin/assign_subject/edit_single/'.$class->id) }}" class="btn btn-primary">Edit Single</a>
                          <a href="{{ url('admin/assign_subject/delete/'.$class->id) }}" class="btn btn-danger">Delete</a>
                      </td>
                  </tr>

                  @endforeach
                </tbody>
              </table>
              <div style="padding:10px;float:right;">
                  {!! $getRecord->appends(Illuminate\Support\Facades\Request::except('page'))->links() !!}

              </div>
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
