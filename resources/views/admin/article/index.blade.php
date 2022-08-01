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
									<h4 class="page-title"><span class="font-weight-normal text-muted ms-2">{{trans('langconvert.adminmenu.articles')}}</span></h4>
								</div>
							</div>
							<!--End Page header-->


							<div class="col-xl-12 col-lg-12 col-md-12">
								<div class="card ">
									<form method="POST" action="{{url('/admin/article')}}" enctype="multipart/form-data">
										@csrf

										@honeypot

										<div class="card-header d-sm-max-flex  border-0">
											<h4 class="card-title">{{trans('langconvert.admindashboard.articlesection')}}</h4>
											<div class="card-options mt-sm-max-2 card-header-styles">
												<small class="me-1 mt-1">{{trans('langconvert.admindashboard.sectionhide')}}</small>
												<div class="float-end mt-0">
													<div class="switch-toggle">
														<a class="onoffswitch2">
															<input type="checkbox"  name="articlecheck" id="articlechecks" class=" toggle-class onoffswitch2-checkbox" value="on" @if($basic->articlecheck == 'on')  checked=""  @endif>
															<label for="articlechecks" class="toggle-class onoffswitch2-label" ></label>
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
														<label class="form-label">{{trans('langconvert.admindashboard.title')}}</label>
														<input type="text" class="form-control @error('articletitle') is-invalid @enderror" name="articletitle" value="{{$basic->articletitle}}">
														@error('articletitle')

															<span class="invalid-feedback" role="alert">
																<strong>{{ $message }}</strong>
															</span>
														@enderror

													</div>
												</div>
												<div class="col-sm-12 col-md-12">
													<div class="form-group">
														<label class="form-label">{{trans('langconvert.admindashboard.subtitle')}}</label>
														<input type="text" class="form-control @error('articlesub') is-invalid @enderror" name="articlesub" value="{{$basic->articlesub}}">
														@error('articlesub')

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
							<div class="col-xl-12 col-lg-12 col-md-12">
								<div class="card mb-0">
									<div class="card-header d-sm-max-flex border-0">
										<h4 class="card-title">{{trans('langconvert.admindashboard.articleslist')}}</h4>
										<div class="card-options mt-sm-max-2">
											@can('Article Create')

											<a href="{{url('/admin/article/create')}}" class="btn btn-secondary me-3" >{{trans('langconvert.admindashboard.addarticle')}}</a>
											@endcan

										</div>
									</div>
									<div class="card-body">
										<div class="table-responsive spruko-delete">
											@can('Article Delete')
											
											<button id="massdelete" class="btn btn-outline-light btn-sm mb-4 data-table-btn"><i class="fe fe-trash"></i> {{trans('langconvert.admindashboard.delete')}}</button>
											@endcan

											<table class="table table-vcenter text-nowrap table-bordered table-striped ticketdeleterow w-100" id="articlelist">
												<thead>
													<tr>
														<th  width="9">{{trans('langconvert.admindashboard.id')}}</th>
														<th  width="9">{{trans('langconvert.admindashboard.slNo')}}</th>
														@can('Article Delete')

														<th width="10" >
															<input type="checkbox"  id="customCheckAll">
															<label  for="customCheckAll"></label>
														</th>
														@endcan
														@cannot('Article Delete')

														<th width="10" >
															<input type="checkbox"  id="customCheckAll" disabled>
															<label  for="customCheckAll"></label>
														</th>
														@endcannot

														<th  >{{trans('langconvert.admindashboard.title')}}</th>
														<th >{{trans('langconvert.admindashboard.category')}}</th>
														<th >{{trans('uhelpupdate::langconvert.newwordslang.privatemode')}}</th>
														<th class="w-5">{{trans('langconvert.admindashboard.status')}}</th>
														<th class="w-5">{{trans('langconvert.admindashboard.actions')}}</th>
													</tr>
												</thead>
												<tbody>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
							@endsection


		@section('scripts')


		<!-- INTERNAL Vertical-scroll js-->
		<script src="{{asset('assets/plugins/vertical-scroll/jquery.bootstrap.newsbox.js')}}"></script>

		<!-- INTERNAL Summernote js  -->
		<script src="{{asset('assets/plugins/summernote/summernote.js')}}"></script>

		<!-- INTERNAL Data tables -->
		<script src="{{asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
		<script src="{{asset('assets/plugins/datatable/js/dataTables.bootstrap5.js')}}"></script>
		<script src="{{asset('assets/plugins/datatable/dataTables.responsive.min.js')}}"></script>
		<script src="{{asset('assets/plugins/datatable/responsive.bootstrap5.min.js')}}"></script>


		<!-- INTERNAL Index js-->
		<script src="{{asset('assets/js/support/support-sidemenu.js')}}"></script>
		<script src="{{asset('assets/js/support/support-articles.js')}}"></script>

		<!-- INTERNAL Sweet-Alert js-->
		<script src="{{asset('assets/plugins/sweet-alert/sweetalert.min.js')}}"></script>

		<script type="text/javascript">

			(function($)  {
				"use strict";

				// Variables
				var SITEURL = '{{url('')}}';
			
				// Csrf Field
				$.ajaxSetup({
					headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					}
				});

				// Datatable
				$('#articlelist').DataTable({

					processing: true,
					serverSide: true,
					ajax: {
						url: "{{ url('/admin/article') }}"
					},
					columns: [
						{data: 'id', name: 'id', 'visible': false},
						{data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false,searchable: false},
						{data: 'checkbox', name: 'checkbox', orderable: false,searchable: false},
						{ data: 'title', name: 'title' },
						{ data: 'category', name: 'category' },
						{ data: 'privatemode', name: 'privatemode' },
						{ data: 'status', name: 'status' },
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
				
				// Delete button article
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
								type: "get",
								url: SITEURL + "/admin/article/"+_id,
								success: function (data) {
									var oTable = $('#articlelist').dataTable();
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

				// Status change article
				$('body').on('click', '.tswitch', function () {
					var _id = $(this).data("id");
					var status = $(this).prop('checked') == true ? 'Published' : 'UnPublished';
					$.ajax({
						type: "post",
						url: SITEURL + "/admin/article/status"+_id,
						data: {'status': status},
						success: function (data) {
							toastr.success(data.success);
						},
						error: function (data) {
							console.log('Error:', data);
						}
					});
				});

				// privatemode change article
				$('body').on('click', '.tswitch1', function () {
					var _id = $(this).data("id");
					var privatemode = $(this).prop('checked') == true ? '1' : '0';
					$.ajax({
						type: "post",
						url: SITEURL + "/admin/article/privatestatus/"+_id,
						data: {'privatemode': privatemode},
						success: function (data) {
							toastr.success(data.success);
						},
						error: function (data) {
							console.log('Error:', data);
						}
					});
				});

				// Mass Delete 
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
									url:"{{ url('admin/massarticle/delete')}}",
									method:"GET",
									data:{id:id},
									success:function(data)
									{

										$('#articlelist').DataTable().ajax.reload();
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

				// Checkbox check all
				$('#customCheckAll').on('click', function() {
					$('.checkall').prop('checked', this.checked);
				});

			})(jQuery);

		</script>

		@endsection
