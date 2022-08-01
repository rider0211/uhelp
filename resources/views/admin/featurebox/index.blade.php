
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
									<h4 class="page-title"><span class="font-weight-normal text-muted ms-2">{{trans('langconvert.adminmenu.featurebox')}}</span></h4>
								</div>
							</div>
							<!--End Page header-->

							<!-- Feature Box Section -->
							<div class="col-xl-12 col-lg-12 col-md-12">
								<div class="card ">
									<form method="POST" action="{{url('/admin/feature-box/feature')}}" enctype="multipart/form-data">
										@csrf

										@honeypot

										<div class="card-header border-0 d-sm-max-flex">
											<h4 class="card-title">{{trans('langconvert.admindashboard.featureboxsection')}}</h4>
										</div>
										<div class="card-body" >
											<div class="row">
												<div class="col-sm-12 col-md-12">
													<input type="hidden" class="form-control " name="id" value="{{$basic->id}}">
													<div class="form-group">
														<label class="form-label">{{trans('langconvert.admindashboard.title')}} <span class="">*</span></label>
														<input type="text" class="form-control @error('featuretitle') is-invalid @enderror" name="featuretitle" value="{{$basic->featuretitle}}">
														@error('featuretitle')

															<span class="invalid-feedback" role="alert">
																<strong>{{ $message }}</strong>
															</span>
														@enderror

													</div>
												</div>
												<div class="col-sm-12 col-md-12">
													<div class="form-group">
														<label class="form-label">{{trans('langconvert.admindashboard.subtitle')}}</label>
														<input type="text" class="form-control @error('featuresub') is-invalid @enderror" name="featuresub" value="{{$basic->featuresub}}">
														@error('featuresub')

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
							<!-- End Feature Box Section -->

							<!-- Feature Box List -->
							<div class="col-xl-12 col-lg-12 col-md-12">
								<div class="card">
									<div class="card-header border-0 d-sm-max-flex">
										<h4 class="card-title ">{{trans('langconvert.admindashboard.featureboxlist')}}</h4>
										<div class="card-options  mt-sm-max-2">
											@can('Feature Box Create')

											<a href="javascript:void(0)" class="btn btn-secondary me-3" id="create-new-featurebox">{{trans('langconvert.admindashboard.addfeature')}}</a>
											@endcan

										</div>
									</div>
									<div class="card-body" >
										<div class="table-responsive spruko-delete">
											@can('Feature Box Delete')

											<button id="massdeletenotify" class="btn btn-outline-light btn-sm mb-4 data-table-btn"><i class="fe fe-trash"></i> {{trans('langconvert.admindashboard.delete')}}</button>
											@endcan

											<table class="table table-vcenter text-nowrap table-bordered table-striped ticketdeleterow w-100" id="featurebox">
												<thead>
													<tr>
														<th width="10" >{{trans('langconvert.admindashboard.id')}}</th>
														<th width="10" >{{trans('langconvert.admindashboard.slNo')}}</th>
														@can('Feature Box Delete')

														<th width="10" >
															<input type="checkbox"  id="customCheckAll">
															<label  for="customCheckAll"></label>
														</th>
														@endcan
														@cannot('Feature Box Delete')

														<th width="10" >
															<input type="checkbox"  id="customCheckAll" disabled>
															<label  for="customCheckAll"></label>
														</th>
														@endcannot

														<th >{{trans('langconvert.admindashboard.title')}}</th>
														<th >{{trans('langconvert.admindashboard.subtitle')}}</th>
														<th >{{trans('langconvert.admindashboard.actions')}}</th>
													</tr>
												</thead>
											</table>
										</div>
									</div>
								</div>
							</div>
							<!-- End Feature Box List -->
							@endsection

				@section('modal')

   				@include('admin.featurebox.model')

				@endsection

		@section('scripts')

		<!-- INTERNAL Vertical-scroll js-->
		<script src="{{asset('assets/plugins/vertical-scroll/jquery.bootstrap.newsbox.js')}}?v=<?php echo time(); ?>"></script>


		<!-- INTERNAL Index js-->
		<script src="{{asset('assets/js/support/support-sidemenu.js')}}?v=<?php echo time(); ?>"></script>

		<!-- INTERNAL Data tables -->
		<script src="{{asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}?v=<?php echo time(); ?>"></script>
		<script src="{{asset('assets/plugins/datatable/js/dataTables.bootstrap5.js')}}?v=<?php echo time(); ?>"></script>
		<script src="{{asset('assets/plugins/datatable/dataTables.responsive.min.js')}}?v=<?php echo time(); ?>"></script>
		<script src="{{asset('assets/plugins/datatable/responsive.bootstrap5.min.js')}}?v=<?php echo time(); ?>"></script>

		<!-- INTERNAL Sweet-Alert js-->
		<script src="{{asset('assets/plugins/sweet-alert/sweetalert.min.js')}}?v=<?php echo time(); ?>"></script>

		<script type="text/javascript">

			"use strict";
			
			(function($)  {

				// Variables
				var SITEURL = '{{url('')}}';

				// Csrf field
				$.ajaxSetup({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					}
				});

				// Datatable
				$('#featurebox').DataTable({
					processing: true,
					serverSide: true,
					ajax: {
						url: "{{ url('/admin/feature-box') }}"
					},
					columns: [
						{data: 'id', name: 'id', 'visible': false},
						{data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false,searchable: false},
						{data: 'checkbox', name: 'checkbox', orderable: false,searchable: false},
						{ data: 'title', name: 'title' },
						{ data: 'subtitle', name: 'subtitle' },
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

				/*  When user click add featurebox button */
				$('#create-new-featurebox').on('click', function () {
					$('#nameError').html('');
					$('#descriptionError').html('');
					$('#ImageError').html('');
					$('#btnsave').val("create-feature");
					$('#featurebox_id').val('');
					$('#featurebox_form').trigger("reset");
					$('.modal-title').html("{{trans('langconvert.admindashboard.addnewfeature')}}");
					$('#addfeature').modal('show');
				});

				/* When click edit featurebox */
				$('body').on('click', '.edit-testimonial', function () {
					var testimonial_id = $(this).data('id');
					$.get('feature-box/' + testimonial_id , function (data) {
						$('#nameError').html('');
						$('#descriptionError').html('');
						$('#ImageError').html('');
						$('.modal-title').html("{{trans('langconvert.admindashboard.editfeature')}}");
						$('#btnsave').val("edit-testimonial");
						$('#addfeature').modal('show');
						$('#featurebox_id').val(data.id);
						$('#name').val(data.title);
						$('#description').val(data.subtitle);
				
					})
				});

				// Delete Featurebox function
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
								url: SITEURL + "/admin/feature-box/delete/"+_id,
								success: function (data) {
								var oTable = $('#featurebox').dataTable();
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

				// Feature Box Submit button
				$('body').on('submit', '#featurebox_form', function (e) {
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
						url: SITEURL + "/admin/feature-box/create",
						data: formData,
						cache:false,
						contentType: false,
						processData: false,
						success: (data) => {
							if(data.errors){
								$('#nameError').html('');
								$('#descriptionError').html('');
								$('#ImageError').html('');
								$('#nameError').html(data.errors.title);
								$('#descriptionError').html(data.errors.subtitle);
								$('#ImageError').html(data.errors.image);
								$('#btnsave').html('Save Changes');
							}
							if(data.success){
								$('#nameError').html('');
								$('#descriptionError').html('');
								$('#ImageError').html('');
								$('#featurebox_form').trigger("reset");
								$('#addfeature').modal('hide');
								$('#btnsave').html('Save Changes');
								var oTable = $('#featurebox').dataTable();
								oTable.fnDraw(false);
								toastr.success(data.success);
							}
						},
						error: function(data){
							$('#nameError').html('');
							$('#descriptionError').html('');
							$('#ImageError').html('');
							console.log('Error:', data);
							$('#btnsave').html('Save Changes');
						}
					});
				});
				// Mass Delete
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
									url:"{{ route('featurebox.deleteall')}}",
									method:"post",
									data:{id:id},
									success:function(data)
									{
										$('#featurebox').DataTable().ajax.reload();
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

				//checkbox checkall
				$('#customCheckAll').on('click', function() {
					$('.checkall').prop('checked', this.checked);
				});
				
			})(jQuery);
			
		</script>

		@endsection
