
@extends('layout.app')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>My Account</h1>
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
                        <input type="text" class="form-control" id="exampleInputEmail1"  name="name" value="{{ old('name',$getRecord->name) }}"  >
                        <div style="color:red;">{{ $errors->first('name') }}</div>

                     </div>
                    <div class="form-group col-md-6">
                        <label for="last_name">Last Name <span style="color: red;">*</span> </label>
                        <input type="text" class="form-control"  id="last_name"  name="last_name" value="{{ old('last_name',$getRecord->last_name) }}">
                        <div style="color:red;">{{ $errors->first('last_name') }}</div>

                     </div>


                     <div class="form-group col-md-6">
                        <label for="gender">Gender <span style="color: red;">*</span> </label>
                        <select name="gender" id="gender" class="form-control"  >
                            <option value="">Select Gender</option>
                            <option {{old('gender',$getRecord->gender)== 'Male' ? 'selected' :''}} value="Male">Male</option>
                            <option {{old('gender',$getRecord->gender)== 'Female' ? 'selected' :''}} value="Female">Female</option>
                            <option {{old('gender',$getRecord->gender)== 'Others' ? 'selected' :''}} value="Others">Others</option>

                        </select>

                     </div>
                     <div class="form-group col-md-6">
                        <label for="date_of_birth">Date Of Birth <span style="color: red;">*</span> </label>
                        <input required type="date" class="form-control" id="date_of_birth"  name="date_of_birth" value="{{ old('date_of_birth',$getRecord->date_of_birth) }}">
                        <div style="color:red;">{{ $errors->first('date_of_birth') }}</div>

                     </div>


                     <div class="form-group col-md-6">
                        <label for="religion">Religion <span style="color: red;"></span> </label>
                        <input type="text" class="form-control" id="religion" placeholder="Religion" name="religion" value="{{ old('religion',$getRecord->religion) }}">
                        <div style="color:red;">{{ $errors->first('religion') }}</div>

                     </div>
                     <div class="form-group col-md-6">
                        <label for="mobile_number">Mobile Number <span style="color: red;"></span> </label>
                        <input type="text" class="form-control" id="mobile_number" placeholder="Mobile Number" name="mobile_number" value="{{ old('mobile_number',$getRecord->mobile_number) }}">
                        <div style="color:red;">{{ $errors->first('mobile_number') }}</div>

                     </div>
                     <div class="form-group col-md-6">
                        <label for="marital_status">Marital Status <span style="color: red;"></span> </label>
                        <input type="text" class="form-control" id="marital_status" placeholder="Marital Status" name="marital_status" value="{{ old('marital_status',$getRecord->marital_status) }}">
                        <div style="color:red;">{{ $errors->first('marital_status') }}
                     </div>
                     </div>

                     <div class="form-group col-md-6">
                        <label for="profile_pic">Profile Pic <span style="color: red;"></span> </label>

                        <input type="file" class="form-control"  id="profile_pic"  name="profile_pic" >
                        <div style="color:red;">{{ $errors->first('profile_pic') }}</div>
                        @if(!empty($getRecord->getProfilepic()))
                         <img src="{{ $getRecord->getProfilepic() }}" alt="" style="height:100px;">
                        @endif



                     </div>
                     <div class="form-group col-md-6">
                        <label for="address">Current Address <span style="color: red;"></span> </label>
                        <textarea name="address" class="form-control" id="address"  >{{ old('address',$getRecord->address) }}</textarea>
                        <div style="color:red;">{{ $errors->first('address') }}</div>

                     </div>
                     <div class="form-group col-md-6">
                        <label for="permanent_address">Permanent Address<span style="color: red;"></span> </label>
                        <textarea name="permanent_address" class="form-control" id="permanent_address"  >{{ old('permanent_address',$getRecord->permanent_address) }}</textarea>
                        <div style="color:red;">{{ $errors->first('permanent_address') }}</div>

                     </div>
                     <div class="form-group col-md-6">
                        <label for="qualification">Qualification<span style="color: red;"></span> </label>
                        <textarea name="qualification" class="form-control" id="qualification"  >{{ old('qualification',$getRecord->qualification) }}</textarea>
                        <div style="color:red;">{{ $errors->first('qualification') }}</div>

                     </div>
                     <div class="form-group col-md-6">
                        <label for="work_experience">Work Experience<span style="color: red;"></span> </label>
                        <textarea name="work_experience" class="form-control" id="work_experience"  >{{ old('work_experience',$getRecord->work_experience) }}</textarea>
                        <div style="color:red;">{{ $errors->first('work_experience') }}</div>

                     </div>

                     <hr>
                  </div>
                  <div class="form-group">
                    <label for="Email1">Email <span style="color: red;">*</span></label>
                    <input type="text" class="form-control" id="Email1" placeholder="Enter Email" name="email" value="{{ old('email',$getRecord->email) }}" >
                    <div style="color:red;">{{ $errors->first('email') }}</div>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Password <span style="color: red;">*</span></label>
                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Enter Password" name="password">
                  </div>



                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Update</button>
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
