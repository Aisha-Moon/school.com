
@extends('layout.app')
@section('content')
@section('style')
<link rel="stylesheet" href="{{ asset('admin/') }}/plugins/select2/css/select2.min.css">
<style type="text/css">
    .select2-container .select2-selection--single{
        height:40px;
    }
</style>

@endsection
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Send Email</h1>
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
              <form method="post" action="">
                {{ csrf_field() }}
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Subject</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Subject" name="subject" required>

                  </div>

                  <div class="form-group">
                    <label for="publis" style="display: block;">Message To</label>
                    <label style="margin-right: 40px;"><input style="margin-right: 10px;" type="checkbox" value="3"  name="message_to[]">Student</label>
                    <label style="margin-right: 40px;"><input style="margin-right: 10px;" type="checkbox" value="4"  name="message_to[]">Parent</label>
                    <label style="margin-right: 40px;"><input style="margin-right: 10px;" type="checkbox" value="2"  name="message_to[]">Teacher</label>

                  </div>
                  <div class="form-group">
                    <label>User(Student / Parent / Teacher)</label>
                    <select name="user_id" class="form-control select2" style="width: 100%;">
                      <option value="">Select</option>

                    </select>
                  </div>

                  <div class="form-group">
                    <label for="msg">Messages</label>
                    <textarea id="compose-textarea" name="message" class="form-control" style="height: 300px">


                    </textarea>
                  </div>

                </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Send Email</button>
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
<script src="{{ asset('admin/') }}/plugins/select2/js/select2.full.min.js"></script>


<script type="text/javascript">

    $(function () {
        $('.select2').select2({
            ajax:{
                url: '{{ url('admin/communicate/search_user') }}',
               dataType: 'json',
               delay:250,
               data:function (data){
                return {
                    search:data.term,
                };
               },
               processResults:function (response){
                return {
                    results:response
                };
               },
            }
        });

        $('#compose-textarea').summernote()
        height:200
        });
  </script>
@endsection
