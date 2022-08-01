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
									<h4 class="page-title"><span class="font-weight-normal text-muted ms-2">{{trans('langconvert.admindashboard.editarticle')}}</span></h4>
								</div>
							</div>
							<!--End Page header-->

							<!--Article Edit-->
							<div class="col-xl-12 col-lg-12 col-md-12">
								<div class="card ">
									<div class="card-header border-0">
										<h4 class="card-title">{{trans('langconvert.admindashboard.editarticle')}}</h4>
									</div>
									<form method="POST" action="{{url('/admin/article/'.$article->id.'/edit')}}" enctype="multipart/form-data">
										@csrf

										@honeypot
										<div class="card-body">
											<div class="form-group">
												<label class="form-label">{{trans('langconvert.admindashboard.title')}}</label>
												<input type="text" class="form-control @error('title') is-invalid @enderror"  name="title" value="{{$article->title}}">
												@error('title')

													<span class="invalid-feedback" role="alert">
														<strong>{{ $message }}</strong>
													</span>
												@enderror

											</div>
											<div class="form-group">
												<label class="form-label">{{trans('langconvert.admindashboard.category')}}</label>
												<select class="form-control select2-show-search  select2 @error('category') is-invalid @enderror" data-placeholder="Select Category" name="category" id="category">
													<option label="Select Category"></option>
													@foreach ($category as $category)

														<option value="{{ $category->id }}" @if ($category->id === 	$article->category_id) selected @endif >{{ $category->name }}</option>
													@endforeach

												</select>
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
												<label class="form-label">{{trans('langconvert.admindashboard.description')}}:</label>
												<textarea class="summernote form-control  @error('message') is-invalid @enderror" rows="6" name="message">{{$article->message}}</textarea>
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
													{{-- <input class="form-control @error('featureimage') is-invalid @enderror" name="featureimage" type="file" accept="image/png, image/jpeg,image/jpg" > --}}
													@error('featureimage')

														<span class="invalid-feedback" role="alert">
																<strong>{{ $message }}</strong>
														</span>
													@enderror

												</div>
												<small class="text-muted"><i>{{trans('langconvert.admindashboard.filesize')}}</i></small>
											</div>
											@if ($article->featureimage != null)

											<div class="file-image-1 removesprukoi{{$article->id}}">
												<div class="product-image custom-ul">
													<a href="#">
														<img src="{{asset('uploads/featureimage/' .$article->featureimage)}}" class="br-5" alt="{{$article->featureimage}}">
													</a>
													<ul class="icons">
														<li><a href="javascript:(0);" class="bg-danger imagefdel" data-id="{{$article->id}}"><i class="fe fe-trash"></i></a></li>
													</ul>
												</div>
											</div>
											@endif

											<div class="form-group">
												<label class="form-label">{{trans('langconvert.admindashboard.tags')}}</label>
												<input type="text" id="tags" class="form-control" name="tags" value="{{$article->tags}}" data-role="tagsinput" />
											</div>
											
											<div class="form-group">
												<div class="custom-controls-stacked d-md-flex">
													<label class="form-label mt-1 me-5">{{trans('langconvert.admindashboard.status')}} :</label>
													<label class="custom-control form-radio success me-4">
														<input type="radio" class="custom-control-input" name="status" value="Published" {{ $article->status == 'Published' ? 'checked' : '' }}>
														<span class="custom-control-label">{{trans('langconvert.admindashboard.publish')}}</span>
													</label>
													<label class="custom-control form-radio success me-4">
														<input type="radio" class="custom-control-input" name="status" value="UnPublished" {{ $article->status == 'UnPublished' ? 'checked' : '' }}>
														<span class="custom-control-label">{{trans('langconvert.admindashboard.unpublish')}}</span>
													</label>
												</div>
											</div>

											<div class="form-group">
												<label class="custom-control form-checkbox">
													<input type="checkbox" class="custom-control-input" name="privatemode" id="privatemode" {{$article->privatemode == 1 ? 'checked' : ''}}>
													<span class="custom-control-label">{{trans('langconvert.newwordslang.articleprivatemode')}}</span>
												</label>
											</div>
											<div class="form-group">
												<label class="form-label">{{trans('langconvert.admindashboard.uploadfile')}}:</label>
												<div class="needsclick dropzone" id="document-dropzone"></div>
												<small class="text-muted"><i>{{trans('langconvert.admindashboard.filesizenotbe')}} {{setting('FILE_UPLOAD_MAX')}}{{trans('langconvert.admindashboard.mb')}}</i></small>
											</div>


											<div class="d-flex align-items-center">
												@foreach ($article->getMedia('article') as $articles)
												<div class="file-image-1 m-1 removespruko{{$articles->id}}">
													<div class="product-image">
														<a href="javascript:void(0);">
															<img src="{{$articles->getFullUrl()}}" class="br-5" alt="{{$articles->file_name}}">
														</a>
														<ul class="icons">
															<li><a href="javascript:(0);" class="bg-danger imagedel" data-id="{{$articles->id}}"><i class="fe fe-trash"></i></a></li>
														</ul>
													</div>
												</div>
												@endforeach
											</div>

										</div>
										<div class="card-footer clearfix">
											<div class="form-group mb-0 float-end">
												<a href="{{ url('/admin/article') }}" class="btn btn-outline-danger mx-2" >{{trans('langconvert.admindashboard.close')}}</a>
												<input type="submit" class="btn btn-secondary"  value="{{trans('langconvert.admindashboard.update')}}" onclick="this.disabled=true;this.form.submit();">
											</div>
										</div>
									</form>
								</div>
							</div>
							<!--End Article Edit-->

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

			// Variables
			var SITEURL = '{{url('')}}';

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
				}
				else {
				  name = uploadedDocumentMap[file.name]
				}
				$('form').find('input[name="article[]"][value="' + name + '"]').remove()
			  },
			  init: function () {
				@if(isset($article) && $article->article)
				  var files =
					{!! json_encode($article->article) !!}
				  for (var i in files) {
					var file = files[i]
					this.options.addedfile.call(this, file)
					file.previewElement.classList.add('dz-complete')
					$('form').append('<input type="hidden" name="article[]" value="' + file.file_name + '">')
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

			// bootstrap tag js
			$('#tags').tagsinput({
				maxTags: 10
			});

			// Summernote js
			$('.summernote').summernote({
				placeholder: '',
				tabsize: 1,
				height: 120,
			});

			// Attachment delete
			$('.imagedel').on('click', function () {
				let id = $(this).data("id");
				let _url = `{{url('/admin/image/delete/${id}')}}`;
				let _token   = $('meta[name="csrf-token"]').attr('content');
				$.ajax({
					type: "DELETE",
					url: _url,
					data: {_token: _token},
					success: function (data) {
					$(".removespruko"+id).remove();
					toastr.success(data.success);
					},
					error: function (data) {
					console.log('Error:', data);
					}
				});
			});

			// Feature Image delete
			$('.imagefdel').on('click', function () {
				let id = $(this).data("id");
				let _url = `{{url('/admin/article/featureimage/${id}')}}`;
				let _token   = $('meta[name="csrf-token"]').attr('content');
				$.ajax({
					type: "post",
					url: _url,
					data: {_token: _token},
					success: function (data) {
					$(".removesprukoi"+id).remove();
					toastr.success(data.success);
					},
					error: function (data) {
					console.log('Error:', data);
					}
				});
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

			$(window).on("load", function(e) {
				$.ajax({
					url:"{{ route('admin.article', $article->id) }}",
					type:"get",
					success:function (data) {
						console.log(data);
						@if($article->subcategory != null)
							$('#selectssSubCategory').show()
							$('#subscategory').html(data);
						@endif
						
					}
				})
			});
			
		</script>

		@endsection
