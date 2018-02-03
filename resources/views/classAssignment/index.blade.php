@extends('layouts.app')
@section('content')
<div class='row'>
    <div class='col-md-6'>
        <label class='label-control col-md-4'>Subject</label>
        <div class='col-md-8'>
            <select id='subjects' class='form-control' onchange='getData(this.value)'>
                <option value="">---Select Subject---</option>
                @foreach($subjects as $subject)
                <option value="{{$subject->subject_code}}">{{$subject->subject_name}}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
<div class='row'>
    <div class='col-md-7'>
        <div class='box'>
            <div class='box-header'><big>Students List</big></div>
            <div class='box-body' id='subject_students_container'></div>
        </div>
    </div>
    <div class='col-md-5'>
        <div class='box'>
            <div class='box-header'><big>Class Information</big><span class='pull-right' id='classChoice'></span></div>
            <div class='box-body' id='class_information_container'></div>
        </div>
        <div class='box'>
            <div class='box-header'><big>Class List</big></div>
            <div class='box-body' id='class_students_list'></div>
        </div>
    </div>
</div>
@stop

@section('java')
<script>
    var getsubject = "";
    var setclass = "";
    
    function getData(subject){
        getsubject = subject;
        setclass = "";
        $("#section_list_container").html("");
        getSubjectStudentList();
        getSubjectClasses();
        $("#class_students_list").html("");
    }
    
    function getSubjectStudentList(){
        arrays = {}
        arrays['batch'] = {{$batch}};
        arrays['subject'] = getsubject;
        
        $.ajax({
            type:"GET",
            url:"{{route('subjectstudentlist')}}",
            data:arrays,
            success:function(data){
                $("#subject_students_container").html(data);
                $('#subject_students_table').DataTable({
                    'paging'      : true,
                    'displayLength': 25,
                    'lengthChange': false,
                    'searching'   : true,
                    'ordering'    : true,
                    'info'        : true,
                    'autoWidth'   : false
                })
            }
        });
    }
    
    function getSubjectClasses(){
        arrays = {}
        arrays['batch'] = {{$batch}};
        arrays['subject'] = getsubject;
        
        $.ajax({
            type:"GET",
            url:"{{route('get_subjectclasses')}}",
            data:arrays,
            success:function(data){
                $("#classChoice").html(data);
            }
        });
    }
    
    

    function setupClass(selectclass){
        setclass = selectclass;
        getClassInfo();
        getClassStudents();
    }
    
    function getClassInfo(){
        arrays = {}
        arrays['batch'] = {{$batch}};
        arrays['subject'] = getsubject;
        arrays['class'] = setclass;
        
        $.ajax({
            type:"GET",
            url:"{{route('get_classInfo')}}",
            data:arrays,
            success:function(data){
                $("#class_information_container").html(data);
            }
        });
    }
    
    function getClassStudents(){
        arrays = {}
        arrays['batch'] = {{$batch}};
        arrays['subject'] = getsubject;
        arrays['class'] = setclass;
        
        $.ajax({
            type:"GET",
            url:"{{route('get_classStudents')}}",
            data:arrays,
            success:function(data){
                $("#class_students_list").html(data);
            }
        });
    }
    
    function changeClass(idno){
        if(setclass != ""){
            arrays = {}
            arrays['class'] = setclass;
            arrays['student'] = idno;
            $.ajax({
                type:"GET",
                url:"{{route('update_studentClass')}}",
                data:arrays,
                success:function(data){
                    getSubjectStudentList();
                    getClassStudents();
                }
            });   
        }else{
            alert('First select a section');
        }
    }
</script>
@stop