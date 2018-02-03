@if($field == "section_course")

	<div class="form-group">
	  <label class="control-label col-md-3">Course</label>
	  <div class="col-md-9">
	  	<select class="form-control" id="course" name="course" onchange="getsection(this.value)">
	  		<option hidden="hidden">---Select course---</option>
	  		@foreach($courses as $course)
	  		<?php $courseinfo = App\TvetCourse::where('course_id',$course->course_id)->first();?>

	  		<option value="{{$course->course_id}}">{{$courseinfo->course}}</option>
	  		@endforeach
	  	</select>
	  </div>
	</div>
@endif

@if($field == "section_section")
	<div class="form-group">
	  <label class="control-label col-md-3">Section</label>
	  <div class="col-md-9">
	  	<select class="form-control" name="section"  onchange="submitSection()">
	  		<option hidden="hidden">---Select section---</option>
	  		@foreach($sections as $section)
	  		<option value="{{$section->id}}">{{$section->section}}</option>
	  		@endforeach
	  	</select>
	  </div>
	</div>
@endif

@if($field == "class_subject")
	<div class="form-group">
	  <label class="control-label col-md-3">Subjects</label>
	  <div class="col-md-9">
	  	<select class="form-control" id="classsubject" name="classsubject" onchange="getclasses(this.value)">
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
@endif

@if($field == "class_class")
	<div class="form-group">
	  <label class="control-label col-md-3">Class</label>
	  <div class="col-md-9">
	  	<select class="form-control" id="classsubject" name="class" onchange='submitClass()'>
	  		<option hidden="hidden">---Select Class---</option>
	  		@foreach($classes as $class)
                            <option value="{{$class->id}}">{{$class->section}}</option>
	  		@endforeach
	  	</select>
	  </div>
	</div>
@endif