
@extends('layouts.adminmaster')

							@section('content')

							<!--Page header-->
							<div class="page-header d-xl-flex d-block">
								<div class="page-leftheader">
									<h4 class="page-title"><span class="font-weight-normal text-muted ms-2">{{trans('langconvert.adminmenu.emailtoticket')}}</span></h4>
								</div>
							</div>
							<!--End Page header-->

							<!--Email to Tickets-->
							<div class="col-xl-12 col-lg-12 col-md-12">
								<div class="card ">
									<form action="{{route('admin.emaitickets')}}" method="POST">
										<div class="card-header border-0">
											<h4 class="card-title">{{trans('langconvert.adminmenu.emailtoticket')}}</h4>
											<div class="card-options">
												<div class="form-group mb-0">
													<div class="switch_section m-0">
														<div class="switch-toggle d-flex mx-0 ps-0 mt-sm-0 mt-2">
															<a class="onoffswitch2">
																<input type="checkbox" id="myonoffswitch18" name="IMAP_STATUS" class=" toggle-class onoffswitch2-checkbox" value="on" @if(setting('IMAP_STATUS') == 'on') checked @endif>
																<label for="myonoffswitch18" class="toggle-class onoffswitch2-label"></label>
															</a>
															<label class="form-label ps-3">{{trans('langconvert.admindashboard.enableemailtotickets')}}</label>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="card-body" >
											@csrf
												
											<div class="row">
												<div class="col-sm-12 col-md-12">
													
												</div>
												<div class="col-sm-12 col-md-12">
													<div class="form-group">
														<label class="form-label">{{trans('langconvert.admindashboard.imaphost')}} <span class="text-red">*</span></label>
														<input type="text" class="form-control @error('imap_host') is-invalid @enderror" name="imap_host" Value="{{ old('IMAP_HOST', setting('IMAP_HOST')) }}">
														@error('imap_host')

															<span class="invalid-feedback" role="alert">
																<strong>{{ $message }}</strong>
															</span>
														@enderror

													</div>
												</div>
												<div class="col-sm-12 col-md-12">
													<div class="form-group">
														<label class="form-label">{{trans('langconvert.admindashboard.imapport')}} <span class="text-red">*</span></label>
														<input type="text" class="form-control @error('imap_port') is-invalid @enderror" name="imap_port" Value="{{ old('IMAP_PORT', setting('IMAP_PORT')) }}">
														@error('imap_port')

															<span class="invalid-feedback" role="alert">
																<strong>{{ $message }}</strong>
															</span>
														@enderror

													</div>
												</div>
												<div class="col-sm-12 col-md-12">
													<div class="form-group">
														<label class="form-label">{{trans('langconvert.admindashboard.imapencryption')}} <span class="text-red">*</span></label>
														<input type="text" class="form-control @error('imap_encryption') is-invalid @enderror" name="imap_encryption" Value="{{ old('IMAP_ENCRYPTION', setting('IMAP_ENCRYPTION')) }}">
														@error('imap_encryption')

															<span class="invalid-feedback" role="alert">
																<strong>{{ $message }}</strong>
															</span>
														@enderror

													</div>
												</div>
												<div class="col-sm-12 col-md-12">
													<div class="form-group">
														<label class="form-label">{{trans('langconvert.admindashboard.imapprotocol')}} <span class="text-red">*</span></label>
														<input type="text" class="form-control @error('imap_protocol') is-invalid @enderror" name="imap_protocol" Value="{{ old('IMAP_PROTOCOL', setting('IMAP_PROTOCOL')) }}">
														@error('imap_protocol')

															<span class="invalid-feedback" role="alert">
																<strong>{{ $message }}</strong>
															</span>
														@enderror

													</div>
												</div>
												<div class="col-sm-12 col-md-12">
													<div class="form-group">
														<label class="form-label">{{trans('langconvert.admindashboard.imapusername')}} <span class="text-red">*</span></label>
														<input type="text" class="form-control @error('imap_username') is-invalid @enderror" name="imap_username" Value="{{ old('IMAP_USERNAME', setting('IMAP_USERNAME')) }}">
														@error('imap_username')

															<span class="invalid-feedback" role="alert">
																<strong>{{ $message }}</strong>
															</span>
														@enderror

													</div>
												</div>
												<div class="col-sm-12 col-md-12">
													<div class="form-group">
														<label class="form-label">{{trans('langconvert.admindashboard.imappassword')}} <span class="text-red">*</span></label>
														<input type="password" class="form-control @error('imap_password') is-invalid @enderror" name="imap_password" Value="{{ old('IMAP_PASSWORD', setting('IMAP_PASSWORD')) }}">
														@error('imap_password')

															<span class="invalid-feedback" role="alert">
																<strong>{{ $message }}</strong>
															</span>
														@enderror

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
							<!-- End Email to Tickets-->
							@endsection

