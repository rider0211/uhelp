@extends('layouts.adminmaster')

		@section('styles')

		<!-- INTERNAL Data table css -->
		<link href="{{asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css')}}?v=<?php echo time(); ?>" rel="stylesheet" />
		<link href="{{asset('assets/plugins/datatable/responsive.bootstrap5.css')}}?v=<?php echo time(); ?>" rel="stylesheet" />
		<link href="{{asset('assets/plugins/datatable/buttonbootstrap.min.css')}}?v=<?php echo time(); ?>" rel="stylesheet" />

		<!-- INTERNAL Sweet-Alert css -->
		<link href="{{asset('assets/plugins/sweet-alert/sweetalert.css')}}?v=<?php echo time(); ?>" rel="stylesheet" />

		@endsection

							@section('content')

							<!--Page header-->
							<div class="page-header d-xl-flex d-block">
								<div class="page-leftheader">
									<h4 class="page-title"><span class="font-weight-normal text-muted ms-2">{{trans('langconvert.admindashboard.employees')}}</span></h4>
								</div>
							</div>
							<!--End Page header-->
							
							<!-- Employee List -->
							<div class="col-xl-12 col-lg-12 col-md-12">
								<div class="card ">
									<div class="card-header border-0 d-md-max-block">
										<h4 class="card-title  mb-md-max-2">{{trans('langconvert.adminmenu.employeeslist')}}</h4>
										<div class="card-options  d-md-max-block">
											@can('Employee Create')

											<a href="{{url('admin/employee/create')}}" class="btn btn-success me-3  mb-md-max-2 mw-12"><i class="feather feather-user-plus"></i> {{trans('langconvert.admindashboard.addemployee')}}</a>
											@endcan
											@can('Employee Importlist')

											<a href="{{route('user.userimport')}}" class="btn btn-info me-3  mb-md-max-2 mw-12"><i class="feather feather-download"></i> {{trans('langconvert.admindashboard.importemployeeslist')}}</a>
											@endcan

										</div>
									</div>
									<div class="card-body" >
										<div class="table-responsive spruko-delete">
											@can('Employee Delete')

											<button id="massdelete" class="btn btn-outline-light btn-sm mb-4 data-table-btn"><i class="fe fe-trash"></i> {{trans('langconvert.admindashboard.delete')}}</button>
											@endcan

											<table class="table table-vcenter text-nowrap table-bordered table-striped ticketdeleterow w-100" id="supportuserlist">
												<thead>
													<tr>
														{{-- <th  width="10">{{trans('langconvert.admindashboard.id')}}</th> --}}
														<th  width="10">{{trans('langconvert.admindashboard.slNo')}}</th>
														@can('Employee Delete')

														<th width="10" >
															<input type="checkbox"  id="customCheckAll">
															<label  for="customCheckAll"></label>
														</th>
														@endcan
														@cannot('Employee Delete')

														<th width="10" >
															<input type="checkbox"  id="customCheckAll" disabled>
															<label  for="customCheckAll"></label>
														</th>
														@endcannot

														<th > {{trans('langconvert.admindashboard.name')}}</th>
														<th > {{trans('langconvert.admindashboard.roles')}}</th>
														<th > {{trans('langconvert.admindashboard.registerdate')}}</th>
														<th class="w-5"> {{trans('langconvert.admindashboard.status')}}</th>
														<th > {{trans('langconvert.admindashboard.actions')}}</th>
													</tr>
												</thead>
												<tbody>	
														@php $i = 1; @endphp
														@foreach ($users as $user)
															<tr id="row_id{{$user->id}}">
																<td>{{$i++}}</td>
																<td>
																	@if(Auth::user()->can('Employee Delete'))
																		@if($user->id != '1')
																		<input type="checkbox" name="customer_checkbox[]" class="checkall" value="{{$user->id}}" />
																		@endif
																	@else
																		@if($user->id != '1')
																		<input type="checkbox" name="customer_checkbox[]" class="checkall" value="{{$user->id}}" disabled />
																		
																		@endif
																	@endif
																</td>
																<td>
																	<div>
																		<a href="#" class="h5">{{Str::limit($user->name, '40')}}</a>
																		
																		</div>
																		<small class="fs-12 text-muted"> <span class="font-weight-normal1">{{Str::limit($user->email, '40')}}</span></small>
																</td>
																<td>
																	@if(!empty($user->getroleNames()[0]))
																		<span>{{Str::limit($user->getroleNames()[0], '40')  }}</span>
																	@else
																		~
																	@endif
																</td>
																<td>
																	<span class="badge badge-success-light">{{$user->created_at->format(setting('date_format'))}}</span>
																</td>
																<td>
																	@if(Auth::user()->can('Employee Edit'))
																		
																		@if($user->id != '1')

																		<label class="custom-switch form-switch mb-0">
																			<input type="checkbox"  name="status" data-id="{{$user->id}}" id="myonoffswitch{{$user->id}}" value="1" class="custom-switch-input tswitch" {{$user->status == 1 ? 'checked' : ''}}>
																			<span class="custom-switch-indicator"></span>
																		</label>

																		@endif
																	
																	@else
																		~
																	@endif
																</td>
																<td>
																	<div class = "d-flex">
																		@if(Auth::user()->can('Employee Edit'))
																
																		<a href="{{url('/admin/agentprofile/' . $user->id)}}" class="action-btns1" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><i class="feather feather-edit text-primary"></i></a>
																		@else
																			~
																		@endif
																		@if(Auth::user()->can('Employee Delete'))
																			@if ($user->id != '1')		
																			<a href="javascript:void(0)" class="action-btns1" data-id="{{$user->id}}" id="show-delete" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><i class="feather feather-trash-2 text-danger"></i></a>
																			@endif
																			@else
																			~
																		@endif
																		
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
							<!-- End Employee List -->

							@endsection

		@section('scripts')


		<!-- INTERNAL Data tables -->
		<script src="{{asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}?v=<?php echo time(); ?>"></script>
		<script src="{{asset('assets/plugins/datatable/js/dataTables.bootstrap5.js')}}?v=<?php echo time(); ?>"></script>
		<script src="{{asset('assets/plugins/datatable/dataTables.responsive.min.js')}}?v=<?php echo time(); ?>"></script>
		<script src="{{asset('assets/plugins/datatable/responsive.bootstrap5.min.js')}}?v=<?php echo time(); ?>"></script>
		<script src="{{asset('assets/plugins/datatable/datatablebutton.min.js')}}?v=<?php echo time(); ?>"></script>
		<script src="{{asset('assets/plugins/datatable/buttonbootstrap.min.js')}}?v=<?php echo time(); ?>"></script>

		<!-- INTERNAL Sweet-Alert js-->
		<script src="{{asset('assets/plugins/sweet-alert/sweetalert.min.js')}}?v=<?php echo time(); ?>"></script>

		<script type="text/javascript">
			var SITEURL = '{{url('')}}';
			(function($) {
				"use strict";
								
				// Csrf Field
				$.ajaxSetup({
					headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					}
				});

				// Datatable
				$('#supportuserlist').DataTable({
					"columnDefs": [
                       { "orderable": false, "targets":[ 0,1] }
							],
					"order": [],
					responsive:true,
				});

				// __Select2 js
				$('.form-select').select2({
					minimumResultsForSearch: -1
				});

				// __Check All checkbox
				$('#customCheckAll').on('click', function() {
					$('.checkall').prop('checked', this.checked);
				
				});

				// Check all js when if all selected check all
				$('.checkall').on('click', function(){
					if($('.checkall:checked').length == $('.checkall').length){
						$('#customCheckAll').prop('checked', true);
					}else{
						$('#customCheckAll').prop('checked', false);
					}
				});
				// Delete Button
				$('body').on('click', '#show-delete', function () {
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
									url: SITEURL + "/admin/agent/"+_id,
									success: function (data) {
										toastr.error(data.error);
										$('#row_id'+ _id).remove();
									},
									error: function (data) {
									console.log('Error:', data);
									}
								});
							}
						});

				});

				// status switch
				$('body').on('click', '.tswitch', function () {
					var _id = $(this).data("id");
					var status = $(this).prop('checked') == true ? '1' : '0';
					$.ajax({
						type: "post",
						url: SITEURL + "/admin/agent/status/"+_id,
						data: {'status': status},
						success: function (data) {
					
						toastr.success(data.success);
						},
						error: function (data) {
						console.log('Error:', data);
						}
					});
				});

				//Mass Delete 
				$('body').on('click', '#massdelete', function () {
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
									url:"{{ url('admin/massuser/deleteall')}}",
									method:"post",
									data:{id:id},
									success:function(data)
									{

									//for client side
									$.each(id, function( index, value ) {
										$('#row_id'+ value).remove();
									});
										
										toastr.error(data.error);
													
									},
									error:function(data){

									}
								});
							}
						});			
					}else{
						toastr.error('{{trans('langconvert.functions.checkboxselect')}}');
					}
				});			
			})(jQuery);

		</script>
		@endsection

