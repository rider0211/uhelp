@extends('installer.layouts.UpdateMaster')

@section('title', trans('installer_messages.updater.welcome.title'))

@section('container')
    <p class="paragraph text-center">
    	{{ trans('installer_messages.updater.welcome.message') }}
    </p>
    <div class="buttons">
        <a href="{{ route('SprukoUpdater::overview') }}" class="button">{{ trans('installer_messages.next') }}</a>
    </div>
@stop