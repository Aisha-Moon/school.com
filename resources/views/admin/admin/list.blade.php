
@extends('layout.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Admin List (Total : {{ $getRecord->total() }})</h1>
          </div>
          <div class="col-sm-6" style="text-align: right;">
           <a href="{{ url('admin/admin/add') }}" class="btn btn-primary">Add new Admin</a>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <section class="content">
      <div class="container-fluid">
        <div class="col-md-12">
        <div class="card">
            <div class="card-header">
              <h3 class="card-title">Search Admin  </h3>
            </div>
            <form method="get" action="">

                <div class="card-body">
                    <div class="row">
                  <div class="form-group col-md-3">
                    <label for="exampleInputEmail1">Name</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Name" name="name" value="{{ Request::get('name') }}">

                  </div>
                  <div class="form-group col-md-3">
                    <label for="Email1">Email</label>
                    <input type="text" class="form-control" id="Email1" placeholder="Enter Email" name="email" value="{{ Request::get('email') }}"">
                    <div style="color:red;">{{ $errors->first('email') }}</div>
                  </div>
                  <div class="form-group col-md-3">
                    <label for="date">Date</label>
                    <input type="date" class="form-control" id="date"  name="date" value="{{ Request::get('date') }}"">
                  </div>

                  <div class="form-group col-md-3" style="margin-top: 10px;">
                    <button type="submit" class="btn btn-primary" style="margin-top: 22px;">Search</button>
                    <a href="{{ url('admin/admin/list') }}" class="btn btn-danger" style="margin-top: 20px;">Clear</a>
                  </div>
                </div>
                </div>
              </form>
        </div>
        </div>
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
                <h3 class="card-title">Admin List </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>Id</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Profile Pic</th>

                      <th>Created Date</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach ($getRecord as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if(!empty($user->getProfileDirect()))
                            <img src="{{ $user->getProfileDirect() }}" alt="" style="height:50px; width:50px;border-radius:50%;">
                            @endif
                        </td>

                        <td>{{ date('d-m-y ,H:i A',strtotime($user->created_at)) }}</td>
                        <td>
                            <a href="{{ url('admin/admin/edit/'.$user->id) }}" class="btn btn-primary">Edit</a>
                            <a href="{{ url('admin/admin/delete/'.$user->id) }}" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                  @endforeach
                  </tbody>
                </table>
                <div style="padding:10px;float:right;">
                    {!! $getRecord->appends(Illuminate\Support\Facades\Request::except('page'))->links() !!}

                </div>
              </div>
              <!-- /.card-body -->
            </div>
          </div>
          <!-- /.col -->
        </div>

      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
@endsection
