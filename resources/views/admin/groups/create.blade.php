@extends('layouts.adminmaster')

                            @section('content')

                            <!--Page header-->
                            <div class="page-header d-xl-flex d-block">
                                <div class="page-leftheader">
                                    <h4 class="page-title"><span class="font-weight-normal text-muted ms-2">{{trans('langconvert.adminmenu.groups')}}</span></h4>
                                </div>
                            </div>
                            <!--End Page header-->
                            
                            <!-- Create Groups-->
                            <div class="col-xl-12 col-lg-12 col-md-12">
                                <div class="card ">
                                    <div class="card-header border-0">
                                        <h4 class="card-title">{{trans('langconvert.adminmenu.creategroup')}}</h4>
                                    </div>
                                    <form method="POST" action="{{ url('/admin/groups/store' )}}">
                                        @csrf

                                        @honeypot
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label class="form-label">{{trans('langconvert.admindashboard.name')}} <span class="text-red">*</span></label>
                                                <input type="text" class="form-control @error('groupname') is-invalid @enderror" placeholder="" name="groupname" value="">
                                                @error('groupname')

                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror

                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">{{trans('langconvert.admindashboard.selectemployee')}} </label>
                                                <div class="custom-controls-stacked d-md-flex" >
                                                    <select multiple="multiple" class="form-control  select2" data-placeholder="Select Employee" name="user_id[]" id="username" >
                                                        @foreach ($users as $item)

                                                        @if($item->id != 1)
                                                        
                                                        <option value="{{$item->id}}" >{{$item->name}} @if(!empty($item->getRoleNames()[0])) ({{$item->getRoleNames()[0]}}) @endif</option>
                                                        @endif
                                                        @endforeach

                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <div class="form-group float-end">
                                                <input type="submit" class="btn btn-secondary"  value="{{trans('langconvert.admindashboard.save')}}" onclick="this.disabled=true;this.form.submit();">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!--End Create Groups-->
                            @endsection
        @section('scripts')

        <!-- INTERNAL Index js-->
        <script src="{{asset('assets/js/select2.js')}}?v=<?php echo time(); ?>"></script>
        
        @endsection
