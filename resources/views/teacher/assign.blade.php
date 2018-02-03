@extends('layouts.app')
@section('header')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        {{$personnel->firstname}} {{$personnel->lastname}}
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li>Administration</li>
        <li class="active">Personnel</li>
      </ol>
    </section>
@endsection

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="box">
            <div class="box-header"><medium><b>Assigned Roles</b></medium></div>
            <div class="box-body">
                <table class="table table-striped">
                    @foreach($positions as $position)
                    <tr>
                        <td>{{$position->position}}</td>
                        <td style="text-align: right;"><a href="{{route('unassignpersonnel',['id'=>$position->user_pos])}}">Remove</a></td>
                    </tr>
                    @endforeach
                    @if(count($positions) == 0)
                    <tr>
                        <td>No data record</td>
                    </tr>
                    @endif
                </table>
            </div>
            <div class="box-footer">
                <form method="POST" action="{{route('assignpersonnel')}}">
                    {{csrf_field()}}
                    <div class="col-md-8">
                        <select class="form-control" name="position" required="required">
                            <option hidden="hidden">--Assign new role--</option>
                            @foreach($roles as $role)
                            <option value="{{$role->id}}">{{$role->position}}</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="personnel" value="{{$personnel->idno}}">
                    </div>
                    <button class="btn btn-success col-md-4" id="assignrole">Assign</button>
                </form>
            </div>
        </div>
    </div>

	<!--Shop Head Assign-->
	@if(in_array(5,$currentroles))
	<div class="col-md-8" id="shopboxlead">
		<div class="box" id="shopbox">
			<div class="box-header"><big><b>Shop Head</b></big></div>
			<div class="box-body">
				<table class="table table-striped">
					@foreach($shops as $shop)
					<?php $head = App\User::where('idno',$shop->course_head)->first();?>
					<tr>
						<td>
              				<input id="head_{{$shop->course_id}}" class="assignHead" type="checkbox" onchange="assignRole('head_{{$shop->course_id}}','5','{{$shop->id}}')"

              				@if($head && $personnel->idno == $head->idno)
              				checked="checked"
              				@endif

              				@if($head && $personnel->idno != $head->idno)
              				disabled="disabled"
              				@endif>
						</td>
						<td>{{$shop->course}}</td>
						<td>
						@if($head)
							<a href="{{route('personnelview',['idno'=>$head->idno])}}">
								{{$head->title}} {{$head->firstname}} {{$head->lastname}}
							</a>
						@endif
						</td>
					</tr>
					@endforeach
				</table>
			</div>
		</div>
	</div>
	@endif
	<!--/Shop Head Assign-->
</div>

@if(in_array(4,$currentroles))
<div class="row">
	<!--Section Adviser Assign-->
	<div class="col-md-4">
            <div class="box box-danger">
                <div class="box-header"><medium><b>Assign Section</b></medium></div>
                <div class="box-body">
                    <form class="form-horizontal" method="POST" action="{{route('assignsectionteacher')}}">
                        {{csrf_field()}}
                        <input type='hidden' name='adviser' value='{{$personnel->idno}}'>
                        <div class="form-group">
                          <label class="control-label col-md-3">Batch</label>
                          <div class="col-md-9">
                                <select class="form-control" id="batch" onchange="getcourse(this.value)">
                                        <option hidden="hidden">---Select batch---</option>
                                        @foreach($batches as $batch)
                                        <option value="{{$batch->period}}">Batch {{$batch->period}}</option>
                                        @endforeach
                                </select>
                          </div>
                        </div>
                        <div id="course_cont"></div>
                        <div id="section_cont"></div>
                        <button id="submit-advisory" style="display: none" class="col-md-12 btn btn-success" type="submit">Assign</button>
                    </form>
                </div>
            </div>
	</div>
	<!--Section Adviser Assign-->
	<div class="col-md-8">  
		<div class="box box-danger">
                    <div class="box-header"><medium><b>Advisory</b></medium></div>
			<div class="box-body table-responsive">
				<table class="table table-striped">
					<thead>
						<tr>
							<td width="15%">Batch</td>
							<td width="50%">Section</td>
							<td width="15%">Course</td>
                                                        <td width="20%">Action</td>
						</tr>
					</thead>
					<tbody>
                                            @foreach($sections as $section)
                                            <tr>
                                                <td>{{$section->batch}}</td>
                                                <td>{{$section->section}}</td>
                                                <td>{{$section->course_id}}</td>
                                                <td align='right'><a style='cursor: pointer' onclick='assignRole({{$section->id}},4,{{$section->id}})'>Unassign</a> / <a href="{{route('viewsection',['id'=>$section->id])}}">View</td>
                                            </tr>
                                            @endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endif

