@extends('layouts.usermaster')


@section('content')


						<!-- Section -->
						<section>
							<div class="bannerimg cover-image" data-bs-image-src="{{asset('assets/images/photos/banner1.jpg')}}">
								<div class="header-text mb-0">
									<div class="container">
										<div class="row text-white">
											<div class="col">
												<h1 class="mb-0">{{trans('langconvert.menu.knowledge')}}</h1>
											</div>
											<div class="col col-auto">
												<ol class="breadcrumb text-center">
													<li class="breadcrumb-item">
														<a href="#" class="text-white-50">{{trans('langconvert.menu.home')}}</a>
													</li>
													<li class="breadcrumb-item active">
														<a href="#" class="text-white">{{trans('langconvert.menu.knowledge')}}</a>
													</li>
												</ol>
											</div>
										</div>
									</div>
								</div>
							</div>
						</section>
						<!-- Section -->

						<!--Article Page-->
						<section>
							<div class="cover-image sptb mb-5">
								<div class="container">
									<div class="row row-deck">

										@if ($article->isEmpty())
										
										<div class="row">
											<div class="card no-articles mx-3">
												<div class="card-body p-8">
													<div class="main-content text-center">
														<div class="notification-icon-container p-4">
															<img src="{{asset('assets/images/noarticle.png')}}" alt="">
														</div>
														<h4 class="mb-1">{{trans('langconvert.admindashboard.noarticlecontent')}}</h4>
														<p class="text-muted">{{trans('langconvert.admindashboard.noarticlecontentsub')}}</p>
													</div>
												</div>  
											</div>
										</div>	
										@else

											<div class="col-xl-6">
												<div class="card">
													<div class="card-header border-bottom-0">
														<h4 class="card-title fs-25">{{trans('langconvert.admindashboard.recentarticles')}}</h4>
													</div>
													<div class="card-body">
														<ul class="list-unstyled list-article mb-0">
															@foreach ($article as $articles)

															@if($articles->articleslug != null)
															
															<li>
																<a class="" href="{{url('/article/' . $articles->articleslug)}}"><i class="typcn typcn-document-text"></i><span class="categ-text">{{Str::limit($articles->title, '100')}}</span></a>
															</li>
															@else

															<li>
																<a class="" href="{{url('/article/' . $articles->id)}}"><i class="typcn typcn-document-text"></i><span class="categ-text">{{Str::limit($articles->title, '100')}}</span></a>
															</li>
															@endif
															@endforeach

														</ul>
													</div>
												</div>
											</div>
											<div class="col-xl-6">
												<div class="card">
													<div class="card-header border-bottom-0">
														<h4 class="card-title fs-25">{{trans('langconvert.menu.populararticles')}}</h4>
													</div>
													<div class="card-body">
														<ul class="list-unstyled list-article mb-0">
															@foreach ($populararticle as $populararticles)

															@if($populararticles->articleslug != null)

															<li>
																<a class="" href="{{url('/article/' . $populararticles->id)}}"><i class="typcn typcn-document-text"></i><span class="categ-text">{{Str::limit($populararticles->title,'100')}}</span></a>
															</li>
															@else

															<li>
																<a class="" href="{{url('/article/' . $populararticles->id)}}"><i class="typcn typcn-document-text"></i><span class="categ-text">{{Str::limit($populararticles->title,'100')}}</span></a>
															</li>
															@endif
															@endforeach

														</ul>
													</div>
												</div>
											</div>
										@endif
										@foreach ($categorys as $category)
										@if ($category->articles->isNotEmpty())

										<div class="col-xl-4">
											<div class="card">
												<div class="card-header border-bottom-0">
													<h4 class="card-title fs-25">{{$category->name}}</h4>
													<div class="card-options me-0">
														@if ($category->articles()->where('status', 'Published')->simplepaginate(5) > '5')

														@if($category->categoryslug != null)

														<a href="{{url('/category/'. $category->categoryslug)}}" class="text-primary">{{trans('langconvert.menu.viewall')}}</a>
														@else

														<a href="{{url('/category/'. $category->id)}}" class="text-primary">{{trans('langconvert.menu.viewall')}}</a>
														@endif
														@endif
													</div>
												</div>
												<div class="card-body">
													<ul class="list-unstyled list-article mb-0">
														@foreach ($category->articles()->where('status', 'Published')->latest()->simplepaginate(5) as $articless)

															@if($articless->articleslug != null)

															<li>
																<a class="" href="{{url('/article/' . $articless->articleslug)}}"><i class="typcn typcn-document-text"></i><span class="categ-text">{{Str::limit($articless->title,'50')}}</span></a>
															</li>
															@else

															<li>
																<a class="" href="{{url('/article/' . $articless->id)}}"><i class="typcn typcn-document-text"></i><span class="categ-text">{{Str::limit($articless->title,'50')}}</span></a>
															</li>
															@endif
														@endforeach

													</ul>
												</div>
											</div>
										</div>
										@endif
										@endforeach

									</div>
								</div>
							</div>
						</section>
						<!--Article Page-->


@endsection


