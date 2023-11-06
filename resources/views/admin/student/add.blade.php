
@extends('layout.app')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Add new Student</h1>
          </div>

        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">

              <!-- /.card-header -->
              <!-- form start -->
              <form method="post" action="" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="card-body">
                  <div class="row">
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1">First Name  <span style="color: red;">*</span> </label>
                        <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter First Name" name="name" value="{{ old('name') }}" required>
                        <div style="color:red;">{{ $errors->first('name') }}</div>

                     </div>
                    <div class="form-group col-md-6">
                        <label for="last_name">Last Name <span style="color: red;">*</span> </label>
                        <input type="text" class="form-control" required id="last_name" placeholder="Enter Last Name" name="last_name" value="{{ old('last_name') }}">
                        <div style="color:red;">{{ $errors->first('last_name') }}</div>

                     </div>
                    <div class="form-group col-md-6">
                        <label for="admission_number">Admission Number <span style="color: red;">*</span> </label>
                        <input type="text" class="form-control" required id="admission_number" placeholder="Enter Admission Number" name="admission_number" value="{{ old('addmission_number') }}">
                        <div style="color:red;">{{ $errors->first('admission_number') }}</div>

                     </div>
                    <div class="form-group col-md-6">
                        <label for="roll_number">Roll Number <span style="color: red;"></span> </label>
                        <input type="text" class="form-control" id="roll_number" placeholder="Enter Roll Number" name="roll_number" value="{{ old('roll_number') }}">
                        <div style="color:red;">{{ $errors->first('roll_number') }}</div>

                     </div>
                     <div class="form-group col-md-6">
                        <label for="class_id">Class <span style="color: red;">*</span> </label>
                        <select name="class_id" id="class_id" class="form-control" required>
                            <option value="">Select Class</option>
                            @foreach ($getClass as $class)
                            <option {{old('class_id')== $class->id ? 'selected' :''}} value=" {{ $class->id }}" >{{ $class->name }}</option>
                            @endforeach
                        </select>

                     </div>
                     <div class="form-group col-md-6">
                        <label for="gender">Gender <span style="color: red;">*</span> </label>
                        <select name="gender" id="gender" class="form-control" required>
                            <option value="">Select Gender</option>
                            <option {{old('gender')== 'Male' ? 'selected' :''}} value="Male">Male</option>
                            <option {{old('gender')== 'Female' ? 'selected' :''}} value="Female">Female</option>
                            <option {{old('gender')== 'Others' ? 'selected' :''}} value="Others">Others</option>

                        </select>

                     </div>
                     <div class="form-group col-md-6">
                        <label for="date_of_birth">Date Of Birth <span style="color: red;">*</span> </label>
                        <input required type="date" class="form-control" id="date_of_birth"  name="date_of_birth" value="{{ old('date_of_birth') }}">
                        <div style="color:red;">{{ $errors->first('date_of_birth') }}</div>

                     </div>
                     <div class="form-group col-md-6">
                        <label for="caste">Caste <span style="color: red;"></span> </label>
                        <input type="text" class="form-control" id="caste" placeholder="Caste" name="caste" value="{{ old('caste') }}">
                        <div style="color:red;">{{ $errors->first('caste') }}</div>

                     </div>
                     <div class="form-group col-md-6">
                        <label for="religion">Religion <span style="color: red;"></span> </label>
                        <input type="text" class="form-control" id="religion" placeholder="Religion" name="religion" value="{{ old('religion') }}">
                        <div style="color:red;">{{ $errors->first('religion') }}</div>

                     </div>
                     <div class="form-group col-md-6">
                        <label for="mobile_number">Mobile Number <span style="color: red;"></span> </label>
                        <input type="text" class="form-control" id="mobile_number" placeholder="Mobile Number" name="mobile_number" value="{{ old('mobile_number') }}">
                        <div style="color:red;">{{ $errors->first('mobile_number') }}</div>

                     </div>
                     <div class="form-group col-md-6">
                        <label for="admission_date">Admission Date <span style="color: red;">*</span> </label>
                        <input type="date" class="form-control" required id="admission_date"  name="admission_date" value="{{ old('admission_date') }}">
                        <div style="color:red;">{{ $errors->first('admission_date') }}</div>

                     </div>
                     <div class="form-group col-md-6">
                        <label for="profile_pic">Profile Pic <span style="color: red;"></span> </label>
                        <input type="file" class="form-control"  id="profile_pic"  name="profile_pic" >
                        <div style="color:red;">{{ $errors->first('profile_pic') }}</div>


                     </div>
                     <div class="form-group col-md-6">
                        <label for="blood_group">Blood Group <span style="color: red;"></span> </label>
                        <input type="text" class="form-control"  id="blood_group" placeholder="Blood Group"  name="blood_group" >
                        <div style="color:red;">{{ $errors->first('blood_group') }}</div>

                     </div>

                     <div class="form-group col-md-6">
                        <label for="height">Height<span style="color: red;"></span> </label>
                        <input type="text" class="form-control"  id="height" placeholder="Height" value="{{ old('height') }}" name="height">
                        <div style="color:red;">{{ $errors->first('height') }}</div>

                     </div>
                     <div class="form-group col-md-6">
                        <label for="weight">Weight<span style="color: red;"></span> </label>
                        <input type="text" class="form-control"  id="weight" placeholder="Weight" value="{{ old('weight') }}"  name="weight">
                        <div style="color:red;">{{ $errors->first('weight') }}</div>

                     </div>

                     <div class="form-group col-md-6">
                        <label for="status">Status <span style="color: red;">*</span> </label>
                        <select name="status" id="status" class="form-control" required>
                            <option value="">Select Status</option>
                            <option {{old('status')== 0 ? 'selected' :''}} value="0">Active</option>
                            <option {{old('status')== 1 ? 'selected' :''}} value="1">Inactive</option>

                        </select>
                        <div style="color:red;">{{ $errors->first('status') }}</div>

                     </div>
                     <hr>
                  </div>
                  <div class="form-group">
                    <label for="Email1">Email <span style="color: red;">*</span></label>
                    <input type="text" class="form-control" id="Email1" placeholder="Enter Email" name="email" value="{{ old('email') }}" required>
                    <div style="color:red;">{{ $errors->first('email') }}</div>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Password <span style="color: red;">*</span></label>
                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Enter Password" name="password">
                  </div>



                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
            <!-- /.card -->




          </div>
          <!--/.col (left) -->
          <!-- right column -->

          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
@endsection
