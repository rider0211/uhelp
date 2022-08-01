<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@if (trim($__env->yieldContent('template_title')))@yield('template_title') | @endif {{ trans('installer_messages.title') }}</title>
        <link rel="icon" type="image/png" href="{{ asset('installer/img/favicon/favicon-16x16.png') }}" sizes="16x16"/>
        <link rel="icon" type="image/png" href="{{ asset('installer/img/favicon/favicon-32x32.png') }}" sizes="32x32"/>
        <link rel="icon" type="image/png" href="{{ asset('installer/img/favicon/favicon-96x96.png') }}" sizes="96x96"/>
        <link href="{{ asset('installer/css/style.css') }}" rel="stylesheet"/>
        @yield('style')
        <script>
            window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
            ]); ?>
        </script>
    </head>
    <body>
        <div class="master">
            <div class="box">
                 <div class="text-center main-logo"> <img src="{{ asset('installer/img/logo-white.png') }}" class="header-brand-img desktop-lgo" alt="logo"> </div>
                <div class="box-content">
                    <div class="header">
                        <h1 class="header__title">@yield('title')</h1>
                    </div>
                    <ul class="step">
                        <li class="step__divider"></li>
                        <li class="step__item {{ isActive('SprukoAppInstaller::final') }}">
                            <i class="step__icon fa fa-server" aria-hidden="true"></i>
                        </li>
                        <li class="step__divider"></li>
                        <li class="step__item {{ isActive('SprukoAppInstaller::register') }}">
                            <i class="step__icon fa fa-user" aria-hidden="true"></i>
                        </li>
                        <li class="step__divider"></li>
                        <li class="step__item {{ isActive('SprukoAppInstaller::environment')}} {{ isActive('SprukoAppInstaller::environmentWizard')}} {{ isActive('SprukoAppInstaller::environmentClassic')}}">
                            @if(Request::is('install/environment') || Request::is('install/environment/wizard') || Request::is('install/environment/classic') )
                                <a href="{{ route('SprukoAppInstaller::environment') }}">
                                    <i class="step__icon fa fa-cog" aria-hidden="true"></i>
                                </a>
                            @else
                                <i class="step__icon fa fa-cog" aria-hidden="true"></i>
                            @endif
                        </li>
                        <li class="step__divider"></li>
                        <li class="step__item {{ isActive('SprukoAppInstaller::permissions') }}">
                            @if(Request::is('install/permissions') || Request::is('install/environment') || Request::is('install/environment/wizard') || Request::is('install/environment/classic') )
                                <a href="{{ route('SprukoAppInstaller::permissions') }}">
                                    <i class="step__icon fa fa-key" aria-hidden="true"></i>
                                </a>
                            @else
                                <i class="step__icon fa fa-key" aria-hidden="true"></i>
                            @endif
                        </li>
                        <li class="step__divider"></li>
                        <li class="step__item {{ isActive('SprukoAppInstaller::requirement') }}">
                            @if(Request::is('install') || Request::is('install/requirement') || Request::is('install/permissions') || Request::is('install/environment') || Request::is('install/environment/wizard') || Request::is('install/environment/classic') )
                                <a href="">
                                    <i class="step__icon fa fa-list" aria-hidden="true"></i>
                                </a>
                            @else
                                <i class="step__icon fa fa-list" aria-hidden="true"></i>
                            @endif
                        </li>
                        <li class="step__divider"></li>
                        <li class="step__item {{ isActive('SprukoAppInstaller::welcome') }}">
                            @if(Request::is('install') || Request::is('install/requirements') || Request::is('install/permissions') || Request::is('install/environment') || Request::is('install/environment/wizard') || Request::is('install/environment/classic') )
                                <a href="">
                                    <i class="step__icon fa fa-home" aria-hidden="true"></i>
                                </a>
                            @else
                                <i class="step__icon fa fa-home" aria-hidden="true"></i>
                            @endif
                        </li>
                        <li class="step__divider"></li>
                    </ul>
                    <div class="main">
                        @if (session('message'))
                            <p class="alert text-center">
                                <strong>
                                    @if(is_array(session('message')))
                                        {{ session('message')['message'] }}
                                    @else
                                        {{ session('message') }}
                                    @endif
                                </strong>
                            </p>
                        @endif
                        
                        @yield('container')
                    </div>
                </div>    
                <div class="copyright"> Copyright © 2022 <a href="javascript:void(0);">Uhelp</a>. Developed by <a href="javascript:void(0);"> Spruko Technologies Pvt.Ltd. </a> All rights reserved </div>
            </div>

            
        </div>
        @yield('scripts')
      
    </body>
</html>
