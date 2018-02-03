@extends('layouts.app')
@section('content')
<style>
#select_class tr td {cursor: pointer;}
.selected {
    background-color: brown;
    color: #FFF;
}
</style>
<div class='row'>

    <div class="col-sm-5 col-sm-push-7">
        <div class="box">
            <div class="box-header"><big><b>Class Information</b></big></div>
            <div class="box-body">
                <table class="table table-bordered">
                    <tr>
                        <td width="35%">Class Name</td>
                        <td>{{$class->section}}</td>
                    </tr>
                    <tr>
                        <td>Subject</td>
                        <td>{{Helper::subjectName($class->subject)}}</td>
                    </tr>
                    <tr>
                        <td>Batch</td>
                        <td>Batch {{$class->batch}}</td>
                    </tr>
                    <tr>
                        <td>Attached Sections</td>
                        <td>{{$sections->pluck('tvetSection')->implode('section',' ; ')}}</td>
                    </tr>
                    <tr>
                        <td>Adviser</td>
                        <td>
                            {{Helper::getName($class->adviser)}}
                            <button type="button" class="btn btn-success pull-right"  data-toggle="modal" data-target="#get_advisers" id="adviser_id">
                                Assign
                            </button>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-sm-7 col-sm-pull-5">
        <div class="box">
            <div class="box-header"><big><b>Class List</b></big></div>
            <div class="box-body">
                <table class="table table-bordered">
                    <tr>
                        <th>Student No.</th>
                        <th>Name</th>
                    </tr>
                    @foreach($students as $student)
                    <tr>
                        <td>{{$student->idno}}</td>
                        <td>{{Helper::getNameReverse($student->idno)}}</td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="get_advisers">
    <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Select Adviser  </h4>
          </div>
          <div class="modal-body" id="get_body">
              <form method="POST" action="{{route('assignclassteacher')}}" id="saveTeacher"></form>
          </div>
        <!-- /.modal-content -->
        </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
</div>
@stop

@section('java')
<script>
  $('#adviser_id').click(function(){

  	$.ajax({
  		type:"GET",
  		url:"{{url('getAdviser')}}/"+{{$class->id}},
  		success:function(data){
  			$('#saveTeacher').html(data);
  		},
  		error:function(){
  			$('#saveTeacher').html("An error occured");
  		}
  	})
  })
  
  $('#saveTeacher').on('click','table tbody tr',function(){
  	$(this).addClass('selected').siblings().removeClass('selected');
  	$(this).parent().find('input').removeAttr('checked');
  	$(this).find('input').attr('checked', true);

  })
</script>
@stop