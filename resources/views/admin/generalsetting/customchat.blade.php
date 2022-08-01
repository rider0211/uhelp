
@extends('layouts.adminmaster')


							@section('content')


							<!--Page header-->
							<div class="page-header d-xl-flex d-block">
								<div class="page-leftheader">
									<h4 class="page-title"><span class="font-weight-normal text-muted ms-2">{{trans('langconvert.admindashboard.externalchat')}}</span></h4>
								</div>
							</div>
							<!--End Page header-->

							<!--External Chat-->
							<div class="col-xl-12 col-lg-12 col-md-12">
								<div class="card ">
									<div class="card-header border-0">
										<h4 class="card-title">{{trans('langconvert.admindashboard.externalchatsetting')}}</h4>
									</div>
									<form method="POST" action="{{route('settings.custom.chat')}}" enctype="multipart/form-data">
										<div class="card-body" >
											@csrf

											@honeypot
											<div class="row">
												<div class="switch_section">
													<div class="switch-toggle d-flex ">
														<a class="onoffswitch2">
															<input type="checkbox"  name="CUSTOMCHATENABLE" id="myonoffswitch18" class=" toggle-class onoffswitch2-checkbox" value="enable" @if(customcssjs('CUSTOMCHATENABLE') =='enable') checked="" @endif>
															<label for="myonoffswitch18" class="toggle-class onoffswitch2-label"></label>
														</a>
														<div class="ps-3">
															<label class="form-label">{{trans('langconvert.admindashboard.externalchatenabledisable')}}</label>
															<small class="text-muted"><i>{{trans('langconvert.admindashboard.externalchatcontent')}}</i></small>
														</div>
													</div>
												</div>
												<div class="switch_section">
													<div class="switch-toggle d-flex ">
														<a class="onoffswitch2">
															<input type="radio"  name="CUSTOMCHATUSER" id="myonoffswitch181" class=" toggle-class onoffswitch2-checkbox" value="public" @if(customcssjs('CUSTOMCHATUSER') == 'public') checked="" @endif>
															<label for="myonoffswitch181" class="toggle-class onoffswitch2-label"></label>
														</a>
														<div class="ps-3">
															<label class="form-label">{{trans('langconvert.admindashboard.allusers')}}</label>
															<small class="text-muted"><i>{{trans('langconvert.admindashboard.alluserscontent')}}</i></small>
														</div>
													</div>
												</div>
												<div class="switch_section">
													<div class="switch-toggle d-flex ">
														<a class="onoffswitch2">
															<input type="radio"  name="CUSTOMCHATUSER" id="myonoffswitch180" class=" toggle-class onoffswitch2-checkbox" value="null"  @if(customcssjs('CUSTOMCHATUSER') == 'null') checked="" @endif>
															<label for="myonoffswitch180" class="toggle-class onoffswitch2-label"></label>
														</a>
														<div class="ps-3">
															<label class="form-label">{{trans('langconvert.admindashboard.onlyregisteredusers')}}</label>
															<small class="text-muted"><i>{{trans('langconvert.admindashboard.onlyregistereduserscontent')}}</i></small>
														</div>
													</div>
												</div>
												<div class="col-sm-12 col-md-12">
													<div class="form-group">
														<label class="form-label">{{trans('langconvert.admindashboard.externalchat')}}</label>
														<textarea name="customchat" class="form-control @error('customchat') is-invalid @enderror cols="30" rows="10" placeholder="External Chat">{{customcssjs('CUSTOMCHAT')}}</textarea>

														@error('customchat')
														
															<span class="invalid-feedback" role="alert">
																<strong>{{ $message }}</strong>
															</span>
														@enderror

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
							<!--End External Chat-->


							@endsection

