        <!-- Guest Email Verification-->
        <div class="modal fade"  id="guestmodalopen" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" ></h5>
                        <button  class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form method="POST" enctype="multipart/form-data" id="guestticket_form" name="guestticket_form">
                        <input type="hidden" name="testimonial_id" id="testimonial_id">
                        @csrf
                        @honeypot
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="form-label mb-0 mt-2">{{trans('langconvert.admindashboard.emailaddress')}} <span class="text-red">*</span></label>
                                <input type="email" class="form-control" placeholder="Email" name="email" id="email"  required>
                                <span id="EmailsError" class="text-danger alert-message"></span>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="#" class="btn btn-outline-danger" data-bs-dismiss="modal">{{trans('langconvert.admindashboard.close')}}</a>
                            <button type="submit" class="btn btn-success" id="validateemail">Verify Your Email</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End Guest Email Verification  -->


        <script>
			"use strict";
            // Variables
            var SITEURL = '{{url('')}}';

			$('body').on('click', '#guestopen', function(e){
				e.preventDefault();
                $('#guestticket_form').trigger("reset");
                $('.modal-title').html("Email Verification for Guest Ticket")
				$('#guestmodalopen').modal('show');
			});

            // Ajax Setup
            $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('body').on('submit', '#guestticket_form', function(e){
                e.preventDefault();
                let email = $('#email').val();
                let regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                $('#validateemail').attr('disabled', true);
                $('#validateemail').html('Please Wait... <i class="fa fa-spinner fa-spin"></i>');
                if(!regex.test(email)){
                    $('#EmailsError').html('You entered the invalid email')
                    $('#validateemail').removeAttr('disabled');
                    $('#validateemail').html('Verify Your Email');
                }
                if(regex.test(email)){
                    $('#EmailsError').html('');
                    $.ajax({
                        type: "post",
                        url: SITEURL + "/guest/emailsvalidate",
                        data:{
                            email : email,
                        },
                        success:function(data){
                            if(data.email == "already"){
                                $('#EmailsError').html(data.error)
                                $('#validateemail').removeAttr('disabled');
                                $('#validateemail').html('Verify Your Email');
                            }
                            if(data.email == "exists"){
                                $('#validateemail').removeAttr('disabled');
                                $('#validateemail').html('Verify Your Email');
                                $('#guestmodalopen').modal('hide');
                                toastr.success(data.success);
                            }
                        },
                        error:function(data){

                        }

                    });
                    console.log('abc');
                }
            });
		</script>