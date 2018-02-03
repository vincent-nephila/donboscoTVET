@extends('layouts.app')

@section('header')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Personnel List
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li>Administration</li>
        <li class="active">Personnel</li>
      </ol>
    </section>
@endsection

@section('content')
<div class='row'>
	<div class="col-md-12 col-xs-12">
		<div class="box">
			<div class="box-body table-responsive">
				<table class="table table-striped" id="personnel">
					<thead>
						<tr>
							<td>Name</td>
							<td>View</td>
						</tr>
					</thead>
					<tbody>
					@foreach($personnels as $personnel)
					<tr>
						<td><big>{{$personnel->firstname}} {{$personnel->lastname}}</big></td>
						<td><a href="{{route('personnelview',['idno'=>$personnel->idno])}}">View</a></td>
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
    $('#personnel').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>
@stop