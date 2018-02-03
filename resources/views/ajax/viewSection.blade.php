<form method="POST" action="{{route('assignsubjectclass')}}">
	{{csrf_field()}}
	<table class="table" id="select_class">
		<thead>
			<tr>
				<th></th>
				<th width="40%">Subject</th>
				<th width="20%">Class</th>
				<th width="40%">Adviser</th>
			</tr>			
		</thead>

		@if(count($classes)>0)
		<tbody>
			@foreach($classes as $class)
			<tr>
				<td><input type="radio" name="get_section" value="{{$class->id}}"></td>
				<td>{{Helper::subjectName($subject)}}</td>
				<td>{{$class->section}}</td>
				<td>
                                    {{Helper::classAdviser($class,'id')}}
                                </td>
			</tr>
			@endforeach
		</tbody>
		@else
		<tfoot>
			<tr>
				<td colspan="4">No Section has been found. <a href="{{route('classlist')}}">Click here</a> to create. </td>
			</tr>
		</tfoot>
		@endif
	</table>
  	<input type="hidden" name="subject" value="{{$subject}}">
  	<input type="hidden" name="section" value="{{$section}}">
  	<button class="btn btn-alert" type="submit" submit="submit">Assign</button>
</form>
