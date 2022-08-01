				<!-- Header-->
				<div class="landingmain-header header">
					<div class="horizontal-main landing-header clearfix sticky">
						<div class="horizontal-mainwrapper container clearfix">
							<div class="d-flex">
								<div class="headerlanding-logo">
									<a class="header-brand" href="{{url('/')}}">
										@if ($title->image !== null)

										<img src="{{asset('uploads/logo/logo/'.$title->image)}}" class="header-brand-img light-logo"
											alt="{{$title->image}}">
										@else
										
										<img src="{{asset('uploads/logo/logo/logo-white.png')}}" class="header-brand-img light-logo"
											alt="logo">
										@endif
										@if ($title->image1 !== null)

											<img src="{{asset('uploads/logo/darklogo/'.$title->image1)}}" class="header-brand-img desktop-lgo"
											alt="{{$title->image1}}">
										@else
										
										<img src="{{asset('uploads/logo/darklogo/logo.png')}}" class="header-brand-img desktop-lgo"
											alt="logo">

										@endif
										
									
									
									</a>

								</div>
								<nav class="horizontalMenu clearfix order-lg-2 my-auto ms-auto">
									<ul class="horizontalMenu-list custom-ul">
										<li>
											<a href="{{url('/')}}">{{trans('langconvert.menu.home')}}</a>
										</li>
										@if (setting('KNOWLEDGE_ENABLE') == 'yes')

										<li>
											<a href="{{url('/knowledge')}}" class="sub-icon">{{trans('langconvert.menu.knowledge')}} </a>
										</li>
										@endif
										@if (setting('FAQ_ENABLE') == 'yes')

										<li>
											<a href="{{url('/faq')}}" class="sub-icon">{{trans('langconvert.menu.faq')}}</a>
										</li>
										@endif
										@if (setting('CONTACT_ENABLE') == 'yes')

										<li>
											<a href="{{url('/contact-us')}}">{{trans('langconvert.menu.contact')}}</a>
										</li>
										@endif

										@foreach ($page as $pages)
										@if($pages->status == '1')
										@if($pages->viewonpages == 'both' || $pages->viewonpages == 'header')

										<li>
											<a href="{{url('page/' .$pages->pageslug)}}">{{$pages->pagename}}</a>
										</li>

										@endif
										@endif
										@endforeach
										
										@if (Auth::guard('customer')->check())

										@include('includes.user.notifynotication')

										<li  class="dropdown header-flags text-capitalize">
											<a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">
												<span class="">{{ app()->getLocale() }} </span>
											</a>
											<div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow animated text-capitalize">
												
												@foreach(getLanguages() as $lang)

													<a href="{{route('front.set_language', [$lang])}}" class="dropdown-item d-flex fs-13">
														<span class="">{{ $lang }}</span>
													</a>

												@endforeach

											</div>
										</li>

										<li class="dropdown profile-dropdown">
											<a href="#" class="nav-link pe-1 ps-0 py-0 mt-1 leading-none" data-bs-toggle="dropdown">
												<span>
													@if (Auth::guard('customer')->user()->image == null)

													<img src="{{asset('uploads/profile/user-profile.png')}}" class="avatar avatar-md bradius rounded-circle" alt="default">
													@else

													<img src="{{asset('uploads/profile/'.Auth::guard('customer')->user()->image)}}" alt="{{Auth::guard('customer')->user()->image}}" class="avatar avatar-md bradius">
													@endif

												</span>
											</a>
											<div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
												<div class="p-3 text-center border-bottom">
													<a href="#" class="text-center user pb-0 font-weight-bold">{{Auth::guard('customer')->user()->username}}</a>
													<p class="text-center user-semi-title">{{Auth::guard('customer')->user()->email}}</p>
												</div>

												<a class="dropdown-item d-flex" href="{{route('client.dashboard')}}">
													<i class="feather feather-grid me-3 fs-16 my-auto"></i>
													<div class="mt-1">{{trans('langconvert.menu.dashboard')}}</div>
												</a>
												<a class="dropdown-item d-flex" href="{{route('client.profile')}}">
													<i class="feather feather-user me-3 fs-16 my-auto"></i>
													<div class="mt-1">{{trans('langconvert.menu.profile')}}</div>
												</a>
												<a class="dropdown-item d-flex" href="{{route('activeticket')}}">
													<i class="ri-ticket-2-line me-3 fs-16 my-auto"></i>
													<div class="mt-1">{{trans('langconvert.menu.ticket')}}</div>
												</a>
												<form id="logout-form" action="{{route('client.logout')}}" method="POST">
													@csrf

													<button type="submit" class="dropdown-item d-flex">
														<i class="feather feather-power me-3 fs-16 my-auto"></i>
													<div class="mt-1">{{trans('langconvert.menu.logout')}}</div>
													</button>
											</form>

											</div>
										</li>

										@else
											@if (setting('REGISTER_POPUP') == 'yes')

											<li><a href="#" data-bs-toggle="modal" data-bs-target="#loginmodal">{{trans('langconvert.menu.login')}}</a></li>
											@if(setting('REGISTER_DISABLE') == 'on')

												<li><a href="#" data-bs-toggle="modal" data-bs-target="#registermodal">{{trans('langconvert.menu.register')}}</a></li>
											@endif
											@else

												<li><a href="{{url('customer/login')}}" >{{trans('langconvert.menu.login')}}</a></li>
												@if(setting('REGISTER_DISABLE') == 'on')

												<li><a href="{{url('customer/register')}}" >{{trans('langconvert.menu.register')}}</a></li>
												@endif
											@endif

											<li  class="dropdown header-flags text-capitalize">
												<a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">
													<span class="">{{ app()->getLocale() }} </span>
												</a>
												<div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow animated text-capitalize">
													
													@foreach(getLanguages() as $lang)
	
														<a href="{{route('front.set_language', [$lang])}}" class="dropdown-item d-flex fs-13">
															<span class="">{{ $lang }}</span>
														</a>
	
													@endforeach
	
												</div>
											</li>
											
											@if(setting('GUEST_TICKET') == 'yes')
											
											<li>
												<span class="menu-btn">
													<a class="btn btn-secondary m-0" href="{{url('/guest/openticket')}}">
														<i class="fa fa-paper-plane-o me-1"></i>
														{{trans('langconvert.menu.submitticket')}}
													</a>
												</span>
											</li>
											
											@endif
										@endif

									</ul>
								</nav>
							</div>
						</div>
					</div>
				</div>
				<!--Header-->

