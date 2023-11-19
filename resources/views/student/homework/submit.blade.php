
@extends('layout.app')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Submit My Homework</h1>
          </div>
        </div>
      </div>
    </section>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
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
            <div class="card card-primary">
              <form method="post" action="" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="card-body">

                  <div class="form-group">
                    <label>Document</label>
                    <input type="file" name="document_file" class="form-control">
                  </div>
                  <div class="form-group">
                    <label>Description <span style="color:red;">*</span></label>
                    <textarea id="compose-textarea" name="description" class="form-control" style="height:300px;">

                    </textarea>
                  </div>


                </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
@endsection
@section('script')
<script src="{{ asset('admin/') }}/dist/js/pages/dashboard.js"></script>
<script src="{{ asset('admin/') }}/plugins/summernote/summernote-bs4.min.js"></script>


<script type="text/javascript">

    $(function () {


        $('#compose-textarea').summernote()
        height:200
        });


  </script>
@endsection
