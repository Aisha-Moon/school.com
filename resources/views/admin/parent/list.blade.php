
@extends('layout.app')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Parent List (Total : {{ $getRecord->total() }})</h1>
          </div>
          <div class="col-sm-6" style="text-align: right;">
           <a href="{{ url('admin/parent/add') }}" class="btn btn-primary">Add new Parent</a>
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
                        <label for="occupation">Occupation</label>
                        <input type="text" class="form-control" id="occupation" placeholder="Enter Occupation" name="occupation" value="{{ Request::get('occupation') }}"">
                        <div style="color:red;">{{ $errors->first('occupation') }}</div>
                      </div>
                      <div class="form-group col-md-2">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" placeholder="Enter address" name="address" value="{{ Request::get('address') }}"">
                        <div style="color:red;">{{ $errors->first('address') }}</div>
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
                        <label for="date">Created Date</label>
                        <input type="date" class="form-control" id="date"  name="date" value="{{ Request::get('date') }}"">
                      </div>

                      <div class="form-group col-md-2" style="margin-top: 10px;">
                        <button type="submit" class="btn btn-primary" style="margin-top: 22px;">Search</button>
                        <a href="{{ url('admin/parent/list') }}" class="btn btn-danger" style="margin-top: 20px;">Clear</a>
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
                <h3 class="card-title">Parent List </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>Id</th>
                      <th>Profile Pic</th>
                      <th>Name</th>
                      <th>Gender</th>
                      <th>Phone</th>
                      <th>Occupation</th>
                      <th>Address</th>
                      <th>Status</th>
                      <th>Email</th>
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
                        <img src="{{ $user->getProfileDirect() }}" alt="" style="height:100px;">
                        @endif
                    </td>
                        <td>{{ $user->name }} {{ $user->last_name }}</td>
                        <td>{{ $user->gender }}</td>
                        <td>{{ $user->mobile_number }}</td>
                        <td>{{ $user->occupation }}</td>
                        <td>{{ $user->address }}</td>
                        <td>{{ ($user->status==0)?'Active':'Inactive' }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ date('d-m-y ,H:i A',strtotime($user->created_at)) }}</td>
                        <td>
                            <a href="{{ url('admin/parent/edit/'.$user->id) }}" class="btn btn-primary">Edit</a>
                            <a href="{{ url('admin/parent/delete/'.$user->id) }}" class="btn btn-danger">Delete</a>
                            <a href="{{ url('admin/parent/my-student/'.$user->id) }}" class="btn btn-info">My Student</a>
                            <a href="{{ url('chat?receiver_id='.base64_encode($user->id)) }}" class="btn btn-primary">Send Message</a>

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
