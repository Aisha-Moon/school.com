
@extends('layout.app')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Notice Board</h1>
          </div>
          <div class="col-sm-6" style="text-align: right;">
           <a href="{{ url('admin/communicate/notice_board/add') }}" class="btn btn-primary">Add new Notice Board</a>
          </div>

        </div>
      </div><!-- /.container-fluid -->
    </section>
    <section class="content">
      <div class="container-fluid">

          <div class="row">
            <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Search Notice</h3>
                </div>
                <form method="get" action="">

                    <div class="card-body">
                        <div class="row">
                      <div class="form-group col-md-3">
                        <label for="exampleInputEmail1">Title</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Title" name="title" value="{{ Request::get('title') }}">

                      </div>
                      <div class="form-group col-md-3">
                        <label for="Email1">Notice Date From</label>
                        <input type="date" class="form-control" id="Email1"  name="notice_date_from" value="{{ Request::get('notice_date_from') }}"">
                      </div>
                      <div class="form-group col-md-3">
                        <label for="date">Notice Date To</label>
                        <input type="date" class="form-control" id="date"  name="notice_date_to" value="{{ Request::get('notice_date_to') }}"">
                      </div>
                      <div class="form-group col-md-3">
                        <label for="Email">Publish Date From</label>
                        <input type="date" class="form-control" id="Email"  name="publish_date_from" value="{{ Request::get('publish_date_from') }}"">
                      </div>
                      <div class="form-group col-md-3">
                        <label for="date">Publish Date To</label>
                        <input type="date" class="form-control" id="date"  name="publish_date_to" value="{{ Request::get('publish_date_to') }}"">
                      </div>
                      <div class="form-group col-md-3">
                        <label for="tet">Message To</label>
                        <select name="message_to" class="form-control" id="tet">
                            <option value="">Select</option>
                            <option {{ Request::get('message_to') == 3 ? 'selected' : '' }} value="3">Student</option>
                            <option {{ Request::get('message_to') == 4 ? 'selected' : '' }} value="4">Parent</option>
                            <option {{ Request::get('message_to') == 2 ? 'selected' : '' }} value="2">Teacher</option>
                        </select>
                      </div>

                      <div class="form-group col-md-3" style="margin-top: 10px;">
                        <button type="submit" class="btn btn-primary" style="margin-top: 22px;">Search</button>
                        <a href="{{ url('admin/communicate/notice_board') }}" class="btn btn-danger" style="margin-top: 20px;">Clear</a>
                      </div>
                    </div>
                    </div>
                  </form>
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
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Notice Board List </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Title</th>
                      <th>Notice Date</th>
                      <th>Publish Date</th>
                      <th>Message To</th>
                      <th>Created By</th>
                      <th>Created Date</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                     @forelse ($getRecord as $value)
                    <tr>
                        <td>{{ $value->id }}</td>
                        <td>{{ $value->title }}</td>
                        <td>{{  date('d-m-y',strtotime($value->notice_date)) }}</td>
                        <td>{{  date('d-m-y',strtotime($value->publish_date)) }}</td>
                        <td>
                            @foreach ($value->getMessage as $message)
                             @if ($message->message_to == 2)
                            Teacher
                             @elseif ($message->message_to == 3)
                             Student
                             @elseif ($message->message_to == 4)
                            Parent
                             @endif
                            @endforeach
                        </td>
                        <td>{{ $value->created_by_name}}</td>
                        <td>{{ date('d-m-y',strtotime($value->created_at)) }}</td>
                        <td style="min-width: 200px">
                            <a href="{{ url('admin/communicate/notice_board/edit/'.$value->id) }}" class="btn btn-sm btn-primary">Edit</a>
                            <a href="{{ url('admin/communicate/notice_board/delete/'.$value->id) }}" class="btn btn-sm btn-danger">Delete</a>
                        </td>
                    </tr>
                     @empty
                     <tr>
                        <td colspan="100%" style="text-align: center;color:red;
                       ">Record Not Found</td>
                     </tr>

                     @endforelse
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
