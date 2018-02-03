@extends('layouts.app')
@section('content')
<style>
#select_class tr td {cursor: pointer;}
.selected {
    background-color: brown;
    color: #FFF;
}
</style>
<div class="row">
	<div class="col-md-6">
		<!--Section Information-->
		<div class="box">
			<div class="box-header">Section Info</div>
			<div class="box-body">
				<table class="table">
					<tr>
						<td>Batch:</td>
						<td><b>Batch {{$section->batch}}</b></td>
					</tr>
					<tr>
						<td>Course:</td>
						<td><b>{{$section->tvetCourse->course}}</b></td>
					</tr>
					<tr>
						<td>Section:</td>
						<td><b>{{$section->section}}</b></td>
					</tr>
					<tr>
						<td>Adviser:</td>
						<td>
                                                    <b>{{Helper::getName($section->adviser_id)}}</b>
                                                    <button type="button" class="btn btn-success pull-right"  data-toggle="modal" data-target="#get_advisers" id="adviser_id">
                                                        Assign
                                                    </button>
                                                </td>
					</tr>
				</table>
			</div>
		</div>
		<!--Section Information-->

		<!--Attached Classes-->
		<div class="box">
			<div class="box-header">Attached Classes</div>
			<div class="box-body">
				<table class="table table-striped">
					<tbody>
						@foreach($subjects as $semester)
						<tr><th style="text-align: center" colspan="4">
						Semester {{$semester->pluck('sem')->last()}}</th></tr>
						<tr>
							<th width="50%">Subject</th>
							<th style="text-align: center" width="20%">Class</th>
							<th style="text-align: center" width="30%">Adviser</th>
							<th></th>
						</tr>
							@foreach($semester as $key=>$subject)
							<?php $class = App\TvetSectionClasses::where('section_id',$section->id)->where('subject_code',$subject->subject_code)->first();?>
							<tr>
								<td>{{$subject->subject_name}}</td>
								<td>{{Helper::className($class,'class_id')}}</td>
								<td>
									<a href="{{route('personnelview',array(Helper::classAdviserId($class,'class_id')))}}">{{Helper::classAdviser($class,'class_id')}}
									</a>
								</td>
								<td>
									@if(Helper::className($class,'class_id') == "")
									<button type="button" class="btn btn-success add-class"  data-toggle="modal" id="{{$subject->subject_code}}" data-target="#get_section">
										<i class="fa fa-link" aria-hidden="true"></i>
									</button>
									@else
									<a href="{{route('unassignsubjectclass',array($class->id))}}" class="btn btn-danger">
										<i class="fa fa-chain-broken" aria-hidden="true"></i>
									</a>
									@endif
								</td>
								
							</tr>
							@endforeach
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
		<!--Attached Classes-->
	</div>
	<div class="col-md-6">
		<div class="box">
			<div class="box-header">Students Enrolled</div>
			<div class="box-body">
				<table class="table table-striped" id="students">
					<thead>
						<tr>
							<th>Student No.</th>
							<th>Name</th>
						</tr>
					</thead>
					<tbody>
						@foreach($students as $student)
						<tr>
							<td>{{$student->idno}}</td>
							<td>{{Helper::getNameReverse($student->idno)}}</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>

    <div class="modal fade" id="get_section">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Select Section</h4>
          </div>
          <div class="modal-body" id="get_section_body">
          </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
</div>
    
<div class="modal fade" id="get_advisers">
    <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Select Adviser  </h4>
          </div>
          <div class="modal-body" id="get_body">
              <form method="POST" action="{{route('assignsectionteacher')}}" id="saveTeacher"></form>
          </div>
        <!-- /.modal-content -->
        </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
</div>
@stop

@section('java')
<script>
  $(function () {
    $('#students').DataTable({
      "aaSortingFixed"	: [[1,'asc']],
      'paging'      : false,
      'lengthChange': false,
      'info'		: false,
      'searching'	: false,
      'ordering'	: true
    })
   })
  $('.add-class').click(function(){
  	arrays = {}
  	arrays['subject'] = $(this).attr('id');
  	arrays['batch'] = {{$section->batch}};
  	arrays['section'] = {{$section->id}};

  	$.ajax({
  		type:"GET",
  		url:"{{url('getAvailableClass')}}",
  		data:arrays,
  		success:function(data){
  			$('#get_section_body').html(data);
  		},
  		error:function(){
  			$('#get_section_body').html("An error occured");
  		}
  	})
  })

  $('#get_section_body').on('click','form table tbody tr',function(){
  	$(this).addClass('selected').siblings().removeClass('selected');
  	$(this).parent().find('input').removeAttr('checked');
  	$(this).find('input').attr('checked', true);

  });
  
  $('#adviser_id').click(function(){

  	$.ajax({
  		type:"GET",
  		url:"{{url('getAdviser')}}/"+{{$section->id}},
  		success:function(data){
  			$('#saveTeacher').html(data);
  		},
  		error:function(){
  			$('#saveTeacher').html("An error occured");
  		}
  	})
  })
  
  $('#saveTeacher').on('click','table tbody tr',function(){
  	$(this).addClass('selected').siblings().removeClass('selected');
  	$(this).parent().find('input').removeAttr('checked');
  	$(this).find('input').attr('checked', true);

  });
</script>
@stop

