
@extends('layouts.adminmaster')

							@section('content')

							<!--Page header-->
							<div class="page-header d-xl-flex d-block">
								<div class="page-leftheader">
									<h4 class="page-title"><span class="font-weight-normal text-muted ms-2">{{trans('langconvert.adminmenu.emailsetting')}}</span></h4>
								</div>
							</div>
							<!--End Page header-->

							<!-- Send Test Mail -->
							<div class="col-xl-12 col-lg-12 col-md-12">
								<div class="card ">
									<div class="card-header border-0">
										<h4 class="card-title">{{trans('langconvert.admindashboard.sendtestmail')}}</h4>
									</div>
									<div class="card-body" >
										<form method="post" action="{{ route('settings.email.sendtestmail') }}" id="my-form" autocomplete="off" enctype="multipart/form-data">
											@csrf

											@method('post')

											<div class="row">
												<div class="form-group col-md-6 {{ $errors->has('email') ? ' has-danger' : '' }}">
													<input class="form-control" name="email" placeholder="{{ __('langconvert.admindashboard.entermail') }}" type="email" value="{{ old('email', setting('email')) }}" id="example-email-input">

													@if ($errors->has('email'))

														<span class="invalid-feedback" role="alert">
															<strong>{{ $errors->first('email') }}</strong>
														</span>
													@endif

												</div>
												<div class="form-group col-md-6 {{ $errors->has('email') ? ' has-danger' : '' }}">
													<button type="submit" class="btn btn-secondary">{{trans('langconvert.admindashboard.send')}}</a>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
							<!-- Send Test Mail -->

							<!-- Email Setting -->
							<div class="col-xl-12 col-lg-12 col-md-12">
								<div class="card ">
									<div class="card-header border-0">
										<h4 class="card-title">{{trans('langconvert.adminmenu.emailsetting')}}</h4>
									</div>
									<form method="POST" enctype="multipart/form-data" name="emailsetting_form" id="emailsetting_form">
										<div class="card-body" >
											@csrf

											@honeypot
											<input type="hidden" class="form-control" name="id" Value="">
											<div class="row" id="selectmail">
												<div class="col-sm-12 col-md-12">
													<div class="form-group">
														<label class="form-label">{{trans('langconvert.admindashboard.maildriver')}}</label>
														<select name="mail_driver" id="mail_driver" class="form-control select2" required>
															@foreach(['smtp' => 'SMTP', 'sendmail' => 'Send Mail'] as $key => $lang)

																<option value="{{ $key }}" {{ old('mail_driver', setting('mail_driver'))==$key ? 'selected' :'' }}>{{$lang}}</option>
															@endforeach

														</select>

														@if ($errors->has('mail_driver'))

															<span class="invalid-feedback" role="alert">
																<strong>{{ $errors->first('mail_driver') }}</strong>
															</span>
														@endif

													</div>
												</div>
											</div>
										</div>
										<div class="card-footer ">
											<div class="form-group float-end">
												<input type="submit" class="btn btn-secondary" id="formemailsetting" value="{{trans('langconvert.admindashboard.savechanges')}}" >
											</div>
										</div>
									</form>
								</div>
							</div>
							<!-- Email Setting -->
							@endsection
					
		@section('scripts')
		
			<!--- select2 js -->
			<script src="{{asset('assets/js/select2.js')}}"></script>

			<script type="text/javascript">

				"use strict";
	
				(function($)  {

					// submit button function
					let optionvar = $('#mail_driver').val();
					if(optionvar == 'sendmail'){
						sendmail()

					}
					else if(optionvar == 'smtp'){

						smtp()
					}
					// Csrf field
					$.ajaxSetup({
						headers: {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						}
					});

					// submit button
					$('body').on('submit', '#emailsetting_form', function(e){
						e.preventDefault();
						var optionclick = $('#mail_driver').val();
						var formData = new FormData(this);
						$('#mailhostError').html('')
						$('#mailportError').html('');
						$('#mailusernameError').html('');
						$('#mailpasswordError').html('');
						$('#mailencryptionError').html('');
						$('#fromnameError').html('');
						$('#fromaddressError').html('');
						$.ajax({
							type:'POST',
							url: '{{route('settings.email.store')}}',
							data: formData,
							cache:false,
							contentType: false,
							processData: false,
							success: (data) => {
								$('#mailhostError').html('')
								$('#mailportError').html('');
								$('#mailusernameError').html('');
								$('#mailpasswordError').html('');
								$('#mailencryptionError').html('');
								$('#fromnameError').html('');
								$('#fromaddressError').html('');
								toastr.success(data.success);
							},
							error: function(data){
								$('#mailhostError').html('')
								$('#mailportError').html('');
								$('#mailusernameError').html('');
								$('#mailpasswordError').html('');
								$('#mailencryptionError').html('');
								$('#fromnameError').html('');
								$('#fromaddressError').html('');

								$('#mailhostError').html(data.responseJSON.errors.mail_host)
								$('#mailportError').html(data.responseJSON.errors.mail_port);
								$('#mailusernameError').html(data.responseJSON.errors.mail_username);
								$('#mailpasswordError').html(data.responseJSON.errors.mail_password);
								$('#mailencryptionError').html(data.responseJSON.errors.mail_encryption);
								$('#fromnameError').html(data.responseJSON.errors.mail_from_name);
								$('#fromaddressError').html(data.responseJSON.errors.mail_from_address);
								console.log(data.responseJSON.errors);
							}
						});

						
						
						
					});

					// select2 change function
					$('#mail_driver').on('change', function(){
						var option = $(this).val();
						if(option == 'sendmail'){
							sendmail()
						}
						else if(option == 'smtp'){
							
							smtp()

						}
					});

				})(jQuery);

				// if sendmail get related inputs
				function sendmail(){

					let selectmail = document.querySelector('#selectmail');
						
					$('.fromail')?.remove();
					// mailfromname
					let divcol12user = document.createElement('div');
					divcol12user.setAttribute('class', 'col-sm-12 col-md-12 fromail');
					let formgroupuser = document.createElement('div');
					formgroupuser.setAttribute('class', 'form-group');
					let formmlabeluser = document.createElement('label');
					formmlabeluser.setAttribute('class', 'form-label');
					formmlabeluser.innerHTML  = '{{trans('langconvert.admindashboard.fromname')}} <span class="text-red">*</span>';
					let inputuser = document.createElement('input');
					inputuser.setAttribute('class', `form-control @error('mail_from_name') is-invalid @enderror`);
					inputuser.setAttribute('name', 'mail_from_name');
					inputuser.setAttribute('type', 'text');
					inputuser.setAttribute('value', '{{ old('mail_from_name', setting('mail_from_name')) }}');
					let spanerror = document.createElement('span');
					spanerror.setAttribute('class', 'text-red');
					spanerror.setAttribute('id', 'fromnameError');
					
					// mailfromemail
					let divcol12email = document.createElement('div');
					divcol12email.setAttribute('class', 'col-sm-12 col-md-12 fromail');
					let formgroupemail = document.createElement('div');
					formgroupemail.setAttribute('class', 'form-group');
					let formmlabelemail = document.createElement('label');
					formmlabelemail.setAttribute('class', 'form-label');
					formmlabelemail.innerHTML  = '{{trans('langconvert.admindashboard.fromemail')}} <span class="text-red">*</span>';
					let inputemail = document.createElement('input');
					inputemail.setAttribute('class', `form-control @error('mail_from_address') is-invalid @enderror`);
					inputemail.setAttribute('name', 'mail_from_address');
					inputemail.setAttribute('type', 'email');
					inputemail.setAttribute('value', `{{ old('mail_from_address', setting('mail_from_address')) }}`);
					let spanerror1 = document.createElement('span');
					spanerror1.setAttribute('class', 'text-red');
					spanerror1.setAttribute('id', 'fromaddressError');
					// mailfromname
					selectmail.append(divcol12user);
					divcol12user.append(formgroupuser);
					formgroupuser.append(formmlabeluser);
					formgroupuser.append(inputuser);
					formgroupuser.append(spanerror);
					// mailfromemail
					selectmail.append(divcol12email);
					divcol12email.append(formgroupemail);
					formgroupemail.append(formmlabelemail);
					formgroupemail.append(inputemail);
					formgroupemail.append(spanerror1);

				}

				// if smtp get related inputs
				function smtp(){
					let selectmail = document.querySelector('#selectmail');
					$('.fromail')?.remove();
					// mailhost
					let div12mailhost = document.createElement('div');
					div12mailhost.setAttribute('class', 'col-sm-12 col-md-12 fromail');
					let formgroupmailhost = document.createElement('div');
					formgroupmailhost.setAttribute('class', 'form-group');
					let formmlabelmailhost = document.createElement('label');
					formmlabelmailhost.setAttribute('class', 'form-label');
					formmlabelmailhost.innerHTML  = '{{trans('langconvert.admindashboard.mailhost')}} <span class="text-red">*</span>';
					let inputmailhost = document.createElement('input');
					inputmailhost.setAttribute('class', `form-control @error('mail_host') is-invalid @enderror`);
					inputmailhost.setAttribute('name', 'mail_host');
					inputmailhost.setAttribute('type', 'text');
					inputmailhost.setAttribute('value', `{{ old('mail_host', setting('mail_host')) }}`);
					let spanerror2 = document.createElement('span');
					spanerror2.setAttribute('class', 'text-red')
					spanerror2.setAttribute('id', 'mailhostError')

					// mailport
					let div12mailport = document.createElement('div');
					div12mailport.setAttribute('class', 'col-sm-12 col-md-12 fromail');
					let formgroupmailport = document.createElement('div');
					formgroupmailport.setAttribute('class', 'form-group');
					let formmlabelmailport = document.createElement('label');
					formmlabelmailport.setAttribute('class', 'form-label');
					formmlabelmailport.innerHTML  = '{{trans('langconvert.admindashboard.mailport')}} <span class="text-red">*</span>';
					let inputmailport = document.createElement('input');
					inputmailport.setAttribute('class', `form-control @error('mail_port') is-invalid @enderror`);
					inputmailport.setAttribute('name', 'mail_port');
					inputmailport.setAttribute('type', 'text');
					inputmailport.setAttribute('value', `{{ old('mail_port', setting('mail_port')) }}`);
					let spanerror3 = document.createElement('span');
					spanerror3.setAttribute('class', 'text-red');
					spanerror3.setAttribute('id', 'mailportError');

					// mailusername
					let div12mailusername = document.createElement('div');
					div12mailusername.setAttribute('class', 'col-sm-12 col-md-12 fromail');
					let formgroupmailusername = document.createElement('div');
					formgroupmailusername.setAttribute('class', 'form-group');
					let formmlabelmailusername = document.createElement('label');
					formmlabelmailusername.setAttribute('class', 'form-label');
					formmlabelmailusername.innerHTML  = '{{trans('langconvert.admindashboard.mailusername')}} <span class="text-red">*</span>';
					let inputmailusername = document.createElement('input');
					inputmailusername.setAttribute('class', `form-control @error('mail_username') is-invalid @enderror`);
					inputmailusername.setAttribute('name', 'mail_username');
					inputmailusername.setAttribute('type', 'text');
					inputmailusername.setAttribute('value', `{{ old('mail_username', setting('mail_username')) }}`);
					let spanerror4 = document.createElement('span');
					spanerror4.setAttribute('class', 'text-red');
					spanerror4.setAttribute('id', 'mailusernameError');

					// mailpassword
					let div12mailpassword = document.createElement('div');
					div12mailpassword.setAttribute('class', 'col-sm-12 col-md-12 fromail');
					let formgroupmailpassword = document.createElement('div');
					formgroupmailpassword.setAttribute('class', 'form-group');
					let formmlabelmailpassword = document.createElement('label');
					formmlabelmailpassword.setAttribute('class', 'form-label');
					formmlabelmailpassword.innerHTML  = '{{trans('langconvert.admindashboard.mailpassword')}} <span class="text-red">*</span>';
					let inputmailpassword = document.createElement('input');
					inputmailpassword.setAttribute('class', `form-control @error('mail_password') is-invalid @enderror`);
					inputmailpassword.setAttribute('name', 'mail_password');
					inputmailpassword.setAttribute('type', 'password');
					inputmailpassword.setAttribute('value', `{{ old('mail_password', setting('mail_password')) }}`);
					let spanerror5 = document.createElement('span');
					spanerror5.setAttribute('class', 'text-red');
					spanerror5.setAttribute('id', 'mailpasswordError');

					// mailencryption
					let div12mailencryption = document.createElement('div');
					div12mailencryption.setAttribute('class', 'col-sm-12 col-md-12 fromail');
					let formgroupmailencryption = document.createElement('div');
					formgroupmailencryption.setAttribute('class', 'form-group');
					let formmlabelmailencryption = document.createElement('label');
					formmlabelmailencryption.setAttribute('class', 'form-label');
					formmlabelmailencryption.innerHTML  = '{{trans('langconvert.admindashboard.mailencryption')}} <span class="text-red">*</span>';
					let inputmailencryption = document.createElement('select');
					inputmailencryption.setAttribute('class', `form-control select2form @error('mail_encryption') is-invalid @enderror`);
					inputmailencryption.setAttribute('name', 'mail_encryption');
					let spanerror6 = document.createElement('span');
					spanerror6.setAttribute('class', 'text-red');
					spanerror6.setAttribute('id', 'mailencryptionError');
				

					// mailfromname
					let div12mailfromname = document.createElement('div');
					div12mailfromname.setAttribute('class', 'col-sm-12 col-md-12 fromail');
					let formgroupmailfromname = document.createElement('div');
					formgroupmailfromname.setAttribute('class', 'form-group');
					let formmlabelmailfromname = document.createElement('label');
					formmlabelmailfromname.setAttribute('class', 'form-label');
					formmlabelmailfromname.innerHTML  = '{{trans('langconvert.admindashboard.fromname')}} <span class="text-red">*</span>';
					let inputmailfromname = document.createElement('input');
					inputmailfromname.setAttribute('class', `form-control @error('mail_from_name') is-invalid @enderror`);
					inputmailfromname.setAttribute('name', 'mail_from_name');
					inputmailfromname.setAttribute('type', 'text');
					inputmailfromname.setAttribute('value', `{{ old('mail_from_name', setting('mail_from_name')) }}`);
					let spanerror7 = document.createElement('span');
					spanerror7.setAttribute('class', 'text-red');
					spanerror7.setAttribute('id', 'fromnameError');

					// mailfromemail
					let div12mailfromemail = document.createElement('div');
					div12mailfromemail.setAttribute('class', 'col-sm-12 col-md-12 fromail');
					let formgroupmailfromemail = document.createElement('div');
					formgroupmailfromemail.setAttribute('class', 'form-group');
					let formmlabelmailfromemail = document.createElement('label');
					formmlabelmailfromemail.setAttribute('class', 'form-label');
					formmlabelmailfromemail.innerHTML  = '{{trans('langconvert.admindashboard.fromemail')}} <span class="text-red">*</span>';
					let inputmailfromemail = document.createElement('input');
					inputmailfromemail.setAttribute('class', `form-control @error('mail_from_address') is-invalid @enderror`);
					inputmailfromemail.setAttribute('name', 'mail_from_address');
					inputmailfromemail.setAttribute('type', 'email');
					inputmailfromemail.setAttribute('value', `{{ old('mail_from_address', setting('mail_from_address')) }}`);
					let spanerror8 = document.createElement('span');
					spanerror8.setAttribute('class', 'text-red');
					spanerror8.setAttribute('id', 'fromaddressError');

					// mailhost
					selectmail.append(div12mailhost);
					div12mailhost.append(formgroupmailhost);
					formgroupmailhost.append(formmlabelmailhost);
					formgroupmailhost.append(inputmailhost);
					formgroupmailhost.append(spanerror2);
					// mailport
					selectmail.append(div12mailport);
					div12mailport.append(formgroupmailport);
					formgroupmailport.append(formmlabelmailport);
					formgroupmailport.append(inputmailport);
					formgroupmailport.append(spanerror3);
					// mailusername
					selectmail.append(div12mailusername);
					div12mailusername.append(formgroupmailusername);
					formgroupmailusername.append(formmlabelmailusername);
					formgroupmailusername.append(inputmailusername);
					formgroupmailusername.append(spanerror4);
					// mailpassword
					selectmail.append(div12mailpassword);
					div12mailpassword.append(formgroupmailpassword);
					formgroupmailpassword.append(formmlabelmailpassword);
					formgroupmailpassword.append(inputmailpassword);
					formgroupmailpassword.append(spanerror5);
					// mailencryption
					selectmail.append(div12mailencryption);
					div12mailencryption.append(formgroupmailencryption);
					formgroupmailencryption.append(formmlabelmailencryption);
					formgroupmailencryption.append(inputmailencryption);
					formgroupmailencryption.append(spanerror6);
					// mailfromname
					selectmail.append(div12mailfromname);
					div12mailfromname.append(formgroupmailfromname);
					formgroupmailfromname.append(formmlabelmailfromname);
					formgroupmailfromname.append(inputmailfromname);
					formgroupmailfromname.append(spanerror7);
					// mailfromemail
					selectmail.append(div12mailfromemail);
					div12mailfromemail.append(formgroupmailfromemail);
					formgroupmailfromemail.append(formmlabelmailfromemail);
					formgroupmailfromemail.append(inputmailfromemail);
					formgroupmailfromemail.append(spanerror8);


					//
					$('.select2form').select2();
					const optionvalue = ["ssl", "tls"]
					$.each(optionvalue,function(index,optionvalues){
						if("{{setting("mail_encryption")}}" == optionvalues){
							$('.select2form').append('<option value="'+optionvalues+'" selected>'+optionvalues+'</option>');
						}
						else{
							$('.select2form').append('<option value="'+optionvalues+'">'+optionvalues+'</option>');
						}
					})
				}

			</script>
		@endsection



	
