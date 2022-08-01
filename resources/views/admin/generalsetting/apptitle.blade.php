
@extends('layouts.adminmaster')

		@section('styles')

		
		<!-- INTERNAl Summernote css -->
		<link rel="stylesheet" href="{{asset('assets/plugins/summernote/summernote.css')}}?v=<?php echo time(); ?>">

		<!-- INTERNAl color css -->
		<link rel="stylesheet" href="{{asset('assets/plugins/colorpickr/themes/nano.min.css')}}?v=<?php echo time(); ?>">

		<!-- INTERNAL Sweet-Alert css -->
		<link href="{{asset('assets/plugins/sweet-alert/sweetalert.css')}}?v=<?php echo time(); ?>" rel="stylesheet" />


		@endsection

							@section('content')


							<!--Page header-->
							<div class="page-header d-xl-flex d-block">
								<div class="page-leftheader">
									<h4 class="page-title"><span class="font-weight-normal text-muted ms-2">{{trans('langconvert.adminmenu.generalsetting')}}</span></h4>
								</div>
							</div>
							<!--End Page header-->

							<div class="row">
								<!-- App Title & Logos -->
								<div class="col-xl-12 col-lg-12 col-md-12">
									<div class="card ">
										<div class="card-header border-0">
											<h4 class="card-title">{{trans('langconvert.admindashboard.apptitlelogos')}}</h4>
										</div>
										<form method="POST" action="{{url('/admin/general')}}" enctype="multipart/form-data">
										<div class="card-body" >
												@csrf

												@honeypot
												<input type="hidden" class="form-control" name="id" Value="{{$basic->id}}">
												<div class="row">
													<div class="col-sm-12 col-md-12">
														<div class="form-group">
															<label class="form-label">{{trans('langconvert.admindashboard.title')}} <span class="text-red">*</span></label>
															<input type="text" class="form-control @error('title') is-invalid @enderror" name="title" Value="{{$basic->title}}" >
															@error('title')

																<span class="invalid-feedback" role="alert">
																	<strong>{{ $message }}</strong>
																</span>
															@enderror

														</div>
													</div>

													<div class="col-xl-4 col-sm-12 col-lg-12">
														<div class="spfileupload">
															<div class="row">
																<div class="col-xl-7 col-lg-9 col-md-9 col-sm-9">
																	<div class="form-group">
																		<div class="@error('image') is-invalid @enderror ">
																			<label class="form-label fs-16">{{trans('langconvert.admindashboard.uploadlightlogo')}}</label>
																			<div class="input-group file-browser">
																				<input class="form-control " name="image" type="file" >
																				
																			</div>
																			<small class="text-muted"><i>{{trans('langconvert.admindashboard.filesize')}}</i></small>
																		</div>
																		@error('image')
			
																		<span class="invalid-feedback" role="alert">
																			<strong>{{ $message }}</strong>
																		</span>
																		@enderror
																		
																	</div>
																</div>
																<div class="col-xl-5 col-lg-3 col-md-3 col-sm-3">
																	<div class="file-image-1 ms-sm-auto sprukologoss ms-sm-auto"> 
																		<div class="product-image sprukologoimages"> 
																			@if($title->image == null)

																			
																			<img src="{{asset('uploads/logo/logo/logo-white.png')}}" class="br-5" alt="logo">
																			@else

																			<button class="btn ticketnotedelete border-white text-gray logosdelete" value="logo1" data-id="{{$title->id}}">
																				<i class="feather feather-x" ></i>
																			</button>
																			<img src="{{asset('uploads/logo/logo/'.$title->image)}}" class="br-5" alt=""> 
																			@endif
																		</div> 
																	</div>
																</div>
															</div>
														</div>
													</div>
													<div class="col-xl-4 col-sm-12 col-lg-12">
														<div class="spfileupload">
															<div class="row">
																<div class="col-xl-7 col-lg-9 col-md-9 col-sm-9">
																	<div class="form-group">
																		<div class="@error('image1') is-invalid @enderror">
																			<label class="form-label fs-16">{{trans('langconvert.admindashboard.uploaddarklogo')}}</label>
																			<div class="input-group file-browser">
																				<input class="form-control " name="image1" type="file" >
																			</div>
																			<small class="text-muted"><i>{{trans('langconvert.admindashboard.filesize')}}</i></small>
																		</div>
																		@error('image1')
			
																		<span class="invalid-feedback" role="alert">
																			<strong>{{ $message }}</strong>
																		</span>
																		@enderror
			
																	</div>
																</div>
																<div class="col-xl-5 col-lg-3 col-md-3 col-sm-3">
																	<div class="file-image-1 ms-sm-auto"> 
																		<div class="product-image sprukologoimages"> 
																			@if($title->image1 == null)

																			<img src="{{asset('uploads/logo/darklogo/logo.png')}}" class="br-5" alt="logo">
																			@else 

																			<button class="btn ticketnotedelete border-white text-gray logosdelete" value="logo2" data-id="{{$title->id}}">
																				<i class="feather feather-x" ></i>
																			</button>
																			<img src="{{asset('uploads/logo/darklogo/'.$title->image1)}}" class="br-5" alt=""> 
																			@endif
																		</div> 
																	</div>
																</div>
															</div>
														</div>
													</div>
													<div class="col-xl-4 col-sm-12 col-lg-12">
														<div class="spfileupload">
															<div class="row">
																<div class="col-xl-7 col-lg-9 col-md-9 col-sm-9">
																	<div class="form-group">
																		<div class="@error('image2') is-invalid @enderror">
																			<label class="form-label fs-16">{{trans('langconvert.admindashboard.darkicon')}}</label>
																			<div class="input-group file-browser">
																				<input class="form-control " name="image2" type="file" >
																			</div>
																			<small class="text-muted"><i>{{trans('langconvert.admindashboard.filesize')}}</i></small>
																		</div>
																		@error('image2')
			
																		<span class="invalid-feedback" role="alert">
																			<strong>{{ $message }}</strong>
																		</span>
																		@enderror
			
																	</div>
																</div>
																<div class="col-xl-5 col-lg-3 col-md-3 col-sm-3">
																	<div class="file-image-1 ms-sm-auto"> 
																		<div class="product-image sprukologoimages"> 
																			@if($title->image2 == null)

																			<img src="{{asset('uploads/logo/icon/icon.png')}}" class="br-5" alt="logo">
																			@else

																			<button class="btn ticketnotedelete border-white text-gray logosdelete" value="logo3" data-id="{{$title->id}}">
																				<i class="feather feather-x" ></i>
																			</button>
																			<img src="{{asset('uploads/logo/icon/'.$title->image2)}}" class="br-5" alt=""> 
																			@endif
																		</div> 
																	</div>
																</div>
															</div>
														</div>
													</div>
													<div class="col-xl-4 col-sm-12 col-lg-12">
														<div class="spfileupload">
															<div class="row">
																<div class="col-xl-7 col-lg-9 col-md-9 col-sm-9">
																	<div class="form-group">
																		<div class="@error('image3') is-invalid @enderror">
																			<label class="form-label fs-16">{{trans('langconvert.admindashboard.lighticon')}}</label>
																			<div class="input-group file-browser">
																				<input class="form-control " name="image3" type="file" >
																			</div>
																			<small class="text-muted"><i>{{trans('langconvert.admindashboard.filesize')}}</i></small>
																		</div>
																		@error('image3')
			
																		<span class="invalid-feedback" role="alert">
																			<strong>{{ $message }}</strong>
																		</span>
																		@enderror
			
																	</div>
																</div>
																<div class="col-xl-5 col-lg-3 col-md-3 col-sm-3">
																	<div class="file-image-1 ms-sm-auto"> 
																		<div class="product-image sprukologoimages"> 
																			@if($title->image3 == null)

																			<img src="{{asset('uploads/logo/darkicon/icon-white.png')}}" class="br-5" alt="logo">
																			@else

																			<button class="btn ticketnotedelete border-white text-gray logosdelete" value="logo4" data-id="{{$title->id}}">
																				<i class="feather feather-x" ></i>
																			</button>
																			<img src="{{asset('uploads/logo/darkicon/'.$title->image3)}}" class="br-5" alt=""> 
																			@endif
																		</div> 
																	</div>
																</div>
															</div>
														</div>
													</div>
													<div class="col-xl-4 col-sm-12 col-lg-12">
														<div class="spfileupload">
															<div class="row">
																<div class="col-xl-7 col-lg-9 col-md-9 col-sm-9">
																	<div class="form-group">
																		<div class="@error('image4') is-invalid @enderror">
																			<label class="form-label fs-16">{{trans('langconvert.admindashboard.uploadfavicon')}}</label>
																			<div class="input-group file-browser">
																				<input class="form-control " name="image4" type="file" >
																			</div>
																			<small class="text-muted"><i>{{trans('langconvert.admindashboard.filesize')}}</i></small>
																		</div>
																		@error('image4')
			
																		<span class="invalid-feedback" role="alert">
																			<strong>{{ $message }}</strong>
																		</span>
																		@enderror
			
																	</div>
																</div>
																<div class="col-xl-5 col-lg-3 col-md-3 col-sm-3">
																	<div class="file-image-1 ms-sm-auto"> 
																		<div class="product-image sprukologoimages"> 
																			@if($title->image4 == null)

																			<img src="{{asset('uploads/logo/favicons/favicon.ico')}}" class="br-5" alt="logo">
																			@else

																			<button class="btn ticketnotedelete border-white text-gray logosdelete" value="logo5" data-id="{{$title->id}}">
																				<i class="feather feather-x" ></i>
																			</button>
																			<img src="{{asset('uploads/logo/favicons/'.$title->image4)}}" class="br-5" alt=""> 
																			@endif
																		</div> 
																	</div>
																</div>
															</div>
														</div>
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
								<!-- End App Title & Logos -->


								<!-- Custom pages -->

								<div class="col-xl-6 col-lg-6 col-md-6">
									<div class="card ">
										<div class="card-header border-0">
											<h4 class="card-title">{{trans('langconvert.newwordslang.seturl')}}</h4>
										</div>
										<form action="{{route('settings.url.urlset')}}" method="POST">
											@csrf

											<div class="card-body" >
												<div class="row">
													<div class="col-xl-12 col-lg-12 col-md-12">
														<div class="form-group ">
															<label for="" class="form-label">{{trans('langconvert.newwordslang.termsurl')}} <span class="text-red">*</span></label>
															<input class="form-control {{ $errors->has('terms_url') ? ' is-invalid' : '' }}" name="terms_url" type="text" value="{{ old('terms_url', setting('terms_url')) }}" >
					
															@if ($errors->has('terms_url'))

																<span class="invalid-feedback" role="alert">
																	<strong>{{ $errors->first('terms_url') }}</strong>
																</span>
															@endif
					
														</div>
													</div>
												</div>	
											</div>
											<div class="col-md-12 card-footer ">
												<div class="form-group float-end ">
													<input type="submit" class="btn btn-secondary" value="{{trans('langconvert.admindashboard.savechanges')}}" onclick="this.disabled=true;this.form.submit();">
												</div>
											</div>
										</form>
									</div>
								</div>
								<!-- End Custom pages -->

								<!-- Color Setting -->
								<div class="col-xl-6 col-lg-6 col-md-6">
									<div class="card ">
										<div class="card-header border-0">
											<h4 class="card-title">{{trans('langconvert.admindashboard.colorsetting')}}</h4>
										</div>
										<form action="{{route('settings.color.colorsetting')}}" method="POST">
											@csrf

											<div class="card-body" >
												<div class="row">
													<div class="col-xl-6 col-lg-6 col-md-6">
														<div class="form-group ">
															<label for="" class="form-label">{{trans('langconvert.admindashboard.primarycolor')}} <span class="text-red">*</span></label>
															<input class="form-control {{ $errors->has('theme_color') ? ' is-invalid' : '' }}" name="theme_color" type="text" value="{{ old('theme_color', setting('theme_color')) }}" id="theme_color-input">
					
															@if ($errors->has('theme_color'))

																<span class="invalid-feedback" role="alert">
																	<strong>{{ $errors->first('theme_color') }}</strong>
																</span>
															@endif
					
														</div>
													</div>
													<div class="col-xl-6 col-lg-6 col-md-6">
														<div class="form-group ">
															<label for="" class="form-label">{{trans('langconvert.admindashboard.secondarycolor')}} <span class="text-red">*</span></label>
															<input class="form-control {{ $errors->has('theme_color_dark') ? ' is-invalid' : '' }}" name="theme_color_dark" type="text" value="{{ old('theme_color_dark', setting('theme_color_dark')) }}" id="theme_color_dark-input">
					
															@if ($errors->has('theme_color_dark'))

																<span class="invalid-feedback" role="alert">
																	<strong>{{ $errors->first('theme_color_dark') }}</strong>
																</span>
															@endif
					
														</div>
													</div>
												</div>	
											</div>
											<div class="col-md-12 card-footer ">
												<div class="form-group float-end ">
													<input type="submit" class="btn btn-secondary" value="{{trans('langconvert.admindashboard.savechanges')}}" onclick="this.disabled=true;this.form.submit();">
												</div>
											</div>
										</form>
									</div>
								</div>
								<!-- Color Setting -->

								<!-- Global Language Setting -->
								<div class="col-xl-6 col-lg-6 col-md-6">
									<div class="card ">
										<div class="card-header border-0">
											<h4 class="card-title">{{trans('langconvert.admindashboard.globallanguage')}}</h4>
										</div>
										<form action="{{ route('settings.lang.store') }}" method="POST">
											@csrf

											<div class="card-body" >
												<div class="form-group mb-4">
												<label  class="form-label">{{trans('langconvert.admindashboard.selectlanguage')}}</label>
													<select name="default_lang" id="input-default_lang" class="form-control select2 select2-show-search" required>
														@foreach(getLanguages() as $key => $lang)

															<option value="{{ $lang }}" {{ old('default_lang', setting('default_lang'))==$lang ? 'selected' :'' }}>{{Str::upper($lang)}}</option>
														@endforeach

													</select>
												</div>
											</div>
											<div class="col-md-12 card-footer ">
												<div class="form-group float-end ">
													<input type="submit" class="btn btn-secondary" value="{{trans('langconvert.admindashboard.savechanges')}}" onclick="this.disabled=true;this.form.submit();">
												</div>
											</div>
										</form>
									</div>
								</div>
								<!-- Global Language Setting -->

								<!-- Date and Time Format -->
								<div class="col-xl-6 col-lg-6 col-md-6">
									<div class="card ">
										<div class="card-header border-0">
											<h4 class="card-title">{{trans('langconvert.newwordslang.datetimeformat')}}</h4>
										</div>
										<form action="{{ route('settings.timedateformat.store') }}" method="POST">
											@csrf

											<div class="card-body" >
												<div class="row">
													<div class="col-6">
														<div class="form-group mb-4">
															<label  class="form-label">{{trans('langconvert.newwordslang.selectdateformat')}}</label>
															<select name="date_format" id="input-date_format" class="form-control select2 select2-show-search" required>
									
																<option value="d M, Y" {{setting('date_format') == 'd M, Y' ? 'selected' : ''}}>d M, Y</option>
																<option value="m.d.y" {{setting('date_format') == 'm.d.y' ? 'selected' : ''}}>m.d.y</option>
																<option value="Y-m-d" {{setting('date_format') == 'Y-m-d' ? 'selected' : ''}}>Y-m-d</option>
																<option value="d-m-Y" {{setting('date_format') == 'd-m-Y' ? 'selected' : ''}}>d-m-Y</option>
																<option value="d/m/Y" {{setting('date_format') == 'd/m/Y' ? 'selected' : ''}}>d/m/Y</option>
																<option value="Y/m/d" {{setting('date_format') == 'Y/m/d' ? 'selected' : ''}}>Y/m/d</option>
		
															</select>
														</div>
													</div>
													<div class="col-6">
														<div class="form-group mb-4">
															<label  class="form-label">{{trans('langconvert.newwordslang.selecttimeformat')}}</label>
															<select name="time_format" id="input-time_format" class="form-control select2 select2-show-search" required>
												
																<option value="h:i A" {{setting('time_format') == 'h:i A' ? 'selected' : ''}}>03:00 PM</option>
																<option value="h:i:s A" {{setting('time_format') == 'h:i:s A' ? 'selected' : ''}}>03:00:02 PM</option>
																<option value="H:i" {{setting('time_format') == 'H:i' ? 'selected' : ''}}>15:00</option>
																<option value="H:i:s" {{setting('time_format') == 'H:i:s' ? 'selected' : ''}}>15:00:02</option>
		
															</select>
														</div>
													</div>

												</div>
											</div>
											<div class="col-md-12 card-footer ">
												<div class="form-group float-end ">
													<input type="submit" class="btn btn-secondary" value="{{trans('langconvert.admindashboard.savechanges')}}" onclick="this.disabled=true;this.form.submit();">
												</div>
											</div>
										</form>
									</div>
								</div>
								<!-- Date and Time Format -->
								
								<!-- Switches -->
								<div class="col-xl-12 col-lg-12 col-md-12">
									<div class="card ">
										<div class="card-header border-0">
											<h4 class="card-title">{{trans('langconvert.admindashboard.appglobalsettings')}}</h4>
										</div>
										<div class="card-body">
											<div class="switch_section">
												<div class="switch-toggle d-flex d-md-max-block mt-4">
													<a class="onoffswitch2">
														<input type="checkbox"  name="checkbox" id="sprukoadminp" class=" toggle-class onoffswitch2-checkbox sprukoregister" @if(setting('SPRUKOADMIN_P') == 'on') checked="" @endif>
														<label for="sprukoadminp" class="toggle-class onoffswitch2-label" ></label>
													</a>
													<label class="form-label ps-3 ps-md-max-0">{{trans('langconvert.admindashboard.personalsettingadmin')}}</label>
													<small class="text-muted ps-2 ps-md-max-0"><i>{{trans('langconvert.admindashboard.personaladminpanel')}}</i></small>
												</div>
											</div>
											<div class="switch_section">
												<div class="switch-toggle d-flex d-md-max-block mt-4">
													<a class="onoffswitch2">
														<input type="checkbox"  name="checkbox" id="sprukoadminc" class=" toggle-class onoffswitch2-checkbox sprukoregister" @if(setting('SPRUKOADMIN_C') == 'on') checked="" @endif>
														<label for="sprukoadminc" class="toggle-class onoffswitch2-label" ></label>
													</a>
													<label class="form-label ps-3 ps-md-max-0">{{trans('langconvert.admindashboard.personalsettingcustomer')}}</label>
													<small class="text-muted ps-2 ps-md-max-0"><i>{{trans('langconvert.admindashboard.personalcustomerpanel')}}</i></small>
												</div>
											</div>

											<div class="switch_section">
												<div class="switch-toggle d-flex d-md-max-block mt-4">
													<a class="onoffswitch2">
														<input type="checkbox"  name="checkbox" id="darkmode" class=" toggle-class onoffswitch2-checkbox sprukoregister" @if(setting('DARK_MODE') == '1') checked="" @endif>
														<label for="darkmode" class="toggle-class onoffswitch2-label" ></label>
													</a>
													<label class="form-label ps-3 ps-md-max-0">{{trans('langconvert.admindashboard.enabledarkmode')}}</label>
													<small class="text-muted ps-2 ps-md-max-0"><i>{{trans('langconvert.admindashboard.enabledarkcontent')}}</i></small>
												</div>
											</div>
											<div class="switch_section">
												<div class="switch-toggle d-flex d-md-max-block mt-4">
													<a class="onoffswitch2">
														<input type="checkbox" name="REGISTER_POPUP" id="myonoffswitch1" class=" toggle-class onoffswitch2-checkbox sprukoregister" value="yes" @if(setting('REGISTER_POPUP') == 'yes') checked="" @endif>
														<label for="myonoffswitch1" class="toggle-class onoffswitch2-label" ></label>
													</a>
													<label class="form-label ps-3 ps-md-max-0">{{trans('langconvert.admindashboard.enablepopupregisterlogin')}}</label>
													<small class="text-muted ps-2 ps-md-max-0"><i>{{trans('langconvert.admindashboard.enablepopupregisterlogincontent')}}</i></small>
												</div>
											</div>

											<div class="switch_section">
												<div class="switch-toggle d-flex d-md-max-block mt-4">
													<a class="onoffswitch2">
														<input type="checkbox"  name="REGISTER_DISABLE" id="REGISTER_DISABLE" class=" toggle-class onoffswitch2-checkbox sprukoregister" value="off" @if(setting('REGISTER_DISABLE') == 'off') checked="" @endif>
														<label for="REGISTER_DISABLE" class="toggle-class onoffswitch2-label" ></label>
													</a>
													<label class="form-label ps-3 ps-md-max-0">{{trans('langconvert.admindashboard.disableregister')}}</label>
													<small class="text-muted ps-2 ps-md-max-0"><i>{{trans('langconvert.admindashboard.disableregistercontent')}}</i></small>
												</div>
											</div>

											<div class="switch_section">
												<div class="switch-toggle d-flex d-md-max-block mt-4">
													<a class="onoffswitch2">
														<input type="checkbox"  name="GOOGLEFONT_DISABLE" id="GOOGLEFONT_DISABLE" class=" toggle-class onoffswitch2-checkbox sprukoregister"  @if(setting('GOOGLEFONT_DISABLE') == 'on') checked="" @endif>
														<label for="GOOGLEFONT_DISABLE" class="toggle-class onoffswitch2-label" ></label>
													</a>
													<label class="form-label ps-3 ps-md-max-0">{{trans('langconvert.admindashboard.disablegooglefont')}}</label>
													<small class="text-muted ps-2 ps-md-max-0"><i>{{trans('langconvert.admindashboard.disablegooglefontcontent')}}</i></small>
												</div>
											</div>
											<div class="switch_section">
												<div class="switch-toggle d-flex d-md-max-block mt-4">
													<a class="onoffswitch2">
														<input type="checkbox"  name="FORCE_SSL" id="FORCE_SSL" class=" toggle-class onoffswitch2-checkbox sprukoregister"  @if(setting('FORCE_SSL') == 'on') checked="" @endif>
														<label for="FORCE_SSL" class="toggle-class onoffswitch2-label" ></label>
													</a>
													<label class="form-label ps-3 ps-md-max-0">{{trans('langconvert.admindashboard.enableforcessl')}}</label>
													<small class="text-muted ps-2 ps-md-max-0"><i>{{trans('langconvert.admindashboard.enableforcesslcontent')}}</i></small>
												</div>
											</div>

											<div class="switch_section">
												<div class="switch-toggle d-flex d-md-max-block mt-4">
													<a class="onoffswitch2">
														<input type="checkbox" name="KNOWLEDGE_ENABLE" id="myonoffswitch12" class=" toggle-class onoffswitch2-checkbox enablemenus" value="yes" @if(setting('KNOWLEDGE_ENABLE') == 'yes') checked="" @endif>
														<label for="myonoffswitch12" class="toggle-class onoffswitch2-label" ></label>
													</a>
													<label class="form-label ps-3 ps-md-max-0">{{trans('langconvert.admindashboard.enableknowledge')}}</label>
													<small class="text-muted ps-2 ps-md-max-0"><i>{{trans('langconvert.admindashboard.enableknowledgecontent')}}</i></small>
												</div>
											</div>
											<div class="switch_section">
												<div class="switch-toggle d-flex d-md-max-block mt-4">
													<a class="onoffswitch2">
														<input type="checkbox" name="FAQ_ENABLE" id="faqs" class=" toggle-class onoffswitch2-checkbox enablemenus" value="yes" @if(setting('FAQ_ENABLE') == 'yes') checked="" @endif>
														<label for="faqs" class="toggle-class onoffswitch2-label" ></label>
													</a>
													<label class="form-label ps-3 ps-md-max-0">{{trans('langconvert.admindashboard.enablefaq')}}</label>
													<small class="text-muted ps-2 ps-md-max-0"><i>{{trans('langconvert.admindashboard.enablefaqcontent')}}</i></small>
												</div>
											</div>
											<div class="switch_section">
												<div class="switch-toggle d-flex d-md-max-block mt-4">
													<a class="onoffswitch2">
														<input type="checkbox" name="CONTACT_ENABLE" id="contact" class=" toggle-class onoffswitch2-checkbox enablemenus" value="yes" @if(setting('CONTACT_ENABLE') == 'yes') checked="" @endif>
														<label for="contact" class="toggle-class onoffswitch2-label" ></label>
													</a>
													<label class="form-label ps-3 ps-md-max-0">{{trans('langconvert.admindashboard.enablecontact')}}</label>
													<small class="text-muted ps-2 ps-md-max-0"><i>{{trans('langconvert.admindashboard.enablecontactcontent')}}</i></small>
												</div>
											</div>
											<div class="switch_section">
												<div class="switch-toggle d-flex d-md-max-block mt-4">
													
													<a class="onoffswitch2">
														<input type="checkbox" name="PROFILE_USER_ENABLE" id="myonoffswitch123" class=" toggle-class onoffswitch2-checkbox" value="yes" @if(setting('PROFILE_USER_ENABLE') == 'yes') checked="" @endif>
														<label for="myonoffswitch123" class="toggle-class onoffswitch2-label" ></label>
													</a>
													<label class="form-label ps-3 ps-md-max-0">{{trans('langconvert.admindashboard.enableimageupload')}}</label>
													<small class="text-muted ps-2 ps-md-max-0"><i>{{trans('langconvert.admindashboard.enableimageuploadcontent')}}</i></small>
												</div>

											</div>

											<div class="switch_section">
												<div class="switch-toggle d-flex d-md-max-block mt-4">
													
													<a class="onoffswitch2">
														<input type="checkbox" name="envato_on" id="envato_on" class=" toggle-class onoffswitch2-checkbox sprukoregister" value="yes" @if(setting('ENVATO_ON') == 'on') checked="" @endif>
														<label for="envato_on" class="toggle-class onoffswitch2-label" ></label>
													</a>
													<label class="form-label ps-3 ps-md-max-0">{{trans('uhelpupdate::langconvert.admindashboard.envato_on')}}</label>
													<small class="text-muted ps-2 ps-md-max-0"><i>{{trans('uhelpupdate::langconvert.admindashboard.envato_on_content')}}</i></small>
												</div>

											</div>

											<div class="switch_section">
												<div class="switch-toggle d-flex d-md-max-block mt-4">
													
													<a class="onoffswitch2">
														<input type="checkbox" name="ENVATO_EXPIRED_BLOCK" id="envato_expired_on" class=" toggle-class onoffswitch2-checkbox sprukoregister" value="yes" @if(setting('ENVATO_EXPIRED_BLOCK') == 'on') checked="" @endif>
														<label for="envato_expired_on" class="toggle-class onoffswitch2-label" ></label>
													</a>
													<label class="form-label ps-3 ps-md-max-0">{{trans('uhelpupdate::langconvert.admindashboard.envato_expired_on')}}</label>
													<small class="text-muted ps-2 ps-md-max-0"><i>{{trans('uhelpupdate::langconvert.admindashboard.envato_expired_on_content')}}</i></small>
												</div>

											</div>

											<div class="switch_section">
												<div class="switch-toggle d-flex d-md-max-block mt-4">
													
													<a class="onoffswitch2">
														<input type="checkbox" name="purchasecode_on" id="purchasecode_on" class=" toggle-class onoffswitch2-checkbox sprukoregister" value="yes" @if(setting('purchasecode_on') == 'on') checked="" @endif>
														<label for="purchasecode_on" class="toggle-class onoffswitch2-label" ></label>
													</a>
													<label class="form-label ps-3 ps-md-max-0">{{trans('langconvert.newwordslang.purchasecode_on')}}</label>
													<small class="text-muted ps-2 ps-md-max-0"><i>{{trans('langconvert.newwordslang.purchasecode_on_content')}}</i></small>
												</div>

											</div>

											<div class="switch_section">
												<div class="switch-toggle d-flex d-md-max-block mt-4">
													<a class="onoffswitch2">
														<input type="checkbox" name="defaultlogin_on" id="defaultlogin_on" class=" toggle-class onoffswitch2-checkbox sprukoregister" value="yes" @if(setting('defaultlogin_on') == 'on') checked="" @endif>
														<label for="defaultlogin_on" class="toggle-class onoffswitch2-label" ></label>
													</a>
													<label class="form-label ps-3 ps-md-max-0">{{trans('langconvert.newwordslang.defaultlogin_on')}}</label>
													<small class="text-muted ps-2 ps-md-max-0"><i>{{trans('langconvert.newwordslang.defaultlogin_on_content')}}</i></small>
												</div>
											</div>
										</div>
									</div>
								</div>
								<!-- End switches-->
								
								<!-- Footer Copyright Text -->
								<div class="col-xl-12 col-lg-12 col-md-12">
									<div class="card ">
										<div class="card-header border-0">
											<h4 class="card-title">{{trans('langconvert.admindashboard.footercopyright')}}</h4>
										</div>
										<form method="POST" action="{{url('admin/footer/' )}}" enctype="multipart/form-data">
											@csrf

											@honeypot
											<input type="hidden" name="id" value="1">

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
													<input type="submit" class="btn btn-secondary" value="{{trans('langconvert.admindashboard.savechanges')}}" onclick="this.disabled=true;this.form.submit();">
												</div>
											</div>
										</form>	
									</div>
								</div>
								<!-- Footer Copyright Text -->
							</div>

							@endsection

		@section('scripts')

		
		<!-- INTERNAL Summernote js  -->
		<script src="{{asset('assets/plugins/summernote/summernote.js')}}?v=<?php echo time(); ?>"></script>

		<!-- INTERNAL Index js-->
		<script src="{{asset('assets/js/support/support-sidemenu.js')}}?v=<?php echo time(); ?>"></script>
		<script src="{{asset('assets/js/select2.js')}}?v=<?php echo time(); ?>"></script>

		<!-- INTERNAL color pickr -->
		<script src="{{ asset('assets/plugins/colorpickr/pickr.min.js') }}?v=<?php echo time(); ?>"></script>

		<!-- INTERNAL Sweet-Alert js-->
		<script src="{{asset('assets/plugins/sweet-alert/sweetalert.min.js')}}?v=<?php echo time(); ?>"></script>



		<script type="text/javascript">

			"use strict";

			(() => {

				//  color pickr code
				// Simple example, see optional options for more configuration.
				window.setColorPicker = (elem, defaultValue) => {
					elem = document.querySelector(elem);
					let pickr = Pickr.create({
						el: elem,
						default: defaultValue,
						theme: 'nano', // or 'monolith', or 'nano'
						useAsButton: true,
						swatches: [
							'#217ff3',
							'#11cdef',
							'#fb6340',
							'#f5365c',
							'#f7fafc',
							'#212529',
							'#2dce89'
						],
						components: {
							// Main components
							preview: true,
							opacity: true,
							hue: true,
							// Input / output Options
							interaction: {
								hex: true,
								rgba: true,
								// hsla: true,
								// hsva: true,
								// cmyk: true,
								input: true,
								clear: true,
								silent: true,
								preview: true,
							}
						}
					});
					pickr.on('init', pickr => {
						elem.value = pickr.getSelectedColor().toRGBA().toString(0);
					}).on('change', color => {
						elem.value = color.toRGBA().toString(0);
					});

					return pickr;

				}

				// Color Pickr variables
				let themeColor = setColorPicker('#theme_color-input', document.querySelector('#theme_color-input').value);
				let themeColorDark = setColorPicker('#theme_color_dark-input', document.querySelector('#theme_color_dark-input').value);

				// Csrf Field
				$.ajaxSetup({
					headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					}
				});

				// summernote js
				$('.summernote').summernote({
					placeholder: '',
					tabsize: 1,
					height: 200
				});

				// Multiple switch changes
				$('.sprukoregister').on('change', function() {
					var status = $('#myonoffswitch1').prop('checked') == true ? 'yes' : 'no';
					var registerdisable = $('#REGISTER_DISABLE').prop('checked') == true ? 'off' : 'on';
					var googledisable = $('#GOOGLEFONT_DISABLE').prop('checked') == true ? 'on' : 'off';
					var forcessl = $('#FORCE_SSL').prop('checked') == true ? 'on' : 'off';
					var darkmode = $('#darkmode').prop('checked') == true ? '1' : '0';
					var sprukoadminp = $('#sprukoadminp').prop('checked') == true ? 'on' : 'off';
					var sprukocustp = $('#sprukoadminc').prop('checked') == true ? 'on' : 'off';
					var envatoon = $('#envato_on').prop('checked') == true ? 'on' : 'off';
					var envatoexpiredon = $('#envato_expired_on').prop('checked') == true ? 'on' : 'off';
					var purchasecodeon = $('#purchasecode_on').prop('checked') == true ? 'on' : 'off';
					var defaultloginon = $('#defaultlogin_on').prop('checked') == true ? 'on' : 'off';
					$.ajax({
						type: "GET",
						dataType: "json",
						url: '{{url('/admin/general/register')}}',
						data: {
							'status': status,
							'registerdisable' : registerdisable,
							'googledisable' : googledisable,
							'forcessl' : forcessl,
							'darkmode' : darkmode,
							'sprukoadminp' : sprukoadminp,
							'sprukocustp' : sprukocustp,
							'envatoon' : envatoon,
							'envatoexpiredon' : envatoexpiredon,
							'purchasecodeon' : purchasecodeon,
							'defaultloginon' : defaultloginon,
						},
						success: function(data){
							toastr.success('{{trans('langconvert.functions.updatecommon')}}')
							window.location.reload();
						}
					});
				});

				// Enable Menus
				$('.enablemenus').on('change', function() {
					var status = $('#myonoffswitch12').prop('checked') == true ? 'yes' : 'no';
					var status1 = $('#faqs').prop('checked') == true ? 'yes' : 'no';
					var status2 = $('#contact').prop('checked') == true ? 'yes' : 'no';
					$.ajax({
						type: "post",
						dataType: "json",
						url: '{{url('/admin/knowledge')}}',
						data: {
							'KNOWLEDGE_ENABLE': status,
							'FAQ_ENABLE': status1,
							'CONTACT_ENABLE': status2,
						},
						success: function(data){
							if(toastr.success('{{trans('langconvert.functions.updatecommon')}}')){
								location.reload();
							}
						},
						error: function(data){
							console.log(data);
						}
					});
				});

				// user profile enable
				$('#myonoffswitch123').on('change', function() {
					var status1 = $('#myonoffswitch123').prop('checked') == true ? 'yes' : 'no';
					$.ajax({
						type: "post",
						dataType: "json",
						url: '{{url('/admin/profileuser')}}',
						data: {'PROFILE_USER_ENABLE': status1},
						success: function(data){
							if(toastr.success('{{trans('langconvert.functions.updatecommon')}}')){
								location.reload();
							}
						},
						error: function(data){
							console.log(data);
						}
					});
				});

				// employye profile enable
				$('#myonoffswitch124').on('change', function() {
					var status2 = $('#myonoffswitch124').prop('checked') == true ? 'yes' : 'no';
					$.ajax({
						type: "post",
						dataType: "json",
						url: '{{url('/admin/profileagent')}}',
						data: {'PROFILE_AGENT_ENABLE': status2},
						success: function(data){
							if(toastr.success('{{trans('langconvert.functions.updatecommon')}}')){
								location.reload();
							}
						},
						error: function(data){
							console.log(data);
						}
					});
				});

				// Logos Delete
				$('body').on('click', '.logosdelete', function(e){
					e.preventDefault();
					let id = $(this).data('id');
					let logo = $(this).val();
					swal({
						title: `{{trans('langconvert.newwordslang.logoimageremove')}}`,
						icon: "warning",
						buttons: true,
						dangerMode: true,
					})
					.then((willDelete) => {
					if (willDelete) {
							$.ajax({
								type: "post",
								url: "{{route('admin.logodelete')}}",
								data: {
									'id': id,
									'logo': logo

								},
								success: function (data) {
								toastr.success(data.success);
								location.reload();
								},
								error: function (data) {
								console.log('Error:', data);
								}
							});
						}
					});
				});
				
			})();

			
		</script>

		
		
		@endsection
