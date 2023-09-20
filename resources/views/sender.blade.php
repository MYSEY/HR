
@extends('layouts.master')
@section('content')
	<section class="container mt-4">
		<div class="container-fluid">
			<div class="row justify-content-center">
				<div class="col-12 col-sm-6 col-md-6">
					<form class="form-container">
						<h2 class="text-center bg-dark p-2 text-white">Add Task Listing</h2>
						<div class="form-group">
							<label for="title">Title</label>
							<input type="text" name="title" class="form-control" id="title"
								placeholder="Enter Title">
						</div>

						<div class="form-group">
							<label for="description">Description</label>
							<textarea class="form-control" name="description" id="description" placeholder="Enter Description"></textarea>
						</div>

						<button type="button" class="btn btn-dark btn-block save_btn">Submit</button>
					</form>
				</div>
			</div>
		</div>
	</section>
@endsection
@include('includs.script')
@push('javascript')
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script>

	$(document).ready(function() {
		$('.save_btn').on('click', function(e) {
			let title = $('#title').val();
			let description = $('#description').val();
			$.ajax({
				type: "POST",
				url: "{{url('save_task')}}",
				data:{
					"_token": "{{ csrf_token() }}",
					"title": title,
					"description": description
				},
				dataType: "JSON",
				success:function(data) {
					// console.log(data);
				},
				error:function(err) {
					console.log(err);
				}
			});
		});
	});
</script>
