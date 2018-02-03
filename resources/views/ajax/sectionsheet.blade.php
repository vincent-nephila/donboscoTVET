@php
use App\Http\Controllers\Reports\Helper as Fetcher;
use App\Http\Controllers\Reports\SheetAController as SheetA;
@endphp

@if($field == 'student_list')
<table class="table table-bordered">
    <tr><td>Student No.</td><td>Name</td><td>Average</td></tr>
    @foreach($students as $student)
    <tr>
        <td>{{$student->idno}}</td>
        <td align="left">{{Helper::getnameReverse($student->idno)}}</td>
        <td>{{Fetcher::getGrade($student->idno,$subject,$section)}}</td>
    </tr>
    @endforeach
</table>
@endif

@if($field == 'list_info')
<table class='table table-bordered'>
    <tr><td>Subject</td><td>{{\Helper::subjectName($subject)}}</td></tr>
    <tr><td>Batch</td><td>Batch {{$section->batch}}</td></tr>
    <tr><td>Class</td><td>{{$classes->implode('section',';')}}</td></tr>
</table>
<h4>
    @if(Fetcher::subject_submitToButton($subject,$section,$classes)->status)
    <button onclick ="forwardgrade('{{$subject}}','{{$section->id}}')" target="framename" class="btn btn-success pull-right">Forward to {{Fetcher::subject_submitToButton($subject,$section,$classes)->passto}}</button>
    @endif
</h4>
@endif

@if($field == "section_changeGrade")
<table class="table table-bordered">
    <tr><td>Student No.</td><td>Name</td><td>Average</td></tr>
    @foreach($students as $student)
    <tr>
        <td>{{$student->idno}}</td>
        <td align="left">{{Helper::getnameReverse($student->idno)}}</td>
        <td>{!!SheetA::inputGrade($subject,$section->batch,$student->idno)!!}</td>
    </tr>
    @endforeach
</table>
@endif