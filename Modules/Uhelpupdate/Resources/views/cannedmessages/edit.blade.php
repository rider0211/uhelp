@extends('layouts.adminmaster')

        @section('styles')

		<!-- INTERNAl Summernote css -->
		<link rel="stylesheet" href="{{asset('assets/plugins/summernote/summernote.css')}}">
        @endsection
							@section('content')

                            <!--Page header-->
							<div class="page-header d-xl-flex d-block">
								<div class="page-leftheader">
									<h4 class="page-title"><span class="font-weight-normal text-muted ms-2">{{trans('uhelpupdate::langconvert.admindashboard.cannedmessagesedit')}}</span></h4>
								</div>
							</div>
							<!--End Page header-->

                            <div class="col-xl-12 col-lg-12 col-md-12">
                                <div class="card">
                                    <div class="card-header border-0">
                                        <h4 class="card-title">{{trans('uhelpupdate::langconvert.admindashboard.cannedmessagesedit')}}</h4>
                                    </div>
                                    <form action="{{route('admin.cannedmessages.update',$cannedmessage->id)}}" method="POST" enctype="multipart/form-data">
                                        @csrf

                                        <div class="card-body">
                                            <div class="form-group">
                                                <label for="" class="form-label">{{trans('uhelpupdate::langconvert.admindashboard.cannedmessagestitle')}}</label>
                                                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{$cannedmessage->title}}">
                                                @error('title')

                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror

                                            </div>
                                            <div class="form-group">
                                                <label for="" class="form-label">{{trans('uhelpupdate::langconvert.admindashboard.cannedmessagesmessages')}}</label>
                                                <textarea  name="message" class="form-control summernote @error('message') is-invalid @enderror"  rows="8" cols="50">{{$cannedmessage->messages}}</textarea>
                                                @error('message')

                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror

                                            </div>
                                            <div class="form-group">
                                                    <div class="switch_section">
                                                        <div class="switch-toggle d-flex mt-4">
                                                            <label class="form-label pe-2">{{trans('langconvert.admindashboard.status')}}:</label>
                                                            <a class="onoffswitch2">
                                                                <input type="checkbox"  name="statuscanned" id="myonoffswitch18" class=" toggle-class onoffswitch2-checkbox" value="1"  {{$cannedmessage->status == 1 ? 'checked' : '' }}>
                                                                <label for="myonoffswitch18" class="toggle-class onoffswitch2-label" ></label>
                                                            </a>
                                                        </div>
                                                    </div>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <div class="form-group float-end">
                                                <input type="submit" class="btn btn-secondary" value="{{trans('langconvert.admindashboard.save')}}">
                                            </div>
                                        </div>
                                    <form>
                                    
                                </div>

                            </div>


                            @endsection

        @section('scripts')

       	<!-- INTERNAL Summernote js  -->
		<script src="{{asset('assets/plugins/summernote/summernote.js')}}"></script>


        <script type="text/javascript">

            "use strict";
            // Summernote js
			$('.summernote').summernote({
				placeholder: '',
				tabsize: 1,
				height: 120,
				toolbar: [
					['style', ['style']],
					['font', ['bold', 'underline', 'clear']],
					// ['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
					['fontname', ['fontname']],
					['fontsize', ['fontsize']],
					['color', ['color']],
					['para', ['ul', 'ol', 'paragraph']],
					// ['height', ['height']],
					// ['table', ['table']],
					['insert', ['link']],
					['view', ['fullscreen']],
					['help', ['help']]
				],
			});
        </script>

        @endsection