
@extends('layouts.adminmaster')

		@section('styles')

		<!-- INTERNAl Tag css -->
		<link href="{{asset('assets/plugins/taginput/bootstrap-tagsinput.css')}}?v=<?php echo time(); ?>" rel="stylesheet" />

		@endsection

							@section('content')

							<!--Page header-->
							<div class="page-header d-xl-flex d-block">
								<div class="page-leftheader">
									<h4 class="page-title"><span class="font-weight-normal text-muted ms-2">{{trans('langconvert.admindashboard.editprofile')}}</span></h4>
								</div>
							</div>
							<!--End Page header-->

							<!-- Edit Profile Page-->
							<div class="row">
								<div class="col-xl-12 col-lg-12 col-md-12">
									<div class="card ">
										<div class="card-header border-0">
											<h4 class="card-title">{{trans('langconvert.admindashboard.editprofile')}}</h4>
										</div>
										<div class="card-body" >
											<form method="POST" action="{{url('/admin/profile')}}" enctype="multipart/form-data">
													@csrf
													@honeypot

													<div class="row">
														<div class="col-sm-6 col-md-6">
															<div class="form-group">
																<label class="form-label">{{trans('langconvert.admindashboard.firstname')}}</label>
																<input type="text" class="form-control @error('firstname') is-invalid @enderror" name="firstname" value="{{Auth::user()->firstname}}">
																@error('firstname')
																
																	<span class="invalid-feedback" role="alert">
																		<strong>{{ $message }}</strong>
																	</span>
																@enderror

															</div>
														</div>
														<div class="col-sm-6 col-md-6">
															<div class="form-group">
																<label class="form-label">{{trans('langconvert.admindashboard.lastname')}}</label>
																<input type="text" class="form-control @error('lastname') is-invalid @enderror" name="lastname" value="{{Auth::user()->lastname }}">
																@error('lastname')

																	<span class="invalid-feedback" role="alert">
																		<strong>{{ $message }}</strong>
																	</span>
																@enderror

															</div>
														</div>
														<div class="col-sm-6 col-md-6">
															<div class="form-group">
																<label class="form-label">{{trans('langconvert.admindashboard.emailaddress')}}</label>
																<input type="email" class="form-control" Value="{{Auth::user()->email}}" disabled>
			
															</div>
														</div>
														<div class="col-sm-6 col-md-6">
															<div class="form-group">
																<label class="form-label"> {{trans('langconvert.admindashboard.employeeiD')}}</label>
																<input type="email" class="form-control" Value="{{Auth::user()->empid}}" disabled>
			
															</div>
														</div>
														<div class="col-sm-6 col-md-6">
															<div class="form-group">
																<label class="form-label">{{trans('langconvert.admindashboard.mobilenumber')}}</label>
																<input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone"  value="{{old('phone',Auth::user()->phone)}}" >
																@error('phone')

																	<span class="invalid-feedback" role="alert">
																		<strong>{{ $message }}</strong>
																	</span>
																@enderror

															</div>
														</div>
														<div class="col-sm-6 col-md-6">
															<div class="form-group">
																<label class="form-label">{{trans('langconvert.admindashboard.languages')}}</label>
																<input type="text" class="form-control @error('languages') is-invalid @enderror sprukotags" value="{{old('languages', Auth::user()->languagues)}}" name="languages[]" data-role="tagsinput" />
																@error('languages')

																	<span class="invalid-feedback" role="alert">
																		<strong>{{ $message }}</strong>
																	</span>
																@enderror

															</div>
														</div>
														<div class="col-sm-6 col-md-6">
															<div class="form-group">
																<label class="form-label">{{trans('langconvert.admindashboard.skills')}}</label>
																<input type="text" class="form-control @error('skills') is-invalid @enderror sprukotags" value="{{old('skills', Auth::user()->skills)}}" name="skills[]" data-role="tagsinput" />
																@error('skills')

																	<span class="invalid-feedback" role="alert">
																		<strong>{{ $message }}</strong>
																	</span>
																@enderror

															</div>
														</div>
														<div class="col-sm-6 col-md-6">
															<div class="form-group">
																<label class="form-label">{{trans('langconvert.admindashboard.uploadimage')}}</label>
																<div class="input-group file-browser">
																	<input class="form-control @error('image') is-invalid @enderror" name="image" type="file" accept="image/png, image/jpeg,image/jpg" >
																	@error('image')

																	<span class="invalid-feedback" role="alert">
																		<strong>{{ $message }}</strong>
																	</span>
																	@enderror

																</div>
																<small class="text-muted"><i>{{trans('langconvert.admindashboard.filesize')}}</i></small>
															</div>
														</div>
														<div class="col-md-12 card-footer ">
															<div class="form-group float-end mb-0">
																<input type="submit" class="btn btn-secondary" value="{{trans('langconvert.admindashboard.savechanges')}}" onclick="this.disabled=true;this.form.submit();">
															</div>
														</div>
													</div>
											</form>
										</div>
									</div>
								</div>
							</div>
							<!-- End Edit Profile Page-->
							@endsection

		@section('scripts')

		<!-- INTERNAL Vertical-scroll js-->
		<script src="{{asset('assets/plugins/vertical-scroll/jquery.bootstrap.newsbox.js')}}?v=<?php echo time(); ?>"></script>

		<!-- INTERNAL Index js-->
		<script src="{{asset('assets/js/support/support-sidemenu.js')}}?v=<?php echo time(); ?>"></script>
		<script src="{{asset('assets/js/select2.js')}}?v=<?php echo time(); ?>"></script>

		<!-- INTERNAL TAG js-->
		<script src="{{asset('assets/plugins/taginput/bootstrap-tagsinput.js')}}?v=<?php echo time(); ?>"></script>

		@endsection
