@extends('layouts.adminmaster')

		@section('styles')

		<!-- INTERNAl Summernote css -->
		<link rel="stylesheet" href="{{asset('assets/plugins/summernote/summernote.css')}}?v=<?php echo time(); ?>">

		<!-- DropZone CSS -->
		<link href="{{asset('assets/plugins/dropzone/dropzone.css')}}?v=<?php echo time(); ?>" rel="stylesheet" />

		<!-- galleryopen CSS -->
		<link href="{{asset('assets/plugins/simplelightbox/simplelightbox.css')}}?v=<?php echo time(); ?>" rel="stylesheet">

		<!-- INTERNAL Sweet-Alert css -->
		<link href="{{asset('assets/plugins/sweet-alert/sweetalert.css')}}?v=<?php echo time(); ?>" rel="stylesheet" />

		@endsection

							@section('content')

							<!--Page header-->
							<div class="page-header d-xl-flex d-block">
								<div class="page-leftheader">
									<h4 class="page-title"><span class="font-weight-normal text-muted ms-2">{{trans('langconvert.admindashboard.ticketinformation')}}</span></h4>
								</div>
							</div>
							<!--End Page header-->

							<!--Row-->
							<div class="row">
								<div class="col-xl-12 col-md-12 col-lg-12">
									<div class="row">
										<div class="col-xl-9 col-lg-12 col-md-12">

											@if($ticket->purchasecode != null)

											<!-- Purchase Code Details -->
											<div class="purchasecodes alert alert-light-warning br-13 ">
												<div class="ps-0 pe-0 pb-0">
													<div class="">
														<strong>{{trans('Puchase Code')}} :</strong>
														@if(Auth::check() && Auth::id() == '1')
														
														<span class="">{{$ticket->purchasecode}}</span>
														@else
														@if(setting('purchasecode_on') == 'on')

														<span class="">{{$ticket->purchasecode}}</span>
														@else

														<span class="">{{ Str::padLeft(Str::substr($ticket->purchasecode, -4), Str::length($ticket->purchasecode), Str::padLeft('*', 1)) }}</span>
														@endif
														@endif
														<button class="btn btn-sm btn-dark leading-tight ms-2" id="purchasecodebtn" data-id="{{ $ticket->purchasecode }}">View Details</button>
														@if($ticket->purchasecodesupport == 'Supported')

														<span class="badge badge-success ms-2">Supported</span>
														@elseif($ticket->purchasecodesupport == 'Expired')

														<span class="badge badge-danger ms-2">Support Expired</span>
														@else
														@endif

													</div>	
												</div>
											</div>
											<!-- End Purchase Code Details -->
											
											@endif

											<div class="card">
												<div class="card-header border-0 mb-1 d-block">
													<div class="d-sm-flex d-block">
														<div>
															<h4 class="card-title mb-1 fs-22">{{ $ticket->subject }} </h4>
														</div>
														<div class="card-options float-sm-end ticket-status">
															@if($ticket->status == "New")
	
															<span class="badge badge-success">{{ $ticket->status }}</span>
															@elseif($ticket->status == "Re-Open")
	
															<span class="badge badge-teal">{{ $ticket->status }}</span>
															@elseif($ticket->status == "Inprogress")
	
															<span class="badge badge-info">{{ $ticket->status }}</span>
															@elseif($ticket->status == "On-Hold")
	
															<span class="badge badge-warning">{{ $ticket->status }}</span>
															@else
	
															<span class="badge badge-danger">{{ $ticket->status }}</span>
															@endif
	
														</div>
													</div>
													<small class="fs-13"><i class="feather feather-clock text-muted me-1"></i>{{trans('langconvert.admindashboard.lastupdatedon')}} <span class="text-muted">{{$ticket->updated_at->diffForHumans()}}</span></small>
												</div>
												<div class="card-body pt-2 readmores px-6 mx-1"> 
													<div>
														<span>{!! $ticket->message !!}</span>
	
														<div class="row galleryopen">
															@foreach ($ticket->getMedia('ticket') as $ticketss)
	
															<div class="file-image-1  removespruko{{$ticketss->id}}" id="imageremove{{$ticketss->id}}">
																<div class="product-image">
																	<a href="{{$ticketss->getFullUrl()}}" class="imageopen">
																		<img src="{{$ticketss->getFullUrl()}}" class="br-5" alt="{{$ticketss->file_name}}">
																	</a>
																	
																</div>
																<span class="file-name-1">
																	{{Str::limit($ticketss->file_name, 10, $end='.......')}}
																</span>
															</div>
															@endforeach
	
														</div>
													</div>

												</div>
											</div>
											{{-- Reply Ticket Display --}}
											@if ($ticket->status != 'Closed')

											<div class="card">
												<div class="card-header border-0">
													<h4 class="card-title">{{trans('langconvert.admindashboard.replyticket')}}</h4>
													
												</div>
												<form method="POST" action="{{url('admin/ticket/'. $ticket->ticket_id)}}" enctype="multipart/form-data">
													@csrf

													@honeypot
													<input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
													<div class="card-body status">
														<div class="col-md-7 col-sm-12 can_msg ps-0 ps-lg-1">
															<div class="d-flex flex-wrap align-items-center">
																<label class="form-label me-2">{{trans('uhelpupdate::langconvert.newwordslang.cannedmessage')}}</label>
																<div class="flex-1 mb-2 mb-lg-0">
																	<select name="cannedmessage" id="cannedmessagess" class="cannedmessage form-control mw"  data-placeholder="Select Canned Messages">
																		<option value="" label="Select Canned Messages"></option>
																		@foreach ($cannedmessages as $cannedmessage)
		
																			<option value="{{$cannedmessage->messages}}">{{$cannedmessage->title}}</option>
																		@endforeach
		
																	</select>
																</div>
															</div>
														</div>
														<div class="form-group">
															<textarea class="summernote form-control @error('comment') is-invalid @enderror" name="comment" rows="6" cols="100" aria-multiline="true">{{old('comment')}}</textarea>
															@error('comment')

																<span class="invalid-feedback" role="alert">
																	<strong>{{ $message }}</strong>
																</span>
															@enderror
														</div>
														<div class="form-group">
															<label class="form-label">{{trans('langconvert.admindashboard.uploadimage')}}</label>
															<div class="file-browser">
																<div class="needsclick dropzone" id="document-dropzone"></div>
															</div>
															<small class="text-muted"><i>{{trans('langconvert.admindashboard.filesizenotbe')}} {{setting('FILE_UPLOAD_MAX')}}{{trans('langconvert.admindashboard.mb')}}</i></small>
														</div>
														
														<div class="custom-controls-stacked d-md-flex" id="text">
															<label class="form-label mt-1 me-5">{{trans('langconvert.admindashboard.status')}}</label>
															<label class="custom-control form-radio success me-4">
																@if($ticket->status == 'Re-Open')

																<input type="radio" class="custom-control-input hold" name="status" value="Inprogress"
																{{ $ticket->status == 'Re-Open' ? 'checked' : '' }} >
																<span class="custom-control-label">{{trans('langconvert.newwordslang.inprogress')}}</span>
																@elseif($ticket->status == 'Inprogress')

																<input type="radio" class="custom-control-input hold" name="status" value="{{$ticket->status}}"
																{{ $ticket->status == 'Inprogress' ? 'checked' : '' }} >
																<span class="custom-control-label">{{trans('langconvert.newwordslang.inprogress')}}</span>
																@else

																<input type="radio" class="custom-control-input hold" name="status" value="Inprogress"
																{{ $ticket->status == 'New' ? 'checked' : '' }} >
																<span class="custom-control-label">{{trans('langconvert.newwordslang.inprogress')}}</span>
																@endif

															</label>
															<label class="custom-control form-radio success me-4">
																<input type="radio" class="custom-control-input hold" name="status" value="Solved" >
																<span class="custom-control-label">{{trans('langconvert.newwordslang.solved')}}</span>
															</label>
															<label class="custom-control form-radio success me-4">
																<input type="radio" class="custom-control-input" name="status" id="onhold" value="On-Hold" @if(old('status') == 'On-Hold') checked @endif {{ $ticket->status == 'On-Hold' ? 'checked' : '' }}>
																<span class="custom-control-label">{{trans('langconvert.newwordslang.onhold')}}</span>
															</label>
														</div>
													</div>
													
													<div class="card-footer">
														<div class="form-group float-end">
															<input type="submit" class="btn btn-secondary" value="{{trans('langconvert.admindashboard.reply')}}" onclick="this.disabled=true;this.form.submit();">
														</div>
													</div>
												</form>
											</div>
											@else
											@endif
											{{-- End Reply Ticket Display --}}

											{{-- Comments Display --}}
											@if($comments->isNOtEmpty())

											<div class="card  mb-0">
												<div class="card-header border-0">
													<h4 class="card-title">{{trans('langconvert.admindashboard.conversions')}}</h4>
												</div>
												<div class="suuport-convercontentbody" >
													{{ csrf_field() }}
													<div id="spruko_loaddata">
														@include('admin.viewticket.showticketdata')
														
													</div>
												</div>
											</div>
											@endif
											{{-- End Comments Display --}}
											
										</div>

										<div class="col-xl-3 col-lg-6 col-md-12">
											<div class="card">
												<div class="card-header  border-0">
													<div class="card-title">{{trans('langconvert.admindashboard.ticketinformation')}}</div>
												</div>
												<div class="card-body pt-2 ps-0 pe-0 pb-0">
													<div class="table-responsive tr-lastchild">
														<table class="table mb-0 table-information">
															<tbody>
																
																<tr>
																	<td>
																		<span class="w-50">{{trans('langconvert.admindashboard.ticketid')}}</span>
																	</td>
																	<td>:</td>
																	<td>
																		<span class="font-weight-semibold">#{{ $ticket->ticket_id }}</span>
																	</td>
																</tr>
																<tr>
																	<td>
																		<span class="w-50">{{trans('langconvert.admindashboard.ticketcategory')}}</span>
																	</td>
																	<td>:</td>
																	<td>
																		@if ($ticket->category_id != null)
																		
																		<span class="font-weight-semibold">{{ $ticket->category->name}}</span>
																		@if ($ticket->status != 'Closed')

																		<a href="javascript:void(0)" data-id="{{$ticket->ticket_id}}" class="p-1 sprukocategory border border-primary br-7 text-white bg-primary ms-2"> <i class="feather feather-edit-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Change Category"></i></a>
																		
																		@endif
																		@else

																		<a href="javascript:void(0)" data-id="{{$ticket->ticket_id}}" class="p-2 sprukocategory border border-primary br-7 text-white bg-primary ms-2" > <i class="feather feather-plus-square" data-toggle="tooltip" data-bs-placement="top" title="Add Category"></i></a>
																		@endif

																	</td>
																</tr>
																
																@if ($ticket->subcategory != null)
																<tr>
																	<td>
																		<span class="w-50">{{trans('langconvert.newwordslang.ticketsubcategory')}}</span>
																	</td>
																	<td>:</td>
																	<td>
																		<span class="font-weight-semibold">{{$ticket->subcategoriess->subcategoryname}}</span>
																		
																	</td>
																</tr>
																@endif
																	
																@if ($ticket->project != null)

																<tr>
																	<td>
																		<span class="w-50">{{trans('langconvert.admindashboard.ticketproject')}}</span>
																	</td>
																	<td>:</td>
																	<td>
																		<span class="font-weight-semibold">{{ $ticket->project }}</span>
																	</td>
																</tr>
																@endif
																@if($ticket->priority != null)
																<tr>
																	<td>
																		<span class="w-50">{{trans('langconvert.admindashboard.ticketpriority')}}</span>
																	</td>
																	<td>:</td>
																	<td id="priorityid">
																		@if($ticket->priority == "Low")

																			<span class="badge badge-success-light" >{{ $ticket->priority }}</span>
																			<button  id="priority" class="p-1 border border-primary br-7 text-white bg-primary ms-2"> 
																				<i class="feather feather-edit-2" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Change priority" aria-label="Add priority"></i>
																			</button>
																		@elseif($ticket->priority == "High")

																			<span class="badge badge-danger-light">{{ $ticket->priority}}</span>
																			<button  id="priority" class="p-1 border border-primary br-7 text-white bg-primary ms-2"> 
																				<i class="feather feather-edit-2" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Change priority" aria-label="Add priority"></i>
																			</button>
																		@elseif($ticket->priority == "Critical")

																			<span class="badge badge-danger-dark">{{ $ticket->priority}}</span>
																			<button  id="priority" class="p-1 border border-primary br-7 text-white bg-primary ms-2"> 
																				<i class="feather feather-edit-2" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Change priority" aria-label="Add priority"></i>
																			</button>
																		@else

																			<span class="badge badge-warning-light">{{ $ticket->priority }}</span>
																			<button  id="priority" class="p-1 border border-primary br-7 text-white bg-primary ms-2"> 
																				<i class="feather feather-edit-2" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Change priority" aria-label="Add priority"></i>
																			</button>
																		@endif
																	</td>
																</tr>
																@else

																<tr>
																	<td>
																		<span class="w-50">{{trans('langconvert.admindashboard.ticketpriority')}}</span>
																	</td>
																	<td>:</td>
																	<td id="priorityid">
																		<button  id="priority" class="p-1 border border-primary br-7 text-white bg-primary ms-2"> 
																			<i class="feather feather-plus" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Change priority" aria-label="Add priority"></i>
																		</button>

																		
																	</td>
																</tr>
																@endif

																<tr>
																	<td>
																		<span class="w-50">{{trans('langconvert.admindashboard.opendate')}}</span>
																	</td>
																	<td>:</td>
																	<td>
																		<span class="font-weight-semibold">{{ $ticket->created_at->timezone(Auth::user()->timezone)->format(setting('date_format'))}}</span>
																	</td>
																</tr>
																<tr>
																	<td>
																		<span class="w-50">{{trans('langconvert.admindashboard.status')}}</span>
																	</td>
																	<td>:</td>
																	<td>
																		@if($ticket->status == "New")

																		<span class="badge badge-success">{{ $ticket->status }}</span>
																		@elseif($ticket->status == "Re-Open")

																		<span class="badge badge-teal">{{ $ticket->status }}</span>
																		@elseif($ticket->status == "Inprogress")

																		<span class="badge badge-info">{{ $ticket->status }}</span>
																		@elseif($ticket->status == "On-Hold")

																		<span class="badge badge-warning">{{ $ticket->status }}</span>
																		@else

																		<span class="badge badge-danger">{{ $ticket->status }}</span>
																		@endif

																	</td>
																</tr>
																@if($ticket->replystatus != null)

																<tr>
																	<td>
																		<span class="w-50">{{trans('langconvert.admindashboard.replystatus')}}</span>
																	</td>
																	<td>:</td>
																	<td>
																		@if($ticket->replystatus == "Solved")

																		<span class="badge badge-success">{{ $ticket->replystatus }}</span>
																		@elseif($ticket->replystatus == "Unanswered")

																		<span class="badge badge-danger-light">{{ $ticket->replystatus }}</span>
																		@elseif($ticket->replystatus == "Waiting for response")

																		<span class="badge badge-warning">{{ $ticket->replystatus }}</span>
																		@else
																		@endif

																	</td>
																</tr>
																@endif

															</tbody>
														</table>
													</div>
												</div>
												<div class="card-footer  ticket-buttons">
													@if($ticket->status == 'Closed')

														<button class="btn btn-secondary my-1" id="reopen" data-id="{{$ticket->id}}"> <i class="feather feather-rotate-ccw"></i> {{trans('langconvert.admindashboard.reopen')}}</button>
														@can('Ticket Assign')
														@if($ticket->toassignuser == null)

														<button data-id="{{$ticket->id}}" id="assigned" class="btn btn-primary my-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Assign" disabled>
															<i class="feather feather-users"></i> {{trans('langconvert.admindashboard.assign')}}
														</button>
														@else

															@if($ticket->toassignuser_id != null)

															<div class="btn-group my-1" role="group" aria-label="Basic outlined example">
																<button  data-id="{{$ticket->id}}"  class="btn btn-primary" id="assigned" data-bs-toggle="tooltip" data-bs-placement="top" title="Change" disabled>{{$ticket->toassignuser->name}}</button>
																<button  data-id="{{$ticket->id}}" class="btn btn-primary" id="btnremove" data-bs-toggle="tooltip" data-bs-placement="top" title="Unassign"disabled><i class="fe fe-x" data-id="{{$ticket->id}}"></i></button>
															</div>
															@else

															<button data-id="{{$ticket->id}}" id="assigned" class="btn btn-primary my-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Assign" disabled>
																<i class="feather feather-users"></i> {{trans('langconvert.admindashboard.assign')}}
															</button>
															@endif
														@endif
														@endcan
													@else
														@can('Ticket Assign')
														@if($ticket->toassignuser == null)

															<button data-id="{{$ticket->id}}" id="assigned" class="btn btn-primary my-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Assign">
																<i class="feather feather-users"></i> {{trans('langconvert.admindashboard.assign')}}
															</button>
														@else
															@if($ticket->toassignuser_id != null)

															<div class="btn-group my-1" role="group" aria-label="Basic outlined example">
																<button  data-id="{{$ticket->id}}"  class="btn btn-primary" id="assigned" data-bs-toggle="tooltip" data-bs-placement="top" title="Change">{{$ticket->toassignuser->name}}</button>
																<button  data-id="{{$ticket->id}}" class="btn btn-primary" id="btnremove"><i class="fe fe-x" data-id="{{$ticket->id}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Unassign"></i></button>
															</div>
															@else

															<button data-id="{{$ticket->id}}" id="assigned" class="btn btn-primary my-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Assign">
																<i class="feather feather-users"></i> {{trans('langconvert.admindashboard.assign')}}
															</button>
															@endif
														@endif
														@endcan
														
													@endif

												</div>
											</div>
											<div class="card">
												<div class="card-header  border-0">
													<div class="card-title">{{trans('langconvert.admindashboard.customerdetails')}}</div>
												</div>
												<div class="card-body text-center pt-2 px-0 pb-0 py-0">
													<div class="profile-pic">
														<div class="profile-pic-img mb-2">
															<span class="bg-success dots" data-bs-toggle="tooltip" data-bs-placement="top" title="Online"></span>
															@if ($ticket->cust->image == null)

																<img src="{{asset('uploads/profile/user-profile.png')}}"  class="brround avatar-xxl" alt="default">
															@else

																<img class="brround avatar-xxl" alt="{{$ticket->cust->image}}" src="{{asset('uploads/profile/'. $ticket->cust->image)}}">
															@endif

														</div>
														<a href="#" class="text-dark">
															<h5 class="mb-1 font-weight-semibold2">{{$ticket->cust->username}}</h5>
															<small class="text-muted ">{{ $ticket->cust->email }}
															</small>
														</a>
													</div>
													<div class="table-responsive text-start tr-lastchild">
														<table class="table mb-0 table-information">
															<tbody>
																<tr>
																	<td>
																		<span class="w-50">{{trans('langconvert.admindashboard.ip')}}</span>
																	</td>
																	<td>:</td>
																	<td>
																		<span class="font-weight-semibold">{{ $ticket->cust->last_login_ip }}</span>
																	</td>
																</tr>
																<tr>
																	<td>
																		<span class="w-50">{{trans('langconvert.admindashboard.mobilenumber')}}</span>
																	</td>
																	<td>:</td>
																	<td>
																		<span class="font-weight-semibold">{{ $ticket->cust->phone}}</span>
																	</td>
																</tr>
																<tr>
																	<td>
																		<span class="w-50">{{trans('langconvert.admindashboard.country')}}</span>
																	</td>
																	<td>:</td>
																	<td>
																		<span class="font-weight-semibold">{{ $ticket->cust->country }}</span>
																	</td>
																</tr>
																<tr>
																	<td>
																		<span class="w-50">{{trans('langconvert.admindashboard.timezone')}}</span>
																	</td>
																	<td>:</td>
																	<td>
																		<span class="font-weight-semibold">{{$ticket->cust->timezone}}</span>
																	</td>
																</tr>
															</tbody>
														</table>
													</div>
												</div>
											</div>
											{{-- ticke note --}}
											<div class="card">
												<div class="card-header  border-0">
													<div class="card-title">{{trans('langconvert.admindashboard.ticketnote')}}</div>
													<div class="card-options">
														@if ($ticket->status != 'Closed')

														<a href="javascript:void(0)" class="btn btn-secondary " id="create-new-note"><i class="feather feather-plus"  ></i></a>
														@endif

													</div>
												</div>
												@php $emptynote = $ticket->ticketnote()->get() @endphp
												@if($emptynote->isNOtEmpty())
												<div class="card-body  item-user">
													<div id="refresh">
														@foreach ($ticket->ticketnote()->latest()->get() as $note)

														<div class="alert alert-light-warning ticketnote" id="ticketnote_{{$note->id}}" role="alert">
															@if($note->user_id == Auth::id())

															<a href="javascript:" class="ticketnotedelete" data-id="{{$note->id}}" onclick="deletePost(event.target)">
																<i class="feather feather-x" data-id="{{$note->id}}" ></i>
															</a>
															@endif

															<p class="m-0">{{$note->ticketnotes}}</p>
															<p class="text-end mb-0"><small><i><b>{{$note->users->name}}</b> @if(!empty($note->users->getRoleNames()[0])) ({{$note->users->getRoleNames()[0]}}) @endif</i></small></p>
														</div>
													@endforeach

													</div>
												</div>
												@else
												<div class="card-body">
													<div class="text-center ">
														<div class="avatar avatar-xxl empty-block mb-4">
															<svg xmlns="http://www.w3.org/2000/svg" height="50" width="50" viewBox="0 0 48 48"><path fill="#CDD6E0" d="M12.8 4.6H38c1.1 0 2 .9 2 2V46c0 1.1-.9 2-2 2H6.7c-1.1 0-2-.9-2-2V12.7l8.1-8.1z"/><path fill="#ffffff" d="M.1 41.4V10.9L11 0h22.4c1.1 0 2 .9 2 2v39.4c0 1.1-.9 2-2 2H2.1c-1.1 0-2-.9-2-2z"/><path fill="#CDD6E0" d="M11 8.9c0 1.1-.9 2-2 2H.1L11 0v8.9z"/><path fill="#FFD05C" d="M15.5 8.6h13.8v2.5H15.5z"/><path fill="#dbe0ef" d="M6.3 31.4h9.8v2.5H6.3zM6.3 23.8h22.9v2.5H6.3zM6.3 16.2h22.9v2.5H6.3z"/><path fill="#FFD15C" d="M22.8 35.7l-2.6 6.4 6.4-2.6z"/><path fill="#334A5E" d="M21.4 39l-1.2 3.1 3.1-1.2z"/><path fill="#FF7058" d="M30.1 18h5.5v23h-5.5z" transform="rotate(-134.999 32.833 29.482)"/><path fill="#40596B" d="M46.2 15l1 1c.8.8.8 2 0 2.8l-2.7 2.7-3.9-3.9 2.7-2.7c.9-.6 2.2-.6 2.9.1z"/><path fill="#F2F2F2" d="M39.1 19.3h5.4v2.4h-5.4z" transform="rotate(-134.999 41.778 20.536)"/></svg>
														</div>
														<h4 class="mb-2">{{trans('langconvert.newwordslang.ticketnotetitle')}}</h4>
														<span class="text-muted">{{trans('langconvert.newwordslang.ticketnotedes')}}</span>
													</div>
												</div>
												@endif
											</div>
											{{-- End ticket note --}}
										</div>
									</div>
								</div>
							</div>

						@endsection

		@section('scripts')
		
		<!-- INTERNAL Summernote js  -->
		<script src="{{asset('assets/plugins/summernote/summernote.js')}}?v=<?php echo time(); ?>"></script>

		<!-- INTERNAL Index js-->
		<script src="{{asset('assets/js/support/support-ticketview.js')}}?v=<?php echo time(); ?>"></script>

		<!-- DropZone JS -->
		<script src="{{asset('assets/plugins/dropzone/dropzone.js')}}?v=<?php echo time(); ?>"></script>

		<!-- galleryopen JS -->
		<script src="{{asset('assets/plugins/simplelightbox/simplelightbox.js')}}?v=<?php echo time(); ?>"></script>
		<script src="{{asset('assets/plugins/simplelightbox/light-box.js')}}?v=<?php echo time(); ?>"></script>

		<!-- INTERNAL Sweet-Alert js-->
		<script src="{{asset('assets/plugins/sweet-alert/sweetalert.min.js')}}?v=<?php echo time(); ?>"></script>	
		<script src="{{asset('assets/js/select2.js')}}?v=<?php echo time(); ?>"></script>

		<!--Showmore Js-->
		<script src="{{asset('assets/js/jquery.showmore.js')}}?v=<?php echo time(); ?>"></script>

		<script type="text/javascript">

			"use strict";

			// Image Upload
			var uploadedDocumentMap = {}
			Dropzone.options.documentDropzone = {
			  url: '{{url('/admin/ticket/imageupload/' .$ticket->ticket_id)}}',
			  maxFilesize: '{{setting('FILE_UPLOAD_MAX')}}', // MB
			  addRemoveLinks: true,
			  acceptedFiles: '{{setting('FILE_UPLOAD_TYPES')}}',
			  headers: {
				'X-CSRF-TOKEN': "{{ csrf_token() }}"
			  },
			  success: function (file, response) {
				$('form').append('<input type="hidden" name="comments[]" value="' + response.name + '">')
				uploadedDocumentMap[file.name] = response.name
			  },
			  removedfile: function (file) {
				file.previewElement.remove()
				var name = ''
				if (typeof file.file_name !== 'undefined') {
				  name = file.file_name
				} else {
				  name = uploadedDocumentMap[file.name]
				}
				$('form').find('input[name="comments[]"][value="' + name + '"]').remove()
			  },
			  init: function () {
				@if(isset($project) && $project->document)
				  var files =
					{!! json_encode($project->document) !!}
				  for (var i in files) {
					var file = files[i]
					this.options.addedfile.call(this, file)
					file.previewElement.classList.add('dz-complete')
					$('form').append('<input type="hidden" name="comments[]" value="' + file.file_name + '">')
				  }
				@endif
				this.on('error', function(file, errorMessage) {
					if (errorMessage.message) {
						var errorDisplay = document.querySelectorAll('[data-dz-errormessage]');
						errorDisplay[errorDisplay.length - 1].innerHTML = errorMessage.message;
					}
				});
			  }
			}

			// Edit Form
			function showEditForm(id) {
				var x = document.querySelector(`#supportnote-icon-${id}`);

				if (x.style.display == "block") {
					x.style.display = "none";
				}
				else {

					x.style.display = "block";
				}
			}

			// Delete Media
			function deleteticket(event) {
                var id  = $(event).data("id");
                let _url = `{{url('/admin/image/delete/${id}')}}`;

                let _token   = $('meta[name="csrf-token"]').attr('content');

				swal({
						title: `{{trans('langconvert.admindashboard.wanttocontinue')}}`,
						text: "{{trans('langconvert.admindashboard.eraserecordspermanently')}}",
						icon: "warning",
						buttons: true,
						dangerMode: true,
					})
					.then((willDelete) => {
					if (willDelete) {
							$.ajax({
								url: _url,
								type: 'DELETE',
								data: {
								_token: _token
								},
								success: function(response) {
									$("#imageremove"+id).remove();
									$('#imageremove'+ id).remove();
								},
								error: function (data) {
								console.log('Error:', data);
								}
							});
						}
					});
            }
	
			@if($ticket->status != "Closed")
			
			// onhold ticket status 
			let hold = document.getElementById('onhold');
			let text = document.querySelector('.status');
			let hold1 = document.querySelectorAll('.hold');
			let  status = false;

			hold.addEventListener('click',(e)=>{
				if( status == false)
					statusDiv();
					status = true;
			}, false)

			if(document.getElementById('onhold').hasAttribute("checked") == true){
				statusDiv();
				status = true;
			}
			
			function statusDiv(){
				let Div = document.createElement('div')
				Div.setAttribute('class','d-block pt-4');
				Div.setAttribute('id','holdremove');

				let newField = document.createElement('textarea');
				newField.setAttribute('type','text');
				newField.setAttribute('name','note');
				newField.setAttribute('class',`form-control @error('note') is-invalid @enderror`);
				newField.setAttribute('rows',3);
				newField.setAttribute('placeholder','Leave a message for On-Hold');
				newField.innerText = `{{old('note',$ticket->note)}}`;
				Div.append(newField);
				text.append(Div);
			}


			hold1.forEach((element,index)=>{
				element.addEventListener('click',()=>{
					let myobj = document.getElementById("holdremove");
					myobj?.remove();

					status = false
				}, false)
			})

			@endif

				// Variables
				var SITEURL = '{{url('')}}';

				// Csrf field
				$.ajaxSetup({
					headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					}
				});

				/*  When user click add note button */
				$('#create-new-note').on('click', function () {
					$('#btnsave').val("create-product");
					$('#ticket_id').val(`{{$ticket->id}}`);
					$('#note_form').trigger("reset");
					$('.modal-title').html("Add Note");
					$('#addnote').modal('show');

				});

				// Note Submit button
				$('body').on('submit', '#note_form', function (e) {
					e.preventDefault();
					var actionType = $('#btnsave').val();
					var fewSeconds = 2;
					$('#btnsave').html('Sending..');
					$('#btnsave').prop('disabled', true);
						setTimeout(function(){
							$('#btnsave').prop('disabled', false);
						}, fewSeconds*1000);
					var formData = new FormData(this);
					$.ajax({
						type:'POST',
						url: SITEURL + "/admin/note/create",
						data: formData,
						cache:false,
						contentType: false,
						processData: false,

						success: (data) => {
							$('#note_form').trigger("reset");
							$('#addnote').modal('hide');
							$('#btnsave').html('Save Changes');
							location.reload();
							toastr.success(data.success);

						},
						error: function(data){
							console.log('Error:', data);
							$('#btnsave').html('Save Changes');
						}
					});
				});

				// when user click its get modal popup to assigned the ticket
				$('body').on('click', '#assigned', function () {
					var assigned_id = $(this).data('id');
					$('.select1-show-search').select2({
						dropdownParent: ".sprukosearch",
						minimumResultsForSearch: '',
						placeholder: "Search",
						width: '100%'
					});

					$.post('ticketassigneds/' + assigned_id , function (data) {
						$('#AssignError').html('');
						$('#assigned_id').val(data.assign_data.id);
						$(".modal-title").text('Assign To Agent');
						$('#username').html(data.table_data);
						$('#addassigned').modal('show');
					});

				});
		
				// Assigned Button submit 
				$('body').on('submit', '#assigned_form', function (e) {
					e.preventDefault();
					var actionType = $('#btnsave').val();
					var fewSeconds = 2;
					$('#btnsave').html('Sending..');
					$('#btnsave').prop('disabled', true);
						setTimeout(function(){
							$('#btnsave').prop('disabled', false);
						}, fewSeconds*1000);
					var formData = new FormData(this);
					$.ajax({
						type:'POST',
						url: SITEURL + "/admin/assigned/create",
						data: formData,
						cache:false,
						contentType: false,
						processData: false,
						success: (data) => {
							$('#AssignError').html('');
							$('#assigned_form').trigger("reset");
							$('#addassigned').modal('hide');
							$('#btnsave').html('Save Changes');
							toastr.success(data.success);
							location.reload();
						},
						error: function(data){
							$('#AssignError').html('');
							$('#AssignError').html(data.responseJSON.errors.assigned_user_id);
							$('#btnsave').html('Save Changes');
							
						}
					});	
				});

				// Remove the assigned from the ticket
				$('body').on('click', '#btnremove', function () {
					var asid = $(this).data("id");

					swal({
							title: `{{trans('langconvert.admindashboard.agentremove')}}`,
							text: "{{trans('langconvert.admindashboard.agentremove1')}}",
							icon: "warning",
							buttons: true,
							dangerMode: true,
						})
						.then((willDelete) => {
						if (willDelete) {

							$.ajax({
								type: "get",
								url: SITEURL + "/admin/assigned/update/"+asid,
								success: function (data) {
								toastr.error(data.error);
								location.reload();
								
								},
								error: function (data) {
								console.log('Error:', data);
								}
								});

						}
					});



				});

				// Reopen the ticket
				$('body').on('click', '#reopen', function(){
					var reopenid = $(this).data('id');
					$.ajax({
						type:'POST',
						url: SITEURL + "/admin/ticket/reopen/" + reopenid,
						data: {
							reopenid:reopenid
						},
						success:function(data){
							
							toastr.success(data.success);
							window.location.reload();
							
						},
						error:function(data){
							toastr.error(data);
						}
					});

				});

				// change priority
				$('#priority').on('click', function () {

					$('#PriorityError').html('');
					$('#btnsave').val("save");
					$('#priority_form').trigger("reset");
					$('.modal-title').html("Priority");
					$('#addpriority').modal('show');
					$('.select2_modalpriority').select2({
						dropdownParent: ".sprukopriority",
						minimumResultsForSearch: '',
						placeholder: "Search",
						width: '100%'
					});


				});

				$('body').on('submit', '#priority_form', function (e) {
					e.preventDefault();
					var actionType = $('#pribtnsave').val();
					var fewSeconds = 2;
					$('#btnsave').html('Sending..');
					var formData = new FormData(this);
					$.ajax({
					type:'POST',
					url: SITEURL + "/admin/priority/change",
					data: formData,
					cache:false,
					contentType: false,
					processData: false,

					success: (data) => {
					$('#PriorityError').html('');
					$('#priority_form').trigger("reset");
					$('#addpriority').modal('hide');
					$('#pribtnsave').html('Save Changes');
					location.reload();
					toastr.success(data.success);
					

					},
					error: function(data){
						$('#PriorityError').html('');
						$('#PriorityError').html(data.responseJSON.errors.priority_user_id);
						$('#btnsave').html('Save Changes');
					}
					});
				});
				// end priority

				// category list
				$('body').on('click', '.sprukocategory', function(){

					var category_id = $(this).data('id');
					$('.modal-title').html("Category");
					$('#CategoryError').html('');
					$('#addcategory').modal('show');

					
					$.ajax({
						type: "get",
						url: SITEURL + "/admin/category/list/" + category_id,
						success: function(data){
							$('.select4-show-search').select2({
								dropdownParent: ".sprukosearchcategory",
							});
							$('.subcategoryselect').select2({
								dropdownParent: ".sprukosearchcategory",
							});
							$('#sprukocategory').html(data.table_data);
							$('.ticket_id').val(data.ticket.id);
							
							if(data.ticket.project != null){
								$('#subcategory')?.empty();
								$('#selectSubCategory .removecategory')?.remove();
								let selectDiv = document.querySelector('#selectSubCategory');
								let Divrow = document.createElement('div');
								Divrow.setAttribute('class','removecategory');
								let selectlabel =  document.createElement('label');
								selectlabel.setAttribute('class','form-label')
								selectlabel.innerText = "Projects";
								let selecthSelectTag =  document.createElement('select');
								selecthSelectTag.setAttribute('class','form-control select2-shows-search');
								selecthSelectTag.setAttribute('id', 'subcategory');
								selecthSelectTag.setAttribute('name', 'project');
								selecthSelectTag.setAttribute('data-placeholder','Select Projects');
								let selectoption = document.createElement('option');
								selectoption.setAttribute('label','Select Projects')
								selectDiv.append(Divrow);
								Divrow.append(selectlabel);
								Divrow.append(selecthSelectTag);
								selecthSelectTag.append(selectoption);
								$('.select2-shows-search').select2({
									dropdownParent: ".sprukosearchcategory",
								});
								$('#subcategory').append(data.projectop);
								
							}

							if(data.ticket.purchasecode != null)
							{
								$('#envato_id')?.empty();
								$('#envatopurchase .row')?.remove();
								let selectDiv = document.querySelector('#envatopurchase');
								let Divrow = document.createElement('div');
								Divrow.setAttribute('class','row');
								let Divcol3 = document.createElement('div');
								let selectlabel =  document.createElement('label');
								selectlabel.setAttribute('class','form-label')
								selectlabel.innerHTML = "Envato Purchase Code <span class='text-red'>*</span>";
								let divcol9 = document.createElement('div');
								let selecthSelectTag =  document.createElement('input');
								selecthSelectTag.setAttribute('class','form-control');
								selecthSelectTag.setAttribute('type','search');
								selecthSelectTag.setAttribute('id', 'envato_id');
								selecthSelectTag.setAttribute('name', 'envato_id');
								selecthSelectTag.setAttribute('placeholder', 'Update Your Purchase Code');
								let selecthSelectInput =  document.createElement('input');
								selecthSelectInput.setAttribute('type','hidden');
								selecthSelectInput.setAttribute('id', 'envato_support');
								selecthSelectInput.setAttribute('name', 'envato_support');
								selectDiv.append(Divrow);
								Divrow.append(Divcol3);
								Divcol3.append(selectlabel);
								divcol9.append(selecthSelectTag);
								divcol9.append(selecthSelectInput);
								Divrow.append(divcol9);
							}

							if(data.ticket.subcategory != null){

								$('#selectssSubCategory').show()
								$('#subscategory').html(data.subcategoryt);
								
							}else{
								if(!data.subcategoryt){
									$('#selectssSubCategory').hide();
								}else{
									$('#selectssSubCategory').show()
									$('#subscategory').html(data.subcategoryt);
								}
							}
							
						},
						error: function(data){

						}
					});


				});


				// when category change its get the subcat list 
				$('body').on('change', '#sprukocategory', function(e) {
					var cat_id = e.target.value;
					$('#selectssSubCategory').hide();
					$.ajax({
						url:"{{ route('guest.subcategorylist') }}",
						type:"POST",
							data: {
							cat_id: cat_id
							},
						success:function (data) {

							if(data.subcategoriess)
							{
								$('#selectssSubCategory').show()
								$('#subscategory').html(data.subcategoriess)
							}
							else
							{
								$('#selectssSubCategory').hide();
								$('#subscategory').html('')
							}

							// Envato access
							if(data.envatosuccess.length >= 1)
							{
								
								$('.sprukoapiblock').attr('disabled', true);
								$('#envato_id')?.empty();
								$('#envatopurchase .row')?.remove();
								let selectDiv = document.querySelector('#envatopurchase');
								let Divrow = document.createElement('div');
								Divrow.setAttribute('class','row');
								let Divcol3 = document.createElement('div');
								let selectlabel =  document.createElement('label');
								selectlabel.setAttribute('class','form-label')
								selectlabel.innerHTML = "Envato Purchase Code <span class='text-red'>*</span>";
								let divcol9 = document.createElement('div');
								let selecthSelectTag =  document.createElement('input');
								selecthSelectTag.setAttribute('class','form-control');
								selecthSelectTag.setAttribute('type','search');
								selecthSelectTag.setAttribute('id', 'envato_id');
								selecthSelectTag.setAttribute('name', 'envato_id');
								selecthSelectTag.setAttribute('placeholder', 'Enter Your Purchase Code');
								let selecthSelectInput =  document.createElement('input');
								selecthSelectInput.setAttribute('type','hidden');
								selecthSelectInput.setAttribute('id', 'envato_support');
								selecthSelectInput.setAttribute('name', 'envato_support');
								selectDiv.append(Divrow);
								Divrow.append(Divcol3);
								Divcol3.append(selectlabel);
								divcol9.append(selecthSelectTag);
								divcol9.append(selecthSelectInput);
								Divrow.append(divcol9);
								$('.purchasecode').attr('disabled', true);
								
							}else{
								$('#envato_id')?.empty();
								$('#envatopurchase .row')?.remove();
								$('.sprukoapiblock').removeAttr('disabled');
								$('.purchasecode').removeAttr('disabled');
							}


							// projectlist
							if(data.subcategories.length >= 1){
							
								$('#subcategory')?.empty();
								$('#selectSubCategory .removecategory')?.remove();
								let selectDiv = document.querySelector('#selectSubCategory');
								let Divrow = document.createElement('div');
								Divrow.setAttribute('class','removecategory');
								let selectlabel =  document.createElement('label');
								selectlabel.setAttribute('class','form-label')
								selectlabel.innerText = "Projects";
								let selecthSelectTag =  document.createElement('select');
								selecthSelectTag.setAttribute('class','form-control select2-show-search');
								selecthSelectTag.setAttribute('id', 'subcategory');
								selecthSelectTag.setAttribute('name', 'project');
								selecthSelectTag.setAttribute('data-placeholder','Select Projects');
								let selectoption = document.createElement('option');
								selectoption.setAttribute('label','Select Projects')
								selectDiv.append(Divrow);
								Divrow.append(selectlabel);
								Divrow.append(selecthSelectTag);
								selecthSelectTag.append(selectoption);
								//
								$('.select2-show-search').select2();
								$.each(data.subcategories,function(index,subcategory){
								$('#subcategory').append('<option value="'+subcategory.name+'">'+subcategory.name+'</option>');
								})
							}
							else{
								$('#subcategory')?.empty();
								$('#selectSubCategory .removecategory')?.remove();
							}
						}
					})
				});


				// category submit form
				$('body').on('submit', '#sprukocategory_form', function(e){
					e.preventDefault();
					var actionType = $('#pribtnsave').val();
					var fewSeconds = 2;
					$('#btnsave').html('Sending..');
					var formData = new FormData(this);
					$.ajax({
						type:'POST',
						url: SITEURL + "/admin/category/change",
						data: formData,
						cache:false,
						contentType: false,
						processData: false,

						success: (data) => {
							$('#CategoryError').html('');
							$('#sprukocategory_form').trigger("reset");
							$('#addcategory').modal('hide');
							$('#pribtnsave').html('Save Changes');
							toastr.success(data.success);
							window.location.reload();
							

						},
						error: function(data){
							$('#CategoryError').html('');
							$('#CategoryError').html(data.responseJSON.errors.category);
							$('#btnsave').html('Save Changes');
						}
					});
				})

				@php $module = Module::all(); @endphp

				@if(in_array('Uhelpupdate', $module))

				// Purchase Code Validation
				$("body").on('keyup', '#envato_id', function() {
					let value = $(this).val();
					if (value != '') {
						var _token = $('input[name="_token"]').val();
						$.ajax({
							url: "{{ route('guest.envatoverify') }}",
							method: "POST",
							data: {data: value, _token: _token},

							dataType:"json",

							success: function (data) {
								if(data.valid == 'true'){
									$('#envato_id').attr('readonly', true);
									$('#envato_id').addClass('is-valid');
									$('.sprukoapiblock').removeAttr('disabled');
									$('#envato_id').css('border', '1px solid #02f577');
									$('#envato_support').val('Supported');
									toastr.success(data.message);
								}
								if(data.valid == 'expried'){
									@if(setting('ENVATO_EXPIRED_BLOCK') == 'on')
									
									$('.sprukoapiblock').attr('disabled', true);
									$('.purchasecode').attr('disabled', true);
									$('#envato_id').css('border', '1px solid #e13a3a');
									$('#envato_support').val('Expired');
									toastr.error(data.message);
									@endif
									@if(setting('ENVATO_EXPIRED_BLOCK') == 'off')
									$('.sprukoapiblock').removeAttr('disabled');
									$('#envato_id').addClass('is-valid');
									$('#envato_id').attr('readonly', true);
									$('.purchasecode').removeAttr('disabled');
									$('#envato_id').css('border', '1px solid #02f577');
									$('#envato_support').val('Expired');
									toastr.warning(data.message);
									@endif
								}
								if(data.valid == 'false'){
									$('.sprukoapiblock').attr('disabled', true);
									$('#envato_id').css('border', '1px solid #e13a3a');
									toastr.error(data.message);
								}
								
							
							},
							error: function (data) {

							}
						});
					}else{
						toastr.error('Purchase Code field is Required');
						$('.purchasecode').attr('disabled', true);
						$('#envato_id').css('border', '1px solid #e13a3a');
					}
				});

				@endif

			// delete note dunction
			function deletePost(event) {
				var id  = $(event).data("id");
				let _url = `{{url('/admin/ticketnote/delete/${id}')}}`;

				let _token   = $('meta[name="csrf-token"]').attr('content');

				swal({
					title: `{{trans('langconvert.admindashboard.wanttocontinue')}}`,
					text: "{{trans('langconvert.admindashboard.eraserecordspermanently')}}",
					icon: "warning",
					buttons: true,
					dangerMode: true,
				})
				.then((willDelete) => {
					if (willDelete) {
						$.ajax({
							url: _url,
							type: 'DELETE',
							data: {
							_token: _token
							},
							success: function(response) {
								toastr.error(response.error);
								$("#ticketnote_"+id).remove();
							},
							error: function (data) {
								console.log('Error:', data);
							}
						});
					}
				});
			}

			// Scrolling Js Start
			var page = 1;
			$(window).scroll(function() {
				if($(window).scrollTop() + $(window).height() >= $(document).height()) {
					page++;
					loadMoreData(page);
				}
			});

			function loadMoreData(page){
				$.ajax(
				{
					url: '?page=' + page,
					type: "get",
				})
				.done(function(data)
				{
					$("#spruko_loaddata").append(data.html);
					console.log(data.html);
				})
				.fail(function(jqXHR, ajaxOptions, thrownError)
				{
					alert('server not responding...');
				});
			}

			// End Scrolling Js 

			// ReadMore JS
			let readMore = document.querySelectorAll('.readmores')
            readMore.forEach(( element, index)=>{
                if(element.clientHeight <= 200)    {
                    element.children[0].classList.add('end')
                }
                else{
                    element.children[0].classList.add('readMore')
                }
            })
            $(`.readMore`).showmore({
                closedHeight: 60,
                buttonTextMore: 'Read More',
                buttonTextLess: 'Read Less',
                buttonCssClass: 'showmore-button',
                animationSpeed: 0.5
            });

			// ReadMore Js End

			// PURCHASE CODE DETAILS GETS
			$('body').on('click', '#purchasecodebtn', function()
			{
				var envatopurchase_id = $(this).data('id');

				@if(Auth::check() && Auth::id() == '1')
				var envatopurchase_i = envatopurchase_id;
				@else
				@if(setting('purchasecode_on') == 'on')
				var envatopurchase_i = envatopurchase_id;
				@else
				var trailingCharsIntactCount = 4;

				var envatopurchase_i = new Array(envatopurchase_id.length - trailingCharsIntactCount + 1).join('*') + envatopurchase_id.slice( -trailingCharsIntactCount);
				@endif
				@endif

				$('.modal-title').html('Purchase Details');
				$('.purchasecode').html(envatopurchase_i);
				$('#addpurchasecode').modal('show');
				$('#purchasedata').html('');

				$.ajax({
					url:"{{ route('admin.ticketlicenseverify') }}",
					type:"POST",
					data: {
						envatopurchase_id: envatopurchase_id
					},
					success:function (data) {
						$('#purchasedata').html(data);
					},
					error:function(data){
						$('#purchasedata').html('');
					}

				});
			});

			// Canned Maessage Select2
			$('.cannedmessage').select2({
				minimumResultsForSearch: '',
				placeholder: "Search",
				width: '100%'
			});

			// On Change Canned Messages display
			$('body').on('change', '#cannedmessagess', function(){
				let optval = $(this).val();
				$('.note-editable').html(optval);
				$('.summernote').html(optval);
			})

		</script>

		@endsection

			@section('modal')
		
	  		<!-- Add note-->
			<div class="modal fade"  id="addnote" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" ></h5>
							<button  class="close" data-bs-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>
						<form method="POST" enctype="multipart/form-data" id="note_form" name="note_form">
							<input type="hidden" name="ticket_id" id="ticket_id">
							@csrf
							@honeypot
							<div class="modal-body">
								
								<div class="form-group">
									<label class="form-label">Note:</label>
									<textarea class="form-control" rows="4" name="ticketnote" id="note" required></textarea>
									<span id="noteError" class="text-danger alert-message"></span>
								</div>
								
							</div>
							<div class="modal-footer">
								<a href="#" class="btn btn-outline-danger" data-bs-dismiss="modal">Close</a>
								<button type="submit" class="btn btn-secondary" id="btnsave"  >Save</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			<!-- End  Add note  -->
	
			<!-- Assigned Tickets-->
			<div class="modal fade sprukosearch"  id="addassigned" role="dialog" aria-hidden="true" >
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" ></h5>
							<button  class="close" data-bs-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>
						<form method="POST" enctype="multipart/form-data" id="assigned_form" name="assigned_form">
							@csrf
							@honeypot
							<input type="hidden" name="assigned_id" id="assigned_id">
							@csrf
							<div class="modal-body">
	
								<div class="custom-controls-stacked d-md-flex" >
									<select class="form-control select1-show-search filll" data-placeholder="Select Agent" name="assigned_user_id" id="username" >
	
									</select>
								</div>
								<span id="AssignError" class="text-danger"></span>
							</div>
							<div class="modal-footer">
								<button type="submit" class="btn btn-secondary" id="btnsave"  >Save</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			<!-- End Assigned Tickets  -->


			<!-- Priority Tickets-->
			<div class="modal fade sprukopriority"  id="addpriority" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" ></h5>
							<button  class="close" data-bs-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>
						<form method="POST" enctype="multipart/form-data" id="priority_form" name="priority_form">
							@csrf
							@honeypot
							<input type="hidden" name="priority_id" id="priority_id" value="{{$ticket->id}}">
							@csrf
							<div class="modal-body">
	
								<div class="custom-controls-stacked d-md-flex" >
									<select class="form-control select2_modalpriority" data-placeholder="Select Priority" name="priority_user_id" id="priority" >
										<option label="Select Priority"></option>
										<option value="Critical" {{($ticket->priority == 'Critical')? 'selected' :'' }}>Critical</option>
										<option value="High" {{($ticket->priority == 'High')? 'selected' :'' }}>High</option>
										<option value="Medium" {{($ticket->priority == 'Medium')? 'selected' :'' }}>Medium</option>
										<option value="Low" {{($ticket->priority == 'Low')? 'selected' :'' }}>Low</option>
									</select>	
								</div>
								<span id="PriorityError" class="text-danger"></span>
							</div>
							<div class="modal-footer">
								<button type="submit" class="btn btn-secondary" id="pribtnsave" >Save</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			<!-- End priority Tickets  -->

			@include('admin.viewticket.modalpopup.categorymodalpopup')

			<!-- PurchaseCode Modals -->
			<div class="modal fade sprukopurchasecode"  id="addpurchasecode" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" ></h5>
							<button  class="close" data-bs-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>
						<input type="hidden" name="purchasecode_id" id="purchasecode_id" value="">
						<div class="modal-body">
							<div class="mb-4">
								<strong>{{trans('Puchase Code')}} :</strong>
								<span class="purchasecode"></span>
							</div>
							<div id="purchasedata">

							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- End PurchaseCode Modals   -->

			@endsection

