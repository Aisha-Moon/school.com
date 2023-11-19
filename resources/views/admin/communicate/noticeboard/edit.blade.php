
@extends('layout.app')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit Notice Board</h1>
          </div>
        </div>
      </div>
    </section>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card card-primary">
              <form method="post" action="">
                {{ csrf_field() }}
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Title</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" value={{ $getRecord->title }}  name="title">

                  </div>
                  <div class="form-group">
                    <label for="notice">Notice Date</label>
                    <input type="date" class="form-control" id="notice" value={{ $getRecord->notice_date}}  name="notice_date" >

                  </div>
                  <div class="form-group">
                    <label for="publish">Publish Date</label>
                    <input type="date" class="form-control" id="publish" value={{ $getRecord->publish_date}}  name="publish_date" >

                  </div>
                  @php
                      $message_to_student=$getRecord->getMessageToSingle($getRecord->id,3);
                      $message_to_parent=$getRecord->getMessageToSingle($getRecord->id,4);
                      $message_to_teacher=$getRecord->getMessageToSingle($getRecord->id,2);
                  @endphp
                  <div class="form-group">
                    <label for="publis" style="display: block;">Message To</label>
                    <label style="margin-right: 40px;"><input {{ !empty($message_to_student) ? 'checked' : ''  }} style="margin-right: 10px;" type="checkbox" value="3"  name="message_to[]">Student</label>
                    <label style="margin-right: 40px;"><input {{ !empty($message_to_parent) ? 'checked' : ''  }} style="margin-right: 10px;" type="checkbox" value="4"  name="message_to[]">Parent</label>
                    <label style="margin-right: 40px;"><input {{ !empty($message_to_teacher) ? 'checked' : ''  }} style="margin-right: 10px;" type="checkbox" value="2"  name="message_to[]">Teacher</label>

                  </div>

                  <div class="form-group">
                    <label for="msg">Messages</label>
                    <textarea id="compose-textarea" name="message" class="form-control" style="height: 300px">

                        {{ $getRecord->message }}

                    </textarea>
                  </div>

                </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Update</button>
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
      //Add text editor
      $('#compose-textarea').summernote()
    })
  </script>
@endsection
