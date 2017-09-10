@extends('layouts.dashboard')

@section('title', 'Pets')

@section('content')
<section class="content-header">
    <h1>
        Pet
        <small>Details</small>
	</h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li>Dashboard</li>
        <li class="active">Pets</li>
    </ol>
    </section>	
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if(session()->has('message'))
    <div class="alert alert-danger">
        {{ session()->get('message') }}
    </div>
    @endif
    <!-- Main content -->
    <section class="content">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Pet Form</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="{{ url('dashboard/admin/pets/update/'.  $pet->id) }}" method="post">
                {{ csrf_field() }}
                <div class="box-body ">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                            <label for="exampleInputEmail1">Name</label>
                            <input type="text" name="name" class="form-control" value="{{ $pet->name }}">
                            </div>
                            <div class="form-group">
                            <label for="exampleInputPassword1">Age</label>
                            <input type="number" name="age"class="form-control" value="{{ $pet->age }}">
                            </div>
                            <div class="form-group">
                            <label>Gender</label>
                            <select class="form-control" name="gender">
                                <option value="Male" {{$pet->gender == 'Male'}} ?? 'selected' : ''>Male</option>
                                <option value="Female" {{$pet->gender == 'Female'}} ?? 'selected' : ''>Female</option>
                            </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputFile">
                                    <img src="{{ asset('/images/'. $pet->image)}}" width="200">
                                </label>
                                <input type="file" name="image" value="{{$pet->image}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                            <label >Breed</label>
                            <input type="text" name="breed" class="form-control" value="{{ $pet->breed }}">
                            </div>
                            <div class="form-group">
                            <label >Color</label>
                            <input type="text" name="color" class="form-control" value="{{ $pet->color }}">
                            </div>
                            <div class="form-group">
                            <label>Type</label>
                            <select class="form-control" name="pet_type_id">
                                @foreach($types as $type)
                                <option value="{{$type->id}}" {{$pet->pet_type_id == $type->id}} ?? 'selected' : ''>{{$type->name}}</option>
                                @endforeach
                            </select>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right">Submit</button>
                </div>
            </form>
        </div>
    </section>
    <!-- /.content -->
@endsection

@section('javascript')
	<script src="{{ asset('bower_components/jquery/dist/jquery.min.js') }}"></script>
	<script>
		$(document).ready(function() {
			$('#example').DataTable();
		});
	</script>
@stop