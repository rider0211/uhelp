<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" >
	<head>
    	@include('includes.admin.styles')

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

	<body class="app sidebar-mini 
	@if(str_replace('_', '-', app()->getLocale()) == 'عربى')
		rtl
	@endif
	@if(setting('SPRUKOADMIN_P') == 'off')
		@if(setting('DARK_MODE') == 1) dark-mode @endif
	@else
	@if(Auth::check() && Auth::user()->darkmode == 1) dark-mode @endif
	
	@endif">

		<div class="page">
			<div class="page-main">
					@include('includes.admin.verticalmenu')
					<div class="app-content main-content">
						<div class="side-app">
							@include('includes.admin.menu')

							@yield('content')

						</div>
					</div><!-- end app-content-->
			</div>
			@include('includes.admin.footer')

		</div>

    	@include('includes.admin.scripts')

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

		@yield('modal')

	</body>
</html>