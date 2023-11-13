
@extends('layout.app')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row ">
          <div class="col-sm-6">
            <h1>Student List (Total : {{ $getRecord->total() }})</h1>
          </div>
          <div class="col-sm-6" style="text-align: right;">
           <a href="{{ url('admin/student/add') }}" class="btn btn-primary">Add new Student</a>
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
            <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Search Student </h3>
                </div>
                <form method="get" action="">

                    <div class="card-body">
                        <div class="row">
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
                      <div class="form-group col-md-2">
                        <label for="admission_number">Admission Number</label>
                        <input type="text" class="form-control" id="admission_number" placeholder="Enter Admission Number" name="admission_number" value="{{ Request::get('admission_number') }}">

                      </div>
                      <div class="form-group col-md-2">
                        <label for="roll_number">Roll Number</label>
                        <input type="text" class="form-control" id="roll_number" placeholder="Enter roll Number" name="roll_number" value="{{ Request::get('roll_number') }}">

                      </div>
                      <div class="form-group col-md-2">
                        <label for="class">Class</label>
                        <input type="text" class="form-control" id="class" placeholder="Enter Class" name="class" value="{{ Request::get('class') }}">

                      </div>
                      <div class="form-group col-md-2">
                        <label for="gender">Gender</label>
                        <select name="gender" id="gender" class="form-control" >
                            <option value="">Select Gender</option>
                            <option {{Request::get('gender')== 'Male' ? 'selected' :''}} value="Male">Male</option>
                            <option {{Request::get('gender')== 'Female' ? 'selected' :''}} value="Female">Female</option>
                            <option {{Request::get('gender')== 'Others' ? 'selected' :''}} value="Others">Others</option>

                        </select>

                      </div>
                      <div class="form-group col-md-2">
                        <label for="caste">Caste</label>
                        <input type="text" class="form-control" id="caste" placeholder="Enter caste" name="caste" value="{{ Request::get('caste') }}">

                      </div>
                      <div class="form-group col-md-2">
                        <label for="religion">Religion</label>
                        <input type="text" class="form-control" id="religion" placeholder="Enter Religion" name="religion" value="{{ Request::get('religion') }}">

                      </div>
                      <div class="form-group col-md-2">
                        <label for="mobile_number">Mobile Number</label>
                        <input type="text" class="form-control" id="mobile_number" placeholder="Enter Mobile Number" name="mobile_number" value="{{ Request::get('mobile_number') }}">

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
                        <label for="blood_group">Blood Group</label>
                        <input type="text" class="form-control" id="blood_group" placeholder="Enter Blood group" name="blood_group" value="{{ Request::get('blood_group') }}">

                      </div>
                      <div class="form-group col-md-2">
                        <label for="admission_date">Admission Date</label>
                        <input type="date" class="form-control" id="admission_date"  name="admission_date" value="{{ Request::get('admission_date') }}">

                      </div>
                      <div class="form-group col-md-2">
                        <label for="date">Created Date</label>
                        <input type="date" class="form-control" id="date"  name="date" value="{{ Request::get('date') }}"">
                      </div>

                      <div class="form-group col-md-2" style="margin-top: 10px;">
                        <button type="submit" class="btn btn-primary" style="margin-top: 22px;">Search</button>
                        <a href="{{ url('admin/student/list') }}" class="btn btn-danger" style="margin-top: 20px;">Clear</a>
                      </div>

                    </div>
                    </div>
                    <!-- /.card-body -->


                  </form>
            </div>

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
                      <h3 class="card-title">Student List </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0" style="overflow: auto;">
                      <table class="table table-striped">
                        <thead>
                          <tr>
                            <th>Id</th>
                            <th>Profile Pic</th>
                            <th>Student Name</th>
                            <th>Parent Name</th>
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
                            <th>Status</th>
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
                              <td>{{ $user->parent_name }} {{ $user->parent_last_name }}</td>
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
                              <td>{{ ($user->status==0) ? 'Active' : 'Inactive' }}</td>
                              <td>{{ date('d-m-y ,H:i A',strtotime($user->created_at)) }}</td>
                              <td style="min-width: 150px;">
                                  <a href="{{ url('admin/student/edit/'.$user->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                  <a href="{{ url('admin/student/delete/'.$user->id) }}" class="btn btn-danger btn-sm">Delete</a>
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
                </div>
           </div>
            <!-- /.card -->
          </div>
        </section>
        </div>
          <!-- /.col -->

        <!-- /.row -->


@endsection
