@extends('layouts.custommaster')
                            @section('content')

								<!--Reset Password -->
								<div class="p-5 pt-0">
									<h1 class="mb-2">Reset Password</h1>
									<p class="text-muted">Enter the email address registered on your account</p>
									@if (session('status'))
									<div class="alert alert-success" role="alert">
										{{ session('status') }}
									</div>
									@endif
								</div>
								<form class="card-body pt-3" method="POST" action="{{route('password.update')}}" >

                                	@csrf

									@honeypot

                                	<input type="hidden" name="token" value="{{ $token }}">
									<div class="form-group">
										<label class="form-label"  for="email" >E-Mail</label>
										<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $users->email ?? old('email') }}" autocomplete="email" placeholder="john@gmail.com" autofocus readonly>

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
									<div class="form-group">
										<label class="form-label" for="password" >New Password</label>
										<input class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="password" type="password">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
									<div class="form-group">
										<label class="form-label" for="password-confirm" >Confirm Password</label>
										<input class="form-control" placeholder="password" id="password-confirm"  name="password_confirmation" type="password">
									</div>
									<div class="submit">
										<button type="submit" class="btn btn-secondary btn-block" onclick="this.disabled=true;this.form.submit();">
											Reset Password
										</button>
									</div>
									<div class="text-center mt-4">
										<p class="text-dark mb-0">Remembered your password?<a class="text-primary ms-1" href="{{url('/login')}}">Login</a></p>
									</div>
								</form>
								<div class="card-body border-top-0 pb-6 pt-2">
									<div class="text-center">
										<span class="avatar brround me-3 bg-primary-transparent text-primary"><i class="ri-facebook-line"></i></span>
										<span class="avatar brround me-3 bg-primary-transparent text-primary"><i class="ri-instagram-line"></i></span>
										<span class="avatar brround me-3 bg-primary-transparent text-primary"><i class="ri-twitter-line"></i></span>
									</div>
								</div>
								<!-- End Reset Password -->

                            @endsection