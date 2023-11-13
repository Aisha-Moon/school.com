
@extends('layout.app')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Add Class Timetable </h1>
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
              <h3 class="card-title">Search Class Timetable</h3>
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



                  <div class="form-group col-md-3" style="margin-top: 10px;">
                    <button type="submit" class="btn btn-primary" style="margin-top: 22px;">Search</button>
                    <a href="{{ url('admin/class_timetable/list') }}" class="btn btn-danger" style="margin-top: 20px;">Reset</a>
                  </div>

                </div>
                </div>
                <!-- /.card-body -->


              </form>
        </div>
        </div>
          <!-- /.col -->
          <div class="col-md-12">


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
