                            @extends('layouts.custommaster')
                            @section('content')

								<!--Admin Login -->
                                <div class="p-5 pt-0">
									<h1 class="mb-2">{{trans('langconvert.menu.login')}}</h1>
									<p class="text-muted">{{trans('langconvert.menu.siginacc')}}</p>
								</div>
								<form class="card-body pt-3" id="login" action="{{route('login')}}" method="post">
									
									@csrf

									@honeypot

									<div class="form-group">
										<label class="form-label">{{trans('langconvert.admindashboard.email')}} <span class="text-red">*</span></label>
										<input class="form-control  @error('email') is-invalid @enderror" placeholder="Email" type="email" value="{{old('email')}}" name="email">
										@error('email')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
										@enderror
									</div>
									<div class="form-group">
										<label class="form-label">{{trans('langconvert.admindashboard.password')}} <span class="text-red">*</span></label>
										<input class="form-control  @error('password') is-invalid @enderror" placeholder="password" type="password" name="password">
										@error('password')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
										@enderror
									</div>
									<div class="form-group">
										<label class="custom-control form-checkbox">
											<input type="checkbox" class="custom-control-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
											<span class="custom-control-label">{{trans('langconvert.menu.rememberme')}}</span>
										</label>
									</div>
									<div class="submit">
										<input class="btn btn-secondary btn-block"  type="submit" value="{{trans('langconvert.menu.login')}}" onclick="this.disabled=true;this.form.submit();">
									</div>
									<div class="text-center mt-3">
										<p class="mb-2"><a href="{{route('password.request')}}">{{trans('langconvert.menu.forgotpass')}}</a></p>
									</div>
								</form>
								<!-- End Admin Login -->
                            @endsection


