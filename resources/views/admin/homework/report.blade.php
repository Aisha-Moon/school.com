
@extends('layout.app')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1> HomeWork Report</h1>
          </div>


        </div>
      </div><!-- /.container-fluid -->
    </section>
    <section class="content">
      <div class="container-fluid">

          <div class="row">

          <!-- /.col -->
          <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Search Homework Report </h3>
                </div>
                <form method="get" action="">

                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="text">Student First Name</label>
                                <input type="text" class="form-control" id="text" placeholder="Enter First Name"  name="first_name" value="{{ Request::get('first_name') }}"">
                              </div>
                              <div class="form-group col-md-3">
                                <label for="texta">Student Last Name</label>
                                <input type="text" class="form-control" id="texta" placeholder="Enter Last Name"  name="last_name" value="{{ Request::get('last_name') }}"">
                              </div>
                              <div class="form-group col-md-3">
                                <label for=""> Class</label>

                                <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Subject" name="class_name"  value="{{ Request::get('class_name') }}">

                              </div>
                      <div class="form-group col-md-3">
                        <label for="exampleInputEmail1">Subject</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Subject" name="subject_name"  value="{{ Request::get('subject_name') }}">

                      </div>

                      <div class="form-group col-md-3">
                        <label for="date">Homework Date From</label>
                        <input type="date" class="form-control" id="date"  name="homework_date" value="{{ Request::get('homework_date') }}"">
                      </div>
                      <div class="form-group col-md-3">
                        <label for="date">Homework Date To</label>
                        <input type="date" class="form-control" id="date"  name="homework_date_to" value="{{ Request::get('homework_date_to') }}"">
                      </div>
                      <div class="form-group col-md-3">
                        <label for="date">Submission Date From</label>
                        <input type="date" class="form-control" id="date"  name="submission_date" value="{{ Request::get('submission_date') }}"">
                      </div>
                      <div class="form-group col-md-3">
                        <label for="date">Submission Date To</label>
                        <input type="date" class="form-control" id="date"  name="submission_date_to" value="{{ Request::get('submission_date_to') }}"">
                      </div>

                      <div class="form-group col-md-3">
                        <label for="date">Submitted Created Date From</label>
                        <input type="date" class="form-control" id="date"  name="created_date" value="{{ Request::get('created_date') }}"">
                      </div>
                      <div class="form-group col-md-3">
                        <label for="date">Submitted Created Date To</label>
                        <input type="date" class="form-control" id="date"  name="created_date_to" value="{{ Request::get('created_date_to') }}"">
                      </div>

                      <div class="form-group col-md-3" style="margin-top: 10px;">
                        <button type="submit" class="btn btn-primary" style="margin-top: 22px;">Search</button>
                        <a href="{{ url('admin/homework/homework_report') }}" class="btn btn-danger" style="margin-top: 20px;">Reset</a>
                      </div>

                    </div>
                    </div>
                    <!-- /.card-body -->


                  </form>
            </div>
            </div>
           <div class="col-md-12">
        <div class="row">
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
            <div class="card">
              <div class="card-header">
                <h3 class="card-title"> Homework Report List </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Student Name</th>
                      <th>Class</th>
                      <th>Subject</th>
                      <th>Homework Date</th>
                      <th>Submission Date</th>
                      <th>Description</th>
                      <th>Document</th>
                      <th>Created Date</th>
                      <th>Submitted Docs</th>
                      <th>Submitted Description</th>
                      <th>Submitted created date</th>
                    </tr>
                  </thead>
                   <tbody>
                    @forelse ($getRecord as $value)
                    <tr>
                     <td>{{ $value->id }}</td>
                     <td>{{ $value->first_name }} {{ $value->last_name }}</td>
                     <td>{{ $value->class_name }}</td>
                     <td>{{ $value->subject_name }}</td>
                     <td>{{ date('d-m-Y',strtotime($value->getHomework->homework_date)) }}</td>
                     <td>{{ date('d-m-Y',strtotime($value->getHomework->submission_date)) }}</td>
                     <td>{!! $value->getHomework->description !!}</td>
                     <td>
                         @if (!empty($value->getHomework->getDocument()))

                         <a href="{{$value->getHomework->getDocument()  }}" class="btn btn-primary"
                         download="">Download</a>
                         @endif
                     </td>
                     <td>{{ date('d-m-Y',strtotime($value->created_at)) }}</td>
                     <td>
                         @if (!empty($value->getDocument()))

                         <a href="{{ $value->getDocument()  }}" class="btn btn-primary"
                         download="">Download</a>
                         @endif
                     </td>
                     <td>{!! $value->description !!}</td>

                     <td>{{ date('d-m-Y',strtotime($value->created_at)) }}</td>

                    </tr>
                     @empty
                     <td colspan="100%" style="text-align: center;color:red;">Record Not Found</td>

                     @endforelse
                   </tbody>
                </table>
                <div style="padding:10px;float:right;">
                    {!! $getRecord->appends(Illuminate\Support\Facades\Request::except('page'))->links() !!}

                </div>
              </div>
            </div>
        </div>
           </div>
          </div>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
@endsection
