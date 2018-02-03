@extends('layouts.app')
@section('header')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
          {{$section->section}} <small>{{$section->tvetCourse->course}}</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li>Section</li>
        <li>{{$section->tvetCourse->course}}</li>
        <li><a href="{{route('sectionsheeta',['section'=>$section->id])}}">{{$section->section}}</a></li>
        <li class="active"><a href="{{route('showStudentAttendance',['sectionid'=>$section->id,'semester'=>$semester])}}">Attendance</a></li>
      </ol>
    </section>
@endsection

@section('content')
<style>
    .attendance{
        border:0px;
        margin:0px;
        padding:0px;
    }
</style>
<div class='row'>
    <div class='col-md-12'>
        <div class='box'>
            <div class='box-header'>
                <big>Section Attendance</big>
                <form class='pull-right' method='POST' action='{{route("forwardAttendance")}}'>
                    {{csrf_field()}}
                    <input type='hidden' name='section' value="{{$section->id}}">
                    <input type='hidden' name='semester' value="{{$semester}}">
                    <button class='btn btn-danger' submit='submit'>Submit</button>
                </form>
            </div>
            <div class='box-body table-responsive'>
                <table class='table table-bordered'>
                    <thead>
                        <tr>
                            <td rowspan='2' style='vertical-align: middle;text-align: center;'>Name</td>
                            @foreach($schooldays as $schoolday)
                            <td colspan="3" align='center'><big>{{$schoolday->month}}</big></td>
                            <td style='border-left:2px solid;border-right:2px solid;'></td>
                            @endforeach
                        </tr>
                        <tr>
                            
                            @foreach($schooldays as $schoolday)
                            <td>Present</td>
                            <td>Absent</td>
                            <td>Tardy</td>
                            <td style='border-left:2px solid;border-right:2px solid;'></td>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $student)
                        <tr>
                            <td>{{Helper::getNameReverse($student->idno)}}</td>
                            @foreach($schooldays as $schoolday)
                            <td>{!!Helper::editstudentAttendance($section->batch,$student->idno,$semester,'DAYP',$schoolday->month_short)!!}</td>
                            <td>{!!Helper::editstudentAttendance($section->batch,$student->idno,$semester,'DAYA',$schoolday->month_short)!!}</td>
                            <td>{!!Helper::editstudentAttendance($section->batch,$student->idno,$semester,'DAYT',$schoolday->month_short)!!}</td>
                            <td style='border-left:2px solid;border-right:2px solid;'></td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop

@section('java')
<script>
    $('.attendance').keyup(function(){
        arrays = {}
        arrays['batch'] = {{$section->batch}};
        arrays['student'] = $(this).attr('data-student');
        arrays['semester'] = {{$semester}};
        arrays['type'] = $(this).attr('data-type');
        arrays['month'] = $(this).attr('data-month');
        arrays['grade'] = $(this).val();
        
        $.ajax({
            type:"GET",
            url:"/updateAttendance",
            data:arrays,
            error:function(){
                alert('Something went wrong while updating the record. Please refresh the page. If the errro persist please call the system administrator.');
            }
        })
    });
</script>
@stop