@extends('layouts.adminmaster')

		@section('styles')

		<!-- INTERNAL Data table css -->
		<link href="{{asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css')}}?v=<?php echo time(); ?>" rel="stylesheet" />
		<link href="{{asset('assets/plugins/datatable/responsive.bootstrap5.css')}}?v=<?php echo time(); ?>" rel="stylesheet" />

		<!-- INTERNAL Sweet-Alert css -->
		<link href="{{asset('assets/plugins/sweet-alert/sweetalert.css')}}?v=<?php echo time(); ?>" rel="stylesheet" />

		@endsection

							@section('content')

							<!--Page header-->
							<div class="page-header d-xl-flex d-block">
								<div class="page-leftheader">
									<h4 class="page-title"><span class="font-weight-normal text-muted ms-2">{{trans('langconvert.adminmenu.testimonial')}}</span></h4>
								</div>
							</div>
							<!--End Page header-->

							<!--Testimonial Section-->
							<div class="col-xl-12 col-lg-12 col-md-12">
								<div class="card ">
									<form method="POST" action="{{url('/admin/testimonial')}}" enctype="multipart/form-data">
										@csrf

										@honeypot

										<div class="card-header border-0 d-sm-max-flex">
											<h4 class="card-title">{{trans('langconvert.admindashboard.testimonialsection')}}</h4>
											<div class="card-options card-header-styles mt-sm-max-2">
												<small class="me-1 mt-1">{{trans('langconvert.admindashboard.sectionhide')}}</small>
												<div class="float-end mt-0">
													<div class="switch-toggle">
														<a class="onoffswitch2">
															<input type="checkbox"  name="testimonialcheck" id="testimonialchecks" class=" toggle-class onoffswitch2-checkbox" value="on" @if($basic->testimonialcheck == 'on')  checked=""  @endif>
															<label for="testimonialchecks" class="toggle-class onoffswitch2-label" ></label>
														</a>
													</div>
												</div>
											</div>
										</div>
										<div class="card-body" >
											<div class="row">
												<div class="col-sm-12 col-md-12">
													<input type="hidden" class="form-control " name="id" value="{{$basic->id}}">
													<div class="form-group">
														<label class="form-label">{{trans('langconvert.admindashboard.title')}} <span class="text-red">*</span></label>
														<input type="text" class="form-control @error('testimonialtitle') is-invalid @enderror" name="testimonialtitle" value="{{$basic->testimonialtitle}}">
														@error('testimonialtitle')

															<span class="invalid-feedback" role="alert">
																<strong>{{ $message }}</strong>
															</span>
														@enderror

													</div>
												</div>
												<div class="col-sm-12 col-md-12">
													<div class="form-group">
														<label class="form-label">{{trans('langconvert.admindashboard.subtitle')}}</label>
														<input type="text" class="form-control @error('testimonialsub') is-invalid @enderror" name="testimonialsub" value="{{$basic->testimonialsub}}">
														@error('testimonialsub')

															<span class="invalid-feedback" role="alert">
																<strong>{{ $message }}</strong>
															</span>
														@enderror

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
							<!--End Testimonial Section-->

							<!--Testimonial List-->
							<div class="col-xl-12 col-lg-12 col-md-12">
								<div class="card ">
									<div class="card-header border-0 d-sm-max-flex">
										<h4 class="card-title">{{trans('langconvert.admindashboard.testimoniallist')}}</h4>
										<div class="card-options mt-sm-max-2">
											@can('Testimonial Create')

											<a href="javascript:void(0)" class="btn btn-secondary me-3" id="create-new-testimonial">{{trans('langconvert.admindashboard.addtestimonial')}}</a>
											@endcan

										</div>
									</div>
									<div class="card-body" >
										<div class="table-responsive spruko-delete">
											@can('Testimonial Delete')

											<button id="massdeletenotify" class="btn btn-outline-light btn-sm mb-4 data-table-btn"><i class="fe fe-trash"></i> {{trans('langconvert.admindashboard.delete')}}</button>
											@endcan

											<table class="table table-vcenter text-nowrap table-bordered table-striped ticketdeleterow w-100" id="support-articlelists">
												<thead>
													<tr>
														<th  width="10">{{trans('langconvert.admindashboard.id')}}</th>
														<th  width="10">{{trans('langconvert.admindashboard.slNo')}}</th>
														@can('Testimonial Delete')

														<th width="10" >
															<input type="checkbox"  id="customCheckAll">
															<label  for="customCheckAll"></label>
														</th>
														@endcan
														@cannot('Testimonial Delete')

														<th width="10" >
															<input type="checkbox"  id="customCheckAll" disabled>
															<label  for="customCheckAll"></label>
														</th>
														@endcannot

														<th >{{trans('langconvert.admindashboard.name')}}</th>
														<th >{{trans('langconvert.admindashboard.designation')}}</th>
														<th >{{trans('langconvert.admindashboard.actions')}}</th>
													</tr>
												</thead>
											</table>
										</div>
									</div>
								</div>
							</div>
							<!--End Testimonial List-->

							@endsection
	@section('modal')

   	@include('admin.testimonial.model')

	@endsection

		@section('scripts')

		<!-- INTERNAL Vertical-scroll js-->
		<script src="{{asset('assets/plugins/vertical-scroll/jquery.bootstrap.newsbox.js')}}?v=<?php echo time(); ?>"></script>

		<!-- INTERNAL Data tables -->
		<script src="{{asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}?v=<?php echo time(); ?>"></script>
		<script src="{{asset('assets/plugins/datatable/js/dataTables.bootstrap5.js')}}?v=<?php echo time(); ?>"></script>
		<script src="{{asset('assets/plugins/datatable/dataTables.responsive.min.js')}}?v=<?php echo time(); ?>"></script>
		<script src="{{asset('assets/plugins/datatable/responsive.bootstrap5.min.js')}}?v=<?php echo time(); ?>"></script>
		<script src="{{asset('assets/plugins/datatable/datatablebutton.min.js')}}?v=<?php echo time(); ?>"></script>
		<script src="{{asset('assets/plugins/datatable/buttonbootstrap.min.js')}}?v=<?php echo time(); ?>"></script>

		<!-- INTERNAL Index js-->
		<script src="{{asset('assets/js/support/support-sidemenu.js')}}?v=<?php echo time(); ?>"></script>

		<!-- INTERNAL Sweet-Alert js-->
		<script src="{{asset('assets/plugins/sweet-alert/sweetalert.min.js')}}?v=<?php echo time(); ?>"></script>

        <script type="text/javascript">

			"use strict";

			(function($)  {

				// Variables
				var SITEURL = '{{url('')}}';

				// Csrf Field
				$.ajaxSetup({
					headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					}
				});

				// Datatable
				$('#support-articlelists').dataTable({

					processing: true,
					serverSide: true,
					ajax: {
					url: "{{ url('/admin/testimonial') }}"
					},
					columns: [
						{data: 'id', name: 'id', 'visible': false},
						{data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false,searchable: false},
						{data: 'checkbox', name: 'checkbox', orderable: false,searchable: false},
						{data: 'name', name: 'name' },
						{data: 'designation', name: 'designation' },
						{data: 'action', name: 'action', orderable: false},
					],
					order:[],
					responsive: true,
					drawCallback: function () {
						var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
						var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
							return new bootstrap.Tooltip(tooltipTriggerEl)
						});
						$('.form-select').select2({
							minimumResultsForSearch: Infinity,
							width: '100%'
						});
						$('#customCheckAll').prop('checked', false);
						$('.checkall').on('click', function(){
							if($('.checkall:checked').length == $('.checkall').length){
								$('#customCheckAll').prop('checked', true);
							}else{
								$('#customCheckAll').prop('checked', false);
							}
						});
					},
				});

				/*  When user click add testimonial button */
				$('#create-new-testimonial').on('click', function () {
					$('#btnsave').val("create-product");
					$('#testimonial_id').val('');
					$('#testimonial_form').trigger("reset");
					$('.modal-title').html("{{trans('langconvert.admindashboard.addnewtestimonial')}}");
					$('#addtestimonial').modal('show');
					$('#image-preview').attr('src', '{{asset('assets/images/imagepreview/displayimage.png')}}');
				});

				/* When click edit testimonial */
				$('body').on('click', '.edit-testimonial', function () {
					var testimonial_id = $(this).data('id');
					$.get('testimonial/' + testimonial_id , function (data) {
						$('#nameError').html('');
						$('#descriptionError').html('');
						$('#designationError').html('');
						$('#imageError').html('');

						$('.modal-title').html("{{trans('langconvert.admindashboard.edittestimonial')}}");
						$('#btnsave').val("edit-testimonial");
						$('#addtestimonial').modal('show');
						$('#testimonial_id').val(data.id);
						$('#name').val(data.name);
						$('#designation').val(data.designation);
						$('#description').val(data.description);
						$('#image-preview').attr('alt', 'No image available');
						if(data.image){
							$('#image-preview').attr('src', SITEURL +'/uploads/testimonial/'+data.image);
							$('#image').attr('src', SITEURL +'/uploads/testimonial/'+data.image);
						}
					})
				});

				// Delete Testimonial
				$('body').on('click', '#delete-testimonial', function () {
					var _id = $(this).data("id");
					swal({
						title: `{{trans('langconvert.admindashboard.wanttocontinue')}}`,
						text: "{{trans('langconvert.admindashboard.eraserecordspermanently')}}",
						icon: "warning",
						buttons: true,
						dangerMode: true,
					})
					.then((willDelete) => {
						if (willDelete) {
							$.ajax({
								type: "get",
								url: SITEURL + "/admin/testimonial/delete/"+_id,
								success: function (data) {
								var oTable = $('#support-articlelists').dataTable();
								oTable.fnDraw(false);
								toastr.error(data.error);
								},
								error: function (data) {
								console.log('Error:', data);
								}
							});
						}
					});
				});

				// Mass Delete Testimonial
				$('body').on('click', '#massdeletenotify', function () {
					var id = [];
					$('.checkall:checked').each(function(){
						id.push($(this).val());
					});
					if(id.length > 0){
						swal({
							title: `{{trans('langconvert.admindashboard.wanttocontinue')}}`,
							text: "{{trans('langconvert.admindashboard.eraserecordspermanently')}}",
							icon: "warning",
							buttons: true,
							dangerMode: true,
						})
						.then((willDelete) => {
							if (willDelete) {
								$.ajax({
									url:"{{ route('testimonial.deleteall')}}",
									method:"post",
									data:{id:id},
									success:function(data)
									{
										$('#support-articlelists').DataTable().ajax.reload();
										toastr.error(data.error);
													
									},
									error:function(data){
										console.log(data);
									}
								});
							}
						});			
					}else{
						toastr.error('{{trans('langconvert.functions.checkboxselect')}}');
					}
					

				});

				// Testimonial submit form
				$('body').on('submit', '#testimonial_form', function (e) {
					e.preventDefault();
					var actionType = $('#btnsave').val();
					var fewSeconds = 2;
					$('#btnsave').html('Sending..');
					$('#btnsave').prop('disabled', true);
						setTimeout(function(){
							$('#btnsave').prop('disabled', false);
						}, fewSeconds*1000);
					var formData = new FormData(this);
					$.ajax({
					type:'POST',
					url: SITEURL + "/admin/testimonial/create",
					data: formData,
					cache:false,
					contentType: false,
					processData: false,

					success: (data) => {
						$('#nameError').html('');
						$('#descriptionError').html('');
						$('#designationError').html('');
						$('#imageError').html('');

						$('#testimonial_form').trigger("reset");
						$('#addtestimonial').modal('hide');
						$('#btnsave').html('Save Changes');
						var oTable = $('#support-articlelists').dataTable();
						oTable.fnDraw(false);
						toastr.success(data.success);
					},
					error: function(data){
						
						$('#nameError').html('');
						$('#descriptionError').html('');
						$('#designationError').html('');
						$('#imageError').html('');
						$('#nameError').html(data.responseJSON.errors.name);
						$('#descriptionError').html(data.responseJSON.errors.description);
						$('#designationError').html(data.responseJSON.errors.designation);
						$('#imageError').html(data.responseJSON.errors.image);
						$('#btnsave').html('Save Changes');
					}
					});
				});
				
				// Checkbox checkall
				$('#customCheckAll').on('click', function() {
					$('.checkall').prop('checked', this.checked);
				});

			})(jQuery);
		</script>

		@endsection
