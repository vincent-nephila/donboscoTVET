
@extends('layouts.app')
@section('content')
<!--Row 1-->
<div class="row">
	<div class="col-md-4">
		<!--Create a new Section-->
		<div class="box box-success">
			<div class="box-header"><big><b>Create Section</b></big></div>
			<div class="box-body">
				<form class="form-horizontal" action="{{route('createsection')}}" method=
				"POST">
					{{csrf_field()}}
					<div class="form-group">
						<label class="label-control col-md-3">Batch</label>
						<div class="col-md-9">
							<select type="text" class="form-control" id="batch" name="batch">
								<option value="" hidden="hidden">---Select Batch---</option>
								@foreach($batches as $batch)
								<option value="{{$batch->period}}">Batch {{$batch->period}}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="label-control col-md-3">Course</label>
						<div class="col-md-9">
							<select type="text" class="form-control" id="course" name="course">
								<option value="" hidden="hidden">---Select Course---</option>
								@foreach($courses as $course)
								<option value="{{$course->course_id}}">{{$course->course}}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="label-control col-md-3">Section</label>
						<div class="col-md-9">
							<input type="text" class="form-control" id="section" name="section">
						</div>
					</div>

					<div class="form-group">
						<label class="label-control col-md-3">Adviser<br><small>(opitonal)</small></label>
						<div class="col-md-9">
							<select class="form-control" id="adviser" name="adviser">
							<option value="" hidden="hidden">---Select Adviser---</option>
							<option value="">None</option>
							@foreach($advisers as $adviser)
							<option value="{{$adviser->idno}}">{{Helper::getName($adviser->idno)}}</option>
							@endforeach
							</select>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-12">
							<button class="btn btn-success form-control">Create Section</button>
						</div>
					</div>
				</form>
			</div>
		</div>
		<!--/Create a new Section-->

	</div>
	<div class="col-md-8">
		<!--Display all Section-->
		<div class="box box-success">
			<div class="box-header"><big>Section List</big></div>
			<div class="box-body table-responsive" id="sectionscontainer">
				<table class="table table-striped" id="sections">
					<thead>
						<tr>
							<th width='16%'>Batch</th>
							<th width='16%'>Course</th>
							<th width='16%'>Section</th>
							<th width='35%'>Adviser</th>
							<th width='17%'>Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach($sections as $section)
						<tr>
							<td>{{$section->batch}}</td>
							<td>{{$section->course_id}}</td>
							<td>{{$section->section}}</td>
							<td>{{Helper::getName($section->adviser_id)}}</td>
							<td><a href="{{route('deletesection',array($section->id))}}">delete</a> / <a href="{{route('viewsection',array($section->id))}}">view</a></td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
		<!--/Display all Section-->
	</div>
</div>
<!--/Row 1-->

<!--Row 2-->
<div class="row">
	<div class="col-md-4">
		<!--Create a new Class-->
		<div class="box box-danger">
			<div class="box-header"><big><b>Create Class</b></big></div>
			<div class="box-body">
				<form class="form-horizontal" action="{{route('createclass')}}" method=
				"POST">
					{{csrf_field()}}
					<div class="form-group">
						<label class="label-control col-md-3">Batch</label>
						<div class="col-md-9">
							<select type="text" class="form-control" id="classbatch" name="classbatch" onchange="batch_subjects(this.value)">
								<option value="" hidden="hidden">---Select Batch---</option>
								@foreach($batches as $batch)
								<option value="{{$batch->period}}">Batch {{$batch->period}}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div id="class_subject"></div>

					<div class="form-group">
						<label class="label-control col-md-3">Adviser</label>
						<div class="col-md-9">
							<select class="form-control" id="classadviser" name="classadviser">
							<option value="" hidden="hidden">---Select Adviser---</option>
							@foreach($advisers as $adviser)
							<option value="{{$adviser->idno}}">{{Helper::getName($adviser->idno)}}</option>
							@endforeach
							</select>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-12">
							<button class="btn btn-danger form-control">Create Class</button>
						</div>
					</div>
				</form>
				
			</div>
			<div class="box-footer">
		      @if (count($errors) > 0)
		         <div class = "alert alert-danger">
		            <ul>
		               @foreach ($errors->all() as $error)
		                  <li>{{ $error }}</li>
		               @endforeach
		            </ul>
		         </div>
		      @endif
			</div>
		</div>
		<!--/Create a new Class-->
	</div>
	<div class="col-md-8">
		<!--Display all Class-->
		<div class="box box-danger">
			<div class="box-header">Class List</div>
			<div class="box-body">
				<table class="table table-striped" id="classes">
					<thead>
						<tr>
							<th width='16%'>Batch</th>
							<th width='21%'>Subject</th>
							<th width='16%'>Class</th>
							<th width='30%'>Adviser</th>
							<th width='17%'>Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach($classes as $class)
						<tr>
							<td>{{$class->batch}}</td>
							<td>{{Helper::subjectName($class->subject)}}</td>
							<td>{{$class->section}}</td>
							<td>{{Helper::getName($class->adviser)}}</td>
							<td><a href="{{route('deleteclass',array($class->id))}}">delete</a> / <a href="{{route('viewclass',array($class->id))}}">view</a>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
		<!--Display all Class-->
	</div>
</div>
<!--/Row 2-->

<div class="modal modal-danger fade" id="modal-info">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Danger Modal</h4>
      </div>
      <div class="modal-body" id="message">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-outline">Save changes</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
@stop


@section('java')
<script>

	function batch_subjects(batch){
		$.ajax({
			type:"GET",
			url:"/getbatchsubjects/"+batch,
			success:function(data){
				$('#class_subject').html(data);
			},
			error:function(){

			}
		})
	}

  $(function () {
	$('.select2').select2();

    $('#sections').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false,
      'displayLength': 5,
    })
    $('#classes').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false,
      'displayLength': 5,
    })
  })
</script>
@stop