@if(in_array(3,$currentroles))
<div class="row">
    <div class="col-md-4">
        <div class="box box-success">
            <div class="box-header"><medium><b>Assign Subject Class</b></medium></div>
            <div class="box-body">
                    <form class="form-horizontal" method="POST" action="{{route('assignclassteacher')}}">
                        {{csrf_field()}}
                        <input type='hidden' name='adviser' value='{{$personnel->idno}}'>
                        <div class="form-group">
                          <label class="control-label col-md-3">Batch</label>
                          <div class="col-md-9">
                                <select class="form-control" id="batch" onchange="getsubjects(this.value)">
                                        <option hidden="hidden">---Select batch---</option>
                                        @foreach($batches as $batch)
                                        <option value="{{$batch->period}}">Batch {{$batch->period}}</option>
                                        @endforeach
                                </select>
                          </div>
                        </div>
                        <div id="subject_cont"></div>
                        <div id="class_cont"></div>
                        <button id="submit-class" style='display:none' class="col-md-12 btn btn-success" type="submit">Assign</button>
                    </form>
            </div>
        </div>
    </div>
    
    <!--Assigned class list-->
    <div class="col-md-8">
        <div class="box box-success">
            <div class="box-header"><medium><b>Subject Classes</b></medium></div>
            <div class="box-body table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th width='5%'>Batch</th>
                            <th width='10%'>Class</th>
                            <th width='65%'>Subject</th>
                            <th width='20%'>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($classes as $class)
                        <tr>
                            <td>{{$class->batch}}</td>
                            <td>{{$class->section}}</td>
                            <td>{{ Helper::subjectName($class->subject)}}</td>
                            <td align='right'><a style='cursor: pointer' onclick='assignRole({{$class->id}},3,{{$class->id}})'>Unassign</a> / <a href="{{route('viewclass',['id'=>$class->id])}}">View</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!--/Assigned class list-->
</div>
@endif
@stop







@section('java')
<script>
var batches = "";
var class_batches = "";
	function assignRole(elem,crate,id){
	
		arrays = {};

		if($('#'+elem).is(':checked')){
			arrays['id'] = id;
			arrays['crate'] = crate;
			arrays['person'] = "{{$personnel->idno}}";
		}else{
			arrays['id'] = id;
			arrays['crate'] = crate;
			arrays['person'] = "";
		}

        $.ajax({
               type: "GET", 
               url: "{{route('assignRole')}}",
               data : arrays,
               success:function(data){
               		location.reload(true);
                   },
                   error:function(){
                   }
               });
	}

	function getcourse(batch){
		batches = batch;
        $.ajax({
               type: "GET", 
               url: "/getassigncourse/"+batch,
               success:function(data){
               		$('#course_cont').html(data);
                        $('#section _cont').html("");
                        $('#submit-advisory').css({"display":"none"});
                   },
                   error:function(){
                   }
               });
	}

	function getsection(course){
        $.ajax({
               type: "GET", 
               url: "/getassignsection/"+batches+"/"+course,
               success:function(data){
               		$('#section_cont').html(data);
                   },
                   error:function(){
                   }
               });
	}
        
        function submitSection(){
            $('#submit-advisory').removeAttr("style");
        }
        
        function getsubjects(batch){
            class_batches = batch;
            
            $.ajax({
                type:"GET",
                url:"/getassignsubject/"+batch,
                success:function(data){
                    $('#subject_cont').html(data);
                        $('#class_cont').html("");
                        $('#submit-class').css({"display":"none"});
                }
            });
        }
        
        function getclasses(subject){
            $.ajax({
                type:"GET",
                url:"/getassignclass/"+class_batches+"/"+subject,
                success:function(data){
                    $('#class_cont').html(data);
                }
            })
        }

        function submitClass(){
            $('#submit-class').removeAttr("style");
        }

</script>
@stop
