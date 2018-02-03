@extends('layouts.app')

@section('header')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        New Personnel
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li>Administration</li>
        <li class="active">Add Personnel</li>
      </ol>
    </section>
@endsection

@section('content')
<div class='row'>
	<div class="col-md-offset-3 col-md-6 col-xs-12">
		<div class="box box-warning">
			<div class="box-body">
				<form action="{{route('saveteacher')}}" method='POST'>
				{{csrf_field()}}
	                <div class="form-group col-md-12">
	                  <label>Idno</label>
	                  <input type="text" class="form-control" name="idno" required='required'>
	                </div>
	                <div class="form-group col-md-4">
	                  <label>Title</label>
	                  <input type="text" class="form-control" name="title">
	                </div>
	                <div class="form-group col-md-8">
	                  <label>First Name</label>
	                  <input type="text" class="form-control" name="firstname" required='required'>
	                </div>
	                <div class="form-group col-md-5">
	                  <label>Middle Name</label>
	                  <input type="text" class="form-control" name="middlename">
	                </div>
	                <div class="form-group col-md-7">
	                  <label>Last Name</label>
	                  <input type="text" class="form-control" name="lastname" required='required'>
	                </div>
	                <div class="form-group col-md-5">
	                  <label>Gender</label>
	                  <select class="form-control" name="gender">
	                    <option value="Male">Male</option>
	                    <option value="Female">Female</option>
	                  </select>
	                </div>
	                <div class="form-group col-md-7">
	                  <label>E-mail</label>
	                  <input type="text" class="form-control" name="email" required='required'>
	                </div>
	                <div class="form-group col-md-12">
	                	<button class="btn btn-danger col-md-12">Submit</button>
	                </div>
				</form>	
			</div>
		</div>
	</div>
</div>
@stop