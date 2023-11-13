
@extends('layout.app')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>My Class Timetable </h1>
          </div>


        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="col-md-12">

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

          @foreach ($getRecord as $value)


           <div class="card">
            <div class="card-header" style="text-align: center;">
              <h2 class="card-title" ><b>{{ $value['name'] }}</b> </h2>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
              <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Week</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Room Number</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($value['week'] as $valueW)
                    <tr>
                        <td>{{ $valueW['week_name'] }}</td>
                        <td>{{ !empty($valueW['start_time']) ? date('h:i A',strtotime($valueW['start_time'])) : '' }}</td>
                        <td>{{ !empty($valueW['end_time']) ? date('h:i A',strtotime($valueW['end_time'])) : '' }}</td>
                        <td>{{ $valueW['room_number'] }}</td>
                    </tr>
                    @endforeach

                </tbody>

              </table>


            </div>
            <!-- /.card-body -->
          </div>
          @endforeach

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

@section('script')
<script type="text/javascript">
  $('.getClass').change(function() {
    var class_id = $(this).val();
    $.ajax({
                    url: "{{ url('admin/class_timetable/get_subject') }}", // URL to request data from
                    type: "POST", // HTTP method
                    data:{
                        "_token":"{{ csrf_token() }}",
                        class_id:class_id,
                    },
                    dataType: "json", // Type of data expected in the response

                    success: function (response) {
                        $('.getSubject').html(response.html);
                    },


                });

  });

</script>
@endsection
