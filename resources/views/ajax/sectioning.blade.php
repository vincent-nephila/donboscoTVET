@if($field == 'courseStudents')
<table class='table table-bordered' id='course_students_table' cellpadding="0">
    <thead>
        <tr>
            <th width="20%">Idno</th>
            <th width="50%">Name</th>
            <th width="20%">Section</th>
            <td width="10%"></td>
        </tr>
    </thead>
    <tbody>
        @foreach($students as $student)
        <tr>
            <td>{{$student->idno}}</td>
            <td>{{Helper::getNameReverse($student->idno)}}</td>
            <td>{{$student->section}}</td>
            <td onclick="changeSection('{{$student->idno}}')" style='text-align: center;cursor:pointer'><i class="fa fa-arrow-right" aria-hidden="true"></i></td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif

@if($field == 'courseSections')
<select class='form-control' onchange='setSection(this.value)'>
    <option value='' hidden='hidden'>---Select Section---</option>
    @foreach($sections as $section)
    <option value='{{$section->section}}'>{{$section->section}}</option>
    @endforeach
</select>
@endif

@if($field == 'courseSectionStudents')
<table class='table table-bordered' id='course_students_table'>
    <thead>
        <tr>
            <th>Idno</th>
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
@endif