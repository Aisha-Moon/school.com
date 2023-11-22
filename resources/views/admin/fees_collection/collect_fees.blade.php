
@extends('layout.app')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1>Collect Fees </h1>
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
              <h3 class="card-title">Search Collect Fees Student</h3>
            </div>
            <form method="get" action="">

                <div class="card-body">
                    <div class="row">
                  <div class="form-group col-md-2">
                    <label for="">Class</label>
                    <select name="class_id"  class="form-control">
                        <option value="">Select Class</option>
                        @foreach ($getClass as $class)
                        <option {{ Request::get('class_id')== $class->id ?'selected' : '' }} value="{{ $class->id }}">{{ $class->name }}</option>
                        @endforeach
                    </select>
                  </div>
                  <div class="form-group col-md-2">
                    <label for="exampleInputEmail1">Student ID</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter ID" name="student_id" value="{{ Request::get('student_id') }}">

                  </div>
                  <div class="form-group col-md-3">
                    <label for="exampleInputEmail1">Student First Name</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter First Name" name="first_name" value="{{ Request::get('first_name') }}">

                  </div>
                  <div class="form-group col-md-3">
                    <label for="exampleInputEmail1">Student Last Name</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Last Name" name="last_name" value="{{ Request::get('last_name') }}">

                  </div>



                  <div class="form-group col-md-3" style="margin-top: 10px;">
                    <button type="submit" class="btn btn-primary" style="margin-top: 22px;">Search</button>
                    <a href="{{ url('admin/fees_collection/collect_fees') }}" class="btn btn-danger" style="margin-top: 20px;">Reset</a>
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
                <h3 class="card-title">Collect Fees </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>Student Id</th>
                      <th>Student Name</th>
                      <th>Class Name</th>
                      <th>Total Amount</th>
                      <th>Paid Amount</th>
                      <th>Remaining Amount</th>
                      <th>Created Date</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if (!empty($getRecord))
                    @forelse ($getRecord as $value)
                    @php
                        $paid_amount=$value->getPaidAmount($value->id,$value->class_id);
                        $RemainingAmount=$value->amount-$paid_amount;
                    @endphp
                    <tr>
                        <td>{{ $value->id }}</td>
                        <td>{{ $value->name }} {{ $value->last_name }}</td>
                        <td>{{ $value->class_name }}</td>
                        <td>{{ number_format($value->amount,2) }}</td>
                        <td>${{ number_format($paid_amount,2) }}</td>
                        <td>${{ number_format($RemainingAmount,2) }}</td>

                        <td>{{ date('d-m-y',strtotime($value->created_at)) }}</td>
                        <td>
                            <a href="{{ url('admin/fees_collection/collect_fees/add_fees/'.$value->id) }}" class="btn btn-success">Collect Fees</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td style="colspan:100%;text-align:center;color:red;">Record Not Found</td>
                    </tr>

                    @endforelse
                    @else
                    <tr>
                        <td style="colspan:100%;text-align:center;color:red;">Record Not Found</td>
                    </tr>
                    @endif
                  </tbody>
                </table>
                <div style="padding:10px;float:right;">
                    @if(!empty($getRecord))
                    {!! $getRecord->appends(Illuminate\Support\Facades\Request::except('page'))->links() !!}

                    @endif
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
