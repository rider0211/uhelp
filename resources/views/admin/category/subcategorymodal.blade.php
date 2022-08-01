                <!-- Add testimonial-->
                <div class="modal fade sprukosubcat"  id="addsubcategory" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" ></h5>
                                <button  class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <form method="POST" enctype="multipart/form-data" id="subcategory_form" name="subcategory_form">
                                <input type="hidden" name="subcategory_id" id="subcategory_id">
                                @csrf
                                @honeypot
                                <div class="modal-body">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xl-3 col-md-12">
                                                <label class="form-label d-flex align-items-center me-6">{{trans('langconvert.newwordslang.subcategoryname')}} <span class="text-red ms-1">*</span> </label>
                                            </div>
                                            <div class="col-xl-9 col-md-12">
                                                <input type="text" class="form-control" name="name" id="name">
                                                <span id="nameError" class="text-danger alert-message"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xl-3 col-md-12">
                                                <label class="form-label d-flex align-items-center me-6">{{trans('langconvert.newwordslang.parent_id')}} </label>
                                            </div>
                                            <div class="col-xl-9 col-md-12">
                                                <select name="parent_id[]" id="parent_id" class="categorysub form-control" data-placeholder="Select Category" multiple>
                                                    
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xl-3 col-md-12">
                                                <label class="form-label pe-1 me-0">{{trans('langconvert.admindashboard.status')}}:</label>
                                            </div>
                                            <div class="col-xl-9 col-md-12">
                                                <div class="switch_section m-0">
                                                    <div class="switch-toggle d-flex  d-md-max-block m-0 p-0">
                                                        <a class="onoffswitch2">
                                                            <input type="checkbox"  name="status" id="myonoffswitch18" class=" toggle-class onoffswitch2-checkbox" value="1" >
                                                            <label for="myonoffswitch18" class="toggle-class onoffswitch2-label" "></label>
                                                        </a>
                                                    </div>
                                                </div>
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
                <!-- End  Add testimonial  -->