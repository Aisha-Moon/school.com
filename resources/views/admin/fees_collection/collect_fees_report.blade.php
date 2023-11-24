
@extends('layout.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1> Collect Fees Report  </h1>
          </div>

        </div>
      </div>
    </section>
    <section class="content">
      <div class="container-fluid">
        <div class="row">


          <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Search Collect Fees Report</h3>
                </div>
                <form method="get" action="">
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-2" >
                                <label for="student_id">Student ID</label>
                                <input type="text" name="student_id" placeholder="Enter Student ID"  value="{{Request::get('student_id') }}"  class="form-control" >
                            </div>
                            <div class="form-group col-md-2" >
                                <label for="student_name">Student Name</label>
                                <input type="text" name="student_name" placeholder="Enter Student's Name" value="{{Request::get('student_name') }}"  class="form-control" >
                            </div>
                            <div class="form-group col-md-2" >
                                <label for="last_name"> Last Name</label>
                                <input type="text" name="student_last_name" placeholder="Student's Last Name" value="{{Request::get('student_last_name') }}"  class="form-control" >
                            </div>

                      <div class="form-group col-md-2">
                        <label for="ss">Class</label>
                        <select name="class_id"  class="form-control" >
                            <option value="">Select Class</option>
                            @foreach ($getClass as $class)
                            <option {{ (Request::get('class_id')==$class->id) ? 'selected' :'' }} required value="{{ $class->id }}">{{ $class->name }}</option>

                            @endforeach
                        </select>
                      </div>
                      <div class="form-group col-md-3" >
                        <label for="attendance_date">Start Created Date</label>
                        <input type="date" name="start_created_date"  value="{{Request::get('start_created_date') }}"  class="form-control" >
                      </div>
                      <div class="form-group col-md-3" >
                        <label for="attendance_date">End Created Date</label>
                        <input type="date" name="end_created_date"  value="{{Request::get('end_created_date') }}"  class="form-control" >
                      </div>
                      <div class="form-group col-md-3" >
                        <label for="attendance_date">Payment Type</label>
                        <select name="payment_type" class="form-control">
                            <option  value="">Select</option>
                            <option {{ (Request::get('payment_type')=='cash') ? 'selected' :'' }} value="Cash">Cash</option>
                            <option {{ (Request::get('payment_type')=='cheque') ? 'selected' :'' }} value="Cheque">Cheque</option>
                            <option {{ (Request::get('payment_type')=='Paypal') ? 'selected' :'' }} value="Paypal">Paypal</option>
                            <option {{ (Request::get('payment_type')=='Stripe') ? 'selected' :'' }} value="Stripe">Stripe</option>
                        </select>
                      </div>
                      <div class="form-group col-md-2" style="margin-top: 10px;min-width:300px;">
                        <button type="submit" class="btn btn-primary" style="margin-top: 22px;">Search</button>
                        <a href="{{ url('admin/fees_collection/collect_fees_report') }}" class="btn btn-danger" style="margin-top: 20px;">Clear</a>
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
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Collect Fees Report</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Student ID</th>
                      <th>Student </th>
                      <th>Class Name</th>
                      <th>Total Amount</th>
                      <th>Paid Amount</th>
                      <th>Remaining Amount</th>
                      <th>Payment Type</th>
                      <th>Remark</th>
                      <th>Created By</th>
                      <th>Created Date</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse ($getRecord as $value)
                    <tr>
                        <td>{{ $value->id }}</td>
                        <td>{{ $value->student_id }}</td>

                        <td>{{ $value->student_first_name }} {{ $value->student_last_name }}</td>
                        <td>{{ $value->class_name }}</td>
                        <td>${{ number_format($value->total_amount, 2) }}</td>
                        <td>${{ number_format($value->paid_amount, 2) }}</td>
                        <td>${{ number_format($value->remaining_amount, 2) }}</td>
                        <td>{{ $value->payment_type }}</td>
                        <td>{{ $value->remark }}</td>
                        <td>{{ $value->created_name }}</td>
                        <td>{{ date('d-m-Y', strtotime($value->created_date)) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="100%" style="text-align: center; color: red;">Record Not Found</td>
                    </tr>
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
    </section>
  </div>

<div class="modal fade" id="AddFeesModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Fees</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>


    </div>
  </div>
</div>
@endsection

@section('script')

@endsection
