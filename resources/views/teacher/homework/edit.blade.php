
@extends('layout.app')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit Homework</h1>
          </div>
        </div>
      </div>
    </section>
    <section class="content">
      <div class="container-fluid">
        <div class="row">

            <div class="card card-primary">
              <form method="post" action="" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="card-body">
                  <div class="form-group">
                    <label>Class <span style="color:red;">*</span></label>
                    <select class="form-control" id="getClass" name="class_id"  >
                        <option value="">Select Class</option>
                        @foreach ($getClass as $class)

                        <option {{ ($getRecord->class_id==$class->class_id) ? 'selected' : '' }} value="{{ $class->class_id }}">{{ $class->class_name }}</option>
                        @endforeach

                    </select>
                  </div>
                  <div class="form-group">
                    <label>Subject <span style="color:red;">*</span></label>
                    <select class="form-control" name="subject_id" id="getSubject"  >
                        <option value="">Select Subject</option>
                        @foreach ($getSubject as $subject)

                        <option {{ ($getRecord->subject_id==$subject->subject_id) ? 'selected' : '' }} value="{{ $subject->subject_id }}">{{ $subject->subject_name }}</option>
                        @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Homework Date <span style="color:red;">*</span></label>
                    <input type="date" value="{{ $getRecord->homework_date }}" name="homework_date" class="form-control"  >
                  </div>
                  <div class="form-group">
                    <label>Submission Date <span style="color:red;">*</span></label>
                    <input type="date" value="{{ $getRecord->submission_date }}" name="submission_date" class="form-control"  >
                  </div>
                  <div class="form-group">
                    <label>Document</label>
                    <input type="file" name="document" class="form-control">
                    @if (!empty($getRecord->getDocument()))

                    <a href="{{ $getRecord->getDocument()  }}" class="btn btn-primary"
                    download="">Download</a>
                    @endif
                  </div>
                  <div class="form-group">
                    <label>Description <span style="color:red;">*</span></label>
                    <textarea id="compose-textarea" name="description" class="form-control" style="height:300px;">
                        {{ $getRecord->description }}
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


        $('#compose-textarea').summernote()
        height:200
        });
        $('#getClass').change (function(){
            var class_id=$(this).val();
            $.ajax({

                    type: "POST",
                    url:"{{ url('teacher/ajax_get_subject') }}",
                    data:{
                            "_token":"{{ csrf_token() }}",
                class_id:class_id,

                    },
                    dataType: "JSON",
                    success: function (data){
                        $('#getSubject').html(data.success);
                    }
                    });
                });

  </script>
@endsection
