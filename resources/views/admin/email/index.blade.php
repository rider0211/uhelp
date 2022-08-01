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
									<h4 class="page-title"><span class="font-weight-normal text-muted ms-2">{{trans('langconvert.adminmenu.emailtemplate')}}</span></h4>
								</div>
							</div>
							<!--End Page header-->

							<!-- Email Template List -->
							<div class="col-xl-12 col-lg-12 col-md-12">
								<div class="card ">
									<div class="card-header border-0">
										<h4 class="card-title">{{trans('langconvert.adminmenu.emailtemplate')}}</h4>
									</div>
									<div class="card-body" >
										<div class="table-responsive">
											<table class="table table-vcenter text-nowrap table-bordered table-striped w-100" id="support-articlelists">
												<thead  >
													<tr>
														<th  width="10">{{trans('langconvert.admindashboard.id')}}</th>
														<th >{{trans('langconvert.admindashboard.title')}}</th>
														<th >{{trans('langconvert.admindashboard.lastupdated')}}</th>
														<th >{{trans('langconvert.admindashboard.action')}}</th>
													</tr>
												</thead>
												<tbody>
												@foreach ($emailtemplates as $emailtemplate)

													<tr id="row_{{$emailtemplate->id}}">
														<td>{{$emailtemplate->id}}</td>
														<td>{{$emailtemplate->title}}</td>
														<td>{{$emailtemplate->updated_at}}</td>
														<td>
															<div class = "d-flex">
																@can('Email Template Edit')

																<a href="{{ route('settings.email.edit', $emailtemplate->id) }}"  class="action-btns1">
																	<i class="feather feather-edit text-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"></i>
																</a>
																@endcan

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
							<!-- End Email Template List -->
							@endsection
		@section('scripts')

		<!-- INTERNAL Data tables -->
		<script src="{{asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
		<script src="{{asset('assets/plugins/datatable/js/dataTables.bootstrap5.js')}}"></script>
		<script src="{{asset('assets/plugins/datatable/dataTables.responsive.min.js')}}"></script>
		<script src="{{asset('assets/plugins/datatable/responsive.bootstrap5.min.js')}}"></script>

		<!-- INTERNAL Index js-->
		<script src="{{asset('assets/js/support/support-sidemenu.js')}}"></script>

		<script type="text/javascript">

			"use strict";
			
			// Datatable
			$('#support-articlelists').dataTable({
				order:[],
				responsive: true,
			});

			// select2 js in datatable
			$('.form-select').select2({
				minimumResultsForSearch: Infinity,
				width: '100%'
			});
		</script>

		@endsection
