@extends('layouts.adminmaster')

							@section('content')

							<!--Page header-->
							<div class="page-header d-xl-flex d-block">
								<div class="page-leftheader">
									<h4 class="page-title"><span class="font-weight-normal text-muted ms-2">Social Login</span></h4>
								</div>
							</div>
							<!--End Page header-->

							<!-- Row -->
							<div class="row">
								<div class="col-md-12">
									<div class="card overflow-hidden">
										<div class="card-body p-0">
											<div class="border-bottom">
												<ul class="nav-settings settings-menu nav nav-pills d-lg-none d-sm-flex d-block p-3">
													<li class="nav-item">
														<a class="nav-link active" data-bs-toggle="tab" href="#envato">
															<span class="nav-setting-icon"><svg class="env-icon" style="enable-background:new 0 0 512 512; width: 14px; height: 14px;" version="1.1" viewBox="0 0 512 512" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g id="_x38_5-envato"><g><g><g><path d="M401.225,19.381c-17.059-8.406-103.613,1.196-166.01,61.218      c-98.304,98.418-95.947,228.089-95.947,228.089s-3.248,13.335-17.086-6.011c-30.305-38.727-14.438-127.817-12.651-140.23      c2.508-17.494-8.615-17.999-13.243-12.229c-109.514,152.46-10.616,277.288,54.136,316.912c75.817,46.386,225.358,46.354,284.922-85.231C509.547,218.042,422.609,29.875,401.225,19.381L401.225,19.381z M401.225,19.381"></path></g></g></g></g><g id="Layer_1"></g></svg></span>
															<span class="nav-setting-txt">Envato</span>
														</a>
													</li>
													<li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#google"><span class="nav-setting-icon"><i class="fa fa-google"></i></span> <span class="nav-setting-txt">Google</span></a></li>
													<li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#facebook"><span class="nav-setting-icon"><i class="fa fa-facebook-f me-1"></i></span> <span class="nav-setting-txt">Facebook</span></a></li>
													<li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#twitter"><span class="nav-setting-icon"><i class="fa fa-twitter"></i></span> <span class="nav-setting-txt">Twitter</span></a></li>
												</ul>
											</div>
											<form method="POST" action="{{ route('settings.sociallogin.update') }}" enctype="multipart/form-data">
												@csrf
			
												@honeypot
											<div class="d-lg-flex main-settings-layout">
												
												<div class="border-end mn-wd-20p d-lg-block d-none">
													<ul class="nav nav-pills nav-settings p-3">
														<li class="nav-item">
															<a class="nav-link active" data-bs-toggle="tab" href="#envato">
																<span class="nav-setting-icon"><svg class="env-icon" style="enable-background:new 0 0 512 512; width: 14px; height: 14px;" version="1.1" viewBox="0 0 512 512" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g id="_x38_5-envato"><g><g><g><path d="M401.225,19.381c-17.059-8.406-103.613,1.196-166.01,61.218      c-98.304,98.418-95.947,228.089-95.947,228.089s-3.248,13.335-17.086-6.011c-30.305-38.727-14.438-127.817-12.651-140.23      c2.508-17.494-8.615-17.999-13.243-12.229c-109.514,152.46-10.616,277.288,54.136,316.912c75.817,46.386,225.358,46.354,284.922-85.231C509.547,218.042,422.609,29.875,401.225,19.381L401.225,19.381z M401.225,19.381"></path></g></g></g></g><g id="Layer_1"></g></svg></span>
																<span class="nav-setting-txt">Envato</span>
															</a>
														</li>
														<li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#google"><span class="nav-setting-icon"><i class="fa fa-google"></i></span> <span class="nav-setting-txt">Google</span></a></li>
														<li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#facebook"><span class="nav-setting-icon"><i class="fa fa-facebook-f me-1"></i></span> <span class="nav-setting-txt">Facebook</span></a></li>
														<li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#twitter"><span class="nav-setting-icon"><i class="fa fa-twitter"></i></span> <span class="nav-setting-txt">Twitter</span></a></li>
													</ul>
												</div>
												<div class="flex-1">
													<div class="tab-content">


														<div class="tab-pane active" id="envato">
															<div class="px-5 py-4 border-bottom d-flex align-items-center">
																<h5 class="mb-0">Envato Settings</h5>
																<div class="ms-auto">
																	<div class="switch_section p-0 m-0">
																		<div class="switch-toggle float-end d-flex">
																			<a class="onoffswitch2 switch-lg">
																				<input type="checkbox" id="myonoffswitch18789" name="envato_status" class=" toggle-class onoffswitch2-checkbox" @if($credentials->envato_status == 'enable') checked @endif>
																				<label for="myonoffswitch18789" class="mb-0 toggle-class onoffswitch2-label"></label>
																			</a>
																		</div>
																	</div>
																</div>
															</div>
															<div class="p-5 main-settings-content" id="envatoSettings">
																<div class="form-group ">
																	<label class="form-label">Envato App ID</label>
																	<input type="text" name="envato_client_id" id="envato_client_id" class="form-control  @error('envato_client_id') is-invalid @enderror" value="{{ $credentials->envato_client_id }}">
																	@error('envato_client_id')
	
																		<span class="invalid-feedback" role="alert">
																			<strong>{{ $message }}</strong>
																		</span>
																	@enderror
	
																</div>
																<div class="form-group ">
																	<label class="form-label">Envato Secret</label>
																	<input type="password" name="envato_secret_id" id="envato_secret_id" class="form-control  @error('envato_secret_id') is-invalid @enderror" value="{{ $credentials->envato_secret_id }}" autocomplete="new-password">
																	@error('envato_secret_id')
	
																		<span class="invalid-feedback" role="alert">
																			<strong>{{ $message }}</strong>
																		</span>
																	@enderror
	
																</div>
																<div class="form-group">
																	<label>Callback/Redirect URL</label>
																	<p class="text-bold p-2 bg-light br-7 mb-1">{{ route('social.login-callback', 'envato') }}</p>
																	<small class="text-muted"><i>{{trans('langconvert.admindashboard.envatologinconrent')}}</i></small>
																</div>
															</div>
															<div class="px-5 py-4 mt-auto border-top">
																<div class="text-end btn-list">
																	<input type="submit" class="btn btn-secondary" value="{{trans('langconvert.admindashboard.savechanges')}}" onclick="this.disabled=true;this.form.submit();">
																</div>
															</div>
														</div>
														<div class="tab-pane" id="google">
															<div class="px-5 py-4 border-bottom d-flex align-items-center">
																<h5 class="mb-0">Google Settings</h5>
																<div class="ms-auto">
																	<div class="switch_section p-0 m-0">
																		<div class="switch-toggle float-end d-flex">
																			<a class="onoffswitch2 switch-lg">
																				<input type="checkbox" id="myonoffswitch18" name="google" class=" toggle-class onoffswitch2-checkbox">
																				<label for="myonoffswitch18" class="mb-0 toggle-class onoffswitch2-label switch-lg-label"></label>
																			</a>
																		</div>
																	</div>
																</div>
															</div>	
															<div class="p-5 main-settings-content" id="googleSettings">
																
																<div class="form-group ">
																	<label class="form-label">Google App ID</label>
																	<input type="text" name="google_client_id" id="google_client_id" class="form-control  @error('google_client_id') is-invalid @enderror" value="{{ $credentials->google_client_id }}">
																	@error('google_client_id')
	
																		<span class="invalid-feedback" role="alert">
																			<strong>{{ $message }}</strong>
																		</span>
																	@enderror
	
																</div>
																<div class="form-group ">
																	<label class="form-label">Google Secret</label>
																	<input type="password" name="google_secret_id" id="google_secret_id" class="form-control  @error('facebook_client_id') is-invalid @enderror" value="{{ $credentials->google_secret_id }}" autocomplete="new-password">
																	@error('google_secret_id')
	
																		<span class="invalid-feedback" role="alert">
																			<strong>{{ $message }}</strong>
																		</span>
																	@enderror
	
																</div>
																<div class="form-group">
																	<label>Callback/Redirect URL</label>
																	<p class="text-bold p-2 bg-light br-7 mb-1">{{ route('social.login-callback', 'google') }}</p>
																	<small class="text-muted"><i>{{trans('langconvert.admindashboard.googleloginconrent')}}</i></small>
																</div>
															</div>
															<div class="px-5 py-4 mt-auto border-top">
																<div class="text-end btn-list">
																	<input type="submit" class="btn btn-secondary" value="{{trans('langconvert.admindashboard.savechanges')}}" onclick="this.disabled=true;this.form.submit();">
																</div>
															</div>
														</div>
														<div class="tab-pane" id="facebook">
															<div class="px-5 py-4 border-bottom d-flex align-items-center">
																<h5 class="mb-0">Facebook Settings</h5>
																<div class="ms-auto">
																	<div class="switch_section p-0 m-0">
																		<div class="switch-toggle d-flex float-end">
																			<a class="onoffswitch2 switch-lg">
																				<input type="checkbox" id="myonoffswitch19" name="facebook_status"  class=" toggle-class onoffswitch2-checkbox">
																				<label for="myonoffswitch19" class="mb-0 toggle-class onoffswitch2-label switch-lg-label" ></label>
																			</a>
																		</div>
																	</div>
																</div>
															</div>
															<div class="p-5 main-settings-content" id="facebookSettings">
																<div class="form-group ">
																	<label class="form-label">Facebook App ID</label>
																	<input type="text" name="facebook_client_id" id="facebook_client_id" class="form-control @error('facebook_client_id') is-invalid @enderror" value="{{ $credentials->facebook_client_id }}">
																	@error('facebook_client_id')
	
																		<span class="invalid-feedback" role="alert">
																			<strong>{{ $message }}</strong>
																		</span>
																	@enderror
	
																</div>
																<div class="form-group ">
																	<label class="form-label">Facebook Secret</label>
																	<input type="password" name="facebook_secret_id" id="facebook_secret_id" class="form-control @error('facebook_secret_id') is-invalid @enderror" value="{{ $credentials->facebook_secret_id }}" autocomplete="new-password">
																	@error('facebook_secret_id')
	
																		<span class="invalid-feedback" role="alert">
																			<strong>{{ $message }}</strong>
																		</span>
																	@enderror
	
																</div>
																<div class="form-group">
																	<label>Callback/Redirect URL</label>
																	<p class="text-bold p-2 bg-light br-7 mb-1">{{ route('social.login-callback', 'facebook') }}</p>
																	<small class="text-muted"><i>{{trans('langconvert.admindashboard.facebookloginconrent')}}</i></small>
																</div>
															</div>
															<div class="px-5 py-4 mt-auto border-top">
																<div class="text-end btn-list">
																	<input type="submit" class="btn btn-secondary" value="{{trans('langconvert.admindashboard.savechanges')}}" onclick="this.disabled=true;this.form.submit();">
																</div>
															</div>
														</div>
														<div class="tab-pane" id="twitter">
															<div class="px-5 py-4 border-bottom d-flex align-items-center">
																<h5 class="mb-0">Twitter Settings</h5>
																<div class="ms-auto">
																	<div class="switch_section p-0 m-0">
																		<div class="switch-toggle d-flex float-end">
																			<a class="onoffswitch2 switch-lg">
																				<input type="checkbox" id="myonoffswitch20" name="twitter_status"  class=" toggle-class onoffswitch2-checkbox">
																				<label for="myonoffswitch20" class="mb-0 toggle-class onoffswitch2-label switch-lg-label"></label>
																			</a>
																		</div>
																	</div>
																</div>
															</div>
															<div class="p-5 main-settings-content" id="twitterSettings">
																<div class="form-group ">
																	<label class="form-label">Twitter App ID</label>
																	<input type="text" name="twitter_client_id" id="twitter_client_id" class="form-control @error('twitter_client_id') is-invalid @enderror" value="{{ $credentials->twitter_client_id }}">
																	@error('twitter_client_id')
	
																		<span class="invalid-feedback" role="alert">
																			<strong>{{ $message }}</strong>
																		</span>
																	@enderror
																	
																</div>
																<div class="form-group ">
																	<label class="form-label">Twitter Secret</label>
																	<input type="password" name="twitter_secret_id" id="twitter_secret_id" class="form-control @error('twitter_secret_id') is-invalid @enderror" value="{{ $credentials->twitter_secret_id }}" autocomplete="new-password">
																	@error('twitter_secret_id')
																		<span class="invalid-feedback" role="alert">
																			<strong>{{ $message }}</strong>
																		</span>
																	@enderror
																</div>
																<div class="form-group">
																	<label>Callback/Redirect URL</label>
																	<p class="text-bold p-2 bg-light br-7 mb-1">{{ route('social.login-callback', 'twitter') }}</p>
																	<small class="text-muted"><i>{{trans('langconvert.admindashboard.twitterloginconrent')}}</i></small>
																</div>
															</div>
															<div class="px-5 py-4 mt-auto border-top">
																<div class="text-end btn-list">
																	<input type="submit" class="btn btn-secondary" value="{{trans('langconvert.admindashboard.savechanges')}}" onclick="this.disabled=true;this.form.submit();">
																</div>
															</div>
														</div>

													</div>
												</div>
											</div>
											</form>
										</div>
									</div>
								</div>
							</div>
							<!--/ row -->


							@endsection


