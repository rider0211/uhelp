
@extends('layouts.usermaster')


		@section('content')

		<!-- Section -->
		<section>
			<div class="bannerimg cover-image" data-bs-image-src="{{asset('assets/images/photos/banner1.jpg')}}">
				<div class="header-text mb-0">
					<div class="container">
						<div class="row text-white">
							<div class="col">
								<h1 class="mb-0">{{trans('langconvert.menu.guestview')}}</h1>
							</div>
							<div class="col col-auto">
								<ol class="breadcrumb text-center">
									<li class="breadcrumb-item">
										<a href="#" class="text-white-50">{{trans('langconvert.menu.home')}}</a>
									</li>
									<li class="breadcrumb-item active">
										<a href="#" class="text-white">{{trans('langconvert.menu.guestview')}}</a>
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
					<div class="row">
						<div class="col-md-6 justify-content-center mx-auto text-center">
                        
                            <div class="card">
                                <div class="card-body p-8 text-center">
                                    <img src="{{asset('assets/images/svgs/check.svg')}}" alt="img" class="w-10">
                                    <h6 class="mt-5 fs-20 leading-normal">{{trans('langconvert.menu.guestcontent')}}</h6>
                                    <p class="mt-3 mb-5 fs-16"> {{trans('langconvert.menu.guestcontent1')}} </p>
                                    <a class="btn ripple btn-primary" href="{{route('gusetticket',$ticket->ticket_id)}}">{{trans('langconvert.menu.viewticket')}}</a>
								</div>
                            </div>
                        </div>
                    </div>
				</div>
			</div>
		</section>
		<!--Section-->

		@endsection


		