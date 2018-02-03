@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-sm-5 col-sm-push-7">
        <div class="box box-warning">
            <div class="box-body">
                <dl class="dl-horizontal">
                    <dt>Batch / Section:</dt>
                    <dd>Batch {{$class->batch}} / {{$class->section}}</dd>
                    <dt>Subject</dt>
                    <dd>{{Helper::subjectName($class->subject)}}</dd>
                </dl>
            </div>
        </div>
    </div>
    
    <div class="col-sm-7 col-sm-pull-5">
            @php
                session()->put('class', $class->id);
            @endphp
            <div class="box box-warning">
                <div class="box-body table-responsive">
                    <table class="table table-bordered" id="students">
                        <thead>
                            <tr>
                                <td>Student No.</td>
                                <td>Name</td>
                                <td>Grade</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($students as $student)
                            <tr>
                                <td>{{$student->idno}}</td>
                                <td>{{Helper::getNameReverse($student->idno)}}</td>
                                <td style='text-align: right'>{{$student->grade}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
    </div>
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
</script>
@stop