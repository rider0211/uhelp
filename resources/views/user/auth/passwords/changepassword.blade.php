                                                    <!--Change Password-->
                                                    <div class="card">
                                                        <div class="card-header border-0">
                                                            <h4 class="card-title">{{trans('langconvert.admindashboard.changepassword')}}</h4>
                                                        </div>
                                                        <form method="POST" action="{{ route('change.password') }}">
                                                            @csrf

                                                            @honeypot

                                                            <div class="card-body">
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <div class="col-md-3">
                                                                            <label class="form-label mb-0 mt-2">{{trans('langconvert.admindashboard.oldpassword')}}<span class="text-red">*</span></label>
                                                                        </div>
                                                                        <div class="col-md-9">
                                                                            <input type="password" class="form-control @error('current_password') is-invalid @enderror" placeholder="Password" value="" name="current_password" autocomplete="current_password">
                                                                            @error('current_password')

                                                                                <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                            @enderror

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <div class="col-md-3">
                                                                            <label class="form-label mb-0 mt-2">{{trans('langconvert.admindashboard.newpassword')}}<span class="text-red">*</span></label>
                                                                        </div>
                                                                        <div class="col-md-9">
                                                                            <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" value=""name="password" autocomplete="password">
                                                                            @error('password')

                                                                                <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                            @enderror

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <div class="col-md-3">
                                                                            <label class="form-label mb-0 mt-2">{{trans('langconvert.admindashboard.confirmpassword')}}<span class="text-red">*</span></label>
                                                                        </div>
                                                                        <div class="col-md-9">
                                                                            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Confirm password" value=""name="password_confirmation" autocomplete="password_confirmation">
                                                                            @error('password_confirmation')

                                                                                <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                            @enderror
                                                                            
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="card-footer text-end">
                                                            <button type="submit" class="btn btn-secondary" onclick="this.disabled=true;this.form.submit();">{{trans('langconvert.admindashboard.savechanges')}}</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <!--Change Password-->