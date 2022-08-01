
@extends('layouts.adminmaster')

		@section('styles')

		<!-- INTERNAL Data table css -->
		<link href="{{asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css')}}?v=<?php echo time(); ?>" rel="stylesheet" />
		<link href="{{asset('assets/plugins/datatable/responsive.bootstrap5.css')}}?v=<?php echo time(); ?>" rel="stylesheet" />

		@endsection

							@section('content')

							<!--Page header-->
							<div class="page-header d-xl-flex d-block">
								<div class="page-leftheader">
									<h4 class="page-title"><span class="font-weight-normal text-muted ms-2">{{trans('langconvert.admindashboard.rolepermissions')}}</span></h4>
								</div>
							</div>
							<!--End Page header-->

							<!--Role List-->
							<div class="col-xl-12 col-lg-12 col-md-12">
								<div class="card ">
									<div class="card-header border-0 d-sm-max-flex">
										<h4 class="card-title">{{trans('langconvert.admindashboard.roleslist')}}</h4>
										<div class="card-options mt-sm-max-2">
											@can('Roles & Permission Create')

											<a href="{{url('admin/role/create')}}" class="btn btn-primary me-3" >{{trans('langconvert.admindashboard.addrole')}}</a>
											@endcan

										</div>
									</div>
									<div class="card-body" >
										<div class="table-responsive role-table">
											<table class="table  table-vcenter text-nowrap table-bordered table-striped w-100" id="roleslist">
												<thead>
													<tr>
														<th  width="10">{{trans('langconvert.admindashboard.id')}}</th>
														<th  width="10">{{trans('langconvert.admindashboard.slNo')}}</th>
														<th >{{trans('langconvert.admindashboard.role')}}</th>
														<th >{{trans('langconvert.admindashboard.employees')}}</th>
														<th >{{trans('langconvert.admindashboard.permissions')}}</th>
														<th >{{trans('langconvert.admindashboard.actions')}}</th>
													</tr>
												</thead>
												<tbody>
													
												</tbody>
											</table>
										</div>
									</div>
									</div>
								</div>
							</div>
							<!--End Role List-->
			
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
		<script src="{{asset('assets/js/support/support-admindash.js')}}?v=<?php echo time(); ?>"></script>

		<script type="text/javascript">

			"use strict";

			(function($)  {

				// Csrf Field
				$.ajaxSetup({
					headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					}
				});

				//Datatable
				$('#roleslist').DataTable({
					processing: true,
					serverSide: true,
					ajax: {
						url: "{{ url('/admin/role') }}"
					},
					columns: [
						{data: 'id', name: 'id', 'visible': false},
						{data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false,searchable: false},
						{ data: 'name', name: 'name' },
						{ data: 'rolescount', name: 'rolescount' },
						{ data: 'permissioncount', name: 'permissioncount'},
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

			})(jQuery);
			
		</script>

		@endsection