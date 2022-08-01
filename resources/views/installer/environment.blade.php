@extends('installer.layouts.InstallerMaster')

@section('template_title')
    {{ trans('Step 3 | Environment Settings') }}
@endsection

@section('title')
    {!! trans('Environment Settings') !!}
@endsection

@section('container')
    <div class="tabs tabs-full">

        
        <form method="post" action="{{ route('SprukoAppInstaller::environmentSaveWizard') }}" class="tabs-wrap">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="row">
                    <div class="form-group col-6 {{ $errors->has('app_name') ? ' has-error ' : '' }}">
                        <div class="label_note">
                            <label for="app_name">
                            {{ trans('AppName') }}

                            <span class="text-red">*</span>
                        </label>
                        <small class="err_note">{!!trans('No spaces included')!!}</small>
                        </div>
                        <input type="text" name="app_name" id="app_name" value="" placeholder="{{ trans('Ex: appName') }}" />
                        
                        @if ($errors->has('app_name'))
                            <span class="error-block">
                                <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                                {{ $errors->first('app_name') }}
                            </span>
                        @endif
                    </div>
                    <div class="form-group mt-3 col-6 {{ $errors->has('app_url') ? ' has-error ' : '' }}">
                        <label for="app_url">
                            {{ trans('App Url') }}

                            <span class="text-red">*</span>
                        </label>
                        <input type="url" name="app_url" id="app_url" value="{{url('/')}}" placeholder="{{ trans('App Url') }}" />
                        @if ($errors->has('app_url'))
                            <span class="error-block">
                                <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                                {{ $errors->first('app_url') }}
                            </span>
                        @endif
                    </div>
    
                    <div class="form-group col-6 {{ $errors->has('database_hostname') ? ' has-error ' : '' }}">
                        <label for="database_hostname">
                            {{ trans('Database Host') }}

                            <span class="text-red">*</span>
                        </label>
                        <input type="text" name="database_hostname" id="database_hostname" value="127.0.0.1" placeholder="{{ trans('Database Host') }}" />
                        @if ($errors->has('database_hostname'))
                            <span class="error-block">
                                <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                                {{ $errors->first('database_hostname') }}
                            </span>
                        @endif
                    </div>
    
                    <div class="form-group col-6 {{ $errors->has('database_port') ? ' has-error ' : '' }}">
                        <label for="database_port">
                            {{ trans('Database Port') }}

                            <span class="text-red">*</span>
                        </label>
                        <input type="number" name="database_port" id="database_port" value="3306" placeholder="{{ trans('Database Port') }}" />
                        @if ($errors->has('database_port'))
                            <span class="error-block">
                                <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                                {{ $errors->first('database_port') }}
                            </span>
                        @endif
                    </div>
    
                    <div class="form-group col-6 {{ $errors->has('database_name') ? ' has-error ' : '' }}">
                        <label for="database_name">
                            {{ trans('Database Name') }}

                            <span class="text-red">*</span>
                        </label>
                        <input type="text" name="database_name" id="database_name" value="" placeholder="{{ trans('Database Name') }}" />
                        @if ($errors->has('database_name'))
                            <span class="error-block">
                                <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                                {{ $errors->first('database_name') }}
                            </span>
                        @endif
                    </div>
    
                    <div class="form-group col-6 {{ $errors->has('database_username') ? ' has-error ' : '' }}">
                        <label for="database_username">
                            {{ trans('Database User Name') }}

                            <span class="text-red">*</span>
                        </label>
                        <input type="text" name="database_username" id="database_username" value="" placeholder="{{ trans('Database User Name') }}" />
                        @if ($errors->has('database_username'))
                            <span class="error-block">
                                <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                                {{ $errors->first('database_username') }}
                            </span>
                        @endif
                    </div>
    
                    <div class="form-group col-6 {{ $errors->has('database_password') ? ' has-error ' : '' }}">
                        <label for="database_password">
                            {{ trans('Database Password') }}
                        </label>
                        <input type="password" name="database_password" id="database_password" value="" placeholder="{{ trans('Database Password') }}" />
                        @if ($errors->has('database_password'))
                            <span class="error-block">
                                <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                                {{ $errors->first('database_password') }}
                            </span>
                        @endif
                    </div>
                </div>
                
                <div class="buttons">
                    <button class="button" id="nextbutton" type="submit"  onclick="button(this)">
                        {{ trans('Next') }}
                        {{-- {{ trans('installer_messages.environment.wizard.form.buttons.install') }} --}}
                        <i class="fa fa-angle-right fa-fw" aria-hidden="true"></i>
                    </button>
                </div>
        </form>

    </div>
@endsection
@section('scripts')

    <script type="text/javascript">

        "use strict";

        function button(bt){
            document.getElementById("nextbutton").innerHTML = `Please Wait... <i class="fa fa-spinner fa-spin"></i>`;
            bt.disabled = true;
            bt.form.submit();
            document.getElementById("nextbutton").style.cursor = "not-allowed";
            document.getElementById("nextbutton").style.opacity = "0.5";
        }
        
    </script>
@endsection