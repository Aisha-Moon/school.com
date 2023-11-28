<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print Exam Result</title>
    <style type="text/css">
    @page{
        size:8.3in 11.7in;
    }
    @page{
        size:A4;
    }
    .margin-bottom{
        margin-bottom: 3px;
    }
    @media print{
        @page{
            margin: 0px;
            margin-left: 20px;
            margin-right: 20px;
        }
    }
    .table-bg{
        border-collapse: collapse;
        width:100%;
        font-size:15px;
        text-align: center;
    }
    .th{
        border:1px solid #000;
        padding: 10px;
    }
    .td{
        border:1px solid #000;
        padding: 4px;
    }
    .text-container{
        text-align: left;
        padding-left: 5px;
    }
    </style>
</head>
<body>
    <div id="page">
        <table style="width:100%;text-align:center;">
            <tr>
                <td width="5%"></td>
                <td width="15%">
                    <img src="{{ $getSetting->getLogo() }}" alt="AdminLTE Logo" style="width:auto;height:50px;border_radius:10px;">
                </td>
                <td align="left">
                    <h1>{{ $getSetting->school_name }}</h1>
                </td>
                <td></td>
            </tr>

        </table>
        <table style="width: 100%;">
            <tr>
                <td width="5%"></td>
                <td width="70%">
                    <table class="margin-bottom" style="width: 100%;">
                       <tbody>
                        <tr>
                            <td width="27%">Name Of Student :</td>
                            <td style="border-bottom:1px solid; width:100%;">{{ $getStudent->name }} {{ $getStudent->last_name }}</td>
                        </tr>
                       </tbody>
                    </table>
                    <table class="margin-bottom" style="width: 100%;">
                       <tbody>
                        <tr>
                            <td width="23%"> Admission Number :</td>
                            <td style="border-bottom:1px solid; width:100%;">{{ $getStudent->admission_number }}</td>
                        </tr>
                       </tbody>
                    </table>
                    <table class="margin-bottom" style="width: 100%;">
                       <tbody>
                        <tr>
                            <td width="23%">Class :</td>
                            <td style="border-bottom:1px solid; width:100%;">{{ $getClass->class_name }}</td>
                        </tr>
                       </tbody>
                    </table>
                    <table class="margin-bottom" style="width: 100%;">
                       <tbody>
                        <tr>
                            <td width="11%">Term : </td>
                            <td style="border-bottom:1px solid; width:80%;">{{ $getExam->name }}</td>
                        </tr>
                       </tbody>
                    </table>

                </td>
                <td width="5%"></td>
                <td width="20%" valign="top">
                    <img src="{{ $getStudent->getProfileDirect()  }}" alt="" style="height:100px;width:100px;border-radius:7px;">
                    <br>
                    Gender :{{ $getStudent->gender }}
                </td>
            </tr>
        </table>
        <div class="res-tab">
            <table class="table table-bg">
                <thead>
                  <tr>
                    <th class="th" style="text-align: left">Subjects</th>
                    <th class="th">Class Work</th>
                    <th class="th">Home Work</th>
                    <th class="th">Test Work</th>
                    <th class="th">Exam</th>
                    <th class="th">Total Marks</th>
                    <th class="th">Passing Marks</th>
                    <th class="th">Full Marks</th>
                    <th class="th">Result</th>
                  </tr>
                </thead>
                <tbody>
                    @php
                        $total_marks=0;
                        $full_marks=0;
                        $result_valid=0;
                    @endphp
                    @foreach ($getExamMark as $exam)
                    @php
                        $total_marks=$total_marks+$exam['total_marks'];
                        $full_marks=$full_marks+$exam['full_marks'];
                    @endphp
                    <tr>
                        <td class="td" style="width:250px; text-align:left;">{{ $exam['subject_name'] }}</td>
                        <td class="td">{{ $exam['class_work'] }}</td>
                        <td class="td">{{ $exam['home_work'] }}</td>
                        <td class="td">{{ $exam['test_work'] }}</td>
                        <td>{{ $exam['exam'] }}</td>
                        <td class="td">{{ $exam['total_marks'] }}</td>
                        <td class="td">{{ $exam['pass_marks'] }}</td>
                        <td class="td">{{ $exam['full_marks'] }}</td>
                        <td class="td">
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
                    <td class="td" colspan="2">
                        <b>Grand Total : {{ $total_marks }}/{{ $full_marks }}</b>
                    </td>
                    <td class="td" colspan="2">
                        @php
                            $percentage=($total_marks * 100)/ $full_marks;
                            $getGrade=App\Models\MarksGrade::getGrade($percentage);
                        @endphp
                        <b>Percentage : {{ round($percentage) }}%</b>
                    </td>
                    <td class="td" colspan="2">

                        @if(!empty($getGrade))
                            <b>Grade :</b> {{ $getGrade }}<br>
                        @endif
                    </td>
                    <td class="td" colspan="5">
                        <b>Result : @if ($result_valid==0)
                            <span style="color:green;">Passed</span>
                        @else
                        <span style="color:red;">Failed</span>
                        @endif</b>
                    </td>
                  </tbody>
              </table>

        </div>
        <br>
        <div>
            {{ $getSetting->exam_description }}
          </div>
          <br>
          <table class="margin-bottom" style="width: 100%;">
            <tbody>
             <tr>
                 <td width="17%">Signature :</td>
                 <td style="border-bottom:1px solid; width:100%;"></td>
             </tr>
            </tbody>
         </table>

    </div>
    <script type="text/javascript">
        window.print();
    </script>

</body>
</html>
