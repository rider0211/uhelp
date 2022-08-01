@extends('layouts.adminmaster')

		@section('styles')

		<!-- INTERNAL owl-carousel css-->
		<link href="{{asset('assets/plugins/owl-carousel/owl-carousel.css')}}?v=<?php echo time(); ?>" rel="stylesheet" />

		<!-- INTERNAL jquery.autocomplete css-->
		<link href="{{asset('assets/plugins/jquery.autocomplete/jquery.autocomplete.css')}}?v=<?php echo time(); ?>" rel="stylesheet" />

		<!-- INTERNAl Summernote css -->
		<link rel="stylesheet" href="{{asset('assets/plugins/summernote/summernote.css')}}?v=<?php echo time(); ?>">

		<!-- INTERNAL Data table css -->
		<link href="{{asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css')}}?v=<?php echo time(); ?>" rel="stylesheet" />
		<link href="{{asset('assets/plugins/datatable/responsive.bootstrap5.css')}}?v=<?php echo time(); ?>" rel="stylesheet" />

		@endsection

			@section('content')

			<!--Page header-->
			<div class="page-header d-xl-flex d-block">
				<div class="page-leftheader">
					<h4 class="page-title"><span class="font-weight-normal text-muted ms-2">Footer</span></h4>
				</div>
			</div>
			<!--End Page header-->

			<!-- Footer page -->
			<div class="col-xl-12 col-lg-12 col-md-12">
				<div class="card ">
					<div class="card-header border-0">
						<h4 class="card-title">Footer Text</h4>
					</div>
					<form method="POST" action="{{url('admin/footer/' )}}" enctype="multipart/form-data">
						@csrf
						@honeypot
						<input type="hidden" name="id" value="1">
						<div class="card-body">
							<textarea class="form-control @error('footertext') is-invalid @enderror" rows="4" name="footertext" aria-multiline="true">{{$footertext->footertext}}</textarea>
							@error('footertext')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
							@enderror
						</div>
						<div class="card-header border-0">
							<h4 class="card-title">Footer Copyright Text</h4>
						</div>

						<div class="card-body">
							<textarea class="summernote d-none @error('copyright') is-invalid @enderror" name="copyright" aria-multiline="true">{{$footertext->copyright}}</textarea>
							@error('copyright')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
							@enderror
						</div>

						<div class="card-footer">
							<div class="form-group float-end ">
								<input type="submit" class="btn btn-secondary" value="Save Changes" onclick="this.disabled=true;this.form.submit();">
							</div>
						</div>
					</form>	
				</div>
			</div>
			<!-- Footer page -->

			@endsection

		@section('scripts')

		<!-- INTERNAL Vertical-scroll js-->
		<script src="{{asset('assets/plugins/vertical-scroll/jquery.bootstrap.newsbox.js')}}?v=<?php echo time(); ?>"></script>

		<!--INTERNAL Owl-carousel js -->
		<script src="{{asset('assets/plugins/owl-carousel/owl-carousel.js')}}?v=<?php echo time(); ?>"></script>

		<!-- INTERNAL Summernote js  -->
		<script src="{{asset('assets/plugins/summernote/summernote.js')}}?v=<?php echo time(); ?>"></script>


		@endsection
