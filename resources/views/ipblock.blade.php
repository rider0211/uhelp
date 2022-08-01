<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>

		<!-- Meta data -->
		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta content="{{$seopage->description ? $seopage->description :''}}" name="description">
		<meta content="{{$seopage->author ? $seopage->author :''}}" name="author">
		<meta name="keywords" content="{{$seopage->keywords ? $seopage->keywords :''}}"/>
		<meta name="csrf-token" content="{{ csrf_token() }}">
		
		<!-- Title -->
		<title>{{$title->title}}</title>

		@if ($title->image4 == null)

		<!--Favicon -->
		<link rel="icon" href="{{asset('uploads/logo/favicon/favicon.png')}}" type="image/x-icon"/>
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
		<link href="{{asset('assets/css/style.css')}}?v=<?php echo time(); ?>" rel="stylesheet" />
		<link href="{{asset('assets/css/dark.css')}}?v=<?php echo time(); ?>" rel="stylesheet" />
		<link href="{{asset('assets/css/updatestyles.css')}}?v=<?php echo time(); ?>" rel="stylesheet" />
		<link href="{{asset('assets/css/skin-modes.css')}}?v=<?php echo time(); ?>" rel="stylesheet" />
		
		<!-- Animate css -->
		<link href="{{asset('assets/css/animated.css')}}?v=<?php echo time(); ?>" rel="stylesheet" />

		<!---Icons css-->
		<link href="{{asset('assets/css/icons.css')}}?v=<?php echo time(); ?>" rel="stylesheet" />

		<style>
			:root {
				--primary:@php echo setting('theme_color') @endphp;
				--secondary:@php echo setting('theme_color_dark') @endphp;
			}

		</style>

		

	</head>

	<body class="@if(setting('DARK_MODE') == 1) dark-mode @endif @if(str_replace('_', '-', app()->getLocale()) == 'عربى')
		rtl
	@endif">
		<!--IP Block Section-->
		<div class="page login-bg1">
			<div class="page-single">
				<div class="container">
					<div class="row justify-content-center">
						<div class="col-md-4 p-md-0">
							<div class="card p-5">
								<div class="ps-4 pt-4 pb-2">
									
									<a class="header-brand" href="{{url('/')}}">
										@if ($title->image !== null)

										<img src="{{asset('uploads/logo/logo/'.$title->image)}}" class="header-brand-img custom-logo-dark"
											alt="{{$title->image}}">
										@else
										<img src="{{asset('uploads/logo/logo/logo-white.png')}}" class="header-brand-img custom-logo-dark"
											alt="logo">
										@endif
										@if ($title->image1 !== null)

											<img src="{{asset('uploads/logo/darklogo/'.$title->image1)}}" class="header-brand-img custom-logo"
											alt="{{$title->image1}}">
										@else
										
										<img src="{{asset('uploads/logo/darklogo/logo.png')}}" class="header-brand-img custom-logo"
											alt="logo">

										@endif
									
									</a>
								</div>
                                <div class="p-5 pt-0">
                                    <h1 class="mb-2">{{trans('langconvert.admindashboard.entercaptchar')}}</h1>
                                </div>
                                <form class="card-body pt-3" id="login" action="{{route('ipblock.update')}}" method="post">
                                    @csrf
                                    @honeypot
                                
                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <input type="text" id="captcha" class="form-control @error('captcha') is-invalid @enderror" placeholder="Enter Captcha" name="captcha">
                                                @error('captcha')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <div class="captcha">
                                                    <span>{!! captcha_img('') !!}</span>
                                                    <button type="button" class="btn btn-outline-info btn-sm captchabtn"><i class="fe fe-refresh-cw"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                
                                    <div class="submit">
                                        <input class="btn btn-secondary btn-block" type="submit" value="{{trans('langconvert.admindashboard.submit')}}"
                                            onclick="this.disabled=true;this.form.submit();">
                                    </div>
                                </form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--IP Block Section-->

		<!-- Jquery js-->
		<script src="{{asset('assets/plugins/jquery/jquery.min.js')}}?v=<?php echo time(); ?>"></script>

		<!-- Bootstrap4 js-->
		<script src="{{asset('assets/plugins/bootstrap/popper.min.js')}}?v=<?php echo time(); ?>"></script>
		<script src="{{asset('assets/plugins/bootstrap/js/bootstrap.min.js')}}?v=<?php echo time(); ?>"></script>


		<script type="text/javascript">
			"use strict";
			
			(function($){
				
				// Captcha refresh
				$(".captchabtn").on('click', function(e){
					e.preventDefault();
					$.ajax({
						type:'GET',
						url:'{{route('captchas.reload')}}',
						success: function(res){
							$(".captcha span").html(res.captcha);
						}
					});
				});

			})(jQuery);
			
		</script>
	</body>
</html>

