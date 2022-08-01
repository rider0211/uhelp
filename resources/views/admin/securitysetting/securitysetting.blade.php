
@extends('layouts.adminmaster')

							@section('content')

							<!--Page header-->
							<div class="page-header d-xl-flex d-block">
								<div class="page-leftheader">
									<h4 class="page-title"><span class="font-weight-normal text-muted ms-2">{{trans('langconvert.adminmenu.securitysetting')}}</span></h4>
								</div>
							</div>
							<!--End Page header-->


							<!-- Row -->
							<div class="row">
								<div class="col-md-12">
									<div class="card overflow-hidden">
										<div class="card-body p-0">
											<div class="border-bottom">
												<ul class="nav nav-pills nav-settings d-lg-none d-sm-flex d-block p-3">
													<li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#countryTab"><span class="nav-setting-icon"><i class="fa fa-globe"></i></span> <span class="nav-setting-txt">{{trans('langconvert.newwordslang.frontend')}}</span></a></li>
														<li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#adminTab"><span class="nav-setting-icon"><i class="fa fa-shield"></i></span> <span class="nav-setting-txt">{{trans('langconvert.newwordslang.admin')}}</span></a></li>
														<li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#dosTab"><span class="nav-setting-icon"><i class="fa fa-ban"></i></span> <span class="nav-setting-txt">{{trans('langconvert.newwordslang.dos')}}</span></a></li>
												</ul>
											</div>
											<div class="d-lg-flex main-settings-layout settings-layout-2">
												<div class="border-end mn-wd-20p d-lg-block d-none">
													<ul class="nav nav-pills nav-settings p-3">
														<li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#countryTab"><span class="nav-setting-icon"><i class="fa fa-globe"></i></span> <span class="nav-setting-txt">{{trans('langconvert.newwordslang.frontend')}}</span></a></li>
														<li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#adminTab"><span class="nav-setting-icon"><i class="fa fa-shield"></i></span> <span class="nav-setting-txt">{{trans('langconvert.newwordslang.admin')}}</span></a></li>
														<li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#dosTab"><span class="nav-setting-icon"><i class="fa fa-ban"></i></span> <span class="nav-setting-txt">{{trans('langconvert.newwordslang.dos')}}</span></a></li>
													</ul>
												</div>
												<div class="flex-1">
													<div class="tab-content">

														
														<div class="tab-pane active" id="countryTab">
															<div class="p-5 border-bottom">
																<h5 class="mb-0">{{trans('langconvert.admindashboard.countryblockunblock')}}</h5>
															</div>
															<form action="{{route('settings.security.country')}}" method="POST">
														
															<div class="p-5 main-settings-content" id="countrySettings">
																@csrf

																@php 
																
																	$countrylist = explode(",", setting('COUNTRY_LIST'));
																	
																@endphp

																<div class="form-group {{ $errors->has('countrylist') ? ' has-danger' : '' }}">
																	<label for="theme_color-input" class="form-label">{{trans('langconvert.admindashboard.countrieslist')}}</label>
																	<select class="form-control select2 @error('countrylist') is-invalid @enderror" data-placeholder="Select Country" multiple name="countrylist[]"  value="{{ old('COUNTRY_LIST', setting('COUNTRY_LIST')) }}" >
																		<option label="Select Country"></option>
																		@foreach($countries as $country)
																		
																		<option  value="{{$country->code}}"  @if (in_array($country->code, $countrylist)) selected @endif > {{$country->name}} - {{$country->code}}</option>
																		@endforeach

																	</select>
																	@if ($errors->has('countrylist'))
																	
																		<span class="invalid-feedback" role="alert">
																			<strong>{{ $errors->first('countrylist') }}</strong>
																		</span>
																	@endif

																</div>

																<div class="custom-controls-stacked d-md-flex" id="text">
																	<label class="custom-control form-radio success me-4">
																		<input type="radio" class="custom-control-input" name="countryblock"  value="block" @if (setting('COUNTRY_BLOCKTYPE') == 'block') checked @endif>
																		<span class="custom-control-label">{{trans('langconvert.admindashboard.blockedcountries')}}</span>
																	</label>
																	<label class="custom-control form-radio success me-4">
																		<input type="radio" class="custom-control-input" name="countryblock"  value="allow" @if (setting('COUNTRY_BLOCKTYPE') == 'allow') checked @endif>
																		<span class="custom-control-label">{{trans('langconvert.admindashboard.allowedcountries')}}</span>
																	</label>
																</div>

															</div>
															<div class="px-5 py-4 mt-auto border-top">
																<div class="text-end btn-list">
																	<input type="submit" class="btn btn-secondary" value="Save Changes" onclick="this.disabled=true;this.form.submit();">
																</div>
															</div>
															</form>
														</div>
														<div class="tab-pane" id="adminTab">
															<div class="p-5 border-bottom">
																<h5 class="mb-0">{{trans('langconvert.admindashboard.admincountryblockunblock')}}</h5>
															</div>
															<form action="{{route('settings.security.admin.country')}}" method="POST">
																@csrf
																<div class="p-5 main-settings-content" id="adminSettings">
																	
																	@php 
																	
																		$admincountrylist = explode(",", setting('ADMIN_COUNTRY_LIST'));
																		
																	@endphp
													
																	<div class="form-group {{ $errors->has('admincountrylist') ? ' has-danger' : '' }}">
																		<label for="theme_color-input" class="form-label">{{trans('langconvert.admindashboard.countrieslist')}}</label>
																		<select class="form-control select2 @error('countrylist') is-invalid @enderror" data-placeholder="Select Country" multiple name="admincountrylist[]"  value="{{ old('ADMIN_COUNTRY_LIST', setting('ADMIN_COUNTRY_LIST')) }}" >
																			<option label="Select Country"></option>
																			@foreach($countries as $country)
													
																			<option  value="{{$country->code}}"  @if (in_array($country->code, $admincountrylist)) selected @endif @if (old($country->code)) selected @endif > {{$country->name}} - {{$country->code}}</option>
																			@endforeach
													
																		</select>
																		@if ($errors->has('admincountrylist'))
													
																			<span class="invalid-feedback" role="alert">
																				<strong>{{ $errors->first('admincountrylist') }}</strong>
																			</span>
																		@endif
													
																	</div>

																	<div class="custom-controls-stacked d-md-flex" id="text">
																		<label class="custom-control form-radio success me-4">
																			<input type="radio" class="custom-control-input" name="admincountryblock"  value="block" @if (setting('ADMIN_COUNTRY_BLOCKTYPE') == 'block') checked @endif>
																			<span class="custom-control-label">{{trans('langconvert.admindashboard.blockedcountries')}}</span>
																		</label>
																		<label class="custom-control form-radio success me-4">
																			<input type="radio" class="custom-control-input" name="admincountryblock"  value="allow" @if (setting('ADMIN_COUNTRY_BLOCKTYPE') == 'allow') checked @endif>
																			<span class="custom-control-label">{{trans('langconvert.admindashboard.allowedcountries')}}</span>
																		</label>
																	</div>
																</div>
																<div class="px-5 py-4 mt-auto border-top">
																	<div class="text-end btn-list">
																		<input type="submit" class="btn btn-secondary" value="Save Changes" onclick="this.disabled=true;this.form.submit();">
																	</div>
																</div>
															</form>
														</div>

														<div class="tab-pane" id="dosTab">
															<div class="p-5 border-bottom">
																<h5 class="mb-0">{{trans('langconvert.admindashboard.dosattack')}}</h5>
															</div>
															<form action="{{route('settings.security.ip')}}" method="POST">
																<div class="p-5 main-settings-content" id="dosSettings">
																	@csrf

																	<div class="switch_section mt-0">
																		<div class="switch-toggle d-flex d-md-max-block ps-0 ms-0">
																			<a class="onoffswitch2">
																				<input type="checkbox"  name="dosswitch" id="sprukoadmindosswitch" class=" toggle-class onoffswitch2-checkbox sprukodosswitch" @if(setting('DOS_Enable') == 'on') checked="" @endif>
																				<label for="sprukoadmindosswitch" class="toggle-class onoffswitch2-label" ></label>
																			</a>
																			<label class="form-label ps-3 ps-md-max-0">{{trans('langconvert.admindashboard.dosswitch')}}</label>
																			<small class="text-muted ps-2 ps-md-max-0"><i>{{trans('langconvert.admindashboard.dosswitchcontent')}}</i></small>
																		</div>
																	</div>
																	
																	<div class="row">
																		<div class="col-lg-12">
																			<div class="form-group me-2 {{ $errors->has('ip_max_attempt') ? ' is-invalid' : '' }}">
																				<div class="d-lg-flex">
																					<div class="row">
																						<div class="col-lg-12 pe-0">
																							<div class="d-lg-flex">
																								<span class="mt-2 px-0 me-2">{{trans('langconvert.admindashboard.morethan')}}</span>
																									<input type="number" maxlength="2" class="w-md-max-20 w-10 form-control {{ $errors->has('ip_max_attempt') ? ' is-invalid' : '' }}"  name="ip_max_attempt"  value="{{old('ip_max_attempt', setting('IPMAXATTEMPT')) }}">	
																									
																								<span class="mt-2 ms-2 me-3 ms-md-max-0">{{trans('langconvert.admindashboard.attemptsin')}}</span>
																									<input type="number" maxlength="2" class="ms-1 w-10 w-md-max-20 ms-md-max-0 form-control {{ $errors->has('ip_seconds') ? ' is-invalid' : '' }}"  name="ip_seconds"  value="{{old('ip_seconds', setting('IPSECONDS')) }}">
																								<span class="mt-2 ms-2 ms-md-max-0">{{trans('langconvert.admindashboard.seconds ')}}</span>
																							</div>
																						</div>
																					</div>
																				</div>	
																			</div>
																		</div>
																		{{--Validation--}}
																		<div class="{{ $errors->has('ip_max_attempt') ? ' is-invalid' : '' }}">
																			@if ($errors->has('ip_max_attempt'))
						
																				<span class="text-danger" role="alert">
																					<strong>{{ $errors->first('ip_max_attempt') }}</strong>
																				</span>
																			@endif
																		</div>
																		<div class="{{ $errors->has('ip_seconds') ? ' is-invalid' : '' }}">
																			@if ($errors->has('ip_seconds'))
										
																			<span class="text-danger" role="alert">
																				<strong>{{ $errors->first('ip_seconds') }}</strong>
																			</span>
																			@endif
						
																		</div>		
																		{{--Validation--}}
						
																	</div>

																	
																	<div class="custom-controls-stacked d-md-flex" id="text">
																		<label class="custom-control form-radio success me-4">
																			<input type="radio" class="custom-control-input" name="ipblocktype"  value="captcha" @if (setting('IPBLOCKTYPE') == 'captcha') checked @endif>
																			<span class="custom-control-label">{{trans('langconvert.admindashboard.viewcaptcha')}}</span>
																		</label>
																		<label class="custom-control form-radio success me-4">
																			<input type="radio" class="custom-control-input" name="ipblocktype"  value="block" @if (setting('IPBLOCKTYPE') == 'block') checked @endif>
																			<span class="custom-control-label">{{trans('langconvert.admindashboard.blockipaddress')}}</span>
																		</label>
																	</div>
																</div>
																<div class="px-5 py-4 mt-auto border-top">
																	<div class="text-end btn-list">
																		<input type="submit" class="btn btn-secondary" value="Save Changes" onclick="this.disabled=true;this.form.submit();">
																	</div>
																</div>
															</form>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!--/ row -->

							
							@endsection

		@section('scripts')

		<script type="text/javascript">

			"use strict";

			(function($)  {

				//______Select2
				$('.select2').select2({
					minimumResultsForSearch: Infinity,
					width: '100%'
				});

				// Select2 by showing the search
				$('.select2-show-search').select2({
				minimumResultsForSearch: ''
				});

			})(jQuery);
			
		</script>
		@endsection