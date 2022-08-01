		@extends('layouts.adminmaster')

		@section('styles')

		<!-- INTERNAL Sweet-Alert css -->
		<link href="{{asset('assets/plugins/sweet-alert/sweetalert.css')}}?v=<?php echo time(); ?>" rel="stylesheet" />


		@endsection

							@section('content')

							<!--Page header-->
							<div class="page-header d-xl-flex d-block">
								<div class="page-leftheader">
									<h4 class="page-title"><span class="font-weight-normal text-muted ms-2">{{trans('langconvert.menu.profile')}}</span></h4>
								</div>
							</div>
							<!--End Page header-->
							
							<!-- Profile Page-->
							<div class="row">
								<div class="col-xl-3 col-lg-4 col-md-12">
									<div class="card user-pro-list overflow-hidden">
										<div class="card-body">
											<div class="user-pic text-center">
												@if (Auth::user()->image == null)

												<span class="avatar avatar-xxl brround" style="background-image: url(../uploads/profile/user-profile.png)">
													<span class="avatar-status bg-green"></span>
												</span>
													@else

												<span class="avatar avatar-xxl brround" style="background-image: url(../uploads/profile/{{Auth::user()->image}})">
													<span class="avatar-status bg-green"></span>
												</span>
													@endif
												<div class="pro-user mt-3">
													<h5 class="pro-user-username text-dark mb-1 fs-16">{{Auth::user()->name}}</h5>
													<h6 class="pro-user-desc text-muted fs-12">{{Auth::user()->email}}</h6>
													@if(!empty(Auth::user()->getRoleNames()[0]))
													<h6 class="pro-user-desc text-muted fs-12">{{ Auth::user()->getRoleNames()[0]}}</h6>
													@endif
													<div class="profilerating" data-rating="{{$avg}}"></div>

													<div class="btn-list">
														@can('Profile Edit')

														<a href="{{url('admin/profile/edit')}}" class="btn btn-secondary mt-3">{{trans('langconvert.admindashboard.editprofile')}}</a>
														@endcan
														@if (Auth::user()->image != null)

														<a href="javascript:void(0)" class="btn btn-light mt-3" id="delete-image"
															data-id="{{Auth::id()}}">Delete Photo</a>
														@endif

													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="card">
										<div class="card-header border-0">
											<h4 class="card-title"> {{trans('langconvert.admindashboard.personaldetails')}}</h4>
										</div>
										<div class="card-body px-0 pb-0">

											<div class="table-responsive tr-lastchild">
												<table class="table mb-0 table-information">
													<tbody>
														<tr>
															<td class="py-2">
																<span class="font-weight-semibold w-50"> {{trans('langconvert.admindashboard.employeeiD')}}</span>
															</td>
															<td class="py-2 ps-4">{{Auth::user()->empid}}</td>
														</tr>
														<tr>
															<td class="py-2">
																<span class="font-weight-semibold w-50"> {{trans('langconvert.admindashboard.name')}} </span>
															</td>
															<td class="py-2 ps-4">{{Auth::user()->name}}</td>
														</tr>
														<tr>
															<td class="py-2">
																<span class="font-weight-semibold w-50"> {{trans('langconvert.admindashboard.role')}} </span>
															</td>
															<td class="py-2 ps-4">
																@if(!empty(Auth::user()->getRoleNames()[0]))

																 {{Auth::user()->getRoleNames()[0]}}
																 @endif

															</td>
														</tr>
														<tr>
															<td class="py-2">
																<span class="font-weight-semibold w-50"> {{trans('langconvert.admindashboard.email')}} </span>
															</td>
															<td class="py-2 ps-4">{{Auth::user()->email}}</td>
														</tr>
														<tr>
															<td class="py-2">
																<span class="font-weight-semibold w-50"> {{trans('langconvert.admindashboard.phone')}} </span>
															</td>
															<td class="py-2 ps-4">{{Auth::user()->phone}}</td>
														</tr>
														<tr>
															<td class="py-2">
																<span class="font-weight-semibold w-50"> {{trans('langconvert.admindashboard.languages')}} </span>
															</td>
															<td class="py-2 ps-4">
																@php
																$values = explode(",", Auth::user()->languagues);

																@endphp

																<ul class="custom-ul">
																	@foreach ($values as $value)

																	<li class="tag mb-1">{{ucfirst($value)}}</li>

																	@endforeach

																</ul>
															</td>
														</tr>
														<tr>
															<td class="py-2">
																<span class="font-weight-semibold w-50">{{trans('langconvert.admindashboard.skills')}} </span>
															</td>
															<td class="py-2 ps-4">
																@php
																$values = explode(",", Auth::user()->skills);
																@endphp

																<ul class="custom-ul">
																	@foreach ($values as $value)

																	<li class="tag mb-1">{{ucfirst($value)}}</li>

																	@endforeach

																</ul>
															</td>
														</tr>
														<tr>
															<td class="py-2">
																<span class="font-weight-semibold w-50"> {{trans('langconvert.admindashboard.location')}} </span>
															</td>
															<td class="py-2 ps-4">{{Auth::user()->country}}</td>
														</tr>

													</tbody>
												</table>
											</div>
										</div>
									</div>
									@if(setting('SPRUKOADMIN_P') == 'on')

									<div class="card">
										<div class="card-header border-0">
											<h4 class="card-title"> {{trans('langconvert.admindashboard.personalsetting')}}</h4>
										</div>
										<div class="card-body">
											<div class="switch_section">
												<div class="switch-toggle d-flex mt-4">
													<a class="onoffswitch2">
														<input type="checkbox" data-id="{{Auth::id()}}" name="checkbox" id="myonoffswitch181" class=" toggle-class onoffswitch2-checkbox sprukoswitch"  @if(Auth::check() && Auth::user()->darkmode == 1) checked="" @endif>
														<label for="myonoffswitch181" class="toggle-class onoffswitch2-label" data-id="{{Auth::id()}}"></label>
													</a>
													<label class="form-label ps-3"> {{trans('langconvert.admindashboard.switchdarkmode')}} </label>
												</div>
											</div>
										</div>
									</div>
									@endif

								</div>
								<div class="col-xl-9 col-lg-8 col-md-12">
									<div class="card ">
										<div class="card-header border-0">
											<h4 class="card-title"> {{trans('langconvert.admindashboard.profiledetails')}}</h4>
										</div>
										<div class="card-body">
											@csrf
											@honeypot

											<div class="row">
												<div class="col-sm-6 col-md-6">
													<div class="form-group">
														<label class="form-label"> {{trans('langconvert.admindashboard.firstname')}}</label>
														<input type="text" class="form-control"
															name="firstname" value="{{Auth::user()->firstname}}" disabled>
													</div>
												</div>
												<div class="col-sm-6 col-md-6">
													<div class="form-group">
														<label class="form-label"> {{trans('langconvert.admindashboard.lastname')}}</label>
														<input type="text" class="form-control"
															name="lastname" value="{{Auth::user()->lastname }}" disabled>
													</div>
												</div>
												<div class="col-sm-6 col-md-6">
													<div class="form-group">
														<label class="form-label"> {{trans('langconvert.admindashboard.emailaddress')}}</label>
														<input type="email" class="form-control" Value="{{Auth::user()->email}}" disabled>

													</div>
												</div>
												<div class="col-sm-6 col-md-6">
													<div class="form-group">
														<label class="form-label"> {{trans('langconvert.admindashboard.employeeiD')}}</label>
														<input type="email" class="form-control" Value="{{Auth::user()->empid}}" disabled>

													</div>
												</div>
												<div class="col-sm-6 col-md-6">
													<div class="form-group">
														<label class="form-label"> {{trans('langconvert.admindashboard.mobilenumber')}}</label>
														<input type="text" class="form-control " name="phone"
															value="{{old('phone',Auth::user()->phone)}}" disabled>
													</div>
												</div>
												<div class="col-sm-6 col-md-6">
													<div class="form-group">
														<label class="form-label"> {{trans('langconvert.admindashboard.languages')}}</label>
														<input type="text" class="form-control"
															value="{{Auth::user()->languagues}}" name="languages" data-role="tagsinput" disabled />
													</div>
												</div>
												<div class=col-sm-6 col-md-6">
													<div class="form-group">
														<label class="form-label"> {{trans('langconvert.admindashboard.skills')}}</label>
														<input type="text" class="form-control"
															value="{{Auth::user()->skills}}" name="skills" data-role="tagsinput" disabled />
													</div>
												</div>
												<div class="col-sm-6 col-md-6">
													<div class="form-group">
														<label class="form-label"> {{trans('langconvert.admindashboard.country')}}</label>
														<input type="text" class="form-control" value="{{Auth::user()->country}}" disabled>

													</div>
												</div>
												<div class="col-sm-6 col-md-6">
													<div class="form-group">
														<label class="form-label"> {{trans('langconvert.admindashboard.timezones')}}</label>
														<input type="text" class="form-control" value="{{Auth::user()->timezone}}" disabled>
													</div>
												</div>
											</div>
										</div>
									</div>
									@include('admin.auth.passwords.changepassword')

								</div>
							</div>
							<!--End Profile Page-->
							@endsection

		@section('scripts')

		<!-- INTERNAL Vertical-scroll js-->
		<script src="{{asset('assets/plugins/vertical-scroll/jquery.bootstrap.newsbox.js')}}?v=<?php echo time(); ?>"></script>

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

				// Profile Rating
				$(".profilerating").starRating({
					readOnly: true,
					// totalStars: 5,
					starSize: 20,
					emptyColor  :  '#ffffff',
					activeColor :  '#F2B827',
					strokeColor :  '#F2B827',
  					strokeWidth :  15,
					useGradient : false

				});

				// DarkMode switch js
				$('.sprukoswitch').on('change', function() {
					var dark = $('#myonoffswitch181').prop('checked') == true ? '1' : '';
					var user_id = $(this).data('id');
					$.ajax({
						type: "GET",
						dataType: "json",
						url: '{{url('/admin/usersettings')}}',
						data: {
							'dark': dark,
							'user_id': user_id
						},
						success: function(data){
							location.reload();
							toastr.success('{{trans('langconvert.functions.updatecommon')}}');
						}
					});
				});

				@if (Auth::user()->image != null)

				//Delete Image
				$('body').on('click', '#delete-image', function () {
					var _id = $(this).data("id");

					swal({
						title: `{{trans('langconvert.functions.profileimageremove')}}`,
						icon: "warning",
						buttons: true,
						dangerMode: true,
					})
					.then((willDelete) => {
					if (willDelete) {
							$.ajax({
								type: "post",
								url: SITEURL + "/admin/image/remove/"+_id,
								success: function (data) {
								toastr.success(data.success);
								location.reload();
								},
								error: function (data) {
								console.log('Error:', data);
								}
							});
						}
					});
				});
				@endif

				
			})(jQuery);

		</script>

		@endsection