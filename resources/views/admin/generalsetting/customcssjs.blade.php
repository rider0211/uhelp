
@extends('layouts.adminmaster')



							@section('content')

							<!--Page header-->
							<div class="page-header d-xl-flex d-block">
								<div class="page-leftheader">
									<h4 class="page-title"><span class="font-weight-normal text-muted ms-2">{{trans('langconvert.adminmenu.customjscss')}}</span></h4>
								</div>
							</div>
							<!--End Page header-->
							
							<!--Custom CSS & JS-->
							<div class="col-xl-12 col-lg-12 col-md-12">
								<div class="card ">
									<div class="card-header border-0">
										<h4 class="card-title">{{trans('langconvert.adminmenu.customjscss')}}</h4>
									</div>
									<form method="POST" action="{{route('settings.custom.cssjs')}}" enctype="multipart/form-data">
										@csrf
										
										@honeypot

										<div class="card-body" >
											<input type="hidden" class="form-control" name="id" Value="">
											<div class="col-sm-12 col-md-12">
												<div class="form-group">
													<label class="form-label">{{trans('langconvert.admindashboard.customcss')}}</label>
													<textarea name="customcss" class="form-control @error('customcss') is-invalid @enderror cols="30" rows="10" placeholder="Custom Css">{{customcssjs('CUSTOMCSS')}}</textarea>
													@error('customcss')

														<span class="invalid-feedback" role="alert">
															<strong>{{ $message }}</strong>
														</span>
													@enderror

												</div>
											</div>
											<div class="col-sm-12 col-md-12">
												<div class="form-group">
													<label class="form-label">{{trans('langconvert.admindashboard.customjs')}}</label>
													<textarea name="customjs" class="form-control @error('customjs') is-invalid @enderror cols="30" rows="10" placeholder="Custom Js">{{customcssjs('CUSTOMJS')}}</textarea>
													@error('customjs')

														<span class="invalid-feedback" role="alert">
															<strong>{{ $message }}</strong>
														</span>
													@enderror
													
												</div>
											</div>
										</div>
										<div class="col-md-12 card-footer ">
											<div class="form-group float-end">
												<input type="submit" class="btn btn-secondary" value="{{trans('langconvert.admindashboard.savechanges')}}" onclick="this.disabled=true;this.form.submit();">
											</div>
										</div>
									</form>
								</div>
							</div>
							<!--End Custom CSS & JS-->
							@endsection


