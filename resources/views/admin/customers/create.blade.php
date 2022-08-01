
@extends('layouts.adminmaster')

		@section('styles')

		<!-- INTERNAl Tag css -->
		<link href="{{asset('assets/plugins/taginput/bootstrap-tagsinput.css')}}?v=<?php echo time(); ?>" rel="stylesheet" />

		@endsection

							@section('content')

							<!--Page header-->
							<div class="page-header d-xl-flex d-block">
								<div class="page-leftheader">
									<h4 class="page-title"><span class="font-weight-normal text-muted ms-2">{{trans('langconvert.admindashboard.customer')}}</span></h4>
								</div>
							</div>
							<!--End Page header-->
							
							<!-- Create Customers -->
							<div class="col-xl-12 col-lg-12 col-md-12">
								<div class="card ">
									<div class="card-header border-0">
										<h4 class="card-title">{{trans('langconvert.admindashboard.createcustomer')}}</h4>
									</div>
									<form method="POST" action="{{url('/admin/customer/create')}}" enctype="multipart/form-data">
										<div class="card-body" >
											@csrf

											@honeypot
											<div class="row">
												<div class="col-sm-6 col-md-6">
													<div class="form-group">
														<label class="form-label">{{trans('langconvert.admindashboard.firstname')}} <span class="text-red">*</span></label>
														<input type="text" class="form-control @error('firstname') is-invalid @enderror" name="firstname"  value="{{old('firstname')}}" >
														@error('firstname')

															<span class="invalid-feedback" role="alert">
																<strong>{{ $message }}</strong>
															</span>
														@enderror

													</div>
												</div>
												<div class="col-sm-6 col-md-6">
													<div class="form-group">
														<label class="form-label">{{trans('langconvert.admindashboard.lastname')}} <span class="text-red">*</span></label>
														<input type="text" class="form-control @error('lastname') is-invalid @enderror" name="lastname"  value="{{old('lastname')}}" >
														@error('lastname')

															<span class="invalid-feedback" role="alert">
																<strong>{{ $message }}</strong>
															</span>
														@enderror

													</div>
												</div>
												<div class="col-sm-6 col-md-6">
													<div class="form-group">
														<label class="form-label">{{trans('langconvert.admindashboard.emailaddress')}} <span class="text-red">*</span></label>
														<input type="email" class="form-control  @error('email') is-invalid @enderror" name="email"  value="{{old('email')}}" >
														@error('email')

															<span class="invalid-feedback" role="alert">
																<strong>{{ $message }}</strong>
															</span>
														@enderror

													</div>
												</div>	
												<div class="col-sm-6 col-md-6">
													<div class="form-group">
														<label class="form-label">{{trans('langconvert.admindashboard.password')}} <small class="text-muted"><i>{{trans('langconvert.admindashboard.copythepassword')}}</i></small></label>
														<div class="input-group mb-4">
															<div class="input-group">
																<a href="javascript:void(0)" class="input-group-text"  >
																	<i class="fe fe-eye" aria-hidden="true"></i>
																</a>
																<input class="form-control @error('password') is-invalid @enderror" type="text"  name="password" value="{{str_random(10)}}"  readonly>
																@error('password')

																	<span class="invalid-feedback" role="alert">
																		<strong>{{ $message }}</strong>
																	</span>
																@enderror

															</div>
														</div>
													</div>
												</div>
												<div class="col-sm-6 col-md-6">
													<div class="form-group">
														<label class="form-label">{{trans('langconvert.admindashboard.mobilenumber')}}</label>
														<input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone"  value="{{old('phone')}}" >
														@error('phone')

															<span class="invalid-feedback" role="alert">
																<strong>{{ $message }}</strong>
															</span>
														@enderror

													</div>
												</div>
											</div>
										</div>
										<div class="col-md-12 card-footer">
											<div class="form-group float-end">
												<input type="submit" class="btn btn-secondary" value="{{trans('langconvert.admindashboard.createcustomer')}}" onclick="this.disabled=true;this.form.submit();">
											</div>
										</div>
									</form>
									
								</div>
							</div>
							<!-- Create Customers -->
							@endsection

		@section('scripts')

		<!--File BROWSER -->
		<script src="{{asset('assets/js/form-browser.js')}}"></script>

		<!-- INTERNAL Vertical-scroll js-->
		<script src="{{asset('assets/plugins/vertical-scroll/jquery.bootstrap.newsbox.js')}}"></script>
		<script src="{{asset('assets/js/select2.js')}}"></script>

		<!-- INTERNAL Index js-->
		<script src="{{asset('assets/js/support/support-sidemenu.js')}}"></script>

		<!-- INTERNAL TAG js-->
		<script src="{{asset('assets/plugins/taginput/bootstrap-tagsinput.js')}}"></script>

		@endsection
