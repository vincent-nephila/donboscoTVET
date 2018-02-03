<?php 
use App\Http\Controllers\Reports\Helper as Fetcher;
use App\Http\Controllers\GradeAccessControll as GradeAccess;
?>
@extends('layouts.app')
@section('header')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
          SECTION {{$section->section}} <small>{{$section->tvetCourse->course}} - Sheet B</small>
      </h1>
                        
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li>Section</li>
        <li>{{$section->tvetCourse->course}}</li>
        <li><a href="{{route('sectionsheeta',['section'=>$section->id])}}">{{$section->section}}</a></li>
        <li class='active'>Sheet B</li>
        
      </ol>
    </section>
@endsection

@section('content')
@foreach($subjects as $sem)
<div class='row'>
    <div class="col-md-12">
        <a class="btn btn-danger" href="{{route('sectionsheeta',['section'=>$section->id])}}">Sheet A</a>
    </div>
    
</div>
<div class="row">
    
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <b>Semester {{$sem->pluck('sem')->last()}}</b>
            </div>
            <div class="box-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            @foreach($sem as $subject)
                            <th style="text-align: center"><span data-toggle="tooltip" title="{{$subject->subject_name}}">{{$subject->subject_code}}</span></th>
                            @endforeach
                            <th>Average</th>
                            <th>Present</th>
                            <th>Absent</th>
                            <th>Tardy</th>
                        </tr>
                        @foreach($students as $student)
                        <tr>
                            <td>{{Helper::getNameReverse($student->idno)}}</td>
                            @foreach($sem as $subject)
                            <td style="text-align: center">{{Fetcher::getGrade($student->idno,$subject->subject_code,$section)}}</td>
                            @endforeach
                            <td style="text-align: center" >{!!Fetcher::computeSemFinal($student->idno,$sem->pluck('sem')->last(),$section->batch)!!}</td>
                            
                            @if(GradeAccess::section_gradeAvailable($section, "ATTENDANCE", $sem->pluck('sem')->last()))
                            <td style="text-align: center" >{{Fetcher::studentTotalAttendace($student->idno,$sem->pluck('sem')->last(),"DAYP",$section->batch)}}</td>
                            <td style="text-align: center" >{{Fetcher::studentTotalAttendace($student->idno,$sem->pluck('sem')->last(),"DAYA",$section->batch)}}</td>
                            <td style="text-align: center" >{{Fetcher::studentTotalAttendace($student->idno,$sem->pluck('sem')->last(),"DAYT",$section->batch)}}</td>
                            @else
                            <td style="text-align: center"></td>
                            <td style="text-align: center"></td>
                            <td style="text-align: center"></td>
                            @endif                            
                        </tr>
                        @endforeach
                    </thead>
                </table>
                <div class="col-md-12">
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach

@stop

@section('java')
<script>
    $(document).ready(function(){
        $('[data-toggle=*]').tooltip();   
    });
</script>
@stop