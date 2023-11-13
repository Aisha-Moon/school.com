
@extends('layout.app')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Assign Class Teacher <span style="color: green;">(Total : {{ $getRecord->total() }})</span></h1>
          </div>
          <div class="col-sm-6" style="text-align: right;">
           <a href="{{ url('admin/assign_class_teacher/add') }}" class="btn btn-primary">Add new Assign Class Teacher</a>
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
                      <div class="form-group col-md-2">
                        <label for="exampleInputEmail1">Class Name</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter class Name" name="class_name" value="{{ Request::get('class_name') }}">

                      </div>
                      <div class="form-group col-md-2">
                        <label for="teacher">Teacher Name</label>
                        <input type="text" class="form-control" id="teacher" placeholder="Enter Teacher Name" name="teacher_name" value="{{ Request::get('teacher_name') }}">

                      </div>

                      <div class="form-group col-md-2">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control" >
                            <option value="">Select Status</option>
                            <option {{(Request::get('status'))== 100 ? 'selected' :''}} value="100">Active</option>
                            <option {{(Request::get('status'))== 1 ? 'selected' :''}} value="1">Inactive</option>

                        </select>


                      </div>
                      <div class="form-group col-md-2">
                        <label for="date">Date</label>
                        <input type="date" class="form-control" id="date"  name="date" value="{{ Request::get('date') }}"">
                      </div>

                      <div class="form-group col-md-2" style="margin-top: 10px;">
                        <button type="submit" class="btn btn-primary btn-sm" style="margin-top: 22px;">Search</button>
                        <a href="{{ url('admin/assign_class_teacher/list') }}" class="btn btn-danger btn-sm" style="margin-top: 20px;">Reset</a>
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
                <h3 class="card-title">Assign Class Teacher List </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>Id</th>
                      <th>Class Name</th>
                      <th>Teacher Name</th>
                      <th>Status</th>
                      <th>Created By</th>
                      <th>Created Date</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($getRecord as $teacher)
                    <tr>
                        <td>{{ $teacher->id }}</td>
                        <td>{{ $teacher->class_name }}</td>
                        <td>{{ $teacher->teacher_name }}</td>
                       <td>
                        @if ($teacher->status==0)
                        Active
                        @else
                        Inactive
                        @endif
                       </td>

                        <td>{{ $teacher->created_by_name }}</td>
                        <td>{{ date('d-m-y H:i A',strtotime($teacher->created_at)) }}</td>
                        <td>
                            <a href="{{ url('admin/assign_class_teacher/edit/'.$teacher->id) }}" class="btn btn-primary">Edit</a>
                            <a href="{{ url('admin/assign_class_teacher/edit_single/'.$teacher->id) }}" class="btn btn-primary">Edit Single</a>

                            <a href="{{ url('admin/assign_class_teacher/delete/'.$teacher->id) }}" class="btn btn-danger">Delete</a>
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
