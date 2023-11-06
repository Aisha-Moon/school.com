
@extends('layout.app')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Parent Student List {{ $getParent->name }}  {{ $getParent->last_name }}</h1>
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
                  <h3 class="card-title">Search Student </h3>
                </div>
                <form method="get" action="">

                    <div class="card-body">
                        <div class="row">
                      <div class="form-group col-md-2">
                        <label for="id">Student Id</label>
                        <input type="text" class="form-control" id="id" placeholder="Enter Student Id" name="id" value="{{ Request::get('id') }}">

                      </div>
                      <div class="form-group col-md-2">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" placeholder="Enter Name" name="name" value="{{ Request::get('name') }}">

                      </div>
                      <div class="form-group col-md-2">
                        <label for="name">Last Name</label>
                        <input type="text" class="form-control" id="name" placeholder="Enter Last Name" name="last_name" value="{{ Request::get('last_name') }}">

                      </div>
                      <div class="form-group col-md-2">
                        <label for="Email1">Email</label>
                        <input type="text" class="form-control" id="Email1" placeholder="Enter Email" name="email" value="{{ Request::get('email') }}"">
                        <div style="color:red;">{{ $errors->first('email') }}</div>
                      </div>



                      <div class="form-group col-md-2" style="margin-top: 10px;">
                        <button type="submit" class="btn btn-primary" style="margin-top: 22px;">Search</button>
                        <a href="{{ url('admin/parent/my-student/'.$parent_id) }}" class="btn btn-danger" style="margin-top: 20px;">Clear</a>
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
@if(!empty($getSearchStudent))
            <div class="card">
              <div class="card-header">
                <h3 class="card-title"> Student List </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>Id</th>
                      <th>Profile Pic</th>
                      <th>Student Name</th>

                      <th>Email</th>
                      <th>Parent Name</th>
                      <th>Created Date</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($getSearchStudent as $user)
                      <tr>
                          <td>{{ $user->id }}</td>
                          <td>
                              @if(!empty($user->getProfilepic()))
                              <img src="{{ $user->getProfilepic() }}" alt="" style="height:100px;">
                              @endif
                          </td>
                          <td>{{ $user->name }} {{ $user->last_name }}</td>
                          <td>{{ $user->email }}</td>
                          <td>{{ $user->parent_name }}</td>
                          <td>{{ date('d-m-y ,H:i A',strtotime($user->created_at)) }}</td>
                          <td style="min-width: 150px;">

                              <a href="{{ url('admin/parent/assign-student-parent/'.$user->id.'/'.$parent_id) }}" class="btn btn-primary btn-sm">Add Student To Parent</a>
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
      @endif
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Parent Student List </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>Id</th>
                        <th>Profile Pic</th>
                        <th>Student Name</th>

                        <th>Email</th>
                        <th>Parent Name</th>
                        <th>Created Date</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($getRecord as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>
                                @if(!empty($user->getProfilepic()))
                                <img src="{{ $user->getProfilepic() }}" alt="" style="height:100px;">
                                @endif
                            </td>
                            <td>{{ $user->name }} {{ $user->last_name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->parent_name }}</td>
                            <td>{{ date('d-m-y ,H:i A',strtotime($user->created_at)) }}</td>
                            <td style="min-width: 150px;">

                                <a href="{{ url('admin/parent/assign-student-parent-delete/'.$user->id) }}" class="btn btn-danger btn-sm">Delete</a>
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
        <!-- /.row -->

        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
@endsection
