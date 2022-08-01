@extends('layouts.adminmaster')


                            @section('content')

                            <!--Page header-->
                            <div class="page-header d-xl-flex d-block">
                                <div class="page-leftheader">
                                    <h4 class="page-title"><span class="font-weight-normal text-muted ms-2">Notifications</span></h4>
                                </div>
                                
                            </div>
                            <!--End Page header-->

                            <!-- Notification Page -->
                            <div class="row">
                                <div class="col-md-12">
                        @if(auth()->user())
                            @forelse( auth()->user()->notifications()->paginate(10) as $notification)
                                @if($notification->data['status'] == 'New')

                                    <div class="card readmores mb-3">
                                        <div class="card-body p-3">
                                            <div class="d-flex">
                                                <div class="text-center me-3">
                                                    <span class="bg-success-transparent brround fs-12 notifications"><i class="feather  feather-bell sidemenu_icon fs-20"></i></span>
                                                </div>
                                                <div class="me-3  mt-1 d-block">
                                                    <a href = "{{$notification->data['link']}}" data-id="{{ $notification->id }}"><p class="mb-0 fs-13  mark-as-read"><span class="font-weight-semibold">{{ $notification->data['title'] }}</span> <span class="text-muted"> ({{ $notification->created_at->diffForHumans() }})</span></p>
                                                    <small>  {{trans('langconvert.adminmenu.newticket')}} <strong>{{ $notification->data['ticket_id'] }}</strong> </small></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if($notification->data['status'] == 'Closed')

                                <div class="card readmores mb-3">
                                    <div class="card-body p-3">
                                        <div class="d-flex">
                                            <div class="text-center me-3">
                                                <span class="bg-success-transparent brround fs-12 notifications"><i class="feather  feather-bell sidemenu_icon fs-20"></i></span>
                                            </div>
                                            <div class="me-3  mt-1 d-block">
                                                <a href = "{{$notification->data['link']}}" data-id="{{ $notification->id }}"><p class="mb-0 fs-13  mark-as-read"><span class="font-weight-semibold"> {{$notification->data['title'] }}</span> <span class="text-muted"> ({{ $notification->created_at->diffForHumans() }})</span></p>
                                                <small>  {{trans('langconvert.adminmenu.closeticket')}} <strong> {{ $notification->data['ticket_id'] }}</strong> </small></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if($notification->data['status'] == 'On-Hold')

                                <div class="card readmores mb-3">
                                    <div class="card-body p-3">
                                        <div class="d-flex">
                                            <div class="text-center me-3">
                                                <span class="bg-success-transparent brround fs-12 notifications"><i class="feather  feather-bell sidemenu_icon fs-20"></i></span>
                                            </div>
                                            <div class="me-3  mt-1 d-block">
                                                <a href = "{{$notification->data['link']}}" data-id="{{ $notification->id }}"><p class="mb-0 fs-13 mark-as-read"> <span class="font-weight-semibold"> {{ $notification->data['title'] }}</span> <span class="text-muted"> ({{ $notification->created_at->diffForHumans() }})</span></p>
                                                <small>  {{trans('langconvert.adminmenu.onholdticket')}} <strong> {{ $notification->data['ticket_id'] }}</strong> </small></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if($notification->data['status'] == 'overdue')

                                <div class="card readmores mb-3">
                                    <div class="card-body p-3">
                                        <div class="d-flex">
                                            <div class="text-center me-3">
                                                <span class="bg-success-transparent brround fs-12 notifications"><i class="feather  feather-bell sidemenu_icon fs-20"></i></span>
                                            </div>
                                            <div class="me-3  mt-1 d-block">
                                                <a href = "{{$notification->data['link']}}" data-id="{{ $notification->id }}"><p class="mb-0 fs-13 mark-as-read"> <span class="font-weight-semibold">{{ $notification->data['title'] }}</span><span class="text-muted"> ({{ $notification->created_at->diffForHumans() }})</span></p>
                                                <small>  {{trans('langconvert.adminmenu.overdueticket')}} <strong> {{ $notification->data['ticket_id'] }}</strong> </small></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if($notification->data['status'] == 'Re-Open')

                                    <div class="card readmores mb-3">
                                        <div class="card-body p-3">
                                            <div class="d-flex">
                                                <div class="text-center me-3">
                                                    <span class="bg-success-transparent brround fs-12 notifications"><i class="feather  feather-bell sidemenu_icon fs-20"></i></span>
                                                </div>
                                                <div class="me-3  mt-1 d-block">
                                                    <a href = "{{$notification->data['link']}}" data-id="{{ $notification->id }}"><p class="mb-0 fs-13 mark-as-read"> <span class="font-weight-semibold">{{ $notification->data['title'] }}</span><span class="text-muted"> ({{ $notification->created_at->diffForHumans() }})</span></p>
                                                    <small>  {{trans('langconvert.adminmenu.reopenticket')}} <strong> {{ $notification->data['ticket_id'] }}</strong> </small></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if($notification->data['status'] == 'Inprogress')

                                    <div class="card readmores mb-3">
                                        <div class="card-body p-3">
                                            <div class="d-flex">
                                                <div class="text-center me-3">
                                                    <span class="bg-success-transparent brround fs-12 notifications"><i class="feather  feather-bell sidemenu_icon fs-20"></i></span>
                                                </div>
                                                <div class="me-3  mt-1 d-block">
                                                    <a href = "{{$notification->data['link']}}" data-id="{{ $notification->id }}"><p class="mb-0 fs-13 mark-as-read"> <span class="font-weight-semibold">{{ $notification->data['title'] }}</span><span class="text-muted"> ({{ $notification->created_at->diffForHumans() }})</span></p>
                                                    <small>  {{trans('langconvert.adminmenu.repliedticket')}} <strong> {{ $notification->data['ticket_id'] }}</strong> </small></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if ($notification->data['status'] == 'mail')

                                <div class="card readmores mb-3">
                                    <div class="card-body p-3">
                                        <div class="d-flex">
                                            <div class="text-center me-3">
                                                <span class="bg-success-transparent brround fs-12 notifications"><i class="feather  feather-bell sidemenu_icon fs-20"></i></span>
                                            </div>
                                            <div class="me-3  mt-1 d-block">
                                                <p class="mb-0 fs-13"> <span class="font-weight-semibold0"> {{$notification->data['mailsubject']}}</span><span class="text-muted"> ({{ $notification->created_at->diffForHumans() }})</span></p>
                                                <small>{{$notification->data['mailtext']}} </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            @empty

                            <div class="card">
                                <div class="card-body h-100 w-100">
                                    <div class="main-content text-center">
                                        <div class="notification-icon-container p-4">
                                            <svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" viewBox="0 0 24 24"><path d="M21.9,21.1l-19-19C2.7,2,2.4,2,2.2,2.1C2,2.3,2,2.7,2.1,2.9l4.5,4.5C6.2,8.2,6,9.1,6,10v4.1c-1.1,0.2-2,1.2-2,2.4v2C4,18.8,4.2,19,4.5,19h3.7c0.5,1.7,2,3,3.8,3c1.8,0,3.4-1.3,3.8-3h2.5l2.9,2.9c0.1,0.1,0.2,0.1,0.4,0.1c0.1,0,0.3-0.1,0.4-0.1C22,21.7,22,21.3,21.9,21.1z M7,10c0-0.7,0.1-1.3,0.4-1.9l5.9,5.9H7V10z M13,20.8c-1.6,0.5-3.3-0.3-3.8-1.8h5.6C14.5,19.9,13.8,20.5,13,20.8z M5,18v-1.5C5,15.7,5.7,15,6.5,15h7.8l3,3H5z M9.6,5.6c1.9-1,4.3-0.7,5.9,0.9C16.5,7.4,17,8.7,17,10v3.3c0,0.3,0.2,0.5,0.5,0.5h0c0.3,0,0.5-0.2,0.5-0.5V10c0-3.1-2.4-5.7-5.5-6V2.5C12.5,2.2,12.3,2,12,2s-0.5,0.2-0.5,0.5V4c-0.8,0.1-1.6,0.3-2.3,0.7c0,0,0,0,0,0C8.9,4.8,8.8,5.1,9,5.4C9.1,5.6,9.4,5.7,9.6,5.6z"/></svg>
                                        </div>
                                        <h4 class="mb-1">{{trans('langconvert.usermenu.nonotify')}}</h4>
                                        <p class="text-muted">{{trans('langconvert.usermenu.nonotifies1')}}</p>
                                    </div>
                                </div>  
                            </div>
                            @endforelse

                            {{  auth()->user()->notifications()->paginate(10)->links('admin.notificationpagination') }}
                        @endif

                                </div>
                            </div>
                            <!-- End Notification Page -->
                            @endsection


        @section('scripts')

        <!-- INTERNAL Vertical-scroll js-->
        <script src="{{asset('assets/plugins/vertical-scroll/jquery.bootstrap.newsbox.js')}}?v=<?php echo time(); ?>"></script>

        <!--Showmore Js-->
	    <script src="{{asset('assets/js/jquery.showmore.js')}}?v=<?php echo time(); ?>"></script>
        
        <!--Showmore Js-->
        <script type="text/javascript">

			"use strict";

            let readMore = document.querySelectorAll('.readmores')
            readMore.forEach(( element, index)=>{
                if(element.clientHeight <= 120)    {
                    element.children[0].children[0].classList.add('end')
                }
                else{
                    element.children[0].children[0].classList.add('readMore')
                }
            })
            $(`.readMore`).showmore({
                closedHeight: 60,
                buttonTextMore: 'Read More',
                buttonTextLess: 'Read Less',
                buttonCssClass: 'showmore-button',
                animationSpeed: 0.5
            });
            
        </script>

        @endsection