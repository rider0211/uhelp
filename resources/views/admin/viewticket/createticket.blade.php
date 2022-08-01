
@extends('layouts.adminmaster')

@section('styles')

<!-- INTERNAl Summernote css -->
<link rel="stylesheet" href="{{asset('assets/plugins/summernote/summernote.css')}}?v=<?php echo time(); ?>">

<!-- INTERNAl Dropzone css -->
<link href="{{asset('assets/plugins/dropzone/dropzone.css')}}?v=<?php echo time(); ?>" rel="stylesheet" />

@endsection

					@section('content')

					<!--Page header-->
					<div class="page-header d-xl-flex d-block">
						<div class="page-leftheader">
							<h4 class="page-title"><span class="font-weight-normal text-muted ms-2">{{trans('langconvert.adminmenu.createticket')}}</span></h4>
						</div>
					</div>
					<!--End Page header-->

					<!-- Create Ticket List-->
					<div class="col-xl-12 col-lg-12 col-md-12">
						<div class="card ">
							<div class="card-header border-0">
								<h4 class="card-title">{{trans('langconvert.admindashboard.newticket')}}</h4>
							</div>
							<form method="post" id="admin_form" enctype="multipart/form-data">
								@honeypot

								<div class="card-body">
									<div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label mb-0 mt-2">{{trans('langconvert.admindashboard.ticketsubject')}} <span class="text-red">*</span></label>
											</div>
											<div class="col-md-9">
												<input type="text" id="subject" class="form-control @error('subject') is-invalid @enderror" placeholder="Subject" name="subject" value="{{ old('subject') }}">
												<span id="SubjectError" class="text-danger alert-message"></span>
												@error('subject')
												
													<span class="invalid-feedback" role="alert">
														<strong>{{ $message }}</strong>
													</span>
												@enderror

											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label mb-0 mt-2">{{trans('langconvert.admindashboard.emailaddress')}} <span class="text-red">*</span></label>
											</div>
											<div class="col-md-9">
												<input type="text" class="form-control @error('email') is-invalid @enderror" placeholder="Email" value="{{ old('email') }}" name="email" id="email">
												<span id="EmailError" class="text-danger alert-message" ></span>
												@error('email')

													<span class="invalid-feedback" role="alert">
														<strong>{{ $message }}</strong>
													</span>
												@enderror

											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label mb-0 mt-2">{{trans('langconvert.admindashboard.ticketcategory')}}<span class="text-red">*</span></label>
											</div>
											<div class="col-md-9">
												<select  class="form-control select2-show-search  select2 @error('category') is-invalid @enderror"  data-placeholder="Select Category" name="category" id="category">
													<option label="Select Category"></option>
													@foreach ($categories as $category)

														<option value="{{ $category->id }}" @if(old('category') == $category->id) selected @endif>{{ $category->name }}</option>
													@endforeach

												</select>
												<span id="CategoryError" class="text-danger alert-message"></span>
												@error('category')

													<span class="invalid-feedback" role="alert">
														<strong>{{ $message }}</strong>
													</span>
												@enderror

											</div>
										</div>
									</div>
									<div class="form-group" id="selectssSubCategory" style="display: none;">
										
										<div class="row">
											<div class="col-md-3">
												<label class="form-label mb-0 mt-2">{{trans('langconvert.newwordslang.ticketsubcategory')}}</label>
											</div>
											<div class="col-md-9">
												<select  class="form-control select2-show-search  select2"  data-placeholder="Select SubCategory" name="subscategory" id="subscategory" >

												</select>
												<span id="subsCategoryError" class="text-danger alert-message"></span>
											</div>
										</div>

									</div>
									<div class="form-group" id="selectSubCategory">
									</div>
									<div class="form-group" id="envatopurchase">
									</div>
									<div class="form-group ticket-summernote ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label mb-0 mt-2">{{trans('langconvert.admindashboard.ticketdescription')}}<span class="text-red">*</span></label>
											</div>
											<div class="col-md-9">
												<textarea class="summernote form-control @error('message') is-invalid @enderror" rows="7" name="message">{{old('message')}}</textarea>
												<span id="MessageError" class="text-danger alert-message"></span>
												@error('message')

													<span class="invalid-feedback" role="alert">
														<strong>{{ $message }}</strong>
													</span>
												@enderror

											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label mb-0 mt-2">{{trans('langconvert.admindashboard.uploadimage')}}</label>
											</div>
											<div class="col-md-9">
												<div class="form-group mb-0">
													<div class="needsclick dropzone" id="document-dropzone"></div>
												</div>
												<small class="text-muted"><i>{{trans('langconvert.admindashboard.filesizenotbe')}} {{setting('FILE_UPLOAD_MAX')}}{{trans('langconvert.admindashboard.mb')}}</i></small>
											</div>
										</div>
									</div>
								</div>
								<div class="card-footer">
									<div class="form-group float-end">
										<input type="submit"  class="btn btn-secondary btn-lg purchasecode"  value="{{trans('langconvert.adminmenu.createticket')}}" >
									</div>
								</div>
							</form>
						</div>
					</div>
					<!--End Create Ticket List-->
					@endsection

		@section('scripts')

		<!-- INTERNAL Vertical-scroll js-->
		<script src="{{asset('assets/plugins/vertical-scroll/jquery.bootstrap.newsbox.js')}}?v=<?php echo time(); ?>"></script>

		<!-- INTERNAL Summernote js  -->
		<script src="{{asset('assets/plugins/summernote/summernote.js')}}?v=<?php echo time(); ?>"></script>

		<!-- INTERNAL Index js-->
		<script src="{{asset('assets/js/support/support-sidemenu.js')}}?v=<?php echo time(); ?>"></script>
		<script src="{{asset('assets/js/support/support-createticket.js')}}?v=<?php echo time(); ?>"></script>
		<script src="{{asset('assets/js/select2.js')}}?v=<?php echo time(); ?>"></script>

		<!-- INTERNAL Dropzone js-->
		<script src="{{asset('assets/plugins/dropzone/dropzone.js')}}?v=<?php echo time(); ?>"></script>

		<script type="text/javascript">

			"use strict";

			// Image Upload
			var uploadedDocumentMap = {}
			Dropzone.options.documentDropzone = {
			url: '{{route('imageuploadadmin')}}',
			maxFilesize: '{{setting('FILE_UPLOAD_MAX')}}', // MB
			addRemoveLinks: true,
			acceptedFiles: '{{setting('FILE_UPLOAD_TYPES')}}',
				headers: {
					'X-CSRF-TOKEN': "{{ csrf_token() }}"
				},
			success: function (file, response) {
				$('form').append('<input type="hidden" name="ticket[]" value="' + response.name + '">')
				uploadedDocumentMap[file.name] = response.name
			},
			removedfile: function (file) {
				file.previewElement.remove()
				var name = ''
				if (typeof file.file_name !== 'undefined') {
				name = file.file_name
				} 
				else {
				name = uploadedDocumentMap[file.name]
				}
				$('form').find('input[name="ticket[]"][value="' + name + '"]').remove()
			},
			init: function () {
				@if(isset($project) && $project->document)
				var files =
					{!! json_encode($project->document) !!}
				for (var i in files) {
					var file = files[i]
					this.options.addedfile.call(this, file)
					file.previewElement.classList.add('dz-complete')
					$('form').append('<input type="hidden" name="ticket[]" value="' + file.file_name + '">')
				}
				@endif

				this.on('error', function(file, errorMessage) {
					if (errorMessage.message) {
					
						var errorDisplay = document.querySelectorAll('[data-dz-errormessage]');
						errorDisplay[errorDisplay.length - 1].innerHTML = errorMessage.message;
					}
				});
			}
			}
				
			// Csrf field
			$.ajaxSetup({
				headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});

			// when category change its get the subcat list 
			$('#category').on('change',function(e) {
				var cat_id = e.target.value;
				$('#selectssSubCategory').hide();
				$.ajax({
					url:"{{ route('guest.subcategorylist') }}",
					type:"POST",
						data: {
						cat_id: cat_id
						},
						cache : false,
						async: true,
					success:function (data) {
						console.log(data);
						if(data.subcategoriess != ''){
							$('#subscategory').html(data.subcategoriess)
							$('#selectssSubCategory').show()
						}
						else{
							$('#selectssSubCategory').hide();
							$('#subscategory').html('')
						}
						//projectlist
						if(data.subcategories.length >= 1){
							
							$('#subcategory')?.empty();
							$('#selectSubCategory .row')?.remove();
							let selectDiv = document.querySelector('#selectSubCategory');
							let Divrow = document.createElement('div');
							Divrow.setAttribute('class','row mt-4');
							let Divcol3 = document.createElement('div');
							Divcol3.setAttribute('class','col-md-3');
							let selectlabel =  document.createElement('label');
							selectlabel.setAttribute('class','form-label mb-0 mt-2')
							selectlabel.innerText = "Projects";
							let divcol9 = document.createElement('div');
							divcol9.setAttribute('class', 'col-md-9');
							let selecthSelectTag =  document.createElement('select');
							selecthSelectTag.setAttribute('class','form-control select2-show-search');
							selecthSelectTag.setAttribute('id', 'subcategory');
							selecthSelectTag.setAttribute('name', 'project');
							selecthSelectTag.setAttribute('data-placeholder','Select Projects');
							let selectoption = document.createElement('option');
							selectoption.setAttribute('label','Select Projects')
							selectDiv.append(Divrow);
							Divrow.append(Divcol3);
							Divcol3.append(selectlabel);
							divcol9.append(selecthSelectTag);
							selecthSelectTag.append(selectoption);
							Divrow.append(divcol9);
							$('.select2-show-search').select2();
							$.each(data.subcategories,function(index,subcategory){
							$('#subcategory').append('<option value="'+subcategory.name+'">'+subcategory.name+'</option>');
							})
						}
						else{
							$('#subcategory')?.empty();
							$('#selectSubCategory .row')?.remove();
						}
						//Envato Access
						if(data.envatosuccess.length >= 1){
							$('#envato_id')?.empty();
							$('#envatopurchase .row')?.remove();
							let selectDiv = document.querySelector('#envatopurchase');
							let Divrow = document.createElement('div');
							Divrow.setAttribute('class','row mt-4');
							let Divcol3 = document.createElement('div');
							Divcol3.setAttribute('class','col-md-3');
							let selectlabel =  document.createElement('label');
							selectlabel.setAttribute('class','form-label mb-0 mt-2')
							selectlabel.innerHTML = "Envato Purchase Code <span class='text-red'>*</span>";
							let divcol9 = document.createElement('div');
							divcol9.setAttribute('class', 'col-md-9');
							let selecthSelectTag =  document.createElement('input');
							selecthSelectTag.setAttribute('class','form-control');
							selecthSelectTag.setAttribute('type','search');
							selecthSelectTag.setAttribute('id', 'envato_id');
							selecthSelectTag.setAttribute('name', 'envato_id');
							selecthSelectTag.setAttribute('placeholder', 'Enter Your Purchase Code');
							let selecthSelectInput =  document.createElement('input');
							selecthSelectInput.setAttribute('type','hidden');
							selecthSelectInput.setAttribute('id', 'envato_support');
							selecthSelectInput.setAttribute('name', 'envato_support');
							selectDiv.append(Divrow);
							Divrow.append(Divcol3);
							Divcol3.append(selectlabel);
							divcol9.append(selecthSelectTag);
							divcol9.append(selecthSelectInput);
							Divrow.append(divcol9);
							$('.purchasecode').attr('disabled', true);
							
						}else{
							$('#envato_id')?.empty();
							$('#envatopurchase .row')?.remove();
							$('.purchasecode').removeAttr('disabled');
						}
					},
					error:(data)=>{

					}
				});
			});


			@php $module = Module::all(); @endphp

			@if(in_array('Uhelpupdate', $module))



			// Purchase Code Validation
			$("body").on('keyup', '#envato_id', function() {
				let value = $(this).val();
				if (value != '') {
					if(value.length == '36'){
						var _token = $('input[name="_token"]').val();
					$.ajax({
						url: "{{ route('guest.envatoverify') }}",
						method: "POST",
						data: {data: value, _token: _token},

						dataType:"json",

						success: function (data) {
							if(data.valid == 'true'){
								$('#envato_id').addClass('is-valid');
								$('#envato_id').attr('readonly', true);
								$('.purchasecode').removeAttr('disabled');
								$('#envato_id').css('border', '1px solid #02f577');
								$('#envato_support').val('Supported');
								toastr.success(data.message);
							}
							if(data.valid == 'expried'){
								@if(setting('ENVATO_EXPIRED_BLOCK') == 'on')
								
								$('.purchasecode').attr('disabled', true);
								$('#envato_id').css('border', '1px solid #e13a3a');
								$('#envato_support').val('Expired');
								toastr.error(data.message);
								@endif
								@if(setting('ENVATO_EXPIRED_BLOCK') == 'off')
								$('#envato_id').addClass('is-valid');
								$('#envato_id').attr('readonly', true);
								$('.purchasecode').removeAttr('disabled');
								$('#envato_id').css('border', '1px solid #02f577');
								$('#envato_support').val('Expired');
								toastr.warning(data.message);
								@endif
								
							}
							if(data.valid == 'false'){
								$('.purchasecode').attr('disabled', true);
								$('#envato_id').css('border', '1px solid #e13a3a');
								toastr.error(data.message);
							}
							
						
						},
						error: function (data) {

						}
					});
					}
				}else{
					toastr.error('Purchase Code field is Required');
					$('.purchasecode').attr('disabled', true);
					$('#envato_id').css('border', '1px solid #e13a3a');
				}
			});


			// summernote 
			$('.note-editable').on('keyup', function(e){
				localStorage.setItem('adminmessage', e.target.innerHTML)
			})

			// store subject to local
			$('#subject').on('keyup', function(e){
				localStorage.setItem('adminsubject', e.target.value)
			})
			// store email to local
			$('#email').on('keyup', function(e){
				localStorage.setItem('adminemail', e.target.value)
			})

			// onload get the data from local
			$(window).on('load', function(){
				if(localStorage.getItem('adminsubject') || localStorage.getItem('adminmessage') || localStorage.getItem('adminemail')){

					document.querySelector('#subject').value = localStorage.getItem('adminsubject');
					document.querySelector('#email').value = localStorage.getItem('adminemail');
					document.querySelector('.summernote').innerHTML = localStorage.getItem('adminmessage');
					document.querySelector('.note-editable').innerHTML = localStorage.getItem('adminmessage');
				}
			})

			// Create Ticket 
			$('body').on('submit', '#admin_form', function (e) {
				e.preventDefault();
				$('#SubjectError').html('');
				$('#MessageError').html('');
				$('#EmailError').html('');
				$('#CategoryError').html('');
				$('#verifyotpError').html('');
				var actionType = $('#btnsave').val();
				var fewSeconds = 2;
				$('#btnsave').html('Sending..');
				$('#btnsave').prop('disabled', true);
					setTimeout(function(){
						$('#btnsave').prop('disabled', false);
					}, fewSeconds*1000);
				var formData = new FormData(this);

				$.ajax({
					type:'post',
					url: '{{url('/admin/createticket')}}',
					data: formData,
					cache:false,
					contentType: false,
					processData: false,
	
					success: (data) => {
						

						$('#SubjectError').html('');
						$('#MessageError').html('');
						$('#EmailError').html('');
						$('#CategoryError').html('');
						$('#verifyotpError').html('');
						toastr.success(data.success);
						if(localStorage.getItem('adminsubject') || localStorage.getItem('adminmessage') || localStorage.getItem('adminemail')){
							localStorage.removeItem("adminsubject");
							localStorage.removeItem("adminmessage");
							localStorage.removeItem("adminemail");
						}
						window.location.replace('{{url('admin/')}}');
						
						
						
						
					},
					error: function(data){

						$('#SubjectError').html(data.responseJSON.errors.subject);
						$('#MessageError').html(data.responseJSON.errors.message);
						$('#EmailError').html(data.responseJSON.errors.email);
						$('#CategoryError').html(data.responseJSON.errors.category);
						$('#verifyotpError').html(data.responseJSON.errors.verifyotp);
						
					}
				});
				
			});

			@endif

		</script>

		@endsection
