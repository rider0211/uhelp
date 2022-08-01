@extends('layouts.adminmaster')

		@section('styles')

		<!-- INTERNAl Summernote css -->
		<link rel="stylesheet" href="{{asset('assets/plugins/summernote/summernote.css')}}?v=<?php echo time(); ?>">

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
									<h4 class="page-title"><span class="font-weight-normal text-muted ms-2">{{trans('langconvert.adminmenu.pages')}}</span></h4>
								</div>
							</div>
							<!--End Page header-->

							<!-- Privacy Policy & Terms of Use List -->
							<div class="col-xl-12 col-lg-12 col-md-12">
								<div class="card ">
									<div class="card-header border-0">
										<h4 class="card-title">{{trans('langconvert.adminmenu.pages')}}</h4>
										<div class="card-options mt-sm-max-2">
											@can('Pages Create')

												<a href="javascript:void(0)" class="btn btn-secondary me-3" id="create-new-pages">{{trans('langconvert.newwordslang.addpages')}}</a>
											@endcan
										</div>
									</div>
									<div class="card-body" >
										<div class="table-responsive">
											<table class="table table-vcenter text-nowrap table-bordered table-striped w-100" id="support-articlelists">
												<thead>
													<tr>
														<th  width="10">{{trans('langconvert.admindashboard.id')}}</th>
														<th  width="10">{{trans('langconvert.admindashboard.slNo')}}</th>
														<th >{{trans('langconvert.admindashboard.name')}}</th>
														<th >{{trans('langconvert.admindashboard.createddate')}} </th>
														<th >{{trans('langconvert.admindashboard.action')}}</th>
													</tr>
												</thead>
											</table>
										</div>
									</div>
								</div>
							</div>
							<!-- End Privacy Policy & Terms of Use List -->

							@endsection

		@section('scripts')

		<!-- INTERNAL Summernote js  -->
		<script src="{{asset('assets/plugins/summernote/summernote.js')}}?v=<?php echo time(); ?>"></script>

		<!-- INTERNAL Data tables -->
		<script src="{{asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}?v=<?php echo time(); ?>"></script>
		<script src="{{asset('assets/plugins/datatable/js/dataTables.bootstrap5.js')}}?v=<?php echo time(); ?>"></script>
		<script src="{{asset('assets/plugins/datatable/dataTables.responsive.min.js')}}?v=<?php echo time(); ?>"></script>
		<script src="{{asset('assets/plugins/datatable/responsive.bootstrap5.min.js')}}?v=<?php echo time(); ?>"></script>

		<!-- INTERNAL Index js-->
		<script src="{{asset('assets/js/support/support-sidemenu.js')}}?v=<?php echo time(); ?>"></script>
		<script src="{{asset('assets/js/support/support-articles.js')}}?v=<?php echo time(); ?>"></script>

		<!--File BROWSER -->
		<script src="{{asset('assets/js/form-browser.js')}}?v=<?php echo time(); ?>"></script>

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
				$('#support-articlelists').dataTable({
					processing: true,
					serverSide: true,
					ajax: {
						url: "{{ url('/admin/pages') }}"
					},
					columns: [
						{data: 'id', name: 'id', 'visible': false},
						{data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false,searchable: false},
						{ data: 'pagename', name: 'pagename' },
						{ data: 'created_at', name: 'created_at' },
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

				/*  When user click add pages button */
				$('#create-new-pages').on('click', function () 
				{
					$('#btnsave').val("create-product");
					$('#pages_id').val('');
					$('#pages_form').trigger("reset");
					$('.modal-title').html("{{trans('langconvert.newwordslang.addnewpages')}}");
					$("#pagedescription").summernote('code', '');
					$('#addtestimonial').modal('show');


				});


				/* When click edit page */
				$('body').on('click', '.edit-testimonial', function () {
					var page_id = $(this).data('id');
					$.get('pages/' + page_id , function (data) {
						$('#pages_form').trigger("reset");
						$('#nameError').html('');
						$('#descriptionError').html('');
						$('.modal-title').html("{{trans('langconvert.admindashboard.editpage')}}");
						$('#btnsave').val("edit-testimonial");
						$('#addtestimonial').modal('show');
						$('#pages_id').val(data.id);
						$("#pagedescription").summernote('code',data.pagedescription);
						$('#pagename').val(data.pagename);
						if (data.viewonpages == "both")
						{

							$('#display').prop('checked', true);
						}
						if (data.viewonpages == "header")
						{

							$('#display1').prop('checked', true);
						}
						if (data.viewonpages == "footer")
						{

							$('#display2').prop('checked', true);
						}

						if (data.status == "1")
						{

							$('#myonoffswitch18').prop('checked', true);
						}

					})
				});

				// submit button when click edit or add pages
				$('body').on('submit', '#pages_form', function (e) {
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
						url: SITEURL + "/admin/pages/create",
						data: formData,
						cache:false,
						contentType: false,
						processData: false,

						success: (data) => {

							$('#nameError').html('');
							$('#descriptionError').html('');
							$('#pages_form').trigger("reset");
							$('#addtestimonial').modal('hide');
							$('#btnsave').html('Save Changes');
							var oTable = $('#support-articlelists').dataTable();
							oTable.fnDraw(false);
							toastr.success(data.success);
						},
						error: function(data){
							$('#nameError').html('');
							$('#descriptionError').html('');
							$('#nameError').html(data.responseJSON.errors.pagename);
							$('#descriptionError').html(data.responseJSON.errors.pagedescription);
							$('#btnsave').html('Save Changes');
						}
					});
				});

				/* When click delete pages */
				$('body').on('click', '.delete-pages', function () {
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
								type: "post",
								url: SITEURL + "/admin/pagesdelete/"+_id,
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

			})(jQuery);

		</script>

		@endsection

		@section('modal')

    		@include('admin.generalpage.model')
			
		@endsection
