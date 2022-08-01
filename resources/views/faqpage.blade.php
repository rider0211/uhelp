@extends('layouts.usermaster')

@section('styles')

@endsection

@section('content')

							<!-- Section -->
							<section>
								<div class="bannerimg cover-image" data-bs-image-src="{{asset('assets/images/photos/banner1.jpg')}}">
									<div class="header-text mb-0">
										<div class="container">
											<div class="row text-white">
												<div class="col">
													<h1 class="mb-0">{{trans('langconvert.menu.faq')}}</h1>
												</div>
												<div class="col col-auto">
													<ol class="breadcrumb text-center d-flex align-items-center justify-content-center">
														<li class="breadcrumb-item">
															<a href="#" class="text-white-50">{{trans('langconvert.menu.home')}}</a>
														</li>
														<li class="breadcrumb-item active">
															<a href="#" class="text-white">{{trans('langconvert.menu.faq')}}</a>
														</li>
													</ol>
												</div>
											</div>
										</div>
									</div>
								</div>
							</section>
							<!-- Section -->

							<!--FAQ Page-->
							<section>
								<div class="cover-image sptb">
									<div class="container">
										<div class="row">
											<div class="col-xl-12">
												<div class="mb-4">
													<div aria-multiselectable="true" class="accordion suuport-accordion" id="accordion" role="tablist">
														@if($faq->isNotempty())
														@foreach ($faq as $faqs)

														<div class="row">
															<div class="col-md-12 d-block mx-auto mb-2">
																<div class="acc-card wow fadeInUp" data-wow-delay="0.2s">
																	<div class="acc-header" id="heading{{$faqs->id}}" role="tab">
																		<h5 class="mb-0">
																			<a aria-controls="collapse{{$faqs->id}}" aria-expanded="false" data-bs-toggle="collapse" href="#collapse{{$faqs->id}}" >
																				{{$faqs->question}} <span class="float-end acc-angle"><i class="fe fe-chevron-right"></i></span>
																			</a>
																		</h5>
																	</div>
																	<div aria-labelledby="heading{{$faqs->id}}" class="collapse" data-parent="#accordion" id="collapse{{$faqs->id}}" role="tabpanel" data-bs-parent="#accordion">
																		<div class="acc-body bg-white p-5">
																			@if($faqs->privatemode == 1)
																			@if(Auth::guard('customer')->check() && Auth::guard('customer')->user())

																			{!!$faqs->answer!!}
																			@else

																			<div class="alert alert-light-warning">
																				<p class="privatearticle">
																				<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
																				You must be logged in and have valid account to access this content.
																				</p>
																			</div>
																			@endif
																			@else
																			
																			{!!$faqs->answer!!}
																			@endif
																		</div>
																	</div>
																</div>
															</div>
														</div>
														@endforeach
														@else

														<div class="row">
															<div class="card no-articles">
																<div class="card-body p-8">
																	<div class="main-content text-center">
																		<div class="notification-icon-container p-4">
																			<img src="{{asset('assets/images/noarticle.png')}}" alt="">
																		</div>
																		<h4 class="mb-1">{{trans('langconvert.admindashboard.nofaqcontent')}}</h4>
																		<p class="text-muted">{{trans('langconvert.admindashboard.nofaqcontentsub')}}</p>
																	</div>
																</div>  
															</div>
														</div>
														@endif
														
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</section>
							<!--FAQ Page-->
@endsection

@section('scripts')

		<!-- INTERNAL Vertical-scroll js-->
		<script src="{{asset('assets/plugins/vertical-scroll/jquery.bootstrap.newsbox.js')}}?v=<?php echo time(); ?>"></script>

@endsection


