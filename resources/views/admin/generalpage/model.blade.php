                    <!-- Add or Edit Privacy Policy & Terms of Use model-->
                    <div class="modal fade"  id="addtestimonial" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" ></h5>
                                    <button  class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <form method="POST" enctype="multipart/form-data" id="pages_form" name="pages_form">
                                    <input type="hidden" name="pages_id" id="pages_id">
                                    @csrf
                                    @honeypot
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label class="form-label">{{trans('langconvert.admindashboard.name')}} <span class="text-red">*</span></label>
                                            <input type="text" class="form-control" name="pagename" id="pagename" >
                                            <span id="nameError" class="text-danger alert-message"></span>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">{{trans('langconvert.admindashboard.description')}} <span class="text-red">*</span></label>
                                            <textarea class="form-control summernote"  name="pagedescription" id="pagedescription"></textarea>
                                            <span id="descriptionError" class="text-danger alert-message"></span>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-controls-stacked d-md-flex  d-md-max-block">
                                                <label class="form-label mt-1 me-4">{{trans('langconvert.admindashboard.viewon')}}: <span class="text-red">*</span></label>
                                                <label class="custom-control form-radio success me-4">
                                                    <input type="radio" class="custom-control-input" id="display" name="display" value="both">
                                                    <span class="custom-control-label">{{trans('langconvert.admindashboard.viewonboth')}}</span>
                                                </label>
                                                <label class="custom-control form-radio success me-4">
                                                    <input type="radio" class="custom-control-input " id="display1" name="display" value="header">
                                                    <span class="custom-control-label">{{trans('langconvert.newwordslang.viewonheader')}}</span>
                                                </label>
                                                <label class="custom-control form-radio success me-4">
                                                    <input type="radio" class="custom-control-input " id="display2" name="display" value="footer">
                                                    <span class="custom-control-label">{{trans('langconvert.newwordslang.viewonfooter')}}</span>
                                                </label>
                                            </div>
                                            <span id="displayError" class="text-danger alert-message"></span>
                                        </div>
                                        <div class="form-group">
                                            <div class="switch_section">
                                                <div class="switch-toggle d-flex  d-md-max-block mt-4 ms-0 ps-0">
                                                    <label class="form-label pe-1 me-6">{{trans('langconvert.admindashboard.status')}}:</label>
                                                    <a class="onoffswitch2">
                                                        <input type="checkbox"  name="status" id="myonoffswitch18" class=" toggle-class onoffswitch2-checkbox" value="1" >
                                                        <label for="myonoffswitch18" class="toggle-class onoffswitch2-label" "></label>
                                                    </a>
                                                </div>
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
                    <!-- End  Add or Edit Privacy Policy & Terms of Use  -->