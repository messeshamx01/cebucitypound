@extends('layouts.dashboard')

@section('title', 'Pets')

@section('content')
<section class="content-header">
	<h1>
		Pets
		<small>Available for Adoption</small>
	</h1>
	@if(Auth::user()->is_admin)
    <ol class="breadcrumb">
        <li>Dashboard</li>
        <li class="active">Pets</li>
        <li class="active">Available Adoptions</li>
    </ol>
    @else
    <ol class="breadcrumb">
        <li><a href="{{ url('/')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li>Dashboard</li>
        <li class="active">Pets</li>
    </ol>
    @endif
	</section>
	<br>
    <!-- Main content -->
    <section class="content">
		<div class="box box-primary">
            <div class="box-header">
				<dic class="row">
					@foreach($available_adoptions as $available_adoption)
					<div class="col-md-3">
						<div class="box-body box-profile" style="border: 1px solid #eee">
							<img class="profile-user-img img-responsive img-circle" src="{{ asset('images/'. $available_adoption->pet->image) }}" alt="User profile picture">

							<h3 class="profile-username text-center">{{ $available_adoption->pet->name }}</h3>

							<p class="text-muted text-center">{{ $available_adoption->pet->breed }}</p>

							<ul class="list-group list-group-unbordered">
								<li class="list-group-item">
								<b>Age</b> <a class="pull-right">{{ $available_adoption->pet->age }}</a>
								</li>
								<li class="list-group-item">
								<b>Gender</b> <a class="pull-right">{{ $available_adoption->pet->gender }}</a>
								</li>
								<li class="list-group-item">
								<b>Color</b> <a class="pull-right">{{ $available_adoption->pet->color }}</a>
								</li>
							</ul>
							@if(count($available_adoption->adopt) > 0)
								@if(Auth::user()->id == $available_adoption->adopt->adopted_by)
									@if($available_adoption->adopt->is_accepted == 0)
										<a href="#" class="btn btn-warning btn-block" disabled="true"><b>Pending</b></a>
									@elseif($available_adoption->adopt->is_accepted == 1)
										<a href="#" class="btn btn-primary btn-block" disabled="true"><b>Accepted</b></a>
									@else
										<a href="#" class="btn btn-danger btn-block" disabled="true"><b>Declined</b></a>
									@endif
								@endif
							@else
							<a href="#" class="btn btn-danger btn-block"  onclick="adopt('{{$available_adoption->id}}')"><b>Adopt</b></a>
							@endif
						</div>
					</div>
					@endforeach
				</div>
			</div>
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

		function adopt (id) {
			$.ajax({
				type: "GET",
				url: '/dashboard/pets/adopt/' + id,
				success: function(response) {
					if(response.status){
						toastr.success('Pet successfully requested for adoption. Thank you!');
						location.reload();
					} else {
						toastr.error('Something went wrong!');
						location.reload();
					}
				},
				error: function(error) {
					console.log(error)
				}
			});
		}
	</script>
@stop