@extends('layouts.adminmaster')

		@section('styles')

		<!-- INTERNAl Summernote css -->
		<link rel="stylesheet" href="{{asset('assets/plugins/summernote/summernote.css')}}?v=<?php echo time(); ?>">

		<!-- INTERNAl dropzone css -->
		<link href="{{asset('assets/plugins/dropzone/dropzone.css')}}?v=<?php echo time(); ?>" rel="stylesheet" />

		<!-- INTERNAl bootstraptag css -->
		<link href="{{asset('assets/plugins/taginput/bootstrap-tagsinput.css')}}?v=<?php echo time(); ?>" rel="stylesheet" />

		@endsection

							@section('content')

							<!--Page header-->
							<div class="page-header d-xl-flex d-block">
								<div class="page-leftheader">
									<h4 class="page-title"><span class="font-weight-normal text-muted ms-2">{{trans('langconvert.admindashboard.newarticle')}}</span></h4>
								</div>
							</div>
							<!--End Page header-->
							
							<!--Article Create-->
							<div class="col-xl-12 col-lg-12 col-md-12">
								<div class="card ">
									<div class="card-header border-0">
										<h4 class="card-title">{{trans('langconvert.admindashboard.addnewarticle')}}</h4>
									</div>
									<form method="post"  enctype="multipart/form-data" id="adminarticle_forms">

										@honeypot
										<div class="card-body">
											<div class="form-group">
												<label class="form-label">{{trans('langconvert.admindashboard.title')}} <span class="text-red">*</span></label>
												<input type="text" class="form-control @error('title') is-invalid @enderror" placeholder="Subject" name="title" value="{{old('title')}}" id="subject">
												<span id="TitleError" class="text-danger alert-message"></span>
												@error('title')

													<span class="invalid-feedback" role="alert">
														<strong>{{ $message }}</strong>
													</span>
												@enderror

											</div>
											<div class="form-group">
												<label class="form-label">{{trans('langconvert.admindashboard.category')}} <span class="text-red">*</span></label>
												<select class="form-control select2-show-search  select2 @error('category') is-invalid @enderror" data-placeholder="Select Category" name="category" id="category">
													<option label="Select Category"></option>
													@foreach ($category as $category)

														<option value="{{ $category->id }}" @if(old('category') == $category->id ) selected @endif>{{ $category->name }}</option>
													@endforeach

												</select>
												<span id="CategoryError" class="text-danger alert-message"></span>
												@error('category')

													<span class="invalid-feedback" role="alert">
														<strong>{{ $message }}</strong>
													</span>
												@enderror

											</div>
											<div class="form-group" id="selectssSubCategory" style="display: none;">
													<label class="form-label mb-0 mt-2">{{trans('langconvert.newwordslang.subcategory')}}</label>
													<select  class="form-control select2-show-search  select2"  data-placeholder="Select SubCategory" name="subscategory" id="subscategory">
													</select>
													<span id="subsCategoryError" class="text-danger alert-message"></span>
											</div>
											<div class="form-group">
												<label class="form-label">{{trans('langconvert.admindashboard.description')}}: <span class="text-red">*</span></label>
												<textarea class="summernote d-none @error('message') is-invalid @enderror" name="message" id="summernote">{{old('message')}}</textarea>
												<span id="MessageError" class="text-danger alert-message"></span>
												@error('message')

													<span class="invalid-feedback" role="alert">
														<strong>{{ $message }}</strong>
													</span>

												@enderror
											</div>
											<div class="form-group">
												<label class="form-label">{{trans('langconvert.admindashboard.featureimage')}}</label>
												<div class="input-group file-browser">
													<div class="needsclick dropzone" id="feature-image"></div>
													@error('featureimage')

														<span class="invalid-feedback" role="alert">
																<strong>{{ $message }}</strong>
														</span>
													@enderror
													<span id="FeatureimageError" class="text-danger alert-message"></span>

												</div>
												<small class="text-muted"><i>{{trans('langconvert.admindashboard.filesize')}}</i></small>
											</div>
											<div class="form-group">
												<label class="form-label">{{trans('langconvert.admindashboard.tags')}} <span class="text-red">*</span></label>
												<input type="text" id = "tags" class="form-control @error('tags') is-invalid @enderror" name="tags" value="{{old('tags')}}" data-role="tagsinput" />
												@error('tags')

													<span class="invalid-feedback" role="alert">
														<strong>{{ $message }}</strong>
													</span>
												@enderror
												<span id="TagsError" class="text-danger alert-message"></span>

											</div>
											<div class="form-group">
												<label class="form-label">{{trans('langconvert.admindashboard.uploadfile')}}:</label>
												<div class="needsclick dropzone" id="document-dropzone"></div>
												<small class="text-muted"><i>{{trans('langconvert.admindashboard.filesizenotbe')}} {{setting('FILE_UPLOAD_MAX')}}{{trans('langconvert.admindashboard.mb')}}</i></small>
											</div>
											<div class="form-group">
												<div class="custom-controls-stacked d-md-flex @error('status') is-invalid @enderror">
													<label class="form-label mt-1 me-5">{{trans('langconvert.admindashboard.status')}} : <span class="text-red">*</span></label>
													<label class="custom-control form-radio success me-4">
														<input type="radio" class="custom-control-input " name="status" value="Published">
														<span class="custom-control-label">{{trans('langconvert.admindashboard.publish')}}</span>
													</label>
													<label class="custom-control form-radio success me-4">
														<input type="radio" class="custom-control-input" name="status" value="UnPublished">
														<span class="custom-control-label">{{trans('langconvert.admindashboard.unpublish')}}</span>
													</label>
												</div>
												@error('status')

													<div class="invalid-feedback" role="alert">
														<strong>{{ $message }}</strong>
													</div>
												@enderror
												<span id="StatusError" class="text-danger alert-message"></span>
											</div>

											<div class="form-group">
												<label class="custom-control form-checkbox">
													<input type="checkbox" class="custom-control-input" name="privatemode" id="privatemode" >
													<span class="custom-control-label">{{trans('langconvert.newwordslang.articleprivatemode')}}</span>
												</label>
											</div>

										</div>
										<div class="card-footer clearfix">
											<div class="form-group float-end mb-0 btn-list">
												<a href="{{ url('/admin/article') }}" class="btn btn-outline-danger" >{{trans('langconvert.admindashboard.close')}}</a>
												<button type="submit" class="btn btn-secondary" >{{trans('langconvert.admindashboard.save')}}</button>
											</div>
										</div>
									</form>
								</div>
							</div>
							<!--End Article Create-->

							@endsection


		@section('scripts')

		<!-- INTERNAL Vertical-scroll js-->
		<script src="{{asset('assets/plugins/vertical-scroll/jquery.bootstrap.newsbox.js')}}?v=<?php echo time(); ?>"></script>

		<!-- INTERNAL Summernote js  -->
		<script src="{{asset('assets/plugins/summernote/summernote.js')}}?v=<?php echo time(); ?>"></script>

		<!-- INTERNAL Index js-->
		<script src="{{asset('assets/js/support/support-sidemenu.js')}}?v=<?php echo time(); ?>"></script>
		<script src="{{asset('assets/js/select2.js')}}?v=<?php echo time(); ?>"></script>

		<!-- INTERNAL dropzone js-->
		<script src="{{asset('assets/plugins/dropzone/dropzone.js')}}?v=<?php echo time(); ?>"></script>

		<!-- INTERNAL bootstraptag js-->
		<script src="{{asset('assets/plugins/taginput/bootstrap-tagsinput.js')}}?v=<?php echo time(); ?>"></script>

		<script type="text/javascript">

			"use strict";

			// Csrf field
			$.ajaxSetup({
				headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});

			// Attachment Image Upload
			var uploadedDocumentMap = {}
			Dropzone.options.documentDropzone = {
			  	url: '{{route('admin.imageupload')}}',
			  	maxFilesize: '{{setting('FILE_UPLOAD_MAX')}}', // MB
			  	addRemoveLinks: true,
			  	acceptedFiles: '{{setting('FILE_UPLOAD_TYPES')}}',
				headers: {
					'X-CSRF-TOKEN': "{{ csrf_token() }}"
				},
			  	success: function (file, response) {
					$('form').append('<input type="hidden" name="article[]" value="' + response.name + '">')
					uploadedDocumentMap[file.name] = response.name
			  	},
			 	removedfile: function (file) {
					file.previewElement.remove()
					var name = ''
					if (typeof file.file_name !== 'undefined') {
				  		name = file.file_name
					} else {
				 		 name = uploadedDocumentMap[file.name]
					}
					$('form').find('input[name="article[]"][value="' + name + '"]').remove()
			  	},
			  	init: function () {
					@if(isset($project) && $project->document)
				  		var files =
							{!! json_encode($project->document) !!}
				  		for (var i in files) {
							var file = files[i]
							this.options.addedfile.call(this, file)
							file.previewElement.classList.add('dz-complete')
							$('form').append('<input type="hidden" name="article[]" value="' + file.file_name + '">')
				  		}
					@endif

					this.on('error', function(file, errorMessage) {
						if (errorMessage.message) {
							console.log(errorMessage);
							var errorDisplay = document.querySelectorAll('[data-dz-errormessage]');
							errorDisplay[errorDisplay.length - 1].innerHTML = errorMessage.message;
						}
					});
			  	}
			}

			// Feature Image
			Dropzone.options.featureImage = {
			  	url: '{{route('admin.featureimageupload')}}',
			  	maxFilesize: '5', // MB
			  	addRemoveLinks: true,
			  	acceptedFiles: '.jpeg,.jpg,.png',
				  maxFiles: 1,
				headers: {
					'X-CSRF-TOKEN': "{{ csrf_token() }}"
				},
			  	success: function (file, response) {
					$('form').append('<input type="hidden" name="featureimage" value="' + response.name + '">')
					uploadedDocumentMap[file.name] = response.name
			  	},
			 	removedfile: function (file) {
					file.previewElement.remove()
					var name = ''
					if (typeof file.file_name !== 'undefined') {
				  		name = file.file_name
					} else {
				 		 name = uploadedDocumentMap[file.name]
					}
					$('form').find('input[name="featureimage"][value="' + name + '"]').remove()
			  	},
			  	init: function () {
					@if(isset($project) && $project->document)
				  		var files =
							{!! json_encode($project->document) !!}
				  		for (var i in files) {
							var file = files[i]
							this.options.addedfile.call(this, file)
							file.previewElement.classList.add('dz-complete')
							$('form').append('<input type="hidden" name="featureimage" value="' + file.file_name + '">')
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

			// Bootstrap tag js
			$('#tags').tagsinput({
				maxTags: 10
			});

			// Summernote js
			$('.summernote').summernote({
				placeholder: '',
				tabsize: 1,
				height: 120,
			});

			// when category change its get the subcat list 
			$('#category').on('change',function(e) {
				e.preventDefault();
				var cat_id = e.target.value;
				$('#selectssSubCategory').hide();
				$.ajax({
					url:"{{ route('guest.subcategorylist') }}",
					type:"POST",
					dataType: "json",
						data: {
						cat_id: cat_id
						},
					success:function (data) {
						if(data.subcategoriess){
							
							$('#selectssSubCategory').hide()
							$('#subscategory').html(data.subcategoriess)
							$('.subcategoryselect').select2();
							$('#selectssSubCategory').show()
						}
						else{
							$('#selectssSubCategory').hide();
							$('#subscategory').html('')
						}
					}
				})
			});

			// store subject to local
			$('#subject').on('keyup', function(e){
				localStorage.setItem('articlesubject', e.target.value)
			})

			// summernote 
			$('.note-editable').on('keyup', function(e){
				localStorage.setItem('articlemessage', e.target.innerHTML)
			})
			

			// onload get the data from local
			$(window).on('load', function(){
				if(localStorage.getItem('articlesubject') || localStorage.getItem('articlemessage')){

					document.querySelector('#subject').value = localStorage.getItem('articlesubject');
					document.querySelector('.summernote').innerHTML = localStorage.getItem('articlemessage');
					document.querySelector('.note-editable').innerHTML = localStorage.getItem('articlemessage');
				}
			})

			// Create Ticket 
			$('body').on('submit', '#adminarticle_forms', function (e) {
				e.preventDefault();
				$('#TitleError').html('');
				$('#CategoryError').html('');
				$('#MessageError').html('');
				$('#TagsError').html('');
				$('#StatusError').html('');
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
					url: '{{url('/admin/article/create')}}',
					data: formData,
					cache:false,
					contentType: false,
					processData: false,
	
					success: (data) => {
						

						$('#TitleError').html('');
						$('#CategoryError').html('');
						$('#MessageError').html('');
						$('#TagsError').html('');
						$('#StatusError').html('');
						toastr.success(data.success);
						if(localStorage.getItem('articlesubject') || localStorage.getItem('articlemessage')){
							localStorage.removeItem("articlesubject");
							localStorage.removeItem("articlemessage");
						}
						window.location.replace('{{url('admin/article')}}');
						
						
						
						
					},
					error: function(data){

						$('#TitleError').html(data.responseJSON.errors.title);
						$('#CategoryError').html(data.responseJSON.errors.category);
						$('#MessageError').html(data.responseJSON.errors.message);
						$('#TagsError').html(data.responseJSON.errors.tags);
						$('#StatusError').html(data.responseJSON.errors.status);
						
					}
				});
				
			});

		</script>
		
		@endsection
