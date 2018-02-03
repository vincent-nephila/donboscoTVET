@extends('layouts.app')

@section('header')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
          SECTION {{$section->section}} <small>{{$section->tvetCourse->course}} - Sheet A</small>
      </h1>
                        
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li>Section</li>
        <li>{{$section->tvetCourse->course}}</li>
        <li><a href="{{route('sectionsheeta',['section'=>$section->id])}}">{{$section->section}}</a></li>
        <li class='active'>Sheet A</li>
        
      </ol>
    </section>
@endsection

@section('content')
<style>
    #subject_table tr td {cursor: pointer;}
    .fa-refresh{
        margin:auto
    }
    
.cell-link
{
    display:block;
    text-decoration:none;
    color: black;
}
</style>

<div class="row">
    <div class="col-md-7">
        <div class="box box-success">
            <div class="box-body" id="student-list" style="text-align: center">
                <table class="table table-bordered" style="text-align: left">
                    <tr>
                        <td rowspan="2">Student No.</td>
                        <td rowspan="2">Name</td>
                        <td colspan='2' style='text-align:center'>Attitude</td>
                    </tr>
                    <tr>
                        <td style='text-align:center'>
                            
                            @if(Helper::showSubmitButton($section,"ATTITUDE",1))
                            <form class='pull-right' method='POST' action='{{route("forwardAttitude")}}'>
                                {{csrf_field()}}
                                <input type='hidden' name='section' value="{{$section->id}}">
                                <input type='hidden' name='semester' value="1">
                                <button class='btn btn-danger' submit='submit'>Submit 1nd Sem</button>
                            </form>
                            @else
                            1st Sem
                            @endif
                        </td>
                        <td style='text-align:center'>
                            @if(Helper::showSubmitButton($section,"ATTITUDE",2))
                            <form class='pull-right' method='POST' action='{{route("forwardAttitude")}}'>
                                {{csrf_field()}}
                                <input type='hidden' name='section' value="{{$section->id}}">
                                <input type='hidden' name='semester' value="2">
                                <button class='btn btn-danger' submit='submit'>Submit 2nd Sem</button>
                            </form>
                            @else
                                2nd Sem
                            @endif
                        </td>
                    </tr>
                    @foreach($students as $student)
                    <tr>
                        <td>{{$student->idno}}</td>
                        <td>{{Helper::getnameReverse($student->idno)}}</td>
                        <td style='text-align:center'><a href="{{route('showAttitude',['batch'=>$section->batch,'student'=>$student->idno,'sem'=>1])}}"><i class="fa fa-align-justify" aria-hidden="true"></i></a></td>
                        <td style='text-align:center'><a href="{{route('showAttitude',['batch'=>$section->batch,'student'=>$student->idno,'sem'=>2])}}"><i class="fa fa-align-justify" aria-hidden="true"></i></a></td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="box box-success">
            <div class="box-header">Currently Showing<span class='pull-right'><a class="btn btn-danger" href="{{route('sectionsheetb',['section'=>$section->id])}}">Sheet B</a></span></div>
            <div class="box-body" id="display-info" style="text-align: center">
                <p  style="text-align: center"><big>None</big></p>
            </div>
        </div>

        <div id="subjects">
            <table class="table table-striped" id='subject_table'>
                @foreach($subjects as $sem)
                <tr><th style="text-align:center"><big>Semester {{$sem->pluck('sem')->last()}}</big></th></tr>
                <tr><td data-href><a class="cell-link" href='{{route("showStudentAttendance",["sectionid"=>$section->id,"semester"=>$sem->pluck("sem")->last()])}}'>Attendance</a></td></tr>
                @foreach($sem as $subject)
                <tr class='subjects' data-href='{{$subject->subject_code}}'><td>{{$subject->subject_name}}<span class='pull-right'></span></td></tr>
                @endforeach
                @endforeach
            </table>
        </div>
    </div>
</div>
@stop

@section('java')
<script>
    viewarrays ={};
    $('.subjects').click(function(){
        viewarrays['subject']=$(this).data('href');
        viewarrays['id']={{$section->id}};
        
        showReport();
    });
    
    function showReport(){
        $('#display-info').html('<i class="fa fa-refresh fa-4x fa-spin" aria-hidden="true"></i>');
        $('#student-list').html('<i class="fa fa-refresh fa-4x fa-spin" aria-hidden="true"></i>');
        
        $.ajax({
            type:"GET",
            url :"{{route('section_subject_details')}}",
            data:viewarrays,
            asyc:true,
            success:function(data){
                $('#display-info').html(data);
            },
            error:function(){
                $('#display-info').html("An error occured. Please contact system admin");
            }
        });
        
        $.ajax({
            type:"GET",
            url :"{{route('section_subject_view')}}",
            data:viewarrays,
            success:function(data){
                $('#student-list').html(data);
            },
            error:function(){
                $('#student-list').html("An error occured. Please contact system admin");
            }
        });
    }
    
    function forwardgrade(subject,id){
        arrays ={};
        arrays['subject']=subject;
        arrays['section']={{$section->id}};
        arrays['semester']=0;
        
        $.ajax({
            type:"GET",
            url :"{{route('forwardSectionSubject')}}",
            data:arrays,
            success:function(data){
                showReport(viewarrays);
            }
        });
    }
    
    $('#student-list').on('keyup','table tr td .student',function(){
        if($(this).val() != ""){
            if($(this).val() > 100){
               $(this).val(100);
            }
        }
        
        arrays = {};
        arrays['grade'] = $(this).val();
        arrays['id'] = $(this).attr('id');
        
        $.ajax({
            type:"GET",
            url:"{{route('updategrade')}}",
            data:arrays,
            error:function(){
                $('#error-alert').modal('show');
            }
            
        });
    });

</script>
@stop