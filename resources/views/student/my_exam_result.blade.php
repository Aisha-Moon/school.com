
@extends('layout.app')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>My Exam Result </h1>
          </div>

        </div>
      </div><!-- /.container-fluid -->
    </section>
    <section class="content">
      <div class="container-fluid">
        <div class="col-md-12">
        </div>
         @foreach ($getRecord as $value)
         <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title"><b>Exam : </b>{{ $value['exam_name'] }} </h3>
              </div>
              <div class="card-body p-0">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>Subjects</th>
                      <th>Class Work</th>
                      <th>Home Work</th>
                      <th>Test Work</th>
                      <th>Exam</th>
                      <th>Total Marks</th>
                      <th>Passing Marks</th>
                      <th>Full Marks</th>
                      <th>Result</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php
                        $total_marks=0;
                        $full_marks=0;
                        $result_valid=0;
                    @endphp
                    @foreach ($value['subject'] as $exam)
                    @php
                        $total_marks=$total_marks+$exam['total_marks'];
                        $full_marks=$full_marks+$exam['full_marks'];
                    @endphp
                    <tr>
                        <td style="width:250px;">{{ $exam['subject_name'] }}</td>
                        <td>{{ $exam['class_work'] }}</td>
                        <td>{{ $exam['home_work'] }}</td>
                        <td>{{ $exam['test_work'] }}</td>
                        <td>{{ $exam['exam'] }}</td>
                        <td>{{ $exam['total_marks'] }}</td>
                        <td>{{ $exam['pass_marks'] }}</td>
                        <td>{{ $exam['full_marks'] }}</td>
                        <td>
                            @if ( $exam['total_marks'] >= $exam['pass_marks'])
                            <span style="color:green;font-weight:bold;">Passed</span>
                            @else
                            @php
                                $result_valid=1;
                            @endphp
                            <span style="color:red;font-weight:bold;">Failed</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    <td colspan="2">
                        <b>Grand Total : {{ $total_marks }}/{{ $full_marks }}</b>
                    </td>
                    <td colspan="2">
                        <b>Percentage : {{ round(($total_marks *100)/ $full_marks,2) }}%</b>
                    </td>
                    <td colspan="5">
                        <b>Result : @if ($result_valid==0)
                            <span style="color:green;">Passed</span>
                        @else
                        <span style="color:red;">Failed</span>
                        @endif</b>
                    </td>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
         @endforeach
        </div>        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
@endsection
