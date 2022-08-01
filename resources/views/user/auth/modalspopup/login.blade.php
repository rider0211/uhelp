        <!--Login Modal-->
        <div class="modal fade" id="loginmodal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{trans('langconvert.menu.login')}}</h5>
                        <button class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body p-0">
                        <div class="single-page customerpage">
                            <div class="wrapper wrapper2 box-shadow-0 border-0">

                                @if($socialAuthSettings->envato_status == 'enable' || $socialAuthSettings->google_status == 'enable'||$socialAuthSettings->facebook_status == 'enable' || $socialAuthSettings->twitter_status == 'enable')

                                <div class="login-icons card-body border br-7 mx-5 p-4 mt-5 d-flex align-items-center justify-content-center">
										@if($socialAuthSettings->envato_status == 'enable')
										<a href="javascript:;" class="social-icon brround me-3 bg-primary-transparent text-primary" data-bs-toggle="tooltip"
											title="Login with Envato" onclick="window.location.href = envato;"
											data-bs-original-title="Login with Envato"> 
											<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><path fill="#7CB342" d="M12.869.088c-.572-.281-3.474.04-5.566 2.047-3.296 3.291-3.217 7.627-3.217 7.627s-.109.446-.573-.201c-1.016-1.295-.484-4.274-.424-4.689.084-.585-.289-.602-.444-.409-3.672 5.098-.356 9.272 1.815 10.597 2.542 1.551 7.556 1.55 9.553-2.85C16.501 6.731 13.586.439 12.869.088z"/></svg>
											</a>
										@endif
										@if($socialAuthSettings->google_status == 'enable')
										<a href="javascript:;" class="social-icon brround me-3 bg-primary-transparent text-primary" data-bs-toggle="tooltip"
											title="Login with Google" onclick="window.location.href = google;"
											data-bs-original-title="Login with Google"> 
											<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 47 48"><g fill="none" fill-rule="evenodd"><path fill="#FBBC05" d="M9.827 24c0-1.524.253-2.986.705-4.356l-7.909-6.04A23.456 23.456 0 0 0 .213 24c0 3.737.868 7.26 2.407 10.388l7.905-6.05A13.885 13.885 0 0 1 9.827 24"/><path fill="#EB4335" d="M23.714 10.133c3.311 0 6.302 1.174 8.652 3.094L39.202 6.4C35.036 2.773 29.695.533 23.714.533a23.43 23.43 0 0 0-21.09 13.071l7.908 6.04a13.849 13.849 0 0 1 13.182-9.51"/><path fill="#34A853" d="M23.714 37.867a13.849 13.849 0 0 1-13.182-9.51l-7.909 6.038a23.43 23.43 0 0 0 21.09 13.072c5.732 0 11.205-2.036 15.312-5.849l-7.507-5.804c-2.118 1.335-4.786 2.053-7.804 2.053"/><path fill="#4285F4" d="M46.145 24c0-1.387-.213-2.88-.534-4.267H23.714V28.8h12.604c-.63 3.091-2.346 5.468-4.8 7.014l7.507 5.804c4.314-4.004 7.12-9.969 7.12-17.618"/></g></svg>
										</a>
										@endif
										@if($socialAuthSettings->facebook_status == 'enable')
										<a href="javascript:;" class="social-icon brround me-3 bg-primary-transparent text-primary" data-bs-toggle="tooltip"
											title="Login with Facebook" onclick="window.location.href = facebook;"
											data-bs-original-title="Login with Facebook"> 
											<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100"><g data-name="facebook circle" transform="translate(-126.445 -2.281)"><circle cx="50" cy="50" r="50" fill="#3c5a9a" data-name="Ellipse 2" transform="translate(126.445 2.281)"/><path fill="#fff" d="M357.464,92.677H346.388c-6.573,0-13.884,2.765-13.884,12.292.032,3.32,0,6.5,0,10.078h-7.6v12.1h7.839v34.835h14.405V126.917h9.508l.86-11.9H346.9s.024-5.3,0-6.833c0-3.765,3.918-3.55,4.153-3.55,1.864,0,5.489.005,6.42,0V92.677Z" data-name="Path 21" transform="translate(-164.761 -75.049)"/></g></svg>
										</a>
										@endif
										@if($socialAuthSettings->twitter_status == 'enable')
										<a href="javascript:;" class="social-icon brround me-3 bg-primary-transparent text-primary" data-bs-toggle="tooltip"
											title="Login with Google" onclick="window.location.href = twitter;"
											data-bs-original-title="Login with Twitter"> 
											<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100"><g data-name="twitter circle" transform="translate(-126.444 -2.281)"><circle cx="50" cy="50" r="50" fill="#2daae1" data-name="Ellipse 1" transform="translate(126.444 2.281)"/><path fill="#fff" d="M297.441,149.67a26.538,26.538,0,0,1-7.7,2.133,13.558,13.558,0,0,0,5.893-7.492,26.6,26.6,0,0,1-8.512,3.287,13.316,13.316,0,0,0-9.782-4.275,13.471,13.471,0,0,0-13.4,13.543,13.837,13.837,0,0,0,.345,3.087,37.921,37.921,0,0,1-27.622-14.15,13.651,13.651,0,0,0,4.147,18.08,13.234,13.234,0,0,1-6.071-1.693v.171a13.514,13.514,0,0,0,10.75,13.278,13.2,13.2,0,0,1-3.531.475,13.462,13.462,0,0,1-2.523-.238,13.436,13.436,0,0,0,12.517,9.4,26.753,26.753,0,0,1-19.841,5.606,37.637,37.637,0,0,0,20.542,6.087c24.648,0,38.129-20.636,38.129-38.532q0-.881-.041-1.752a27.467,27.467,0,0,0,6.7-7.02Z" data-name="Path 1" transform="translate(-88.232 -117.765)"/></g></svg>
										</a>
										@endif
									<span class="text-center">Or</span>
								</div> 
                                @endif

                                <form class="card-body border-top-0 pt-4" id="login_form" name="login_form" method="post">
                                    @csrf
                                    @honeypot
                                    
                                    <div class="form-group">
                                        <label class="form-label">{{trans('langconvert.admindashboard.email')}} <span class="text-red">*</span></label>
                                        <input class="form-control " placeholder="Email"
                                            type="email" value="{{old('email')}}" name="email" required="" id="username">
                                            <div id="err" style="color: red"></div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">{{trans('langconvert.admindashboard.password')}} <span class="text-red">*</span></label>
                                        <input class="form-control"
                                            placeholder="password" type="password" id="password" name="password" required="">
                                            <div id="passworderr" style="color: red"></div>
                                    </div>
                                    <div class="form-group">
                                        <label class="custom-control form-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="remember" id="remember" {{
                                                old('remember') ? 'checked' : '' }}>
                                            <span class="custom-control-label">{{trans('langconvert.menu.rememberme')}}</span>
                                        </label>
                                    </div>
                                    @if(setting('CAPTCHATYPE')=='manual')
                                        @if(setting('RECAPTCH_ENABLE_LOGIN')=='yes')
                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <input type="text" id="captcha" class="form-control @error('captcha') is-invalid @enderror" placeholder="Enter Captcha" name="captcha">
                                                <div id="captchaerr" style="color: red"></div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="captcha">
                                                    <span>{!! captcha_img('') !!}</span>
                                                    <button type="button" class="btn btn-outline-info btn-sm captchabtn"><i class="fe fe-refresh-cw"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    @endif
                                    <!--- if Enable the Google ReCaptcha --->
                                    @if(setting('CAPTCHATYPE')=='google')
                                        @if(setting('RECAPTCH_ENABLE_LOGIN')=='yes')
                                        <div class="form-group">
                                            <div class="g-recaptcha" data-sitekey="{{setting('GOOGLE_RECAPTCHA_KEY')}}"></div>
                                            @if ($errors->has('g-recaptcha-response'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        @endif
                                    @endif
                                    <div class="submit">
                                        <input class="btn btn-secondary btn-block" type="button" value="Login" onclick="login()">
                                    </div>
                                    <div class="text-center mt-3">
                                       <a href="#" id="forgot1" class="text-primary pb-2">{{trans('langconvert.menu.forgotpass')}}</a>
                                        @if(setting('REGISTER_DISABLE') == 'on')
                                        <p class="text-dark mb-0">{{trans('langconvert.menu.doyoulogin')}}<a class="text-primary ms-1" href="#"
                                                data-bs-toggle="modal" id="register1"
                                                data-bs-target="#registermodal">{{trans('langconvert.menu.register')}}</a></p>
                                        @endif
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Login Modal  -->

        <script type="text/javascript">
            "use strict";

            var facebook = "{{ route('social.login', 'facebook') }}";
            var google = "{{ route('social.login', 'google') }}";
            var twitter = "{{ route('social.login', 'twitter') }}";
            var envato = "{{ route('social.login', 'envato') }}";
            
            // Login Js submit Js
            function login()
            {
                if($('#username').val() == "")
                {
                    $('#err').html('{{trans('langconvert.functions.enteremail')}}');
                    return false;
                }
                if($('#password').val() == "")
                {
                    $('#passworderr').html('{{trans('langconvert.functions.enterpass')}}');
                    return false;
                }
                
                var data = $("#login_form").serialize();
                    
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
         
                $.ajax({
                        type : 'POST',
                        url: '{{route('client.do_ajaxlogin')}}',
                        data : data,
                    success : function(response)
                    {
                        if(response.errors){
                            $("#err").hide().html(response.errors.email).fadeIn('slow');
                            $("#captchaerr").hide().html(response.errors.captcha).fadeIn('slow');
                        }
                        if(response == 1)
                        {
                          window.location.replace('{{route('client.dashboard')}}');
                        }
                        else if(response == 3)
                        {
                            toastr.error('{{trans('langconvert.functions.usernamepassinvalid')}}');
                            $("#err").hide().html("{{trans('langconvert.functions.usernamepassinvalid')}}").fadeIn('slow');
                        }
                        else if(response == 4)
                        {
                            toastr.error('{{trans('langconvert.functions.verifyemail')}}');
                        }
                        else if(response == 5)
                        {
                            toastr.error('{{trans('langconvert.functions.accountdisable')}}');
                        }
                    }
                });
            }

            //set button id on click to hide first modal
            $("#register1").on( "click", function() {
                $('#loginmodal').modal('hide');
                $('#login_form').trigger("reset");

            });

            //trigger next modal
            $("#register1").on( "click", function() {
                $('#registermodal').modal('show');

            });

            $("#forgot1").on( "click", function() {
                $('#loginmodal').modal('hide');
                $('#login_form').trigger("reset");

            });
            
            //trigger next modal
            $("#forgot1").on( "click", function() {
                $('#forgotmodal').modal('show');

            });

            (function($){

                // Captcha Js
				$(".captchabtn").on('click', function(e){
					e.preventDefault();
					$.ajax({
						type:'GET',
						url:'{{route('captcha.reload')}}',
						success: function(res){
							$(".captcha span").html(res.captcha);
						}
					});
				});

			})(jQuery);
            
        </script>

        <!-- Captcha Js -->
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>