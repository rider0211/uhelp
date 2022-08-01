@extends('layouts.adminmaster')

							@section('content')

							<!--Page header-->
							<div class="page-header d-xl-flex d-block">
								<div class="page-leftheader">
									<h4 class="page-title"><span class="font-weight-normal text-muted ms-2">{{trans('langconvert.adminmenu.404errorpage')}}</span></h4>
								</div>
							</div>
							<!--End Page header-->

							<!-- Edit 404 page -->
							<div class="col-xl-12 col-lg-12 col-md-12">
								<div class="card ">
									<div class="card-header border-0">
										<h4 class="card-title">{{trans('langconvert.adminmenu.404errorpage')}}</h4>
									</div>
									<form method="POST" action="{{url('/admin/error404')}}" enctype="multipart/form-data">
										@csrf

										@honeypot
										<div class="card-body">
											<div class="form-group">
												<label class="form-label">{{trans('langconvert.admindashboard.title')}} <span class="text-red">*</span></label>
												<input type="text" class="form-control @error('404title') is-invalid @enderror" value="{{settingpages('404title')}}" name="404title">
												@error('404title')

													<span class="invalid-feedback" role="alert">
														<strong>{{ $message }}</strong>
													</span>
												@enderror

											</div>
											<div class="form-group">
												<label class="form-label">{{trans('langconvert.admindashboard.subtitle')}} </label>
												<textarea class="form-control @error('404subtitle') is-invalid @enderror" rows="4" name="404subtitle" aria-multiline="true">{{settingpages('404subtitle')}}</textarea>
												@error('404subtitle')

													<span class="invalid-feedback" role="alert">
														<strong>{{ $message }}</strong>
													</span>
												@enderror
												
											</div>
										</div>
										<div class="card-footer">
											<div class="form-group float-end ">
												<input type="submit" class="btn btn-secondary" value="{{trans('langconvert.admindashboard.savechanges')}}" onclick="this.disabled=true;this.form.submit();">
											</div>
										</div>
									</form>
								</div>
							</div>
							<!-- End Edit 404 page -->

							@endsection


