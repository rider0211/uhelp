
@extends('layouts.adminmaster')

		@section('styles')

		<!-- INTERNAl Tag css -->
		<link href="{{asset('assets/plugins/taginput/bootstrap-tagsinput.css')}}?v=<?php echo time(); ?>" rel="stylesheet" />

		@endsection


							@section('content')

							<!--Page header-->
							<div class="page-header d-xl-flex d-block">
								<div class="page-leftheader">
									<h4 class="page-title"><span class="font-weight-normal text-muted ms-2">{{trans('langconvert.adminmenu.ticketsetting')}}</span></h4>
								</div>
							</div>
							<!--End Page header-->


							<!-- Ticket Settings-->
							<div class="col-xl-12 col-lg-12 col-md-12">
								<div class="card ">
									<div class="card-header border-0">
										<h4 class="card-title">{{trans('langconvert.adminmenu.ticketsetting')}}</h4>
									</div>
									<form method="POST" action="{{ route('settings.ticket.store') }}" enctype="multipart/form-data">
										<div class="card-body" >
											@csrf

											@honeypot
											<div class="row">
												<!---RE-OPEN TICKET--->
												<div class="border-bottom">
													<div class="col-sm-12 col-md-12">
														<div class="form-group {{ $errors->has('USER_REOPEN_ISSUE') ? ' has-danger' : '' }}">
															<div class="switch_section">
																<div class="switch-toggle d-flex mt-4">
																	<a class="onoffswitch2">
																		<input type="checkbox" id="myonoffswitch18" name="USER_REOPEN_ISSUE" value="yes"  class=" toggle-class onoffswitch2-checkbox"  @if(setting('USER_REOPEN_ISSUE') == 'yes') checked="" @endif>
																		<label for="myonoffswitch18" class="toggle-class onoffswitch2-label" ></label>
																	</a>
																	<div class="ps-3">
																		<label class="form-label">{{trans('langconvert.admindashboard.customerreopenticket')}}</label>
																		<small class="text-muted ">
																			<i>{{trans('langconvert.admindashboard.customerreopenticketcontent')}}</i></small>
																	</div>
																</div>
															</div>
															@if ($errors->has('USER_REOPEN_ISSUE'))

																<span class="invalid-feedback" role="alert">
																	<strong>{{ $errors->first('USER_REOPEN_ISSUE') }}</strong>
																</span>
															@endif

														</div>
													</div>
													<div class="col-sm-12 col-md-12 ms-7 ps-3 ">
														<div class="form-group d-flex d-md-max-block {{ $errors->has('userreopentime') ? ' is-invalid' : '' }}">
															<input type="number" maxlength="2" class="form-control wd-5 w-lg-max-30 ms-2 "  name="userreopentime"  value="{{old('userreopentime', setting('USER_REOPEN_TIME')) }}">
															<label class="form-label mt-2 ms-2">{{trans('langconvert.admindashboard.reopendays')}}</label>
														</div>
														@if ($errors->has('userreopentime'))

															<span class="invalid-feedback" role="alert">
																<strong>{{ $errors->first('userreopentime') }}</strong>
															</span>
														@endif

													</div>
												</div>
												<!---END RE-OPEN TICKET--->
												<!---AUTO CLOSE TICKET--->
												<div class="border-bottom">
													<div class="col-sm-12 col-md-12">
														<div class="form-group {{ $errors->has('AUTO_CLOSE_TICKET') ? ' has-danger' : '' }}">
															<div class="switch_section">
																<div class="switch-toggle d-flex mt-4">
																	<a class="onoffswitch2">
																		<input type="checkbox" id="myonoffswitch1" name="AUTO_CLOSE_TICKET" value="yes"  class=" toggle-class onoffswitch2-checkbox"  @if(setting('AUTO_CLOSE_TICKET') == 'yes') checked="" @endif>
																		<label for="myonoffswitch1" class="toggle-class onoffswitch2-label" ></label>
																	</a>
																	<div class="ps-3">
																	<label class="form-label">{{trans('langconvert.admindashboard.autocloseticket')}}</label>
																	<small class="text-muted ">
																		<i>{{trans('langconvert.admindashboard.autocloseticketcontent')}}</i></small>
																</div>
																</div>
															</div>
															@if ($errors->has('AUTO_CLOSE_TICKET'))

																<span class="invalid-feedback" role="alert">
																	<strong>{{ $errors->first('AUTO_CLOSE_TICKET') }}</strong>
																</span>
															@endif

														</div>
													</div>
													
													<div class="col-sm-12 col-md-12 ms-7">
														<div class="form-group d-flex d-md-max-block {{ $errors->has('autoclosetickettime') ? ' is-invalid' : '' }}">
															<input type="number" maxlength="2" class="form-control wd-5 w-lg-max-30 ms-2"  name="autoclosetickettime"  value="{{old('autoclosetickettime', setting('AUTO_CLOSE_TICKET_TIME')) }}">
															<label class="form-label  mt-2 ms-2">{{trans('langconvert.admindashboard.autoclosedays')}}</label>
														</div>
														@if ($errors->has('autoclosetickettime'))

															<span class="invalid-feedback" role="alert">
																<strong>{{ $errors->first('autoclosetickettime') }}</strong>
															</span>
														@endif
													</div>
												</div>
												<!--- END AUTO CLOSE TICKET--->
												<!---AUTO OVERDUE TICKET--->
												<div class="border-bottom">
													<div class="col-sm-12 col-md-12">
														<div class="form-group {{ $errors->has('AUTO_OVERDUE_TICKET') ? ' has-danger' : '' }}">
															<div class="switch_section">
																<div class="switch-toggle d-flex mt-4">
																	<a class="onoffswitch2">
																		<input type="checkbox" id="myonoffswitch1" name="AUTO_OVERDUE_TICKET" value="yes"  class=" toggle-class onoffswitch2-checkbox"  @if(setting('AUTO_OVERDUE_TICKET') == 'yes') checked="" @endif>
																		<label for="myonoffswitch1" class="toggle-class onoffswitch2-label" ></label>
																	</a>
																	<div class="ps-3">
																		<label class="form-label">{{trans('langconvert.admindashboard.autoticketoverdue')}}</label>
																		<small class="text-muted ">
																			<i>{{trans('langconvert.admindashboard.autoticketoverduecontent')}}</i></small>
																	</div>
																</div>
															</div>
															@if ($errors->has('AUTO_OVERDUE_TICKET'))

																<span class="invalid-feedback" role="alert">
																	<strong>{{ $errors->first('AUTO_OVERDUE_TICKET') }}</strong>
																</span>
															@endif

														</div>
													</div>
													<div class="col-sm-12 col-md-12 ms-7">
														<div class="form-group d-flex d-md-max-block {{ $errors->has('autooverduetickettime') ? ' is-invalid' : '' }}">
															<input type="number" maxlength="2" class="form-control wd-5 w-lg-max-30 ms-2 "  name="autooverduetickettime"  value="{{old('autooverduetickettime', setting('AUTO_OVERDUE_TICKET_TIME')) }}">
															<label class="form-label  mt-2 ms-2">{{trans('langconvert.admindashboard.autooverduedays')}}</label>
														</div>
														@if ($errors->has('autooverduetickettime'))

															<span class="invalid-feedback" role="alert">
																<strong>{{ $errors->first('autooverduetickettime') }}</strong>
															</span>
														@endif

													</div>
												</div>
												<!--- END AUTO OVERDUE TICKET--->
												<!---AUTO RESPONSETIME TICKET--->
												<div class="border-bottom">
													<div class="col-sm-12 col-md-12">
														<div class="form-group {{ $errors->has('AUTO_RESPONSETIME_TICKET') ? ' has-danger' : '' }}">
															<div class="switch_section">
																<div class="switch-toggle d-flex mt-4">
																	<a class="onoffswitch2">
																		<input type="checkbox" id="responsetime" name="AUTO_RESPONSETIME_TICKET" value="yes"  class=" toggle-class onoffswitch2-checkbox"  @if(setting('AUTO_RESPONSETIME_TICKET') == 'yes') checked="" @endif>
																		<label for="responsetime" class="toggle-class onoffswitch2-label" ></label>
																	</a>
																	<div class="ps-3">
																		<label class="form-label">{{trans('langconvert.admindashboard.ticketresponsetime')}}</label>
																		<small class="text-muted ">
																			<i>{{trans('langconvert.admindashboard.ticketresponsetimecontent')}}</i></small>
																	</div>
																</div>
															</div>
															@if ($errors->has('AUTO_RESPONSETIME_TICKET'))

																<span class="invalid-feedback" role="alert">
																	<strong>{{ $errors->first('AUTO_RESPONSETIME_TICKET') }}</strong>
																</span>
															@endif

														</div>
													</div>
													<div class="col-sm-12 col-md-12 ms-7">
														<div class="form-group d-flex d-md-max-block {{ $errors->has('autoresponsetickettime') ? ' is-invalid' : '' }}">
															<input type="number" maxlength="2" class="form-control wd-5 w-lg-max-30 ms-2"  name="autoresponsetickettime"  value="{{old('autoresponsetickettime', setting('AUTO_RESPONSETIME_TICKET_TIME')) }}">
															<label class="form-label mt-2 ms-2">{{trans('langconvert.admindashboard.autoreplystatushours')}}</label>
														</div>
														@if ($errors->has('autoresponsetickettime'))

															<span class="invalid-feedback" role="alert">
																<strong>{{ $errors->first('autoresponsetickettime') }}</strong>
															</span>
														@endif

													</div>
												</div>
												<!--- END AUTO RESPONSE TICKET--->
												<!---AUTO NOTIFY DELETE TICKET--->
												<div class="border-bottom">
													<div class="col-sm-12 col-md-12">
														<div class="form-group ">
															<div class="switch_section">
																<div class="switch-toggle d-flex mt-4">
																	<a class="onoffswitch2">
																		<input type="checkbox" id="responsetime" name="AUTO_NOTIFICATION_DELETE_ENABLE" value="on"  class=" toggle-class onoffswitch2-checkbox"  @if(setting('AUTO_NOTIFICATION_DELETE_ENABLE') == 'on') checked="" @endif>
																		<label for="responsetime" class="toggle-class onoffswitch2-label" ></label>
																	</a>
																	<div class="ps-3">
																		<label class="form-label">{{trans('langconvert.admindashboard.autonotificationsdelete')}}</label>
																		<small class="text-muted ">
																			<i>{{trans('langconvert.admindashboard.autonotificationsdeletecontent')}}</i></small>
																	</div>
																</div>
															</div>
															@if ($errors->has('AUTO_NOTIFICATION_DELETE_ENABLE'))

																<span class="invalid-feedback" role="alert">
																	<strong>{{ $errors->first('AUTO_NOTIFICATION_DELETE_ENABLE') }}</strong>
																</span>
															@endif

														</div>
													</div>
													<div class="col-sm-12 col-md-12 ms-7">
														<div class="form-group d-flex d-md-max-block {{ $errors->has('autonotificationdeletedays') ? ' is-invalid' : '' }}">
															<input type="number" maxlength="2" class="form-control wd-5 w-lg-max-30 ms-2"  name="autonotificationdeletedays"  value="{{old('autonotificationdeletedays', setting('AUTO_NOTIFICATION_DELETE_DAYS')) }}">
															<label class="form-label mt-2 ms-2">{{trans('langconvert.admindashboard.autonotificationdays')}}</label>
														</div>
														@if ($errors->has('autonotificationdeletedays'))

															<span class="invalid-feedback" role="alert">
																<strong>{{ $errors->first('autonotificationdeletedays') }}</strong>
															</span>
														@endif

													</div>
												</div>
												<!--- END AUTO  NOTIFY DELETE TICKET--->

												<!---Customer TICKET ID--->
												<div class="border-bottom">
													<div class="col-sm-12 col-md-12 ">
														<div class="form-group mt-2 ms-7 {{ $errors->has('CUSTOMER_TICKETID') ? ' has-danger' : '' }}">
															<div class="pb-2">
																<label class="form-label pb-0 mb-0"> {{trans('langconvert.admindashboard.customticketid')}} <span class="text-red">*</span></label>
																<small class="text-muted "><i>{{trans('langconvert.admindashboard.customticketidcontent')}}</i></small>
															</div>
																<input type="text" class="form-control w-20 w-lg-max-30 ms-2 {{ $errors->has('ticketid') ? ' is-invalid' : '' }}"  name="ticketid"  value="{{old('CUSTOMER_TICKETID', setting('CUSTOMER_TICKETID')) }}" required="">
															@if ($errors->has('ticketid'))

																<span class="invalid-feedback" role="alert">
																	<strong>{{ $errors->first('ticketid') }}</strong>
																</span>
															@endif

														</div>
													</div>
												</div>
												<!---  End Customer TICKET ID--->


												<!--- GUEST TICKET --->
												<div class="col-sm-12 col-md-12">
													<div class="form-group {{ $errors->has('GUEST_TICKET') ? ' has-danger' : '' }}">
														<div class="switch_section">
															<div class="switch-toggle d-flex mt-4">
																<a class="onoffswitch2">
																	<input type="checkbox" id="myonoffswitch2" name="GUEST_TICKET" value="yes"  class=" toggle-class onoffswitch2-checkbox"  @if(setting('GUEST_TICKET') == 'yes') checked="" @endif>
																	<label for="myonoffswitch2" class="toggle-class onoffswitch2-label" ></label>
																</a>
																<div class="ps-3">
																	<label class="form-label">{{trans('langconvert.admindashboard.guestticketcontrol')}}</label>
																	<small class="text-muted"><i>{{trans('langconvert.admindashboard.guestticketcontrolcontent')}}</i></small>
																</div>
															</div>
														</div>
														@if ($errors->has('GUEST_TICKET'))

															<span class="invalid-feedback" role="alert">
																<strong>{{ $errors->first('GUEST_TICKET') }}</strong>
															</span>
														@endif

													</div>
												</div>
												<!--- END GUEST TICKET --->
												
												<div class="col-sm-12 col-md-12">
													<div class="form-group {{ $errors->has('USER_FILE_UPLOAD_ENABLE') ? ' has-danger' : '' }}">
														<div class="switch_section">
															<div class="switch-toggle d-flex mt-4">
																<a class="onoffswitch2">
																	<input type="checkbox" id="myonoffswitch1823" name="USER_FILE_UPLOAD_ENABLE" value="yes"  class=" toggle-class onoffswitch2-checkbox"  @if(setting('USER_FILE_UPLOAD_ENABLE') == 'yes') checked="" @endif>
																	<label for="myonoffswitch1823" class="toggle-class onoffswitch2-label" ></label>
																</a>
																<div class="ps-3">
																	<label class="form-label">{{trans('langconvert.admindashboard.customerfileupload')}}</label>
																	<small class="text-muted"><i>{{trans('langconvert.admindashboard.customerfileuploadcontent')}}</i></small>
																</div>
															</div>
														</div>
														@if ($errors->has('USER_FILE_UPLOAD_ENABLE'))

															<span class="invalid-feedback" role="alert">
																<strong>{{ $errors->first('USER_FILE_UPLOAD_ENABLE') }}</strong>
															</span>
														@endif

													</div>
												</div>
												<div class="col-sm-12 col-md-12">
													<div class="form-group {{ $errors->has('GUEST_FILE_UPLOAD_ENABLE') ? ' has-danger' : '' }}">
														<div class="switch_section">
															<div class="switch-toggle d-flex mt-4">
																<a class="onoffswitch2">
																	<input type="checkbox" id="myonoffswitch1825" name="GUEST_FILE_UPLOAD_ENABLE" value="yes"  class=" toggle-class onoffswitch2-checkbox"  @if(setting('GUEST_FILE_UPLOAD_ENABLE') == 'yes') checked="" @endif>
																	<label for="myonoffswitch1825" class="toggle-class onoffswitch2-label" ></label>
																</a>
																<div class="ps-3">
																	<label class="form-label">{{trans('langconvert.admindashboard.guestuserfileupload')}}</label>
																	<small class="text-muted "><i>{{trans('langconvert.admindashboard.guestuserfileuploadcontent')}}</i></small>
																</div>
															</div>
														</div>
														@if ($errors->has('GUEST_FILE_UPLOAD_ENABLE'))

															<span class="invalid-feedback" role="alert">
																<strong>{{ $errors->first('GUEST_FILE_UPLOAD_ENABLE') }}</strong>
															</span>
														@endif

													</div>
												</div>
											</div>
										</div>
										<div class="card-footer ">
											<div class="form-group float-end">
												<input type="submit" class="btn btn-secondary" value="{{trans('langconvert.admindashboard.savechanges')}}" onclick="this.disabled=true;this.form.submit();">
											</div>
										</div>
									</form>
								</div>
							</div>
							<!-- End Ticket Settings-->

							<!-- File Setting-->
							<div class="col-xl-12 col-lg-12 col-md-12">
								<div class="card ">
									<div class="card-header border-0">
										<h4 class="card-title">{{trans('langconvert.admindashboard.filesetting')}}</h4>
									</div>
									<form method="POST" action="{{ route('settings.file.store') }}" enctype="multipart/form-data">
										<div class="card-body" >
											@csrf

											@honeypot
											<div class="row">
												<div class="col-sm-12 col-md-4">
													<div class="form-group {{ $errors->has('maxfileupload') ? ' has-danger' : '' }}">
														<label class="form-label">{{trans('uhelpupdate::langconvert.admindashboard.maxfilesupload')}}</label>
														<div class="d-flex justify-content-center align-items-center">
														<input type="number" maxlength="2"  class="form-control {{ $errors->has('maxfileupload') ? ' is-invalid' : '' }}"  name="maxfileupload"  value="{{old('maxfileupload', setting('MAX_FILE_UPLOAD')) }}">
														
														</div>
														@if ($errors->has('maxfileupload'))

															<span class="invalid-feedback" role="alert">
																<strong>{{ $errors->first('maxfileupload') }}</strong>
															</span>
														@endif

													</div>
												</div>
												<div class="col-sm-12 col-md-4">
													<div class="form-group {{ $errors->has('fileuploadmax') ? ' has-danger' : '' }}">
														<label class="form-label">{{trans('langconvert.admindashboard.maxfilesizeupload')}}</label>
														<div class="d-flex justify-content-center align-items-center">
														<input type="number" maxlength="2"  class="form-control {{ $errors->has('fileuploadmax') ? ' is-invalid' : '' }}"  name="fileuploadmax"  value="{{old('fileuploadmax', setting('FILE_UPLOAD_MAX')) }}">
														<span class="ms-2 font-weight-bold">{{trans('langconvert.admindashboard.mb')}}</span>
														</div>
														@if ($errors->has('fileuploadmax'))

															<span class="invalid-feedback" role="alert">
																<strong>{{ $errors->first('fileuploadmax') }}</strong>
															</span>
														@endif

													</div>
												</div>

												<div class="col-sm-12 col-md-4">
													<div class="form-group {{ $errors->has('fileuploadtypes') ? ' has-danger' : '' }}">
														<label class="form-label">{{trans('langconvert.admindashboard.allowfiletypes')}}</label>
														<div class="d-flex">
															<input type="text"  class="form-control {{ $errors->has('fileuploadtypes') ? ' is-invalid' : '' }}" id="tags" data-role="tagsinput"  name="fileuploadtypes"  value="{{old('fileuploadtypes', setting('FILE_UPLOAD_TYPES')) }}">
															@if ($errors->has('fileuploadtypes'))

																<span class="invalid-feedback" role="alert">
																	<strong>{{ $errors->first('fileuploadtypes') }}</strong>
																</span>
															@endif
														</div>	
														
													</div>
												</div>
											</div>
										</div>
										<div class="card-footer ">
											<div class="form-group float-end">
												<input type="submit" class="btn btn-secondary" value="{{trans('langconvert.admindashboard.savechanges')}}" onclick="this.disabled=true;this.form.submit();">
											</div>
										</div>
									</form>
								</div>
							</div>
							<!-- End File Setting-->
			
							@endsection
		@section('scripts')
		
		<!-- INTERNAL TAG js-->
		<script src="{{asset('assets/plugins/taginput/bootstrap-tagsinput.js')}}?v=<?php echo time(); ?>"></script>

		@endsection