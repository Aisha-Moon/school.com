
@extends('layout.app')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Submitted HomeWork</h1>
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
                  <h3 class="card-title">Search Submitted Homework </h3>
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
                        <label for="date">Created Date From</label>
                        <input type="date" class="form-control" id="date"  name="created_date" value="{{ Request::get('created_date') }}"">
                      </div>
                      <div class="form-group col-md-3">
                        <label for="date">Created Date To</label>
                        <input type="date" class="form-control" id="date"  name="created_date_to" value="{{ Request::get('created_date_to') }}"">
                      </div>

                      <div class="form-group col-md-3" style="margin-top: 10px;">
                        <button type="submit" class="btn btn-primary" style="margin-top: 22px;">Search</button>
                        <a href="{{ url('teacher/homework/homework/submitted/'.$homework_id) }}" class="btn btn-danger" style="margin-top: 20px;">Reset</a>
                      </div>

                    </div>
                    </div>
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
                <h3 class="card-title">Submitted Homework List </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Student Name</th>
                      <th>Document</th>
                      <th>Description</th>
                      <th>Created Date</th>
                    </tr>
                  </thead>
                   <tbody>
                    @forelse ($getRecord as $value)
                   <tr>
                    <td>{{ $value->id }}</td>
                    <td>{{ $value->first_name }}{{ $value->last_name }}</td>
                    <td>
                        @if (!empty($value->getDocument()))

                        <a href="{{ $value->getDocument() }}" class="btn btn-primary"
                        download="">Download</a>
                        @endif
                    </td>
                    <td>{!! $value->description !!}</td>

                    <td>{{ date('d-m-Y',strtotime($value->created_at)) }}</td>


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
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
@endsection
