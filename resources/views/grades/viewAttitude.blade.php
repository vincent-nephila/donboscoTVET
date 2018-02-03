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
                        <th width='85%'>ATTITUDINAL REPORT</th>
                        <th width='15%'>RATING</th>
                    </tr>
                    @foreach($attitudes as $attitude)
                    <tr>
                        <td><div style='padding-left: 1.5em;text-indent:-1.5em;'><b>{{$attitude->TvetAttitude->criteria}}</b> - {{$attitude->TvetAttitude->description}}</td>
                        
                        @if($gradeAvailable)
                        <td align="center">{{$attitude->rating}}</td>
                        @else
                        <td></td>
                        @endif
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>

</div>
@stop