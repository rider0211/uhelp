				<!-- Mobile Header -->
				<div class="support-mobile-header clearfix">
					<div class="">
						<div class="d-flex">
							<a class="animated-arrow horizontal-navtoggle"><span></span></a>
							<span class="smallogo">
								 
								{{--Logo--}}
                                @if ($title->image == null)

                                <img src="{{asset('uploads/logo/logo/logo-white.png')}}" class="header-brand-img dark-logo" alt="logo">
                                @else

                                <img src="{{asset('uploads/logo/logo/'.$title->image)}}" class="header-brand-img dark-logo" alt="logo">
                                @endif

                                {{--Dark-Logo--}}
                                @if ($title->image1 == null)

                                <img src="{{asset('uploads/logo/darklogo/logo.png')}}" class="header-brand-img desktop-lgo" alt="dark-logo">
                                @else

                                <img src="{{asset('uploads/logo/darklogo/'.$title->image1)}}" class="header-brand-img desktop-lgo" alt="dark-logo">
                                @endif

                                {{--Mobile-Logo--}}
                                @if ($title->image2 == null)

                                <img src="{{asset('uploads/logo/icon/icon.png')}}" class="header-brand-img mobile-logo" alt="mobile-logo">
                                @else

                                <img src="{{asset('uploads/logo/icon/'.$title->image2)}}" class="header-brand-img mobile-logo" alt="mobile-logo">
                                @endif

                                {{--Mobile-Dark-Logo--}}
                                @if ($title->image3 == null)

                                <img src="{{asset('uploads/logo/darkicon/icon-white.png')}}" class="header-brand-img darkmobile-logo" alt="mobile-dark-logo">
                                @else

                                <img src="{{asset('uploads/logo/darkicon/'.$title->image3)}}" class="header-brand-img darkmobile-logo" alt="mobile-dark-logo">
                                @endif

							</span>

							<div class="d-flex ms-auto pe-3">
								<div  class="dropdown header-flags text-uppercase">
									<a href="#" class="nav-link pe-1 ps-0  dropdown-toggle" data-bs-toggle="dropdown">
										<span class="">{{ app()->getLocale() }} </span>
									</a>
									<div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow animated text-uppercase">
										@foreach(getLanguages() as $lang)

											<a href="{{route('front.set_language', [$lang])}}" class="dropdown-item d-flex">
												<span class="">{{ $lang }}</span>
											</a>

										@endforeach

									</div>
								</div>

								@if(Auth::guard('customer')->check())

									@include('includes.user.mobilenotification')

										<div class="dropdown profile-dropdown">
											<a href="#" class="nav-link pe-1 ps-0 leading-none" data-bs-toggle="dropdown">
												<span>
													@if (Auth::guard('customer')->check() && Auth::guard('customer')->user()->image == null)

													<img src="{{asset('uploads/profile/user-profile.png')}}" class="avatar avatar-md bradius rounded-circle" alt="default">
													@else

													<img src="{{asset('uploads/profile/'.Auth::user()->image)}}" alt="{{Auth::guard('customer')->user()->image}}" class="avatar avatar-md bradius">
													@endif

												</span>
											</a>
											<div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
												<div class="p-3 text-center border-bottom">
													<a href="#" class="text-center user pb-0 font-weight-bold">{{Auth::guard('customer')->user()->username}}</a>
													<p class="text-center user-semi-title">{{Auth::guard('customer')->user()->email}}</p>
												</div>
												<a class="dropdown-item d-flex" href="{{route('client.profile')}}">
													<i class="feather feather-user me-3 fs-16 my-auto"></i>
													<div class="mt-1">Profile</div>
												</a>
												<a class="dropdown-item d-flex" href="{{route('activeticket')}}">
													<i class="ri-ticket-2-line me-3 fs-16 my-auto"></i>
													<div class="mt-1">Tickets</div>
												</a>
												<form id="logout-form" action="{{route('client.logout')}}" method="POST">
													@csrf

													<button type="submit" class="dropdown-item d-flex">
														<i class="feather feather-power me-3 fs-16 my-auto"></i>
														<div class="mt-1">Log Out</div>
													</button>
											</form>
											</div>
										</div>
										
								@endif

							</div>	
							

						</div>
					</div>
				</div>
				<!-- /Mobile Header -->