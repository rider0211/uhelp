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
									<h4 class="page-title"><span class="font-weight-normal text-muted ms-2">{{trans('langconvert.newwordslang.subcategory')}}</span></h4>
								</div>
							</div>
							<!--End Page header-->


							<div class="col-xl-12 col-lg-12 col-md-12">
								<div class="card ">
									<div class="card-header border-0 d-sm-max-flex ">
										<h4 class="card-title">{{trans('langconvert.newwordslang.subcategorylist')}}</h4>
										<div class="card-options mt-sm-max-2">
											@can('Subcategory Create')

												<a href="javascript:void(0)" class="btn btn-secondary me-3" id="create-new-subcategory">{{trans('langconvert.newwordslang.addsubcategory')}}</a>
											@endcan
										
											
										</div>
									</div>
									<div class="card-body" >
										<div class="table-responsive">
											<table class="table table-vcenter text-nowrap  table-bordered table-striped table-striped w-100" id="support-articlelists">
												<thead>
													<tr>
														<th  width="10">{{trans('langconvert.admindashboard.slNo')}}</th>
														<th >{{trans('subcategory')}}</th>
														<th >{{trans('Parent Category list')}}</th>
														<th >{{trans('langconvert.admindashboard.status')}}</th>
														<th >{{trans('langconvert.admindashboard.actions')}}</th>
													</tr>
												</thead>
												<tbody>
													@php $i = 1; @endphp

													@foreach($subcategory as $subcats)
														<tr>
															<td>{{$i++}}</td>
															<td>{{$subcats->subcategoryname}}</td>
															<td>
																@foreach($subcats->subcategorylist as $subcatlist)
																<span class="badge badge-info-light">
																	{{$subcatlist->subcatlistss->name}}
																</span>
																@endforeach
															</td>
															<td>
																<label class="custom-switch form-switch mb-0">
																	<input type="checkbox" name="status" data-id="{{$subcats->id}}" id="myonoffswitch{{$subcats->id}}" value="1" class="custom-switch-input stswitch" {{$subcats->status == 1 ? 'checked' : ''}}>
																	<span class="custom-switch-indicator"></span>
																</label>
																
															</td>
															<td>
																<div class = "d-flex">
																	@can('Subcategory Edit')

																	<a href="javascript:void(0)" class="action-btns1 edit-subcategory" data-id="{{$subcats->id}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><i class="feather feather-edit text-primary"></i></a>
																	@endcan
																	@can('Subcategory Delete')

																	<a href="javascript:void(0)" class="action-btns1 delete-subcategory" data-id="{{$subcats->id}}" id="show-delete" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><i class="feather feather-trash-2 text-danger"></i></a>
																	@endcan
																	@cannot('Subcategory Edit')
																	~
																	@endcannot
																	@cannot('Subcategory Delete')
																	~
																	@endcannot
																</div>
															</td>
														</tr>
													@endforeach
												</tbody>
											</table>
										</div>
									</div>
									</div>
								</div>
							</div>
			
							@endsection


		@section('scripts')

		<!-- INTERNAL Vertical-scroll js-->
		<script src="{{asset('assets/plugins/vertical-scroll/jquery.bootstrap.newsbox.js')}}?v=<?php echo time(); ?>"></script>

		<!-- INTERNAL Data tables -->
		<script src="{{asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}?v=<?php echo time(); ?>"></script>
		<script src="{{asset('assets/plugins/datatable/js/dataTables.bootstrap5.js')}}?v=<?php echo time(); ?>"></script>
		<script src="{{asset('assets/plugins/datatable/dataTables.responsive.min.js')}}?v=<?php echo time(); ?>"></script>
		<script src="{{asset('assets/plugins/datatable/responsive.bootstrap5.min.js')}}?v=<?php echo time(); ?>"></script>

		<!-- INTERNAL Index js-->
		<script src="{{asset('assets/js/support/support-sidemenu.js')}}?v=<?php echo time(); ?>"></script>

		<!-- INTERNAL Sweet-Alert js-->
		<script src="{{asset('assets/plugins/sweet-alert/sweetalert.min.js')}}?v=<?php echo time(); ?>"></script>

		<script type="text/javascript">

			"use strict";

			(function($)  {

				// Variables
				var SITEURL = '{{url('')}}';

				// select2 js
				$('.select2').select2({
					minimumResultsForSearch: Infinity
				});

				// Csrf field
				$.ajaxSetup({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					}
				});
				
				// Datatable
				$('#support-articlelists').dataTable({
					processing: true,
					order:[],
					responsive: true,
				});

                /*  When user click add category button */
				$('#create-new-subcategory').on('click', function () {
					$('#btnsave').val("create-product");
					$('#subcategory_id').val('');
					$('#nameError').html('');
					$('#displayError').html('');
					$('#priorityError').html('');
					$('.categorysub').html('');
					$('#subcategory_form').trigger("reset");
					$('.modal-title').html("{{trans('langconvert.newwordslang.addnewsubcategory')}}");
					$('.categorysub').select2({
						minimumResultsForSearch: '',
					});
					$.post('category/all', function(data){
						$('.categorysub').html(data);
					});
					
					$('#addsubcategory').modal('show');


				});

				/* When click edit category */
				$('body').on('click', '.edit-subcategory', function () {
					var subcategory_id = $(this).data('id');
					$('.categorysub').select2({
						minimumResultsForSearch: '',
					});
					$.get('subcategories/' + subcategory_id  + '/edit', function (data) {
						$('#subcategory_form').trigger("reset");
						$('#nameError').html('');
						$('#displayError').html('');
						$('#priorityError').html('');
						$('.categorysub').html('');
						$('.modal-title').html("{{trans('langconvert.newwordslang.editsubcategory')}}");
						$('#btnsave').val("edit-testimonial");
						$('#addsubcategory').modal('show');
						$('#subcategory_id').val(data.subcategory.id);
						$('#name').val(data.subcategory.subcategoryname);
						$('.categorysub').html(data.categorylist);
						if (data.subcategory.status == "1")
						{
							$('#myonoffswitch18').prop('checked', true);
						}
						

						

					})
				});


				// Category form submit
				$('body').on('submit', '#subcategory_form', function (e) {
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
						url: "{{route('subcategorys.store')}}",
						data: formData,
						cache:false,
						contentType: false,
						processData: false,
						success: (data) => {
							if(data.errors){
								$('#nameError').html('');
								$('#displayError').html('');
								$('#priorityError').html('');
								$('#nameError').html(data.errors.name);
								$('#displayError').html(data.errors.display);
								$('#priorityError').html(data.errors.priority);
								$('#btnsave').html('Save Changes');
								
							}
							if(data.success){
								$('#nameError').html('');
								$('#displayError').html('');
								$('#priorityError').html('');
								$('#subcategory_form').trigger("reset");
								$('#addsubcategory').modal('hide');
								$('#btnsave').html('Save Changes');
								toastr.success(data.success);
								location.reload();
							}

						},
						error: function(data){
							toastr.error('Category name already exists');
							$('#btnsave').html('Save Changes');
						}
					});
				});

				//status On Off
				$('body').on('change', '.stswitch', function(){
					let id = $(this).data('id');
					let status = $(this).prop('checked') == true ? '1' : '0';
					$.ajax({
						type: "POST",
						dataType: "json",
						url: '{{route('category.admin.subcategorystatusupdate')}}',
						data: {
							'status': status,
							'id': id,
						},
						success:function(data){
							toastr.success(data.success);
						},
						error:function(data){

						}
					});
				});

				// Delete subcategory
				$('body').on('click', '.delete-subcategory', function(){
					let id = $(this).data('id');
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
								type: "POST",
								dataType: "json",
								url: '{{route('category.admin.subcategorydelete')}}',
								data: {
									'id': id,
								},
								success:function(data){
									toastr.error(data.error);
									location.reload();
								},
								error:function(data){

								}
							});
						}
					});
				});


				$('.form-select').select2({
					minimumResultsForSearch: Infinity,
					width: '100%'
				});
		
			})(jQuery);

		</script>

		@endsection


		@section('modal')

		@include('admin.category.subcategorymodal')

		@endsection

