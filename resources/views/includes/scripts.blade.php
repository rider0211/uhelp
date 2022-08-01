		<!-- Back to top -->
		<a href="#top" id="back-to-top"><span class="feather feather-chevrons-up"></span></a>

		<!-- Jquery js-->
		<script src="{{asset('assets/plugins/jquery/jquery.min.js')}}?v=<?php echo time(); ?>"></script>

		<!--Moment js-->
		<script src="{{asset('assets/plugins/moment/moment.js')}}?v=<?php echo time(); ?>"></script>

		<!-- Bootstrap4 js-->
		<script src="{{asset('assets/plugins/bootstrap/popper.min.js')}}?v=<?php echo time(); ?>"></script>
		<script src="{{asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}?v=<?php echo time(); ?>"></script>


		<!-- P-scroll js-->
		<script src="{{asset('assets/plugins/p-scrollbar/p-scrollbar.js')}}?v=<?php echo time(); ?>"></script>
			
		<!-- Select2 js -->
		<script src="{{asset('assets/plugins/select2/select2.full.min.js')}}?v=<?php echo time(); ?>"></script>

		<!--INTERNAL Horizontalmenu js -->
		<script src="{{asset('assets/plugins/horizontal-menu/horizontal-menu.js')}}?v=<?php echo time(); ?>"></script>

		<!--INTERNAL Sticky js -->
		<script src="{{asset('assets/plugins/sticky/sticky2.js')}}?v=<?php echo time(); ?>"></script>

		@yield('scripts')
		
		<!--INTERNAL Toastr js -->
		<script src="{{asset('assets/plugins/toastr/toastr.min.js')}}?v=<?php echo time(); ?>"></script>

		<!--INTERNAL sweetalert js -->
		<script src="{{asset('assets/plugins/sweet-alert/sweetalert.min.js')}}?v=<?php echo time(); ?>"></script>


		<script type="text/javascript">

		    "use strict";

			// Custom js
			@php echo customcssjs('CUSTOMJS') @endphp

			@guest
			@else	
			@if(Auth::guard('customer')->check() && Auth::guard('customer')->user()->image != null)

			// Remove Image
			var SITEURL = '{{url('')}}';
			function deletePost(event) {
				var id  = $(event).data("id");
				let _url = `{{url('/customer/image/remove/${id}')}}`;

				let _token   = $('meta[name="csrf-token"]').attr('content');

				swal({
					title: `{{trans('langconvert.admindashboard.wanttocontinue')}}`,
					text: "{{trans('langconvert.admindashboard.eraserecordspermanently')}}",
					icon: "warning",
					buttons: true,
					dangerMode: true,
				})
				.then((willDelete) => {
					if (willDelete) {
						$.ajax({
							url: _url,
							type: 'DELETE',
							data: {
							_token: _token
						},
						success: function(response) {
							toastr.success(response.success);
							location.reload();
						},
						error: function (data) {
							console.log('Error:', data);
									}
						});
					}
				});
			}

			@endif
			@if(auth()->guard('customer')->user())

			// Mark as Read
			function sendMarkRequest(id = null) {
				return $.ajax("{{ route('customer.markNotification') }}", {
					method: 'GET',
					data: {
						id
					}
				});
			}
			(function($) {
				$('.mark-as-read').on('click', function() {
					let request = sendMarkRequest($(this).data('id'));
					request.done(() => {
						$(this).parents('div.alert').remove();
					});
				});
				$('.cmark-all').on('click', function() {
					let request = sendMarkRequest();
					request.done(() => {
						$('div.alert').remove();
					})
				});
			})(jQuery);
			@endif
			@endguest

		</script>

		<!-- Custom html js-->
		<script src="{{asset('assets/js/custom.js')}}?v=<?php echo time(); ?>"></script>