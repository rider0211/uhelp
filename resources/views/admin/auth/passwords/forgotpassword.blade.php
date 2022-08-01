@extends('layouts.custommaster')
                            	@section('content')

								<!--Forgot Password -->
                            	<div class="p-5 pt-0">
									<h1 class="mb-2">{{trans('langconvert.menu.forgotpass')}}</h1>
									<p class="text-muted">{{trans('langconvert.menu.enteremail')}}</p>
								</div>
								<form class="card-body pt-3" id="forgot" action="{{route('password.email')}}" method="post">
                                	@csrf

									@honeypot

									<div class="form-group">
										<label class="form-label">{{trans('langconvert.admindashboard.email')}}</label>
										<input class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Email" type="email">
                                        @error('email')

                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror

									</div>
									<div class="submit">
                                        <input class="btn btn-secondary btn-block" type="submit" value="{{trans('langconvert.admindashboard.submit')}}" onclick="this.disabled=true;this.form.submit();">
									</div>
									<div class="text-center mt-4">
										<p class="text-dark mb-0"><a class="text-primary ms-1" href="{{url('/')}}">{{trans('langconvert.menu.sendmeback')}}</a></p>
									</div>
								</form>
								<!--End Forgot Password -->
								
                            	@endsection