@extends('layout.app')
@section('content')
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
            <div class="col-sm-6">
               <h1>Student Subject <span style="color:blue;">({{ $getUser->name }} {{ $getUser->last_name }})</span></h1>
            </div>
         </div>
      </div>
      <!-- /.container-fluid -->
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
            <!-- /.card -->
            <div class="card">
               <div class="card-header">
                  <h3 class="card-title">my Subject </h3>
               </div>
               <!-- /.card-header -->
               <div class="card-body p-0">
                  <table class="table table-striped">
                     <thead>
                        <tr>
                           <th>Subject Name</th>
                           <th>Subject Type</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($getRecord as $user)
                        <tr>
                           <td>{{ $user->subject_name }}</td>
                           <td>{{ $user->subject_type }}</td>
                           <td>
                            <a href="{{ url('parent/my_student/subject/class_timetable/'.$user->class_id.'/'.$user->subject_id.'/'.$getUser->id) }}" class="btn btn-primary">My Class Timetable</a>
                           </td>
                        </tr>
                        @endforeach
                     </tbody>
                  </table>
               </div>
               <!-- /.card-body -->
            </div>
            <!-- /.card -->
         </div>
         <!-- /.col -->
      </div>
      <!-- /.row -->
      <!-- /.row -->
</div>
<!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>
@endsection
