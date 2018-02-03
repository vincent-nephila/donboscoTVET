@extends('layouts.app')
@section('content')
<style>
#select_class tr td {cursor: pointer;}
.selected {
    background-color: brown;
    color: #FFF;
}
</style>
<div class="row">
    @foreach($courses as $course)
    <div class="col-md-4">
        <div class="box box-success">
            <div class="box-header">{{$course->course}}</div>
            <?php $secs = $sections->where('course_id',$course->course_id);?>
            <div class="box-body">
                <table class="table table-striped" id='select_class'>
                    @foreach($secs as $sec)
                    <tr class="clickable-row" data-href="{{route('sectionsheeta',['section'=>$sec->id,''])}}"><td>{{$sec->section}}</td></tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    @endforeach
</div>
@stop

@section('java')
<script>
    $('.clickable-row').click(function(){
        window.location = $(this).data('href');
    })
</script>
@stop