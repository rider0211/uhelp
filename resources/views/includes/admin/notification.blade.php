
											<!--Notification Page-->
											<div class="dropdown header-message">
												<a class="nav-link icon" data-bs-toggle="dropdown">
													<i class="feather feather-bell header-icon"></i>
													<!-- Counter - Alerts -->
													<span class="badge badge-success badge-counter">{{ auth()->user()->unreadNotifications->count() }}</span>
												</a>
												<div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow animated p-0 notification-dropdown-container">
													<div class="header-dropdown-list message-menu" id="message-menu">
												@if(auth()->user())
													@forelse( auth()->user()->unreadNotifications()->paginate(2) as $notification)
														@if($notification->data['status'] == 'New')

															<a class="dropdown-item border-bottom mark-as-read" href="{{$notification->data['link']}}" data-id="{{ $notification->id }}">
																<div class="d-flex align-items-center">
																	<div class="">
																		<span class="bg-success-transparent brround fs-12 notifications"><i class="feather  feather-bell sidemenu_icon fs-20 text-success"></i></span>
																	</div>
																	<div class="d-flex">
																		<div class="ps-3">
																			<h6 class="mb-1">{{ Str::limit($notification->data['title'], '30') }}</h6>
																			<p class="fs-13 mb-1 text-wrap"> {{trans('langconvert.adminmenu.newticket')}} {{ $notification->data['ticket_id'] }}</p>
																			<div class="small text-muted">
																				{{ $notification->created_at->diffForHumans() }}
																			</div>
																		</div>
																	</div>
																</div>
															</a>
														@endif
														@if($notification->data['status'] == 'Closed')

															<a class="dropdown-item border-bottom mark-as-read" href="{{$notification->data['link']}}" data-id="{{ $notification->id }}">
																<div class="d-flex align-items-center">
																	<div class="">
																		<span class="bg-success-transparent brround fs-12 notifications"><i class="feather  feather-bell sidemenu_icon fs-20 text-success"></i></span>
																	</div>
																	<div class="d-flex">
																		<div class="ps-3">
																			<h6 class="mb-1">{{ Str::limit($notification->data['title'], '30') }}</h6>
																			<p class="fs-13 mb-1 text-wrap"> {{trans('langconvert.adminmenu.closeticket')}} {{ $notification->data['ticket_id'] }}</p>
																			<div class="small text-muted">
																				{{ $notification->created_at->diffForHumans() }}
																			</div>
																		</div>
																	</div>
																</div>
															</a>
														@endif
														@if($notification->data['status'] == 'On-Hold')

															<a class="dropdown-item border-bottom mark-as-read" href="{{$notification->data['link']}}" data-id="{{ $notification->id }}">
																<div class="d-flex align-items-center">
																	<div class="">
																		<span class="bg-success-transparent brround fs-12 notifications"><i class="feather  feather-bell sidemenu_icon fs-20 text-success"></i></span>
																	</div>
																	<div class="d-flex">
																		<div class="ps-3">
																			<h6 class="mb-1">{{ Str::limit($notification->data['title'], '30') }}</h6>
																			<p class="fs-13 mb-1 text-wrap"> {{trans('langconvert.adminmenu.onholdticket')}} {{ $notification->data['ticket_id'] }}</p>
																			<div class="small text-muted">
																				{{ $notification->created_at->diffForHumans() }}
																			</div>
																		</div>
																	</div>
																</div>
															</a>
														@endif
														@if($notification->data['status'] == 'Re-Open')

															<a class="dropdown-item border-bottom mark-as-read" href="{{$notification->data['link']}}" data-id="{{ $notification->id }}">
																<div class="d-flex align-items-center">
																	<div class="">
																		<span class="bg-success-transparent brround fs-12 notifications"><i class="feather  feather-bell sidemenu_icon fs-20 text-success"></i></span>
																	</div>
																	<div class="d-flex">
																		<div class="ps-3">
																			<h6 class="mb-1">{{ Str::limit($notification->data['title'], '30') }}</h6>
																			<p class="fs-13 mb-1 text-wrap"> {{trans('langconvert.adminmenu.reopenticket')}} {{ $notification->data['ticket_id'] }}</p>
																			<div class="small text-muted">
																				{{ $notification->created_at->diffForHumans() }}
																			</div>
																		</div>
																	</div>
																</div>
															</a>
														@endif
														@if($notification->data['status'] == 'Inprogress')

															<a class="dropdown-item border-bottom mark-as-read" href="{{$notification->data['link']}}" data-id="{{ $notification->id }}">
																<div class="d-flex align-items-center">
																	<div class="">
																		<span class="bg-success-transparent brround fs-12 notifications"><i class="feather  feather-bell sidemenu_icon fs-20 text-success"></i></span>
																	</div>
																	<div class="d-flex">
																		<div class="ps-3">
																			<h6 class="mb-1">{{ Str::limit($notification->data['title'], '30') }}</h6>
																			<p class="fs-13 mb-1 text-wrap"> {{trans('langconvert.adminmenu.repliedticket')}} {{ $notification->data['ticket_id'] }}</p>
																			<div class="small text-muted">
																				{{ $notification->created_at->diffForHumans() }}
																			</div>
																		</div>
																	</div>
																</div>
															</a>
														@endif
														@if($notification->data['status'] == 'overdue')

															<a class="dropdown-item border-bottom mark-as-read" href="{{$notification->data['link']}}" data-id="{{ $notification->id }}">
																<div class="d-flex align-items-center">
 																<div class="">
																	<span class="bg-success-transparent brround fs-12 notifications"><i class="feather  feather-bell sidemenu_icon fs-20 text-success"></i></span>
																</div>
																	<div class="d-flex">
																		<div class="ps-3">
																			<h6 class="mb-1">{{ Str::limit($notification->data['title'], '30') }}</h6>
																			<p class="fs-13 mb-1 text-wrap"> {{trans('langconvert.adminmenu.overdueticket')}} {{ $notification->data['ticket_id'] }}</p>
																			<div class="small text-muted">
																				{{ $notification->created_at->diffForHumans() }}
																			</div>
																		</div>
																	</div>
																</div>
															</a>
														@endif
														@if ($notification->data['status'] == 'mail')
														
														<a class="dropdown-item border-bottom mark-as-read" href="#" >
															<div class="d-flex ">
																<div class="">
																	<span class="avatar avatar-md brround align-self-center cover-image" data-image-src="../../assets/images/users/1.jpg"></span>
																</div>
																<div class="d-flex">
																	<div class="ps-3">
																		<h6 class="mb-1"> {{$notification->data['mailsubject']}}</h6>
																		<p class="fs-13 mb-1 text-wrap">
																			{{Str::limit($notification->data['mailtext'], '100', '.......')}}
																		</p>
																		<div class="small text-muted">
																			{{ $notification->created_at->diffForHumans() }}
																		</div>
																	</div>
																</div>
															</div>
														</a>
														@endif
													@empty

													<a class="dropdown-item border-bottom mark-as-read notification-dropdown" href="">
														<div class="d-flex justify-content-center">
															<div class="ps-3 text-center">
																<img src="{{asset('assets/images/nonotification.png')}}" alt="">
																<p class="fs-13 mb-1 text-muted">{{trans('langconvert.usermenu.nonotify')}}</p>
															</div>
														</div>
													</a>
														
													@endforelse
												@endif
												
													</div>
													<div class="text-center p-2">
														<a href="{{route('notificationpage')}}" class="smark-all">{{trans('langconvert.usermenu.allnotify')}} ({{ auth()->user()->notifications->count() }})</a>
													</div>
												</div>
											</div>
											<!--Notification Page-->