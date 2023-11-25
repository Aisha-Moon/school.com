
@extends('layout.app')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row ">
          <div class="col-sm-6">
            <h1>Teacher List (Total : {{ $getRecord->total() }})</h1>
          </div>
          <div class="col-sm-6" style="text-align: right;">
           <a href="{{ url('admin/teacher/add') }}" class="btn btn-primary">Add new Teacher</a>
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
                  <h3 class="card-title">Search Teacher </h3>
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
                        <label for="gender">Gender</label>
                        <select name="gender" id="gender" class="form-control" >
                            <option value="">Select Gender</option>
                            <option {{Request::get('gender')== 'Male' ? 'selected' :''}} value="Male">Male</option>
                            <option {{Request::get('gender')== 'Female' ? 'selected' :''}} value="Female">Female</option>
                            <option {{Request::get('gender')== 'Others' ? 'selected' :''}} value="Others">Others</option>

                        </select>

                      </div>

                      <div class="form-group col-md-2">
                        <label for="religion">Marital Status</label>
                        <input type="text" class="form-control" id="marital_status" placeholder="Enter Marital Status" name="marital_status" value="{{ Request::get('marital_status') }}">

                      </div>
                      <div class="form-group col-md-2">
                        <label for="religion">Current Address</label>
                        <input type="text" class="form-control" id="current_address" placeholder="Enter Current Address" name="current_address" value="{{ Request::get('current_address') }}">

                      </div>
                      <div class="form-group col-md-2">
                        <label for="mobile_number">Mobile Number</label>
                        <input type="text" class="form-control" id="mobile_number" placeholder="Enter Mobile Number" name="mobile_number" value="{{ Request::get('mobile_number') }}">

                      </div>
                      <div class="form-group col-md-2">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control" >
                            <option value="">Select Status</option>
                            <option {{Request::get('status')== 100 ? 'selected' :''}} value="100">Active</option>
                            <option {{Request::get('status')== 0 ? 'selected' :''}} value="0">Inactive</option>

                        </select>


                      </div>

                      <div class="form-group col-md-2">
                        <label for="admission_date">Date Of Joining</label>
                        <input type="date" class="form-control" id="date_of_joining"  name="date_of_joining" value="{{ Request::get('date_of_joining') }}">

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
                      <h3 class="card-title">Teacher List </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0" style="overflow: auto;">
                      <table class="table table-striped">
                        <thead>
                          <tr>
                            <th>Id</th>
                            <th>Profile Pic</th>
                            <th>Teacher Name</th>
                            <th>Email</th>
                            <th>Gender</th>
                            <th>Date Of Birth</th>
                            <th>Date Of Joining</th>
                            <th>Religion</th>
                            <th>Mobile Number</th>
                            <th>Marital Status</th>
                            <th>Current Address</th>
                            <th>Permanent Address</th>
                            <th>Qualification</th>
                            <th>Work Experience</th>
                            <th>Note</th>
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
                                  @if(!empty($user->getProfileDirect()))
                                  <img src="{{ $user->getProfileDirect() }}" alt="" style="height:100px;width:100px;border-radius:50%;">
                                  @endif
                              </td>
                              <td>{{ $user->name }} {{ $user->last_name }}</td>
                              <td>{{ $user->email }}</td>
                              <td>{{ $user->gender }}</td>
                              <td> @if(!empty($user->date_of_birth))
                                {{ date('d-m-y',strtotime($user->date_of_birth)) }}
                                 @endif</td>
                                 <td> @if(!empty($user->admission_date))
                                    {{ date('d-m-y',strtotime($user->admission_date)) }}
                                  @endif</td>
                              <td>{{ $user->religion }}</td>
                              <td>{{ $user->mobile_number}}</td>
                             <td>{{ $user->marital_status}}</td>
                             <td>{{ $user->current_address}}</td>
                             <td>{{ $user->permanent_address}}</td>


                              <td>{{ $user->qualification }}</td>
                              <td>{{ $user->work_experience}}</td>
                              <td>{{ $user->note}}</td>

                              <td>{{ ($user->status==0) ? 'Active' : 'Inactive' }}</td>
                              <td>{{ date('d-m-y ,H:i A',strtotime($user->created_at)) }}</td>
                              <td style="min-width: 250px;">
                                  <a href="{{ url('admin/teacher/edit/'.$user->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                  <a href="{{ url('admin/teacher/delete/'.$user->id) }}" class="btn btn-danger btn-sm">Delete</a>
                                  <a href="{{ url('chat?receiver_id='.base64_encode($user->id)) }}" class="btn btn-primary btn-sm">Send Message</a>

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
                </div>
           </div>
            <!-- /.card -->
          </div>
        </section>
        </div>
          <!-- /.col -->

        <!-- /.row -->


@endsection
