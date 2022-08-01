@extends('layouts.adminmaster')

		@section('styles')

		<link href="{{asset('assets/plugins/taginput/bootstrap-tagsinput.css')}}?v=<?php echo time(); ?>" rel="stylesheet" />

		@endsection

							@section('content')


							<!--Page header-->
							<div class="page-header d-xl-flex d-block">
								<div class="page-leftheader">
									<h4 class="page-title"><span class="font-weight-normal text-muted ms-2">{{trans('langconvert.adminmenu.seo')}}</span></h4>
								</div>
							</div>
							<!--End Page header-->

							<!--Seo -->
							<div class="col-xl-12 col-lg-12 col-md-12">
								<div class="card ">
									<div class="card-header border-0">
										<h4 class="card-title">{{trans('langconvert.adminmenu.seo')}}</h4>
									</div>
									<form method="POST" action="{{url('/admin/seo/create')}}" enctype="multipart/form-data">
										@csrf

										@honeypot
										<input type="hidden" name="seo_id" value="1">
										<div class="card-body">
											<div class="form-group">
												<label class="form-label">{{trans('langconvert.admindashboard.author')}} <span class="text-red">*</span></label>
												<input type="text" class="form-control @error('author') is-invalid @enderror" value="{{$seopage->author ? $seopage->author : ''}}" name="author">
												@error('author')

													<span class="invalid-feedback" role="alert">
														<strong>{{ $message }}</strong>
													</span>
												@enderror

											</div>
											<div class="form-group">
												<label class="form-label">{{trans('langconvert.admindashboard.description')}} <span class="text-red">*</span></label>
												<input type="text" class="form-control @error('description') is-invalid @enderror" value="{{$seopage->description ? $seopage->description : '' }}" name="description">
												@error('description')

													<span class="invalid-feedback" role="alert">
														<strong>{{ $message }}</strong>
													</span>
												@enderror

											</div>
											<div class="form-group">
												<label class="form-label">{{trans('langconvert.admindashboard.keywords')}} <span class="text-red">*</span></label>
												<input type="text" id="tags" class="form-control @error('keywords') is-invalid @enderror" value="{{$seopage->keywords ? $seopage->keywords : ''}}" name="keywords" data-role="tagsinput" />
												@error('keywords')

													<span class="invalid-feedback" role="alert">
														<strong>{{ $message }}</strong>
													</span>
												@enderror

											</div>
										</div>
										<div class="card-footer">
											<div class="form-group float-end">
												<input type="submit" class="btn btn-secondary "  value="{{trans('langconvert.admindashboard.savechanges')}}" onclick="this.disabled=true;this.form.submit();">
											</div>
										</div>
									</form>
								</div>
							</div>
							<!--End Seo-->

							@endsection


		@section('scripts')
		
		<!--- bootstrap tag js -->
		<script src="{{asset('assets/plugins/taginput/bootstrap-tagsinput.js')}}?v=<?php echo time(); ?>"></script>

		<script type="text/javascript">

			"use strict";

			// bootstrap js
			$('#tags').tagsinput({
				maxTags: 15
			});
			
		</script>
		@endsection