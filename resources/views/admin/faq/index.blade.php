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
									<h4 class="page-title"><span class="font-weight-normal text-muted ms-2">{{trans('langconvert.menu.faq')}}</span></h4>
								</div>
							</div>
							<!--End Page header-->

							<div class="col-xl-12 col-lg-12 col-md-12">
								<div class="card ">
									<form method="POST" action="{{url('/admin/faq')}}" enctype="multipart/form-data">
										@csrf

										@honeypot

										<div class="card-header border-0 d-sm-max-flex">
											<h4 class="card-title">{{trans('langconvert.admindashboard.faqsection')}}</h4>
											<div class="card-options card-header-styles mt-sm-max-2">
												<small class="me-1 mt-1">{{trans('langconvert.admindashboard.sectionhide')}}</small>
												<div class="float-end mt-0">
													<div class="switch-toggle">
														<a class="onoffswitch2">
															<input type="checkbox"  name="faqcheck" id="faqchecks" class=" toggle-class onoffswitch2-checkbox" value="on" @if($basic->faqcheck == 'on')  checked=""  @endif>
															<label for="faqchecks" class="toggle-class onoffswitch2-label" ></label>
														</a>
													</div>
												</div>
											</div>
										</div>
										<div class="card-body" >
											<div class="row">
												<div class="col-sm-12 col-md-12">
													<input type="hidden" class="form-control " id="testimonial_id" name="id" value="{{$basic->id}}">
													<div class="form-group">
														<label class="form-label">{{trans('langconvert.admindashboard.title')}} <span class="text-red">*</span></label>
														<input type="text" class="form-control @error('faqtitle') is-invalid @enderror" name="faqtitle" value="{{$basic->faqtitle}}">
														@error('faqtitle')

															<span class="invalid-feedback" role="alert">
																<strong>{{ $message }}</strong>
															</span>
														@enderror

													</div>
												</div>
												<div class="col-sm-12 col-md-12">
													<div class="form-group">
														<label class="form-label">{{trans('langconvert.admindashboard.subtitle')}}</label>
														<input type="text" class="form-control @error('faqsub') is-invalid @enderror" name="faqsub" value="{{$basic->faqsub}}">
														@error('faqsub')

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
								<div class="card ">
									<div class="card-header border-0 d-sm-max-flex">
										<h4 class="card-title">{{trans('langconvert.menu.faq')}}</h4>
										<div class="card-options mt-sm-max-2">
											@can('FAQs Create')

											<a href="javascript:void(0)" class="btn btn-secondary me-3" id="create-new-post" onclick="addPost()">{{trans('langconvert.admindashboard.addfaq')}}</a>
											@endcan

										</div>
									</div>
									<div class="card-body" >
										<div class="table-responsive spruko-delete">
											@can('FAQs Delete')

											<button id="massdeletenotify" class="btn btn-outline-light btn-sm mb-4 data-table-btn"><i class="fe fe-trash"></i> {{trans('langconvert.admindashboard.delete')}}</button>
											@endcan

											<table class="table table-vcenter text-nowrap table-bordered table-striped ticketdeleterow w-100" id="support-articlelists">
												<thead>
													<tr>
														<th  width="10">{{trans('langconvert.admindashboard.id')}}</th>
														<th  width="10">{{trans('langconvert.admindashboard.slNo')}}</th>
														@can('FAQs Delete')

														<th width="10" >
															<input type="checkbox"  id="customCheckAll">
															<label  for="customCheckAll"></label>
														</th>
														@endcan
														@cannot('FAQs Delete')

														<th width="10" >
															<input type="checkbox"  id="customCheckAll" disabled>
															<label  for="customCheckAll"></label>
														</th>
														@endcannot

														<th >{{trans('langconvert.admindashboard.question')}}</th>
														<th >{{trans('langconvert.admindashboard.answer')}}</th>
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
	@section('modal')

   	@include('admin.faq.model')

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
				$('#support-articlelists').DataTable({
					processing: true,
					serverSide: true,
					ajax: {
						url: "{{ route('faq.index') }}"
					},
					columns: [
						{data: 'id', name: 'id', 'visible': false},
						{data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false,searchable: false},
						{data: 'checkbox', name: 'checkbox', orderable: false,searchable: false},
						{data: 'question', name: 'question' },
						{data: 'answer', name: 'answer' },
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

				//Mass Delete 
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
									url:"{{ route('faq.deleteall')}}",
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
					}else{
						toastr.error('{{trans('langconvert.functions.checkboxselect')}}');
					}

				});
				//Mass Delete

				// checkbox check all
				$('#customCheckAll').on('click', function() {
					$('.checkall').prop('checked', this.checked);
				});

				// Status change faq
				$('body').on('click', '.tswitch', function () {
					var _id = $(this).data("id");
					var status = $(this).prop('checked') == true ? '1' : '0';
					$.ajax({
						type: "post",
						url: SITEURL + "/admin/faq/status"+_id,
						data: {'status': status},
						success: function (data) {
							toastr.success(data.success);
						},
						error: function (data) {
							console.log('Error:', data);
						}
					});
				});

				// privatemode change faq
				$('body').on('click', '.tswitch1', function () {
					var _id = $(this).data("id");
					var privatemode = $(this).prop('checked') == true ? '1' : '0';
					$.ajax({
						type: "post",
						url: SITEURL + "/admin/faq/privatestatus/"+_id,
						data: {'privatemode': privatemode},
						success: function (data) {
							toastr.success(data.success);
						},
						error: function (data) {
							console.log('Error:', data);
						}
					});
				});

			})(jQuery);

			// Add faq
			function addPost() {
                $("#faq_id").val('');
                $(".modal-title").text('{{trans('langconvert.admindashboard.addnewfaq')}}');
				$('#faq_form').trigger("reset");
				$('#answer').summernote('reset');
                $('#addfaq').modal('show');
            }
			
			// edit faq
            function editPost(event) {
                var id  = $(event).data("id");
                let _url = `{{url('/admin/faq/${id}')}}`;
                $('#questionError').text('');
                $('#answerError').text('');
                $.ajax({
                	url: _url,
               		type: "GET",
                	success: function(response) {
                    	if(response) {
							$('#questionError').text('');
                			$('#answerError').text('');
                     	   	$(".modal-title").text('{{trans('langconvert.admindashboard.editfaq')}}');
                        	$("#faq_id").val(response.id);
                        	$("#question").val(response.question);
                        	$("#answer").summernote('code',response.answer);
							if (response.status == "1")
							{
								$('#status').prop('checked', true);
							}
							if (response.privatemode == "1")
							{
								$('#privatemode').prop('checked', true);
							}
                        	$('#addfaq').modal('show');
                   		}
                	}
                });
            }

			// Delete faq
            function deletePost(event) {
                var id  = $(event).data("id");
                let _url = `{{url('/admin/faq/delete/${id}')}}`;
                let _token   = $('meta[name="csrf-token"]').attr('content');
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
							url: _url,
							type: 'DELETE',
							data: {
								_token: _token
							},
							success: function(response) {
								toastr.error(response.error);
								var oTable = $('#support-articlelists').dataTable();
								oTable.fnDraw(false);
							},
							error: function (data) {
								console.log('Error:', data);
							}
						});
					}
				});
            }

			// create the faq
            function createPost() {
				$('#questionError').text('');
                $('#answerError').text('');
                var question = $('#question').val();
                var answer = $('#answer').val();
				var status = $('#status').prop('checked') == true ? '1' : '0';
				var privatemode = $('#privatemode').prop('checked') == true ? '1' : '0';
                var id = $('#faq_id').val();
				var actionType = $('#btnsave').val();
				var fewSeconds = 2;
				$('#btnsave').prop('disabled', true);
					setTimeout(function(){
						$('#btnsave').prop('disabled', false);
					}, fewSeconds*1000);
                let _url = `{{url('/admin/faq/create')}}`;
                let _token   = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url:_url,
                    type:"POST",
                    data:{
                        id: id,
                        question: question,
                        answer: answer,
                        status: status,
                        privatemode: privatemode,
                        _token: _token
                    },
                    success: function(response) {
                        if(response.code == 200) {
							$('#questionError').text('');
                			$('#answerError').text('');
							$('#faq_form').trigger("reset");
							$('#answer').summernote('reset');
							$('#addfaq').modal('hide');
                            var oTable = $('#support-articlelists').dataTable();
							oTable.fnDraw(false);
                            toastr.success(response.success);

                        }
                    },
                    error: function(response) {
						$('#questionError').text('');
                		$('#answerError').text('');
                        $('#questionError').text(response.responseJSON.errors.question);
                        $('#answerError').text(response.responseJSON.errors.answer);
                    }
                });

            }

			// cancel faq
			function cancelPost() {
				$('#faq_form').trigger("reset");
				$('#answer').summernote('reset');
			}
		
		</script>

		@endsection
