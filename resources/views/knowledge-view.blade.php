<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<!-- Meta data -->
		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta content="{{substr(strip_tags($articles->message),0,150) ? substr(strip_tags($articles->message),0,150) :''}}"
			name="description">
		<meta content="{{substr($articles->title,0,60) ? substr($articles->title,0,60) :''}}" name="title">
		<meta name="keywords" content="{{$articles->tags ? $articles->tags :''}}" />
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<!-- Title -->
		<title>{{$articles->title}}</title>

		@if ($title->image4 == null)

		<!--Favicon -->
		<link rel="icon" href="{{asset('uploads/logo/favicons/favicon.ico')}}" type="image/x-icon"/>
		@else

		<!--Favicon -->
		<link rel="icon" href="{{asset('uploads/logo/favicons/'.$title->image4)}}" type="image/x-icon"/>  
		@endif

		@if(str_replace('_', '-', app()->getLocale()) == 'عربى')

		<!-- Bootstrap css -->
		<link href="{{asset('assets/plugins/bootstrap/css/bootstrap.rtl.css')}}?v=<?php echo time(); ?>" rel="stylesheet" />
		@else

		<!-- Bootstrap css -->
		<link href="{{asset('assets/plugins/bootstrap/css/bootstrap.css')}}?v=<?php echo time(); ?>" rel="stylesheet" />
		@endif

		<!-- Style css -->
		<link href="{{URL::asset('assets/css/style.css')}}?v=<?php echo time(); ?>" rel="stylesheet" />
		<link href="{{URL::asset('assets/css/dark.css')}}?v=<?php echo time(); ?>" rel="stylesheet" />
		<link href="{{asset('assets/css/updatestyles.css')}}?v=<?php echo time(); ?>" rel="stylesheet" />

		<!-- Animate css -->
		<link href="{{URL::asset('assets/css/animated.css')}}?v=<?php echo time(); ?>" rel="stylesheet" />

		<!-- P-scroll bar css-->
		<link href="{{URL::asset('assets/plugins/p-scrollbar/p-scrollbar.css')}}?v=<?php echo time(); ?>" rel="stylesheet" />

		<!---Icons css-->
		<link href="{{URL::asset('assets/css/icons.css')}}?v=<?php echo time(); ?>" rel="stylesheet" />

		<!-- Select2 css -->
		<link href="{{URL::asset('assets/plugins/select2/select2.min.css')}}?v=<?php echo time(); ?>" rel="stylesheet" />

		<!--INTERNAL Toastr css -->
		<link href="{{URL::asset('assets/plugins/toastr/toastr.css')}}?v=<?php echo time(); ?>" rel="stylesheet" />

		<!-- INTERNAL owl-carousel css-->
		<link href="{{asset('assets/plugins/owl-carousel/owl-carousel.css')}}?v=<?php echo time(); ?>" rel="stylesheet" />


		<!-- GALLERY CSS -->
		<link href="{{asset('assets/plugins/simplelightbox/simplelightbox.css')}}?v=<?php echo time(); ?>" rel="stylesheet">

		<!-- Color Change -->	
		<style>
			:root {
				--primary: @php echo setting('theme_color') @endphp;
				--secondary: @php echo setting('theme_color_dark') @endphp;
			}
		</style>

		<!-- Custom css-->
		<style>

			@php echo customcssjs('CUSTOMCSS') @endphp;

		</style>

		@if(setting('GOOGLEFONT_DISABLE') == 'off')
		
		<!-- Google Fonts -->
		<style>
			@import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap');
		</style>

		@endif

	</head>
	<body class="@if(str_replace('_', '-', app()->getLocale()) == 'عربى')
		rtl
	@endif">

				@include('includes.user.mobileheader')

				@include('includes.user.menu')

				<!--Article Page View -->
				<div class="page">
					<div class="page-main">
						<div class="containerheight">
							<!-- Section -->
							<section>
								<div class="bannerimg cover-image" data-bs-image-src="{{asset('assets/images/photos/banner1.jpg')}}">
									<div class="header-text mb-0">
										<div class="container">
											<div class="row text-white">
												<div class="col my-2">
													<h1>{{trans('langconvert.menu.knowledge')}}</h1>
												</div>
												<div class="col col-auto">
													<ol class="breadcrumb text-center">
														<li class="breadcrumb-item">
															<a href="#" class="text-white-50">{{trans('langconvert.menu.home')}}</a>
														</li>
														<li class="breadcrumb-item">
															<a href="{{route('knowledge')}}" class="text-white">{{trans('langconvert.menu.knowledge')}}</a>
														</li>
														@if($articles->category->categoryslug != null)

														<li class="breadcrumb-item ">
															<a href="{{url('/category/'. $articles->category->categoryslug)}}" class="text-white"> {{$articles->category->name}}</a>
														</li>
														@else
														
														<li class="breadcrumb-item ">
															<a href="{{url('/category/'. $articles->category->id	)}}" class="text-white"> {{$articles->category->name}}</a>
														</li>
														@endif
														
														@if($articles->subcategory != null)

														<li class="breadcrumb-item ">
															<a href="#" class="text-white">{{$articles->subcategorys->subcategoryname}}</a>
														</li>
														@endif
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
										<div class="row">
											<div class="col-xl-8">
												<div class="card">
													<div class="px-5 pb-0 pt-5 pos-relative">
														<div class="w-lg-90 w-md-lg-85 w-100">
															<h4 class="card-title mb-2">{{$articles->title}}</h4>
															<ul class="mb-0 d-flex flex-wrap fs-13 custom-ul">
																<li class="me-5">
																	<span><i class="feather feather-clock text-muted me-1"></i>{{trans('langconvert.admindashboard.lastcreatedon')}} <span
																			class="text-muted">{{$articles->updated_at->format('M d, Y')}}</span></span>
																</li>
																<li class="me-5" data-placement="top" data-bs-toggle="tooltip" title=""
																	data-bs-original-title="Views">
																	<span><i class="feather feather-eye text-muted me-1"></i>{!!
																		$articles->views !!}</span>
																</li>
															</ul>
														</div>	
														<div class="klview-icons btn-group">
															<span class="btn btn-white btn-sm"><i
																	class="fa fa-thumbs-up text-success"></i> {{$like->count()}}</span>
															<span class="btn btn-white btn-sm"><i
																	class="fa fa-thumbs-down text-danger"></i> {{$dislike->count()}}</span>
														</div>	
													</div>
													<div class="card-body pt-0">

														@if($articles->privatemode == 1)
															@if(Auth::guard('customer')->check() && Auth::guard('customer')->user())
															<div class="mb-4 description mt-3">
																@if($articles->featureimage != null)
																
																<img src="{{asset('uploads/featureimage/'.$articles->featureimage)}}" alt="">
																@endif
																<div class="mt-3">{!!ucfirst($articles->message) !!}</div>
																
																<div class="row">
																	<div class="col-xl-12">
																		<div class="row">
																			@foreach ($articles->getMedia('article') as $article)
	
																			<div class="col-xl-3 col-md-4 col-sm-12">
																				<div class="tags  gallery me-3">
																				<a href="{{url($article->getFullUrl())}}">
																					<span class="tag tag-attachments rounded-pill  tag-outline-primary mt-0">
																						<span class="me-2"><i class="mdi mdi-file-image tx-24"></i></span>
																						{{Str::limit($article->file_name, 15, $end='.......')}}
																					</span>
																				</a>
																			</div>
																			
																			</div>
																			@endforeach
																		</div>
																	</div>
																</div>
															</div>
															@else
															
															<div class="alert alert-light-warning mt-3">
																<p class="privatearticle">
																<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
																You must be logged in and have valid account to access this content.
																</p>
															</div>
															@endif
														@else

															<div class="mb-4 description mt-3">
																@if($articles->featureimage != null)
																
																<img src="{{asset('uploads/featureimage/'.$articles->featureimage)}}" alt="">
																@endif
																<div class="mt-3">{!!ucfirst($articles->message) !!}</div>
																
																<div class="row">
																	<div class="col-xl-12">
																		<div class="d-flex flex-wrap align-items-center">
																			@foreach ($articles->getMedia('article') as $article)

																			<div class="mb-2 gallery me-2">
																				<a href="{{url($article->getFullUrl())}}">
																					<span class="tag tag-attachments br-7 tag-outline-gray mt-0">
																						<span class="me-2"><i class="mdi mdi-file-image tx-24"></i></span>
																						{{Str::limit($article->file_name, 15, $end='.......')}}
																					</span>
																				</a>
																			</div>
																			
																			@endforeach
																		</div>
																	</div>
																</div>
															</div>
														@endif
													

													</div>
													@guest

													<div class="card-body d-md-flex">
														<div class="ms-auto"><span>{{trans('langconvert.admindashboard.views')}}:</span><span class="font-weight-semibold ms-1">{!!
																$articles->views !!}</span></div>
													</div>
													@else

													@if(Auth::guard('customer')->check() && Auth::guard('customer')->user())
													<div class="card-body d-md-flex">
														<div> 
															<span class="">{{trans('langconvert.admindashboard.articlehelpfull')}}</span>
															<button class="btn btn-success btn-sm likedislike" value="like" data-name="{{$articles->id}}" @if($viewrating != null) {{$viewrating->rating == '1' ? 'disabled' : ''}} @endif>
																<i class="fa fa-thumbs-up"></i>
															</button>
															<button class="btn btn-danger btn-sm likedislike" value="dislike" data-name="{{$articles->id}}" @if($viewrating != null) {{$viewrating->rating == '-1' ? 'disabled' : ''}} @endif>
																<i class="fa fa-thumbs-down"></i>
															</button>
															<a href="{{url('/likes/'.$articles->id)}}" >
																
															</a>
															<a href="{{url('/dislikes/'.$articles->id)}}" >
																
															</a>
														</div>
													</div>
													@endif
													@endguest

												</div>

											</div>
											<div class="col-xl-4">
												<div class="card p-0">
													<div class="search-background article-search p-0">
														<input type="text" class="form-control input-lg" name="search_name" id="search_name"  placeholder="Ask your Questions.....">
														<button class="btn"><i class="fe fe-search"></i></button>
							
														<div id="searchList">
															
														</div>
													</div>
													@csrf
												</div>	

												<div class="card ">
													<div class="card-header  border-0">
														<h4 class="card-title">{{trans('langconvert.admindashboard.recentarticles')}}</h4>
													</div>
													<div class="card-body">
														<div class="list-catergory ">
															<ul class="item-list item-list-scroll mb-0 custom-ul">
																@foreach ($recentarticles as $recentarticle)
																<li class="item mb-4 position-relative">
																	@if($recentarticle->articleslug != null)

																	<a href="{{url('/article/' . $recentarticle->articleslug)}} " class=" admintickets"></a>
																
																	@else

																	<a href="{{url('/article/' . $recentarticle->id)}} " class=" admintickets"></a>
																	@endif
																	<div class="d-flex">
																		<div class="me-7">
																			<i class="typcn typcn-document-text item-list-icon"></i>
																		
																		</div>
																		<div class="">
																			<span class="">{{Str::limit($recentarticle->title,'40')}} </span>
																		</div>
																		<div class=" ms-auto">
																				<span class="badge badge-light badge-md fs-10"><i
																					class="fa fa-eye me-1"></i>{{$recentarticle->views}}</span>
																		</div>
																	</div>
																</li>
																@endforeach
					
															</ul>
														</div>
													</div>
												</div>
					
												<div class="card mb-0">
													<div class="card-header  border-0">
														<h4 class="card-title">{{trans('langconvert.menu.populararticles')}}</h4>
													</div>
													<div class="card-body">
														<div class="list-catergory">
															<ul class="item-list item-list-scroll mb-0 custom-ul">
																@foreach ($populararticles as $populararticle)
																<li class="item mb-4 position-relative">
																	@if($populararticle->articleslug != null)

																	<a href="{{url('/article/' . $populararticle->articleslug)}} " class=" admintickets"></a>
																	@else

																	<a href="{{url('/article/' . $populararticle->id)}} " class=" admintickets"></a>
																	@endif
																	<div class="d-flex">
																		<div class="me-7">
																			<i class="typcn typcn-document-text item-list-icon"></i>
																		</div>
																		<div class="">
																			<span class="">{{Str::limit($populararticle->title, '40')}} </span>
																		</div>
																		<div class="ms-auto">
																				<span class="badge badge-light badge-md fs-10">
																					<i class="fa fa-eye me-1"></i>{{$populararticle->views}}</span>
																		</div>
																	</div>
																</li>
																@endforeach
					
															</ul>
														</div>
													</div>
													
												</div>
											</div>
										</div>
									</div>
								</div>
							</section>
							<!--Section-->
						</div>
					</div>
				</div>
				<!--Article Page View -->
				
				@include('includes.footer')

		<!-- Back to top -->
		<a href="#top" id="back-to-top"><span class="feather feather-chevrons-up"></span></a>

		<!-- Jquery js-->
		<script src="{{URL::asset('assets/plugins/jquery/jquery.min.js')}}?v=<?php echo time(); ?>"></script>

		<!--Moment js-->
		<script src="{{URL::asset('assets/plugins/moment/moment.js')}}?v=<?php echo time(); ?>"></script>

		<!-- Bootstrap4 js-->
		<script src="{{URL::asset('assets/plugins/bootstrap/popper.min.js')}}?v=<?php echo time(); ?>"></script>
		<script src="{{URL::asset('assets/plugins/bootstrap/js/bootstrap.min.js')}}?v=<?php echo time(); ?>"></script>

		<!-- P-scroll js-->
		<script src="{{URL::asset('assets/plugins/p-scrollbar/p-scrollbar.js')}}?v=<?php echo time(); ?>"></script>

		<!-- Select2 js -->
		<script src="{{URL::asset('assets/plugins/select2/select2.full.min.js')}}?v=<?php echo time(); ?>"></script>

		<!--INTERNAL Horizontalmenu js -->
		<script src="{{URL::asset('assets/plugins/horizontal-menu/horizontal-menu.js')}}?v=<?php echo time(); ?>"></script>

		<!--INTERNAL Sticky js -->
		<script src="{{asset('assets/plugins/sticky/sticky2.js')}}?v=<?php echo time(); ?>"></script>

		@yield('scripts')

		<!--INTERNAL Toastr js -->
		<script src="{{URL::asset('assets/plugins/toastr/toastr.min.js')}}?v=<?php echo time(); ?>"></script>


		<!-- INTERNAL Vertical-scroll js-->
		<script src="{{asset('assets/plugins/vertical-scroll/jquery.bootstrap.newsbox.js')}}?v=<?php echo time(); ?>"></script>


		<!-- GALLERY JS -->
		<script src="{{asset('assets/plugins/simplelightbox/simplelightbox.js')}}?v=<?php echo time(); ?>"></script>
		<script src="{{asset('assets/plugins/simplelightbox/light-box.js')}}?v=<?php echo time(); ?>"></script>

		<!-- Custom html js-->
		<script src="{{URL::asset('assets/js/custom.js')}}?v=<?php echo time(); ?>"></script>

		<!-- Custom js-->	
		<script type="text/javascript">
			"use strict";

			@php echo customcssjs('CUSTOMJS') @endphp


			// close the data search
			document.querySelector('.page-main').addEventListener('click', ()=>{ 
				$('#searchList').fadeOut();
				$('#searchList').html(''); 
			});
			
			// search the data
			$('#search_name').keyup(function () {

				var data = $(this).val();
				if (data != '') {
					var _token = $('input[name="_token"]').val();
					$.ajax({
						url: "{{ url('/search') }}",
						method: "POST",
						data: {data: data, _token: _token},

						dataType:"json",

						success: function (data) {

							$('#searchList').fadeIn();
							$('#searchList').html(data);
							const ps3 = new PerfectScrollbar('.sprukohomesearch', {
								useBothWheelAxes:true,
								suppressScrollX:true,
							});
						},
						error: function (data) {

						}
					});
				}
			});

		</script>

		@guest
		@if (customcssjs('CUSTOMCHATENABLE') == 'enable')
		@if (customcssjs('CUSTOMCHATUSER') == 'public')

		@php echo customcssjs('CUSTOMCHAT') @endphp;

		@endif
		@endif
		@else
		@if (customcssjs('CUSTOMCHATENABLE') == 'enable')
		@if (Auth::guard('customer')->check() && Auth::guard('customer')->user())

		@php echo customcssjs('CUSTOMCHAT') @endphp;

		@endif
		@endif
		@endguest
		@if (Session::has('error'))

		<script>
			toastr.error("{!! Session::get('error') !!}");
		</script>

		@elseif(Session::has('success'))
		
		<script>
			toastr.success("{!! Session::get('success') !!}");
		</script>

		@elseif(Session::has('info'))

		<script>
			toastr.info("{!! Session::get('info') !!}");
		</script>
		@elseif(Session::has('warning'))

		<script>
			toastr.warning("{!! Session::get('warning') !!}");
		</script>
		@endif

		@include('user.auth.modalspopup.register')

		@include('user.auth.modalspopup.login')
		
		@include('user.auth.modalspopup.forgotpassword')

</body>

</html>