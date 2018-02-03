@if($field == "batch_subjects")

	<div class="form-group">
	  <label class="control-label col-md-3">Subjects</label>
	  <div class="col-md-9">
	  	<select class="form-control" id="classsubject" name="classsubject" onchange="getteachers()">
	  		<option hidden="hidden">---Select Subject---</option>
	  		@foreach($subjects as $semester)
                        <optgroup label="Semester {{$semester->pluck('sem')->last()}}">
                            @foreach($semester as $subject)
                            <option value="{{$subject->subject_code}}">{{$subject->subject_name}}</option>
                            @endforeach
                        </optgroup>
	  		@endforeach
	  	</select>
	  </div>
	</div>
	<!--div class="form-group">
	  <label class="control-label col-md-3">No. of Classes</label>
	  <div class="col-md-9">
              <input  class="form-control"  type="number" name="noofclass">
	  </div>
	</div-->
@endif