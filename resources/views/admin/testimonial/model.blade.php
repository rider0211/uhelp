            <!-- Add testimonial-->
            <div class="modal fade"  id="addtestimonial" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" ></h5>
                            <button  class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <form method="POST" enctype="multipart/form-data" id="testimonial_form" name="testimonial_form">
                            <input type="hidden" name="testimonial_id" id="testimonial_id">
                            @csrf
                            @honeypot
                            <div class="modal-body">
                                <div class="form-group">
                                    <label class="form-label">{{trans('langconvert.admindashboard.name')}} <span class="text-red">*</span></label>
                                    <input type="text" class="form-control" name="name" id="name" >
                                    <span id="nameError" class="text-danger alert-message"></span>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">{{trans('langconvert.admindashboard.description')}} <span class="text-red">*</span></label>
                                    <textarea class="form-control"  name="description" id="description" ></textarea>
                                    <span id="descriptionError" class="text-danger alert-message"></span>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">{{trans('langconvert.admindashboard.designation')}} <span class="text-red">*</span></label>
                                    <input type="text" class="form-control" name="designation" id="designation" >
                                    <span id="designationError" class="text-danger alert-message"></span>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">{{trans('langconvert.admindashboard.uploadimage')}}</label>
                                    <div class="input-group file-browser">
                                        <input class="form-control " id="image" name="image" type="file">
                                    </div>
                                    <small class="text-muted"><i>{{trans('langconvert.admindashboard.Filemorethan')}}</i></small>
                                    <div>
                                        <span id="imageError" class="text-danger alert-message"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <a href="#" class="btn btn-outline-danger" data-bs-dismiss="modal">{{trans('langconvert.admindashboard.close')}}</a>
                                <button type="submit" class="btn btn-secondary" id="btnsave"  >{{trans('langconvert.admindashboard.save')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- End  Add testimonial  -->