@extends('layouts.app')

@section('header')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
          {{$course->course}}
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li>Courses</li>
        <li class="active">{{$course->course_id}}</li>
      </ol>
    </section>
@endsection


@section('content')
<style>
#select_class tr td {cursor: pointer;}
.selected {
    background-color: brown;
    color: #FFF;
}
</style>

<div class='row'>
    
    @foreach($sections->groupBy('batch') as $section)
    <div class='col-md-4'>
        <div class='panel panel-default'>
            <div class='panel-heading'><big>Batch {{$section->pluck('batch')->last()}}</big></div>
            <div class='panel-body'>
                <table class='table table-striped'>
                    <tr>
                        <th>Section</th>
                        <th>Adviser</th>
                        <th></th>
                    </tr>
                @foreach($section as $sec)
                    <tr>
                        <td>{{$sec->section}}</td>
                        <td>{{Helper::getname($sec->adviser_id)}}</td>
                        <td><a href="{{route('sectionsheeta',['id'=>$sec->id])}}">view</a></td>
                    </tr>
                @endforeach
                </table>
            </div>
        </div>
    </div>
    @endforeach
    
</div>
@endsection

