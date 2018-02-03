@extends('layouts.app')
@section('content')
<div class='row'>
    <div class='col-md-5'>
        <div class='form-group'>
            <label class='label-control col-md-4' for='course'>Course</label>
            <div class='col-md-8'>
                <select class='form-control' id='course' onchange='getData(this.value)'>
                    <option value='' hidden='hidden'>---Select Course---</option>
                    @foreach($courses as $course)
                    <option value='{{$course->course_id}}'>{{$course->course}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>
<div class='row'>
    <div class='col-md-7'>
        <div class='box'>
            <div class='box-header'>Student List</div>
            <div class='box-body' id='student_list_container'>
            </div>
        </div>
    </div>
    <div class='col-md-5'>
        <div class='box'>
            <div class='box-header'>
                Section List
                <div class='pull-right' id='course_section'></div>
            </div>
            <div class='box-body' id='section_list_container'>
            </div>
        </div>
    </div>
</div>
@stop

@section('java')
<script>
    var getcourse = "";
    var getsection = "";
    function getData(course){
        getcourse = course;
        getsection = "";
        $("#section_list_container").html("");
        getCourseStudentList();
        getCourseSections();
    }

    function getCourseStudentList(){
        arrays = {}
        arrays['batch'] = {{$batch}};
        arrays['course'] = getcourse;
        $.ajax({
            type:"GET",
            url:"{{route('coursestudentlist')}}",
            data:arrays,
            success:function(data){
                $("#student_list_container").html(data);
                $('#course_students_table').DataTable({
                  'paging'      : true,
                  'displayLength': 25,
                  'lengthChange': false,
                  'info'	: false,
                  'searching'	: true,
                  'ordering'	: true
                })
            }

        });
    }
    
    function getCourseSections(){
        arrays = {}
        arrays['batch'] = {{$batch}};
        arrays['course'] = getcourse;
        $.ajax({
            type:"GET",
            url:"{{route('get_coursesections')}}",
            data:arrays,
            success:function(data){
                $("#course_section").html(data);
            }

        });
    }
    
    function setSection(section){
        getsection = section;
        getSectionsStudents()
    }
    
    function getSectionsStudents(){
        arrays = {}
        arrays['batch'] = {{$batch}};
        arrays['course'] = getcourse;
        arrays['section'] = getsection;
        $.ajax({
            type:"GET",
            url:"{{route('get_sectionStudents')}}",
            data:arrays,
            success:function(data){
                $("#section_list_container").html(data);
            }

        });
    }
    
    function changeSection(idno){
        if(getsection != ""){
            arrays = {}
            arrays['batch'] = {{$batch}};
            arrays['course'] = getcourse;
            arrays['section'] = getsection;
            arrays['student'] = idno;
            $.ajax({
                type:"GET",
                url:"{{route('update_studentSection')}}",
                data:arrays,
                success:function(data){
                    getCourseStudentList();
                    getSectionsStudents();
                }
            });   
        }else{
            alert('First select a section');
        }
    }
</script>
@stop   