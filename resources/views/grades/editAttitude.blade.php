@extends('layouts.app')
@section('header')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
          {{Helper::getName($idno)}} <small>{{$section->tvetCourse->course}}</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li>Section</li>
        <li>{{$section->tvetCourse->course}}</li>
        <li><a href="{{route('sectionsheeta',['section'=>$section->id])}}">{{$section->section}}</a></li>
        <li>Attitude</li>
        <li class="active">{{$idno}}</li>
      </ol>
    </section>
@endsection

@section('content')
    <style>
select {
-webkit-appearance: none;
-moz-appearance: none;
appearance: none;
}
    </style>
<div class='row'>
    <div class='col-md-8'>
        <div class='box'>
            <div class='box-header'>ATTITUDINAL REPORT</div>
            <div class='box-body'>
                <table class='table table-bordered'>
                    <tr>
                        <th width='80%'>ATTITUDINAL REPORT</th>
                        <th width='20%'>RATING</th>
                    </tr>
                    @foreach($attitudes as $attitude)
                    <tr>
                        <td><div style='padding-left: 1.5em;text-indent:-1.5em;'><b>{{$attitude->TvetAttitude->criteria}}</b> - {{$attitude->TvetAttitude->description}}</td>
                        <td>
                            <select class="form-control attitude" id="{{$attitude->id}}">
                                {!!Helper::dropdownOption($attitude->rating,"default_satisfation")!!}
                            </select>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>

</div>
@stop

@section('java')
<script>
    $('.attitude').change(function(){
        arrays = {}
        arrays['rate'] = $(this).val();
        arrays['attitude']  = $(this).attr('id');
        $.ajax({
            type:"GET",
            url :"{{route('updateStudentAttitude')}}",
            data:arrays
        })
    });
</script>
@stop