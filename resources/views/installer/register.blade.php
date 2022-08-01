@extends('installer.layouts.InstallerMaster')

@section('template_title')
    {{-- {{ trans('installer_messages.final.templateTitle') }} --}}
    {{ trans('Register') }}
@endsection

@section('title')
    {{ trans('Enter Admin Details') }}
    {{-- {{ trans('installer_messages.final.title') }} --}}
@endsection


@section('container')
        <form method="post" action="{{ route('SprukoAppInstaller::registerstore') }}" class="tabs-wrap">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="row">

                <div class="form-group col-6 {{ $errors->has('app_firstname') ? ' has-error ' : '' }}">
                    <label for="app_firstname">
                        {{ trans('Enter Your Firstname') }}
                        <span class="text-red">*</span>
                    </label>
                    <input type="text" name="app_firstname" id="app_firstname" value="" placeholder="{{ trans('Enter Your Firstname') }}" />
                    @if ($errors->has('app_firstname'))
                        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('app_firstname') }}
                        </span>
                    @endif
                </div>
                <div class="form-group col-6 {{ $errors->has('app_lastname') ? ' has-error ' : '' }}">
                    <label for="app_lastname">
                        {{ trans('Enter Your Lastname') }}
                        <span class="text-red">*</span>
                    </label>
                    <input type="text" name="app_lastname" id="app_lastname" value="" placeholder="{{ trans('Enter Your Lastname') }}" />
                    @if ($errors->has('app_lastname'))
                        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('app_lastname') }}
                        </span>
                    @endif
                </div>
                <div class="form-group col-6 {{ $errors->has('app_email') ? ' has-error ' : '' }}">
                    <label for="app_email">
                        {{ trans('Enter Your Email') }}
                        <span class="text-red">*</span>
                    </label>
                    <input type="email" name="app_email" id="app_email" value="" placeholder="{{ trans('Enter Your Email') }}" />
                    @if ($errors->has('app_email'))
                        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('app_email') }}
                        </span>
                    @endif
                </div>
                <div class="form-group col-6 {{ $errors->has('app_password') ? ' has-error ' : '' }}">
                    <label for="app_password">
                        {{ trans('Enter the password') }}
                        <span class="text-red">*</span>
                    </label>
                    <div class="pos-relative" id="password-toggle">
                        <input type="password" name="app_password" id="app_password" value="" placeholder="{{ trans('Enter the password') }}" />
                        <a class="password-show"  href="javascript:void(0);" onclick="spruko(this)"><i class="fa fa-eye" aria-hidden="true" ></i></a>
                    </div>
                    
                    @if ($errors->has('app_password'))
                        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('app_password') }}
                        </span>
                    @endif
                </div>

                <div class="form-group col-6 {{ $errors->has('envato_purchasecode') ? ' has-error ' : '' }}">
                    <label for="envato_purchasecode">
                        {{ trans('Enter the Envato Purchase Code') }}
                        <span class="text-red">*</span>
                    </label>
                    <div class="pos-relative" id="password-toggle">
                        <input type="text" name="envato_purchasecode" id="envato_purchasecode" value="" placeholder="{{ trans('Enter the Envato Purchase Code ') }}" />
                    </div>
                    
                    @if ($errors->has('envato_purchasecode'))
                        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('envato_purchasecode') }}
                        </span>
                    @elseif($message = Session::get('error'))
                        <span class="error-block text-red">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $message }}
                        </span>
                    @endif
                   
                </div>
            </div>

            <div class="buttons">
                <button class="button" type="submit" id="buttonfinal" onclick="button(this)">
                    {{ trans('Install') }}
                    <i class="fa fa-angle-right fa-fw" aria-hidden="true"></i>
                </button>
            </div>
        </form>

@endsection
@section('scripts')

        <script type="text/javascript">

            "use strict";
            

            function spruko(){
                event.preventDefault();
                if(document.querySelector('#password-toggle input').getAttribute("type") == "text"){

                   document.querySelector('#password-toggle input').setAttribute('type', 'password');
                   document.querySelector('#password-toggle i').classList.add( "fa-eye" );
                    document.querySelector('#password-toggle i').classList.remove( "fa-eye-slash" );

                }else if(document.querySelector('#password-toggle input').getAttribute("type") == "password"){

                    document.querySelector('#password-toggle input').setAttribute('type', 'text');
                    document.querySelector('#password-toggle a i').classList.remove( "fa-eye" );

                    document.querySelector('#password-toggle a i').classList.add( "fa-eye-slash" );
                }
            }


            function button(bt){
                document.getElementById("buttonfinal").innerHTML = `Please Wait... <i class="fa fa-spinner fa-spin"></i>`;
                bt.disabled = true;
                bt.form.submit();
                document.getElementById("buttonfinal").style.cursor = "not-allowed";
                document.getElementById("buttonfinal").style.opacity = "0.5";
            }

        </script>
        
@endsection