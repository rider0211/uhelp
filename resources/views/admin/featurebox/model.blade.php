                        <!-- Add FeatureBox-->
                        <div class="modal fade"  id="addfeature" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" ></h5>
                                        <button  class="close" data-bs-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <form method="POST" enctype="multipart/form-data" id="featurebox_form" name="featurebox_form">
                                        <input type="hidden" name="featurebox_id" id="featurebox_id">
                                        @csrf
                                        @honeypot
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label class="form-label">{{trans('langconvert.admindashboard.title')}} <span class="text-red">*</span></label>
                                                <input type="text" class="form-control" name="title" id="name">
                                                <span id="nameError" class="text-danger alert-message"></span>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">{{trans('langconvert.admindashboard.description')}} <span class="text-red">*</span></label>
                                                <textarea class="form-control"  name="subtitle" id="description"></textarea>
                                                <span id="descriptionError" class="text-danger alert-message"></span>

                                                <div id="count">
                                                    <span id="current_count">0</span>
                                                    <span id="maximum_count">/ 255</span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">{{trans('langconvert.admindashboard.uploadimage')}}</label>
                                                <div class="input-group file-browser">
                                                    <input class="form-control " id="image" name="image" type="file" >
                                                </div>
                                                <small class="text-muted"><i>{{trans('langconvert.admindashboard.Filemorethan')}}</i></small>
                                                <div>
                                                    <span id="ImageError" class="text-danger alert-message"></span>
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
                        <!-- End  Add FeatureBox  -->


                         <!--Count the words   -->
                        <script type="text/javascript">
                                "use strict";
                            $('textarea').keyup(function() {
                                var characterCount = $(this).val().length,
                                current_count = $('#current_count'),
                                maximum_count = $('#maximum_count'),
                                count = $('#count');
                                current_count.text(characterCount);
                            });
                        </script>