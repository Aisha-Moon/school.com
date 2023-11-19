
@extends('layout.app')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>My Notice Board</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Compose</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
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



                          <div class="form-group col-md-3" style="margin-top: 10px;">
                            <button type="submit" class="btn btn-primary" style="margin-top: 22px;">Search</button>
                            <a href="{{ url('parent/my_notice_board') }}" class="btn btn-danger" style="margin-top: 20px;">Clear</a>
                          </div>
                        </div>
                        </div>
                      </form>
                </div>
            </div>

       @foreach ($getRecord as $value)
       <div class="col-md-12">
        <div class="card card-primary card-outline">

          <div class="card-body p-0">
            <div class="mailbox-read-info">
              <h5>{{ $value->title }}</h5>
                <h6 style="font-weight: bold;color:black;font-size:16px;margin-top:10px;">{{ date('d-m-y',strtotime($value->notice_date)) }}
                </h6>
            </div>
            <div class="mailbox-read-message">
                {!! $value->message !!}
            </div>
          </div>
        </div>
      </div>
       @endforeach
       <div style="padding:10px;float:right;">
        {!! $getRecord->appends(Illuminate\Support\Facades\Request::except('page'))->links() !!}

    </div>
      </div>
      </div>
    </section>
  </div>
@endsection
