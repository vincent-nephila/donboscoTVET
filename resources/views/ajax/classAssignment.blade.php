@if($field == 'classStudents')
<table class='table table-bordered' id='subject_students_table'>
    <thead>
        <tr>
            <th width="20%">Idno</th>
            <th width="40%">Name</th>
            <th width="10%">Course</th>
            <th width="10%">Section</th>
            <th width="10%">Class</th>
            <th width="10%"></th>
        </tr>
    </thead>
    <tbody>
        @foreach($students as $student)
        <tr>
            <td>{{$student->idno}}</td>
            <td>{{Helper::getNameReverse($student->idno)}}</td>
            <td>{{$student->course_id}}</td>
            <td>{{Helper::getSection($student->idno,$batch)}}</td>
            <td>{{$student->section}}</td>
            <td onclick="changeClass('{{$student->id}}')" style='text-align: center;cursor:pointer'><i class="fa fa-arrow-right" aria-hidden="true"></i></td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif

@if($field == 'subjectClasses')
<select class='form-control' onchange='setupClass(this.value)'>
    <option value='' hidden='hidden'>---Select Section---</option>
    @foreach($classes as $class)
    <option value='{{$class->section}}'>{{$class->section}}</option>
    @endforeach
</select>
@endif


@if($field == 'classInfo')
<table class='table table-bordered'>
    <tr>
        <td>Adviser</td><td>{{Helper::getName($classInfo->adviser)}}</td>
    </tr>
    <tr>
        <td>Attached Section</td><td>{{$attachedSection->pluck('tvetSection')->implode('section',' ; ')}}</td>
    </tr>
</table>
@endif

@if($field == 'sectionStudents')
<table class='table table-bordered' id='subject_students_table'>
    <thead>
        <tr>
            <th width="20%">Idno</th>
            <th width="40%">Name</th>
            <th width="10%">Course</th>
        </tr>
    </thead>
    <tbody>
        @foreach($students as $student)
        <tr>
            <td>{{$student->idno}}</td>
            <td>{{Helper::getNameReverse($student->idno)}}</td>
            <td>{{$student->course_id}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif