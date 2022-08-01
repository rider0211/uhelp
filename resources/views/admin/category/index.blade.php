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
									<h4 class="page-title"><span class="font-weight-normal text-muted ms-2">{{trans('langconvert.admindashboard.category')}}</span></h4>
								</div>
							</div>
							<!--End Page header-->

							<!--Category List -->
							<div class="col-xl-12 col-lg-12 col-md-12">
								<div class="card ">
									<div class="card-header border-0 d-sm-max-flex ">
										<h4 class="card-title">{{trans('langconvert.admindashboard.categorylist')}}</h4>
										<div class="card-options mt-sm-max-2">
											@can('Category Create')

											<a href="javascript:void(0)" class="btn btn-secondary me-3" id="create-new-testimonial">{{trans('langconvert.admindashboard.addcategory')}}</a>
											@endcan

											@php $module = Module::all(); @endphp

											@if(in_array('Uhelpupdate', $module))
											@if(setting('ENVATO_ON') == 'on')

												<button class="btn btn-info" id="envatoapiassign">{{trans('langconvert.newwordslang.envatoapiassign')}}</button>
											@endif
											@endif

										</div>
									</div>
									<div class="card-body" >
										<div class="table-responsive">
											<table class="table table-vcenter text-nowrap table-bordered table-striped table-striped w-100" id="support-articlelists">
												<thead>
													<tr>
														<th  width="10">{{trans('langconvert.admindashboard.id')}}</th>
														<th  width="10">{{trans('langconvert.admindashboard.slNo')}}</th>
														<th >{{trans('langconvert.admindashboard.name')}}</th>
														<th >{{trans('langconvert.admindashboard.ticketknowledge')}}</th>
														<th >{{trans('langconvert.admindashboard.assigntogroups')}}</th>
														<th >{{trans('langconvert.newwordslang.assignedpriority')}}</th>
														<th >{{trans('langconvert.admindashboard.status')}}</th>
														<th >{{trans('langconvert.admindashboard.actions')}}</th>
													</tr>
												</thead>

											</table>
										</div>
									</div>
									</div>
								</div>
							</div>
							<!-- List Category List -->
			
							@endsection


		@section('scripts')

		<!-- INTERNAL Vertical-scroll js-->
		<script src="{{asset('assets/plugins/vertical-scroll/jquery.bootstrap.newsbox.js')}}"></script>

		<!-- INTERNAL Data tables -->
		<script src="{{asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
		<script src="{{asset('assets/plugins/datatable/js/dataTables.bootstrap5.js')}}"></script>
		<script src="{{asset('assets/plugins/datatable/dataTables.responsive.min.js')}}"></script>
		<script src="{{asset('assets/plugins/datatable/responsive.bootstrap5.min.js')}}"></script>

		<!-- INTERNAL Index js-->
		<script src="{{asset('assets/js/support/support-sidemenu.js')}}"></script>

		<!--File BROWSER -->
		<script src="{{asset('assets/js/form-browser.js')}}"></script>

		<!-- INTERNAL Sweet-Alert js-->
		<script src="{{asset('assets/plugins/sweet-alert/sweetalert.min.js')}}"></script>

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
					serverSide: true,
					ajax: {
						url: "{{ url('/admin/categories') }}"
					},
					columns: [
						{data: 'id', name: 'id', 'visible': false},
						{data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false,searchable: false},
						{data: 'name', name: 'name' },
						{data: 'display', name: 'display' },
						{data: 'groupcategory', name: 'groupcategory'},
						{data: 'priority', name: 'priority'},
						{data: 'status', name: 'status'},
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
					},
				});

				/*  When user click add category button */
				$('#create-new-testimonial').on('click', function () {
					$('#btnsave').val("create-product");
					$('#testimonial_id').val('');
					$('#testimonial_form').trigger("reset");
					$('.modal-title').html("{{trans('langconvert.admindashboard.addnewcategory')}}");

					$.post('category/all', function(data){
						$('.categorysub').html(data);
						$('.categorysub').select2({
							dropdownParent: ".sprukosubcat",
							minimumResultsForSearch: '',
							width: '100%',
						});
					
					});
					$('#addtestimonial').modal('show');
				});

				/* When click edit category */
				$('body').on('click', '.edit-testimonial', function () {
					var testimonial_id = $(this).data('id');
					$.get('categories/' + testimonial_id  + '/edit', function (data) {
						$('#nameError').html('');
						$('#displayError').html('');
						$('#priorityError').html('');
						$('.modal-title').html("{{trans('langconvert.admindashboard.editcategory')}}");
						$('#btnsave').val("edit-testimonial");
						$('#addtestimonial').modal('show');
						$('#testimonial_id').val(data.post.id);
						$('#name').val(data.post.name);
						if (data.post.display == "both")
						{
							$('#display').prop('checked', true);
						}
						if (data.post.display == "ticket")
						{
							$('#display1').prop('checked', true);
						}
						if (data.post.display == "knowledge")
						{
							$('#display2').prop('checked', true);
						}
						if (data.post.priority == "Low")
						{
							$('#priority').prop('checked', true);
						}
						if (data.post.priority == "Medium")
						{
							$('#priority1').prop('checked', true);
						}
						if (data.post.priority == "High")
						{
							$('#priority2').prop('checked', true);
						}
						if (data.post.status == "1")
						{
							$('#myonoffswitch18').prop('checked', true);
						}
						$('.categorysub').select2({
							dropdownParent: ".sprukosubcat",
							minimumResultsForSearch: '',
							width: '100%',
							
						});
						$('.categorysub').html(data.output);
						

					})
				});

				/* When click delete category */
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
									url: SITEURL + "/admin/categories/"+_id,
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

				// Category status change
				$('body').on('click', '.tswitch', function () {
					var _id = $(this).data("id");
					var status = $(this).prop('checked') == true ? '1' : '0';
					$.ajax({
						type: "get",
						url: SITEURL + "/admin/categories/status"+_id,
						data: {'status': status},
						success: function (data) {
							// var oTable = $('#support-articlelists').dataTable();
							// oTable.fnDraw(false);
							toastr.success(data.success);
						},
						error: function (data) {
							console.log('Error:', data);
						}
					});
				});

				// Category group assign js
				$('body').on('click', '#assigneds', function () {
					var assigned_group = $(this).data('id');
					$('.select2_modalcategory').select2({
						minimumResultsForSearch: '',
						placeholder: "Search",
						width: '100%'
					});

					$.get('groupassigned/' + assigned_group , function (data) {
						$('#category_id').val(data.assign_data.id);
						$('#category_name').val(data.assign_data.name);
						$(".modal-title").text('{{trans('langconvert.admindashboard.assigntogroups')}}');
						$('#groupname').html('');
						$('#groupname').html(data.table_data);
						$('#addassigneds').modal('show');

					});
				});

				// Category form submit
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
						url: SITEURL + "/admin/categories/create",
						data: formData,
						cache:false,
						contentType: false,
						processData: false,
						success: (data) => {
							if(data.errors){
								$('#nameError').html('');
								$('#displayError').html('');
								$('#nameError').html(data.errors.name);
								$('#displayError').html(data.errors.display);
								$('#btnsave').html('Save Changes');
								
							}
							if(data.success){
								$('#nameError').html('');
								$('#displayError').html('');
								$('#testimonial_form').trigger("reset");
								$('#addtestimonial').modal('hide');
								$('#btnsave').html('Save Changes');
								var oTable = $('#support-articlelists').dataTable();
								oTable.fnDraw(false);
								toastr.success(data.success);
							}

						},
						error: function(data){
							toastr.error('Category name already exists');
							$('#btnsave').html('Save Changes');
						}
					});
				});

				// Assign group submit
				$('body').on('submit', '#group_form', function (e) {
					e.preventDefault();
					var assigned_id = $(this).data('id');
					var actionType = $('#btngroup').val();
					var fewSeconds = 2;
					$('#btngroup').html('Sending..');
					$('#btngroup').prop('disabled', true);
						setTimeout(function(){
							$('#btngroup').prop('disabled', false);
						}, fewSeconds*1000);
					var formData = new FormData(this);
					$.ajax({
						type:'POST',
						url: SITEURL + "/admin/groupcategory/group",
						data: formData,
						cache:false,
						contentType: false,
						processData: false,
						success: (data) => {
							$('#group_form').trigger("reset");
							$('#addassigneds').modal('hide');
							$('#btngroup').html('Save Changes');
							toastr.success(data.success);
							window.location.reload();
						},
						error: function(data){
							console.log('Error:', data);
							$('#btnsave').html('Save Changes');
						}
					});
				});

				// Assign Envato api validation
				$('#envatoapiassign').on('click', function(){

					$('.modal-title').html("{{trans('uhelpupdate::langconvert.admindashboard.assigntoenvatoapi')}}");
					$('#category_form').trigger("reset");
					$('.select2_envato').select2({

						minimumResultsForSearch: '',
						placeholder: "Search",
						width: '100%'
						
					});

					$.get('categorylist/' , function (data) {
						$('#categorys').html(data);
					});
					$('#addEnvatoapi').modal('show');

				});

				// Submit the form of envato api assigning
				$('body').on('submit', '#categoryenvato_form', function(e){
					e.preventDefault();
					var formData = new FormData(this);
					$.ajax({
						type:'POST',
						url: SITEURL + "/admin/categoryenvatoassign",
						data: formData,
						cache:false,
						contentType: false,
						processData: false,
						success: (data) => {
							toastr.success(data.success);
							$('#category_form').trigger("reset");
							$('#addEnvatoapi').modal('hide');
						},
						error: (data) => {
							console.log('abcv');
						}
					});
				});
				
			})(jQuery);
		</script>

		@endsection


		@section('modal')

		@include('admin.category.modal')

				@include('admin.category.groupmodal')

				@include('admin.category.envatocategorylist')
		@endsection

