
@extends('layout.app')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit Single Assign Subject</h1>
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
              <form method="post" action="">
                {{ csrf_field() }}
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Class Name</label>
                    <select name="class_id" class="form-control">
                        <option >Select Class</option>
                        @foreach ($getClass as $class)
                        <option {{ ($getRecord->class_id==$class->id) ? 'selected' : '' }} value="{{ $class->id }}">{{ $class->name }}</option>
                        @endforeach

                    </select>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Subject Name</label>
                    <select name="subject_id" class="form-control">
                        <option >Select Subject</option>
                        @foreach ($getSubject as $subject)
                        <option {{ ($getRecord->subject_id==$subject->id) ? 'selected' : '' }} value="{{ $subject->id }}">{{ $subject->name }}</option>
                        @endforeach

                    </select>
                  </div>


                  <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" class="form-control">
                        <option value="0" {{ ($getRecord->status=0)?'selected' : '' }}>Active</option>
                        <option value="1" {{ ($getRecord->status=1)?'selected' : '' }}>Inactive</option>
                    </select>

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
