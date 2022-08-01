@extends('layouts.custommaster')
@section('content')

								<!--Reset Password-->
								<div class="p-5 pt-0">
									<h1 class="mb-2">{{trans('langconvert.menu.resetpass')}}</h1>
								</div>
								<form class="card-body pt-3" method="POST" action="{{url('customer/reset-password')}}" >
                                @csrf
								@honeypot

                                <input type="hidden" name="token" value="{{ $token }}">
									<div class="form-group">
										<label class="form-label"  for="email" >{{trans('langconvert.admindashboard.email')}}</label>
										<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email ?? old('email') }}" autocomplete="email" placeholder="john@gmail.com" autofocus readonly>

                                        @error('email')

                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror

                                    </div>
									<div class="form-group">
										<label class="form-label" for="password" >{{trans('langconvert.admindashboard.newpassword')}}</label>
										<input class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="password" type="password">
                                        @error('password')

                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
										
                                    </div>
									<div class="form-group">
										<label class="form-label" for="password-confirm" >{{trans('langconvert.admindashboard.confirmpassword')}}</label>
										<input class="form-control" placeholder="password" id="password-confirm"  name="password_confirmation" type="password">
									</div>
									<div class="submit">
                                    <button type="submit" class="btn btn-secondary btn-block" onclick="this.disabled=true;this.form.submit();">
                                        {{trans('langconvert.menu.resetpass')}}
                                    </button>
									</div>
									<div class="text-center mt-4">
										<p class="text-dark mb-0">{{trans('langconvert.menu.remberpass')}}<a class="text-primary ms-1" href="{{url('/login')}}">{{trans('langconvert.menu.login')}}Login</a></p>
									</div>
								</form>
								<!--Reset Password-->
@endsection