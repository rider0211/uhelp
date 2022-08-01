                    <!-- Add IP-->
                    <div class="modal fade"  id="addIP" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" ></h5>
                                    <button  class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <form method="POST" enctype="multipart/form-data" id="IP_form" name="IP_form">
                                    <input type="hidden" name="IP_id" id="IP_id">
                                    @csrf
                                    @honeypot
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label class="form-label">{{trans('langconvert.admindashboard.ip')}} <span class="text-red">*</span></label>
                                            <input type="text" class="form-control" name="ip" id="ip">
                                            <span id="nameError" class="text-danger alert-message"></span>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-controls-stacked d-md-flex">
                                                <label class="form-label mt-1 me-5">{{trans('langconvert.admindashboard.types')}} <span class="text-red">*</span></label>
                                                <label class="custom-control form-radio success me-4">
                                                    <input type="radio" class="custom-control-input iptype1"  name="types" value="Unlock">
                                                    <span class="custom-control-label">{{trans('langconvert.admindashboard.unlock')}}</span>
                                                </label>
                                                <label class="custom-control form-radio success me-4">
                                                    <input type="radio" class="custom-control-input iptype2"  name="types" value="Locked">
                                                    <span class="custom-control-label">{{trans('langconvert.admindashboard.lock')}}</span>
                                                </label>
                                                <label class="custom-control form-radio success me-4">
                                                    <input type="radio" class="custom-control-input iptype3"  name="types" value="Blocked">
                                                    <span class="custom-control-label">{{trans('langconvert.admindashboard.block')}}</span>
                                                </label>
                                            </div>
                                            <span id="displayError" class="text-danger alert-message"></span>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <a href="#" class="btn btn-outline-danger" data-bs-dismiss="modal">{{trans('langconvert.admindashboard.close')}}</a>
                                        <button type="submit" class="btn btn-secondary" id="btnipsave"  >{{trans('langconvert.admindashboard.save')}}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- End  Add IP  -->