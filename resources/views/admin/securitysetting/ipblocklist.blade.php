@extends('layouts.adminmaster')

		@section('styles')

		<!-- INTERNAL Data table css -->
		<link href="{{asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css')}}?v=<?php echo time(); ?>" rel="stylesheet" />
		<link href="{{asset('assets/plugins/datatable/responsive.bootstrap5.css')}}?v=<?php echo time(); ?>" rel="stylesheet" />

		<!-- INTERNAL Sweet-Alert css -->
		<link href="{{asset('assets/plugins/sweet-alert/sweetalert.css')}}" rel="stylesheet" />

		@endsection

							@section('content')

							<!--Page header-->
							<div class="page-header d-xl-flex d-block">
								<div class="page-leftheader">
									<h4 class="page-title"><span class="font-weight-normal text-muted ms-2">{{trans('langconvert.adminmenu.iplist')}}</span></h4>
								</div>
							</div>
							<!--End Page header-->

							<!-- IP List-->
							<div class="col-xl-12 col-lg-12 col-md-12">
								<div class="card ">
									<div class="card-header border-0 d-sm-max-flex">
										<h4 class="card-title">{{trans('langconvert.adminmenu.iplist')}}</h4>
										<div class="card-options mt-sm-max-2">
											@can('IpBlock Add')

											<a href="javascript:void(0)" class="btn btn-secondary me-3" id="create-new-ip">{{trans('langconvert.admindashboard.addipaddress')}}</a>
											@endcan

										</div>
									</div>
									<div class="card-body" >
										<div class="table-responsive">
											@can('IpBlock Delete')

											<button id="massdeletenotify" class="btn btn-outline-light btn-sm mb-4 data-table-btn"><i class="fe fe-trash"></i> {{trans('langconvert.admindashboard.delete')}}</button>
											@endcan

											<table class="table table-vcenter text-nowrap table-bordered table-striped ticketdeleterow w-100" id="support-articlelists">
												<thead>
													<tr>
														<th  width="10">{{trans('langconvert.admindashboard.id')}}</th>
														<th  width="10">{{trans('langconvert.admindashboard.slNo')}}</th>
														@can('IpBlock Delete')

														<th width="10" >
															<input type="checkbox"  id="customCheckAll">
															<label  for="customCheckAll"></label>
														</th>
														@endcan
														@cannot('IpBlock Delete')

														<th width="10" >
															<input type="checkbox"  id="customCheckAll" disabled>
															<label  for="customCheckAll"></label>
														</th>
														@endcannot

														<th >{{trans('langconvert.admindashboard.ip')}}</th>
														<th >{{trans('langconvert.admindashboard.country')}}</th>
														<th >{{trans('langconvert.admindashboard.entry')}}</th>
														<th >{{trans('langconvert.admindashboard.types')}}</th>
														<th >{{trans('langconvert.admindashboard.actions')}}</th>
													</tr>
												</thead>
											</table>
										</div>
									</div>
								</div>
							</div>
							<!--End IP List-->
							@endsection

		@section('scripts')

		<!--INTERNAL Owl-carousel js -->
		<script src="{{asset('assets/plugins/owl-carousel/owl-carousel.js')}}?v=<?php echo time(); ?>"></script>

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

				// Csrf Field
				$.ajaxSetup({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					}
				});

				// DataTable
				$('#support-articlelists').dataTable({
					processing: true,
					serverSide: true,
					ajax: {
					url: "{{ route('ipblocklist') }}"
					},
					columns: [
						{data: 'id', name: 'id', 'visible': false},
						{data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false,searchable: false},
						{data: 'checkbox', name: 'checkbox', orderable: false,searchable: false},
						{data: 'ip', name: 'ip' },
						{data: 'country', name: 'country' },
						{data: 'entrytype', name: 'entrytype' },
						{data: 'types', name: 'types' },
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

				/*  When user click add ip button */
				$('#create-new-ip').on('click', function () {
					$('#btnsave').val("ipblock");
					$('#IP_id').val('');
					$('#IP_form').trigger("reset");
					$('.modal-title').html("{{trans('langconvert.admindashboard.addnewipaddress')}}");
					$('#addIP').modal('show');
				});

				/* When click edit ip */
				$('body').on('click', '.edit-iplist', function () {
					var ip_id = $(this).data('id');
					$.get('ipblocklist/' + ip_id , function (data) {
						$('#nameError').html('');
						$('#displayError').html('');
						$('.modal-title').html("{{trans('langconvert.admindashboard.editipaddress')}}");
						$('#btnsave').val("edit-ip");
						$('#addIP').modal('show');
						$('#IP_id').val(data.id);
						$('#ip').val(data.ip);
						if (data.types == "Unlock")
						{
							$('.iptype1').prop('checked', true);
						}
						if (data.types == "Locked")
						{
							$('.iptype2').prop('checked', true);
						}
						if (data.types == "Blocked")
						{
							$('.iptype3').prop('checked', true);
						}
							
					})
				});

				// submit ip list
				$('body').on('submit', '#IP_form', function (e) {
					e.preventDefault();
					var actionType = $('#btnsave').val();
					var fewSeconds = 2;
					$('#btnipsave').html('Sending..');
					$('#btnipsave').prop('disabled', true);
						setTimeout(function(){
							$('#btnipsave').prop('disabled', false);
						}, fewSeconds*1000);
					var formData = new FormData(this);
					$.ajax({
						type:'POST',
						url: SITEURL + "/admin/ipblocklist/create",
						data: formData,
						cache:false,
						contentType: false,
						processData: false,
						success: (data) => {
							$('#nameError').html('');
							$('#displayError').html('');
							$('#IP_form').trigger("reset");
							$('#addIP').modal('hide');
							$('#btnipsave').html('Save Changes');
							var oTable = $('#support-articlelists').dataTable();
							oTable.fnDraw(false);
							toastr.success(data.success);
						},
						error: function(data){
							$('#nameError').html('');
							$('#displayError').html('');
							$('#nameError').html(data.responseJSON.errors.ip);
							$('#displayError').html(data.responseJSON.errors.types);
							$('#btnsave').html('Save Changes');
						}
					});
				});

				// delete ip list 
				$('body').on('click', '#delete-iplist', function () {
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
								type: "delete",
								url: SITEURL + "/admin/ipblocklist/delete/"+_id,
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

				// Mass delete ip list
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
									url:"{{ route('ipblocklist.deleteall')}}",
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
					}
					else{
						toastr.error('{{trans('langconvert.functions.checkboxselect')}}');
					}

				});

				// Reset ip js
				$('body').on('click', '#reset-iplist', function(){
					var reset_id = $(this).data("id");
					swal({
						title: `{{trans('langconvert.admindashboard.areyousuretoresetrecord')}}`,
						icon: "warning",
						buttons: true,
						dangerMode: true,
					})
					.then((willDelete) => {
						if (willDelete) {
							$.ajax({
								type: "post",
								url: SITEURL + "/admin/ipblocklist/reset/"+reset_id,
								success: function (data) {
								var oTable = $('#support-articlelists').dataTable();
								oTable.fnDraw(false);
								toastr.success(data.success);
								},
								error: function (data) {
								console.log('Error:', data);
								}
							});
						}
					});
				});

				// checkbox chaeck all
				$('#customCheckAll').on('click', function() {
					$('.checkall').prop('checked', this.checked);
				});

			})(jQuery);
			
		</script>
		@endsection
		@section('modal')

    		@include('admin.securitysetting.ipblockmodel')
			
		@endsection