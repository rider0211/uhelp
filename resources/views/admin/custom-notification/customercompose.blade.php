@extends('layouts.adminmaster')

        @section('styles')

        <!-- INTERNAL multiselecte css-->
        <link href="{{asset('assets/plugins/multipleselect/multiple-select.css')}}?v=<?php echo time(); ?>" rel="stylesheet" />
		<link href="{{asset('assets/plugins/multi/multi.min.css')}}?v=<?php echo time(); ?>" rel="stylesheet" />

        @endsection

                            @section('content')

                            <!--Page header-->
                            <div class="page-header d-lg-flex d-block">
                                <div class="page-leftheader">
                                    <h4 class="page-title">
                                        <span class="font-weight-normal text-muted ms-2">{{trans('langconvert.adminmenu.customers')}}</span>
                                    </h4>
                                </div>
                                <div class="page-rightheader ms-md-auto">
                                    <div class="d-flex align-items-end flex-wrap my-auto end-content breadcrumb-end">
                                        <div class="d-flex">
                                            <div class="btn-list">
                                                @can('Custom Notifications Employee')

                                                <a href="{{route('mail.employee')}}" class="btn btn-success">{{trans('langconvert.admindashboard.composetoemployees')}}</a>
                                                @endcan

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--End Page header-->

                            <!-- Row Customer Compose -->
                            <div class="row">
                                <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                                    <div class="card">
                                        <div class="card-header border-bottom-0">
                                            <h3 class="card-title">{{trans('langconvert.admindashboard.composenotifiyforcustomers')}}</h3>
                                        </div>
                                        <form action="{{route('mail.customersend')}}" method="post">
                                            @csrf

                                            <div class="card-body">
                                                <div class="form-group">
                                                    <div class="row align-items-center">
                                                        <label class="col-sm-2 form-label">{{trans('langconvert.admindashboard.to')}} <span class="text-red">*</span></label>
                                                        <div class="col-sm-10">
                                                            <div class="custom-controls-stacked d-md-flex @error('users') is-invalid @enderror"  id="projectdisable">
                                                                <select multiple="multiple" class="filter-multi"  id="users"  name="users[]" >
                                                                    @foreach ($users as $item)

                                                                        <option value="{{$item->id}}" @if(old('users') == $item->id) selected @endif>{{$item->username}}</option>
                                                                    @endforeach
                                                                    
                                                                </select>
                                                            </div>
                                                            @error('users')

                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row align-items-center">
                                                        <label class="col-sm-2 form-label">{{trans('langconvert.admindashboard.subject')}} <span class="text-red">*</span></label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control @error('subject') is-invalid @enderror" value="{{old('subject')}}" name="subject">
                                                            @error('subject')

                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row ">
                                                        <label class="col-sm-2 form-label">{{trans('langconvert.admindashboard.message')}} <span class="text-red">*</span></label>
                                                        <div class="col-sm-10">
                                                            <textarea rows="10" class="form-control @error('message') is-invalid @enderror" name="message">{{old('message')}}</textarea>
                                                            @error('message')

                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer d-sm-flex">
                                                <div class="btn-list ms-auto">
                                                    <button type="submit" class="btn btn-primary btn-space">{{trans('langconvert.admindashboard.sendmessage')}}</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- End Row Customer Compose -->

                            @endsection

        @section('scripts')

        <!-- INTERNAL multiselecte js-->
        <script src="{{asset('assets/plugins/multipleselect/multiple-select.js')}}"></script>
        <script src="{{asset('assets/plugins/multipleselect/multi-select.js')}}"></script>

        @endsection

