<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" >
	<head>
    	@include('includes.styles')


		@if(setting('GOOGLE_ANALYTICS_ENABLE') == 'yes')  

		<!-- Global site tag (gtag.js) - Google Analytics -->
		<script async src="https://www.googletagmanager.com/gtag/js?id={{setting('GOOGLE_ANALYTICS')}}"></script>
		<script>
			window.dataLayer = window.dataLayer || [];
			function gtag(){dataLayer.push(arguments);}
			gtag('js', new Date());

			gtag('config', '{{setting('GOOGLE_ANALYTICS')}}');
		</script>

		@endif

	</head>

	<body class="@if(str_replace('_', '-', app()->getLocale()) == 'عربى') rtl @endif
	@if(setting('SPRUKOADMIN_C') == 'off')
		@if(setting('DARK_MODE') == 1) dark-mode @endif
	@else
		@if(Auth::guard('customer')->check())
			@if(Auth::guard('customer')->check() && Auth::guard('customer')->user()->custsetting->darkmode == 1) dark-mode @endif
		@else 
			@if(setting('DARK_MODE') == 1) dark-mode @endif
		@endif
	@endif">

				@foreach ($announcement as $anct)
				@if ($anct->status == 1  )

				<div class="alert alert-success br-0 mb-0" role="alert">
					<button class="close" data-bs-dismiss="alert" aria-hidden="true">×</button>
					<i class="fa fa-check-circle-o me-2" aria-hidden="true"></i>
					{{$anct->title}}
					{!!$anct->notice!!}
				</div>

				@endif
				@endforeach

				@include('includes.user.mobileheader')

				@include('includes.menu')

				<div class="page page-1">
					<div class="page-main">

							@yield('content')

					</div>
				</div>

				@include('includes.footer')

    	@include('includes.scripts')

		@guest
		@if (customcssjs('CUSTOMCHATENABLE') == 'enable')
		@if (customcssjs('CUSTOMCHATUSER') == 'public')
		@php  echo customcssjs('CUSTOMCHAT') @endphp;
		@endif
		@endif
		@else
		@if (customcssjs('CUSTOMCHATENABLE') == 'enable')
		@if (Auth::check() && Auth::user()->role_id == "4")
		@php  echo customcssjs('CUSTOMCHAT') @endphp;
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
			@if(setting('REGISTER_POPUP') == 'yes')
			@if(!Auth::guard('customer')->check())

			@include('user.auth.modalspopup.register')

			@include('user.auth.modalspopup.login')

			@include('user.auth.modalspopup.forgotpassword')

			@endif	
			@endif	

			@if(setting('GUEST_TICKET') == 'yes')

				@include('guestticket.guestmodal')

			@endif
			
			@yield('modal')
			
	</body>
</html>