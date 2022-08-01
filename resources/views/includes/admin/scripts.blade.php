		<!-- Back to top -->
		<a href="#top" id="back-to-top"><span class="feather feather-chevrons-up"></span></a>
        
        <!-- Jquery js-->
		<script src="{{asset('assets/plugins/jquery/jquery.min.js')}}?v=<?php echo time(); ?>"></script>

		<!-- Bootstrap js-->
		<script src="{{asset('assets/plugins/bootstrap/popper.min.js')}}?v=<?php echo time(); ?>"></script>
		<script src="{{asset('assets/plugins/bootstrap/js/bootstrap.min.js')}}?v=<?php echo time(); ?>"></script>

		<!--Sidemenu js-->
		<script src="{{asset('assets/plugins/sidemenu/sidemenu.js')}}?v=<?php echo time(); ?>"></script>

		<!-- P-scroll js-->
		<script src="{{asset('assets/plugins/p-scrollbar/p-scrollbar.js')}}?v=<?php echo time(); ?>"></script>
		<script src="{{asset('assets/plugins/p-scrollbar/p-scroll1.js')}}?v=<?php echo time(); ?>"></script>

		<!-- Select2 js -->
		<script src="{{asset('assets/plugins/select2/select2.full.min.js')}}?v=<?php echo time(); ?>"></script>

        <!--INTERNAL RATING js -->
        <script src="{{asset('assets/plugins/ratings/jquerystarrating.js')}}?v=<?php echo time(); ?>"></script>

        @yield('scripts')

		<!--INTERNAL Toastr js -->
		<script src="{{asset('assets/plugins/toastr/toastr.min.js')}}?v=<?php echo time(); ?>"></script>


        <script type="text/javascript">

		    "use strict";

            @php echo customcssjs('CUSTOMJS') @endphp

            // Profile Rating
            $(".allprofilerating").starRating({
                readOnly: true,
                starSize    :  20,
                emptyColor  :  '#17263a',
                activeColor :  '#F2B827',
                strokeColor :  '#556a86',
                strokeWidth :  15,
                useGradient : false
            });

            @if(auth()->user())

            //  Mark As Read
            function sendMarkRequest(id = null) {
                return $.ajax("{{ route('admin.markNotification') }}", {
                    method: 'GET',
                    data: {
                        // _token,
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
                $('.smark-all').on('click', function() {
                    
                    let request = sendMarkRequest();
                    request.done(() => {
                        $('div.alert').remove();
                    })
                });

            })(jQuery);
            @endif

        </script>

        <!-- Custom html js-->
		<script src="{{asset('assets/js/custom.js')}}?v=<?php echo time(); ?>"></script>

