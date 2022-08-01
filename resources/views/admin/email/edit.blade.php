
@extends('layouts.adminmaster')

		@section('styles')

		<!-- INTERNAl Summernote css -->
		<link rel="stylesheet" href="{{asset('assets/plugins/summernote/summernote.css')}}?v=<?php echo time(); ?>">
		@endsection

							@section('content')

							<!--Page header-->
							<div class="page-header d-xl-flex d-block">
								<div class="page-leftheader">
									<h4 class="page-title"><span class="font-weight-normal text-muted ms-2">{{trans('langconvert.adminmenu.emailtemplate')}}</span></h4>
								</div>
							</div>
							<!--End Page header-->

							<!-- Email Template Edit -->
							<div class="col-xl-12 col-lg-12 col-md-12">
								<div class="card ">
									<div class="card-header border-0">
										<h4 class="card-title">{{trans('langconvert.adminmenu.emailtemplate')}}</h4>
									</div>
									<div class="card-body" >
										<form method="POST" action="{{ route('settings.email.update', [$template->id]) }}" enctype="multipart/form-data">
											@csrf

											@honeypot
											<div class="row">
												<div class="col-sm-12 col-md-12">
													<div class="form-group">
														<label class="form-label">{{trans('langconvert.admindashboard.emailsub')}} <span class="text-red">*</span></label>
														<input type="text" class="form-control @error('subject') is-invalid @enderror" name="subject" Value="{{ old('subject', $template->subject) }}">
														@error('subject')

															<span class="invalid-feedback" role="alert">
																<strong>{{ $message }}</strong>
															</span>
														@enderror

													</div>
												</div>
												<div class="col-sm-12 col-md-12">
													<div class="form-group">
														<label class="form-label">{{trans('langconvert.admindashboard.emailbody')}} <span class="text-red">*</span></label>
														<textarea class="form-control summernote @error('body') is-invalid @enderror" placeholder="FAQ Answer" name="body" id="answer" aria-multiline="true">
															{{ old('body', $template->body) }}
														</textarea>
														@error('body')

															<span class="invalid-feedback" role="alert">
																<strong>{{ $message }}</strong>
															</span>
														@enderror

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
							<!-- Email Template Edit -->
							@endsection
		@section('scripts')

		<!-- INTERNAL Summernote js  -->
		<script src="{{asset('assets/plugins/summernote/summernote.js')}}"></script>

		<!-- INTERNAL Index js-->
		<script src="{{asset('assets/js/support/support-sidemenu.js')}}"></script>
        <script src="{{asset('assets/js/support/support-createticket.js')}}"></script>

		@endsection
