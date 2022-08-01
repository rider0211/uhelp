@extends('installer.layouts.InstallerMaster')

@section('template_title')
{{ trans('installer_messages.final.templateTitle') }}
@endsection

@section('title')
{{ trans('installer_messages.final.title') }}
@endsection


@section('container')

@if ($message = Session::get('success'))

<p class="paragraph para-heading text-center">
    {{ $message }}
</p>
@endif
@if ($message = Session::get('info'))

<p class="paragraph para-heading text-center">
    {{ $message }}
</p>
@endif

<div class="border-bottom pb-20">
    <p class="url-title">Admin Url:</p>
    <p class="link"><span id="clipurl" class="clipurl">{{ url('/') . '/admin'
            }}</span>
        <a class="btn" href="javascript:void(0);" data-clipboard-target="#clipurl">
            <i class="fa fa-copy"></i>
        </a>
    </p>

    @if ($message = Session::get('success'))

    <p class="paragraph text-bold"><span class="url-link">Username:-</span> <span id="clipurl1"
            class="clipurl">{{Session::get('emails')}}</span>
        <a class="btn" href="javascript:void(0);" data-clipboard-target="#clipurl1">
            <i class="fa fa-copy"></i>
        </a>
    </p>
    <p class="paragraph  text-bold"><span class="url-link">Password:-</span> <span id="clipurl2" class="clipurl">{{Session::get('password')}}</span>
            <a class="btn" href="javascript:void(0);" data-clipboard-target="#clipurl2">
                <i class="fa fa-copy"></i>
            </a>
    </p>
    @endif

    <div class="buttons">
        <a href="{{ url('/') .'/admin' }}" class="button">Go to Admin url</a>
    </div>
</div>


<div>
    <p class="url-title">Frontend Url:</p>
    <p class="link"><span id="clipfurl" class="clipurl">{{ url('/') }}</span>
        <a class="btn" href="javascript:void(0);" data-clipboard-target="#clipfurl">
            <i class="fa fa-copy"></i>
        </a>
    </p>
    <div class="buttons">
        <a href="{{ url('/') }}" class="button">Go to Frontend Url</a>
    </div>
</div>

@endsection
@section('scripts')
    <script src="{{asset('installer/clipboard/clipboard.js')}}?v=<?php echo time(); ?>"></script>

    <script type="text/javascript">

        "use strict";
        var clipboard = new ClipboardJS('.btn');
    
        clipboard.on('success', function (e) {
            console.log(e);
        });

        clipboard.on('error', function (e) {
            console.log(e);
        });
        
    </script>
@endsection