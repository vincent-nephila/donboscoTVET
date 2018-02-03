@if($field == "adviser_list")

	{{csrf_field()}}
	<table class="table" id="select_class">
		<thead>
			<tr>
				<th></th>
				<th>Name</th>
			</tr>			
		</thead>

		<tbody>
			@foreach($advisers as $adviser)
			<tr>
				<td><input type="radio" name="adviser" value="{{$adviser->idno}}"></td>
				<td>{{Helper::getName($adviser->idno)}}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
  	<input type="hidden" name="class" value="{{$classid}}">
  	<button class="btn btn-alert" type="submit" submit="submit">Assign</button>
@endif