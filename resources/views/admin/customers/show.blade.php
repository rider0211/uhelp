
@extends('layouts.adminmaster')

						@section('content')

							<!--Page header-->
							<div class="page-header d-xl-flex d-block">
								<div class="page-leftheader">
									<h4 class="page-title"><span class="font-weight-normal text-muted ms-2">{{trans('langconvert.admindashboard.customer')}}</span></h4>
								</div>
							</div>
							<!--End Page header-->

							<!-- Customer Edit -->
							<div class="col-xl-12 col-lg-12 col-md-12">
								<div class="card ">
									<div class="card-header border-0">
										<h4 class="card-title">{{trans('langconvert.admindashboard.editcustomer')}}</h4>
									</div>
									<form method="POST" action="{{url('/admin/customer/' . $user->id)}}" enctype="multipart/form-data">
										<div class="card-body" >
											@csrf

											@honeypot
											<div class="row">
												<div class="col-sm-6 col-md-6">
													<div class="form-group">
														<label class="form-label">{{trans('langconvert.admindashboard.firstname')}}</label>
														<input type="text" class="form-control @error('firstname') is-invalid @enderror" name="firstname"  value="{{ $user->firstname, old('firstname') }}" >
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
														<input type="text" class="form-control @error('lastname') is-invalid @enderror" name="lastname"  value="{{$user->lastname, old('lastname') }}" >
														@error('lastname')

															<span class="invalid-feedback" role="alert">
																<strong>{{ $message }}</strong>
															</span>
														@enderror
													</div>
												</div>
												<div class="col-sm-6 col-md-6">
													<div class="form-group">
														<label class="form-label">{{trans('langconvert.admindashboard.username')}}</label>
														<input type="text" class="form-control" name="name"  value="{{$user->username }}" readonly>
													</div>
												</div>
												<div class="col-sm-6 col-md-6">
													<div class="form-group">
														<label class="form-label">{{trans('langconvert.admindashboard.emailaddress')}}</label>
														<input type="email @error('email') is-invalid @enderror" class="form-control" name="email" Value="{{$user->email, old('email')}}">
														@error('email')

															<span class="invalid-feedback" role="alert">
																<strong>{{ $message }}</strong>
															</span>
														@enderror

													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label class="form-label">{{trans('langconvert.admindashboard.country')}}</label>
														<input type="text" class="form-control "
																		Value="{{$user->country}}" name="timezone" readonly>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label class="form-label">{{trans('langconvert.admindashboard.timezones')}}</label>
														<input type="text" class="form-control "
																		Value="{{$user->timezone}}" name="timezone" readonly>
													</div>
												</div>
												<div class="col-md-12">
													<div class="form-group">
														<label class="form-label">{{trans('langconvert.admindashboard.status')}}</label>
														<select class="form-control  select2" data-placeholder="Select Status" name="status">
															<option label="Select Status"></option>
															@if ($user->status === '1')

															<option value="{{$user->status}}" @if ($user->status === '1') selected @endif>Active</option>
															<option value="0">Inactive</option>
															@else

															<option value="{{$user->status}}" @if ($user->status === '0') selected @endif>Inactive</option>
															<option value="1">Active</option>
															@endif

														</select>
													</div>
												</div>
											</div>
										</div>
										<div class="card-footer">
											<div class="form-group float-end">
												<input type="submit" class="btn btn-secondary" value="{{trans('langconvert.admindashboard.savechanges')}}" onclick="this.disabled=true;this.form.submit();">
											</div>
										</div>
									</form>
								</div>
							</div>
							<!-- End Customer Edit -->
			
							@endsection

		@section('scripts')
		
		<!-- INTERNAL select2 js-->
		<script src="{{asset('assets/js/select2.js')}}"></script>
		@endsection
