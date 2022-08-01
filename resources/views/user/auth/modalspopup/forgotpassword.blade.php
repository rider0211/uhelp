        <!--Forgot  Modal-->
        <div class="modal fade" id="forgotmodal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{trans('langconvert.menu.forgotpass')}}</h5>
                        <button class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body p-0">
                        <div class="single-page customerpage">
                            <div class="wrapper wrapper2 box-shadow-0 border-0">
                                <form class="card-body pt-3" id="forgot_form" name="forgot_form"
                                    method="post">
                                    @csrf
                                    @honeypot
                                    
                                    <div class="form-group">
                                        <label class="form-label">{{trans('langconvert.admindashboard.email')}}</label>
                                        <input class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ old('email') }}" placeholder="Email" type="email" id="email">
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="submit">
                                        <input class="btn btn-secondary btn-block" type="button" value="{{trans('langconvert.admindashboard.submit')}}" onclick="forgots()"> 
                                    </div>
                                    <div class="text-center mt-4">
                                        <p class="text-dark mb-0">{{trans('langconvert.menu.alreadyacc')}}<a class="text-primary ms-1" href="#"
                                                data-bs-toggle="modal" id="login2" data-bs-target="#loginmodal">{{trans('langconvert.menu.login')}}</a></p>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Forgot  Modal  -->

        <script type="text/javascript">
            "use strict";
            
            //set button id on click to hide first modal
            $("#login2").on( "click", function() {
                $('#forgotmodal').modal('hide');
                $('#forgot_form').trigger("reset");

            });
            //trigger next modal
            $("#login2").on( "click", function() {
                $('#loginmodal').modal('show');

            });

            // Forgot paswword js
            function forgots(){
                if($('#email').val() == "")
                {
                    toastr.error('Please Enter Your Email');
                    return false;
                }
                var data = $("#forgot_form").serialize();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                        type : 'POST',
                        url: '{{route('ajax.forgot')}}',
                        data : data,
                    success : function(response)
                    {
                        if(response == 1)
                        {
                            $('#forgotmodal').modal('hide');
                            $('#forgot_form').trigger("reset");
                            toastr.success('{{trans('langconvert.functions.resetpasswordsend')}}');
                        }
                        else if(response == 3)
                        {
                            toastr.error('{{trans('langconvert.functions.credentialsnotmatch')}}');
                        }
                    }
                });
            }

        </script>