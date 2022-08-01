                                    <!--Notification Page-->
                                    <div class="dropdown me-0 pe-1 header-message">
                                        <a class="nav-link icon p-0 mt-1" data-bs-toggle="dropdown">
                                            <i class="feather feather-bell header-icon"></i>
                                            <!-- Counter - Alerts -->
                                            <span class="badge badge-success badge-counter">{{ auth()->guard('customer')->user()->unreadNotifications->count() }}</span>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow p-0 notification-dropdown-container">
                                            @if(auth()->guard('customer')->user())
                                                @forelse( auth()->guard('customer')->user()->unreadNotifications()->paginate(2) as $notification)
                                                    @if($notification->data['status'] == 'New')

                                                        <a class="dropdown-item border-bottom mark-as-read" href="{{$notification->data['clink']}}" data-id="{{ $notification->id }}">
                                                            <div class="d-flex align-items-center">
                                                                <div class="">
                                                                    <span class="bg-success-transparent brround fs-12 notifications"><i class="feather  feather-bell sidemenu_icon fs-20"></i></span>
                                                                </div>
                                                                <div class="d-flex">
                                                                    <div class="ps-3">
                                                                        <h6 class="mb-1">{{ $notification->data['title'] }}</h6>
                                                                        <p class="fs-13 mb-1 text-wrap">  {{trans('langconvert.usermenu.newticket')}} {{ $notification->data['ticket_id'] }}</p>
                                                                        <div class="small text-muted">
                                                                            {{ $notification->created_at->diffForHumans() }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    @endif
                                                    @if($notification->data['status'] == 'Closed')

                                                        <a class="dropdown-item border-bottom mark-as-read" href="{{$notification->data['clink']}}" data-id="{{ $notification->id }}">
                                                            <div class="d-flex align-items-center">
                                                                <div class="">
                                                                    <span class="bg-success-transparent brround fs-12 notifications"><i class="feather  feather-bell sidemenu_icon fs-20"></i></span>
                                                                </div>
                                                                <div class="d-flex">
                                                                    <div class="ps-3">
                                                                        <h6 class="mb-1">{{ $notification->data['title'] }}</h6>
                                                                        <p class="fs-13 mb-1 text-wrap">  {{trans('langconvert.usermenu.closeticket')}} {{ $notification->data['ticket_id'] }}</p>
                                                                        <div class="small text-muted">
                                                                            {{ $notification->created_at->diffForHumans() }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    @endif
                                                    @if($notification->data['status'] == 'On-Hold')

                                                        <a class="dropdown-item border-bottom mark-as-read" href="{{$notification->data['clink']}}" data-id="{{ $notification->id }}">
                                                            <div class="d-flex align-items-center">
                                                                <div class="">
                                                                    <span class="bg-success-transparent brround fs-12 notifications"><i class="feather  feather-bell sidemenu_icon fs-20"></i></span>
                                                                </div>
                                                                <div class="d-flex">
                                                                    <div class="ps-3">
                                                                        <h6 class="mb-1">{{ $notification->data['title'] }}</h6>
                                                                        <p class="fs-13 mb-1 text-wrap">  {{trans('langconvert.usermenu.onholdticket')}} {{ $notification->data['ticket_id'] }}</p>
                                                                        <div class="small text-muted">
                                                                            {{ $notification->created_at->diffForHumans() }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    @endif
                                                    @if($notification->data['status'] == 'Re-Open')

                                                        <a class="dropdown-item border-bottom mark-as-read" href="{{$notification->data['clink']}}" data-id="{{ $notification->id }}">
                                                            <div class="d-flex align-items-center">
                                                                <div class="">
                                                                    <span class="bg-success-transparent brround fs-12 notifications"><i class="feather  feather-bell sidemenu_icon fs-20"></i></span>
                                                                </div>
                                                                <div class="d-flex">
                                                                    <div class="ps-3">
                                                                        <h6 class="mb-1">{{ $notification->data['title'] }}</h6>
                                                                        <p class="fs-13 mb-1 text-wrap">  {{trans('langconvert.usermenu.reopenticket')}} {{ $notification->data['ticket_id'] }}</p>
                                                                        <div class="small text-muted">
                                                                            {{ $notification->created_at->diffForHumans() }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    @endif
                                                    @if($notification->data['status'] == 'Inprogress')

                                                        <a class="dropdown-item border-bottom mark-as-read" href="{{$notification->data['clink']}}" data-id="{{ $notification->id }}">
                                                            <div class="d-flex align-items-center">
                                                                <div class="">
                                                                    <span class="bg-success-transparent brround fs-12 notifications"><i class="feather  feather-bell sidemenu_icon fs-20"></i></span>
                                                                </div>
                                                                <div class="d-flex">
                                                                    <div class="ps-3">
                                                                        <h6 class="mb-1">{{ $notification->data['title'] }}</h6>
                                                                        <p class="fs-13 mb-1 text-wrap">  {{trans('langconvert.usermenu.repliedticket')}} {{ $notification->data['ticket_id'] }}</p>
                                                                        <div class="small text-muted">
                                                                            {{ $notification->created_at->diffForHumans() }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    @endif
                                                    @if($notification->data['status'] == 'overdue')

                                                        <a class="dropdown-item border-bottom mark-as-read" href="{{$notification->data['clink']}}" data-id="{{ $notification->id }}">
                                                            <div class="d-flex align-items-center">
                                                                <div class="">
                                                                    <span class="bg-success-transparent brround fs-12 notifications"><i class="feather  feather-bell sidemenu_icon fs-20"></i></span>
                                                                </div>
                                                                <div class="d-flex">
                                                                    <div class="ps-3">
                                                                        <h6 class="mb-1">{{ $notification->data['title'] }}</h6>
                                                                        <p class="fs-13 mb-1 text-wrap">  {{trans('langconvert.usermenu.overdueticket')}} {{ $notification->data['ticket_id'] }}</p>
                                                                        <div class="small text-muted">
                                                                            {{ $notification->created_at->diffForHumans() }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    @endif
                                                    @if ($notification->data['status'] == 'mail')

                                                    <a class="dropdown-item border-bottom mark-as-read" href="{{route('client.notification')}}" >
                                                        <div class="d-flex ">
                                                            <div class="">
                                                                <span class="bg-success-transparent brround fs-12 notifications"><i class="feather  feather-bell sidemenu_icon fs-20"></i></span>
                                                            </div>
                                                            <div class="d-flex">
                                                                <div class="ps-3">
                                                                    <h6 class="mb-1"> {{$notification->data['mailsubject']}}</h6>
                                                                    <p class="fs-13 mb-1 text-wrap">
                                                                        {{$notification->data['mailtext']}}
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
                                                        <div class="d-flex justify-content-center align-items-center">
                                                            <div class="d-flex">
                                                                <div class="ps-3 text-center">
                                                                    <img src="{{asset('assets/images/nonotification.png')}}" alt="">
                                                                    <p class="fs-13 mb-1 text-muted">{{trans('langconvert.usermenu.nonotify')}}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                @endforelse
                                            @endif

                                            <div class=" text-center p-2">
                                                <a href="{{route('client.notification')}}" class="">{{trans('langconvert.usermenu.allnotify')}} ({{ auth()->guard('customer')->user()->notifications->count() }})</a>
                                            </div>
                                        </div>

                                    </div>
                                    <!--Notification Page-->