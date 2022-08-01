@extends('layouts.usermaster')



                    @section('content')

                    <!-- Section -->
                    <section>
                        <div class="bannerimg cover-image" data-bs-image-src="{{asset('assets/images/photos/banner1.jpg')}}">
                            <div class="header-text mb-0">
                                <div class="container">
                                    <div class="row text-white">
                                        <div class="col">
                                            <h1 class="mb-0">{{trans('langconvert.menu.rating')}}</h1>
                                        </div>
                                        <div class="col col-auto">
                                            <ol class="breadcrumb text-center">
                                                <li class="breadcrumb-item">
                                                    <a href="#" class="text-white-50">{{trans('langconvert.menu.home')}}</a>
                                                </li>
                                                <li class="breadcrumb-item active">
                                                    <a href="#" class="text-white">{{trans('langconvert.menu.rating')}}</a>
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
                        <!--Page header-->
                        <div class="row">
                            <div class="col-md-12 col-lg-6 col-sm-12 m-auto">
                                <div class="row row-sm">
                                    <div class="col-md-6 m-auto">
                                        <div class="page-header d-lg-flex d-block">
                                            <div class="page-leftheader">
                                                <h3 class="text-center">{{trans('langconvert.menu.lovefeedback')}}</h3>
                                                <p class="text-center text-muted">{{trans('langconvert.menu.feedbackrecent')}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--Rating -->
                                <div class="card">
                                    <div class="card-header">
                                    <div class="card-title ">{{trans('langconvert.menu.feedbacksupport')}}</div>
                                    </div> 
                                    @foreach ($comment as $item)
                                    @if ($item->user_id != null)
                                        @if ($item->user_id == $item->user->id )
                                            <div class="border-top">  
                                                <div class="row p-5  m-auto">
                                                    <div class="text-center ">
                                                        <div class="">
                                                            @if ($item->user->image == null)
                                                                <img src="{{asset('uploads/profile/user-profile.png')}}" class="avatar avatar-xl brround me-3" alt="default">
                                                            @else
                                                                <img src="{{asset('uploads/profile/'.$item->user->image)}}" class="avatar avatar-xl brround me-3" alt="{{$item->user->image}}">
                                                            @endif
                                                            <div class="me-3 mt-0 mt-sm-3">
                                                                <h6 class="mb-0 fs-16">{{$item->user->name}}</h6>
                                                                <p class="text-muted mb-0 pb-0 fs-12">{{$item->user->getRoleNames()[0]}}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="">
                                                        <div class="rattings mt-4">
                                                            <div class="d-flex rate">
                                                                <a href="{{url('/rating/star1/'.$item->user->id)}}" class="emoji text-center">
                                                                    <img src="{{asset('assets/images/rattings/rating1.png')}}" alt="img" class="w-7">
                                                                    <div class=" p-0 border-top-0 bd-t-0 py-1">
                                                                        <h6 class="mb-0 text-red">{{trans('langconvert.menu.worst')}}</h6>
                                                                    </div>
                                                                </a>
                                                                <a href="{{url('/rating/star2/'.$item->user->id)}}" class="emoji text-center">
                                                                    <img src="{{asset('assets/images/rattings/rating2.png')}}" alt="img" class="w-7">
                                                                    <div class="border-top-0 bd-t-0 py-1">
                                                                        <h6 class="mb-0 text-danger">{{trans('langconvert.menu.poor')}}</h6>
                                                                    </div>
                                                                </a>
                                                                <a href="{{url('/rating/star3/'.$item->user->id)}}" class="emoji text-center">
                                                                    <img src="{{asset('assets/images/rattings/rating3.png')}}" alt="img" class="w-7">
                                                                    <div class=" p-0 border-top-0 bd-t-0 py-1">
                                                                        <h6 class="mb-0 text-orange">{{trans('langconvert.menu.average')}}</h6>
                                                                    </div>
                                                                </a>
                                                                <a href="{{url('/rating/star4/'.$item->user->id)}}" class="emoji text-center">
                                                                    <img src="{{asset('assets/images/rattings/rating4.png')}}" alt="img" class="w-7">
                                                                    <div class=" p-0  border-top-0 bd-t-0 py-1">
                                                                        <h6 class="mb-0 text-yellow">{{trans('langconvert.menu.good')}}</h6>
                                                                    </div>
                                                                </a>
                                                                <a href="{{url('/rating/star5/'.$item->user->id)}}" class="emoji text-center">
                                                                    <img src="{{asset('assets/images/rattings/rating5.png')}}" alt="img" class="w-7">
                                                                    <div class=" p-0 border-top-0 bd-t-0 py-1">
                                                                        <h6 class="mb-0 text-success">{{trans('langconvert.menu.excellent')}}</h6>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                                    @endforeach
                                </div>
                                <!--Rating -->
                            </div>
                        </div>
                        <!-- End Row-->
                    </section>
                    <!--Section-->

                    @endsection


