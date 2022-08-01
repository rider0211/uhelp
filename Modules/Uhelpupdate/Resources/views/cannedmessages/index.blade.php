@extends('layouts.adminmaster')

    @section('styles')

        <!-- INTERNAL Data table css -->
		<link href="{{asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" />
		<link href="{{asset('assets/plugins/datatable/responsive.bootstrap5.css')}}" rel="stylesheet" />

        <!-- INTERNAL Sweet-Alert css -->
		<link href="{{asset('assets/plugins/sweet-alert/sweetalert.css')}}" rel="stylesheet" />

    @endsection
							@section('content')

                            <!--Page header-->
							<div class="page-header d-xl-flex d-block">
								<div class="page-leftheader">
									<h4 class="page-title"><span class="font-weight-normal text-muted ms-2">{{trans('uhelpupdate::langconvert.admindashboard.cannedmessages')}}</span></h4>
								</div>
							</div>
							<!--End Page header-->

                            <div class="col-xl-12 col-lg-12 col-md-12">
                                <div class="card ">
                                    <div class="card-header border-0 d-sm-max-flex">
                                        <h4 class="card-title">{{trans('uhelpupdate::langconvert.admindashboard.cannedmessageslist')}}</h4>
                                        <div class="card-options mt-sm-max-2">
                                            @can('Canned Response Create')

                                            <a href="{{route('admin.cannedmessages.create')}}" class="btn btn-secondary me-3" >{{trans('uhelpupdate::langconvert.admindashboard.addcannedmessages')}}</a>
                                            @endcan

                                        </div>
                                    </div>
                                    <div class="card-body" >
                                        <div class="table-responsive spruko-delete">
                                            @can('Canned Response Delete')

                                            <button id="massdeletenotify" class="btn btn-outline-light btn-sm mb-4 data-table-btn"><i class="fe fe-trash"></i> {{trans('langconvert.admindashboard.delete')}}</button>
                                            @endcan

                                            <table class="table table-vcenter text-nowrap table-bordered table-striped ticketdeleterow w-100" id="cannedmessages">
                                                <thead>
                                                    <tr>
                                                        <th  width="10">{{trans('langconvert.admindashboard.id')}}</th>
                                                        <th  width="10">{{trans('langconvert.admindashboard.slNo')}}</th>
                                                        @can('Canned Response Delete')

                                                        <th width="10" >
                                                            <input type="checkbox"  id="customCheckAll">
                                                            <label  for="customCheckAll"></label>
                                                        </th>
                                                        @endcan
                                                        @cannot('Canned Response Delete')

                                                        <th width="10" >
                                                            <input type="checkbox"  id="customCheckAll" disabled>
                                                            <label  for="customCheckAll"></label>
                                                        </th>
                                                        @endcannot

                                                        <th class="w-50">{{trans('langconvert.admindashboard.title')}}</th>
                                                        <th class="w-50">{{trans('langconvert.admindashboard.status')}}</th>
                                                        <th class="w-50">{{trans('langconvert.admindashboard.actions')}}</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            @endsection

        @section('scripts')

        <!-- INTERNAL Data tables -->
		<script src="{{asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
		<script src="{{asset('assets/plugins/datatable/js/dataTables.bootstrap5.js')}}"></script>
		<script src="{{asset('assets/plugins/datatable/dataTables.responsive.min.js')}}"></script>
		<script src="{{asset('assets/plugins/datatable/responsive.bootstrap5.min.js')}}"></script>
		<script src="{{asset('assets/plugins/datatable/datatablebutton.min.js')}}"></script>
		<script src="{{asset('assets/plugins/datatable/buttonbootstrap.min.js')}}"></script>

        <!-- INTERNAL Sweet-Alert js-->
		<script src="{{asset('assets/plugins/sweet-alert/sweetalert.min.js')}}"></script>
        
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
				$('#cannedmessages').dataTable({
                    processing: true,
					serverSide: true,
					ajax: {
					url: "{{ url('/admin/cannedmessages') }}"
					},
					columns: [
						{data: 'id', name: 'id', 'visible': false},
						{data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false,searchable: false},
						{data: 'checkbox', name: 'checkbox', orderable: false,searchable: false},
						{data: 'title', name: 'title' },
						{data: 'status', name: 'status' },
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

                // Checkbox checkall
				$('#customCheckAll').on('click', function() {
					$('.checkall').prop('checked', this.checked);
				});

                // Status change article
				$('body').on('click', '.tswitch', function () {
					var _id = $(this).data("id");
					var status = $(this).prop('checked') == true ? '1' : '0';
                    console.log(_id, status);
					$.ajax({
						type: "post",
						url: SITEURL + "/admin/cannedmessages/status/"+_id,
						data: {'status': status},
						success: function (data) {
							toastr.success(data.success);
						},
						error: function (data) {
							console.log('Error:', data);
						}
					});
				});

                // Delete Testimonial
				$('body').on('click', '#delete-cannedmessages', function () {
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
								url: SITEURL + "/admin/cannedmessages/delete/"+_id,
								success: function (data) {
								var oTable = $('#cannedmessages').dataTable();
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
									url:"{{ route('admin.cannedmessages.deleteall')}}",
									method:"post",
									data:{id:id},
									success:function(data)
									{
										var oTable = $('#cannedmessages').dataTable();
										oTable.fnDraw(false);
										// $('#cannedmessages').DataTable().ajax.reload();
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

            })(jQuery);
        </script>
        @endsection