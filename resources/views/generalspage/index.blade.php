@extends('layouts.usermaster')


							@section('content')

							<!-- Section -->
							<section>
								<div class="bannerimg cover-image" data-bs-image-src="{{asset('assets/images/photos/banner1.jpg')}}">
									<div class="header-text mb-0">
										<div class="container">
											<div class="row text-white ">
												<div class="col">
													<h1>{{$pages->pagename}}</h1>
												</div>
												<div class="col col-auto">
													<ol class="breadcrumb text-center">
														<li class="breadcrumb-item">
															<a href="#" class="text-white-50">{{trans('langconvert.menu.home')}}</a>
														</li>
														<li class="breadcrumb-item active">
															<a href="#" class="text-white">{{$pages->pagename}}</a>
														</li>
													</ol>
												</div>
											</div>
										</div>
									</div>
								</div>
							</section>
							<!-- Section -->

							<!--Section-->
							<section>
								<div class="cover-image sptb">
									<div class="container">
										<div class="row justify-content-center">
											<div class="col-xl-8">
												<div class="card">
													<div class="card-header border-0">
														<h4 class="card-title ">{{$pages->pagename}}</h4>
													</div>
													<div class="card-body ">
														<div class="mb-4">
															{!!$pages->pagedescription!!}
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</section>
							<!--Section-->
							@endsection

