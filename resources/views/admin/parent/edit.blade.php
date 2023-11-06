
@extends('layout.app')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit new Parent</h1>
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
                        <input type="text" class="form-control" id="exampleInputEmail1"  name="name" value="{{ old('name',$getRecord->name) }}" required>
                        <div style="color:red;">{{ $errors->first('name') }}</div>

                     </div>
                    <div class="form-group col-md-6">
                        <label for="last_name">Last Name <span style="color: red;">*</span> </label>
                        <input type="text" class="form-control" required id="last_name"  name="last_name" value="{{ old('last_name',$getRecord->last_name) }}">
                        <div style="color:red;">{{ $errors->first('last_name') }}</div>

                     </div>


                     <div class="form-group col-md-6">
                        <label for="gender">Gender <span style="color: red;">*</span> </label>
                        <select name="gender" id="gender" class="form-control" required>
                            <option value="">Select Gender</option>
                            <option {{old('gender',$getRecord->gender)== 'Male' ? 'selected' :''}} value="Male">Male</option>
                            <option {{old('gender',$getRecord->gender)== 'Female' ? 'selected' :''}} value="Female">Female</option>
                            <option {{old('gender',$getRecord->gender)== 'Others' ? 'selected' :''}} value="Others">Others</option>

                        </select>

                     </div>



                     <div class="form-group col-md-6">
                        <label for="mobile_number">Mobile Number <span style="color: red;"></span> </label>
                        <input type="text" class="form-control" required id="mobile_number"  name="mobile_number" value="{{ old('mobile_number',$getRecord->mobile_number) }}">
                        <div style="color:red;">{{ $errors->first('mobile_number') }}</div>

                     </div>
                     <div class="form-group col-md-6">
                        <label for="occupation">Occupation <span style="color: red;"></span> </label>
                        <input type="text" class="form-control" id="occupation"  name="occupation" value="{{ old('occupation',$getRecord->occupation) }}">
                        <div style="color:red;">{{ $errors->first('occupation') }}</div>

                     </div>
                     <div class="form-group col-md-6">
                        <label for="address">Address <span style="color: red;"></span> </label>
                        <input type="text" class="form-control" id="address"  required name="address" value="{{ old('address',$getRecord->address) }}">
                        <div style="color:red;">{{ $errors->first('address') }}</div>
                        @if(!empty($getRecord->getProfilepic()))
                         <img src="{{ $getRecord->getProfilepic() }}" alt="" style="height:100px;">
                        @endif

                     </div>

                     <div class="form-group col-md-6">
                        <label for="profile_pic">Profile Pic <span style="color: red;"></span> </label>
                        <input type="file" class="form-control"  id="profile_pic"  name="profile_pic" >
                        <div style="color:red;">{{ $errors->first('profile_pic') }}</div>


                     </div>




                     <div class="form-group col-md-6">
                        <label for="status">Status <span style="color: red;">*</span> </label>
                        <select name="status" id="status" class="form-control" required>
                            <option value="">Select Status</option>
                            <option {{old('status',$getRecord->status)== 0 ? 'selected' :''}} value="0">Active</option>
                            <option {{old('status',$getRecord->status)== 1 ? 'selected' :''}} value="1">Inactive</option>

                        </select>
                        <div style="color:red;">{{ $errors->first('status') }}</div>

                     </div>
                     <hr>
                  </div>
                  <div class="form-group">
                    <label for="Email1">Email <span style="color: red;">*</span></label>
                    <input type="text" class="form-control" id="Email1" placeholder="Enter Email" name="email" value="{{ old('email',$getRecord->email) }}" required>
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
