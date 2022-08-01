@extends('installer.layouts.InstallerMaster')

@section('template_title')
    {{ trans('Welcome') }}
@endsection

@section('title')
    {{ trans('Laravel Installer') }}
@endsection

@section('container')
    <p class="fs-12 text-center">
      {{ trans('Easy Installation and Setup Wizard') }}
    </p>
    <p class="text-center">
      <a href="{{ route('SprukoAppInstaller::requirement') }}" class="button">
        {{ trans('Check Requirements') }}
        <i class="fa fa-angle-right fa-fw" aria-hidden="true"></i>
      </a>
    </p>
@endsection
