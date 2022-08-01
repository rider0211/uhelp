						@foreach ($comments as $comment)
							{{--Customer Reply status--}}
							@if($comment->cust_id != null)
							@if ($loop->first)

														<div class="card-body">
															<div class="d-sm-flex">
																<div class="d-flex me-3">
																	<a href="#">
																		@if ($comment->cust->image == null)

																		<img src="{{asset('uploads/profile/user-profile.png')}}"
																			class="media-object brround avatar-lg" alt="default">
																		@else

																		<img class="media-object brround avatar-lg" alt="{{$comment->cust->image}}"
																			src="{{asset('uploads/profile/'. $comment->cust->image)}}">
																		@endif

																	</a>
																</div>
																<div class="media-body">
																	<h5 class="mt-1 mb-1 font-weight-semibold">{{ $comment->cust->username }}</h5>
																	<small class="text-muted"><i class="feather feather-clock"></i> {{
																		$comment->created_at->diffForHumans() }}</small>
																	<div class="fs-13 mb-0 mt-1">
																		{!! $comment->comment !!}
																	</div>
																	<div class="editsupportnote-icon animated"
																		id="supportnote-icon-{{$comment->id}}">
																		<form action="{{route('client.comment.edit',$comment->id)}}" method="POST">
																			@csrf
																			@honeypot

																			<textarea class="editsummernote"
																				name="editcomment"> {{$comment->comment}}</textarea>
																			<div class="btn-list mt-1">
																				<input type="submit" class="btn btn-secondary"
																					onclick="this.disabled=true;this.form.submit();" value="Update">
																			</div>
																		</form>
																	</div>
																	@if (Auth::guard('customer')->id() == $comment->cust_id)
																	@if($comment->getMedia('comments')->isNotEmpty())

																	<div class="card-footer border-0">
																		<div class="row galleryopen">
																			@foreach ($comment->getMedia('comments') as $commentss)

																				<div class="file-image-1  removespruko{{$commentss->id}}" id="imageremove{{$commentss->id}}">
																					<div class="product-image  ">
																						<a href="{{$commentss->getFullUrl()}}" class="imageopen">
																							<img src="{{$commentss->getFullUrl()}}" class="br-5" alt="{{$commentss->file_name}}">
																						</a>
																						<ul class="icons">
																							<li><a href="javascript:(0);" class="bg-danger imgdel" data-id="{{$commentss->id}}"><i class="fe fe-trash" data-id="{{$commentss->id}}"></i>@csrf</a></li>
																						</ul>
																					</div>
																					<span class="file-name-1">
																						{{Str::limit($commentss->file_name, 10, $end='.......')}}
																					</span>
																				</div>
																			@endforeach

																		</div>
																	</div>
																	@endif
																	@else
																	@if($comment->getMedia('comments')->isNotEmpty())

																	<div class="card-footer border-0">
																		<div class="row galleryopen">
																			@foreach ($comment->getMedia('comments') as $commentss)

																				<div class="file-image-1  removespruko{{$commentss->id}}" id="imageremove{{$commentss->id}}">
																					<div class="product-image  ">
																						<a href="{{$commentss->getFullUrl()}}" class="imageopen">
																							<img src="{{$commentss->getFullUrl()}}" class="br-5" alt="{{$commentss->file_name}}">
																						</a>
																					</div>
																					<span class="file-name-1">
																						{{Str::limit($commentss->file_name, 10, $end='.......')}}
																					</span>
																				</div>
																			@endforeach

																		</div>
																	</div>
																	@endif
																	@endif

																</div>
																@if (Auth::guard('customer')->id() == $comment->cust_id)

																<div class="ms-auto">
																	<span class="action-btns supportnote-icon"
																		onclick="showEditForm('{{$comment->id}}')"><i
																			class="feather feather-edit text-primary fs-16"></i></span>
																</div>
																@endif

															</div>
														</div>

							@else
														<div class="card-body">
															<div class="d-sm-flex">
																<div class="d-flex me-3">
																	<a href="#">
																		@if ($comment->cust->image == null)

																		<img src="{{asset('uploads/profile/user-profile.png')}}"
																			class="media-object brround avatar-lg" alt="default">
																		@else

																		<img class="media-object brround avatar-lg" alt="{{$comment->cust->image}}"
																			src="{{asset('uploads/profile/'. $comment->cust->image)}}">
																		@endif

																	</a>
																</div>
																<div class="media-body">
																	<h5 class="mt-1 mb-1 font-weight-semibold">{{ $comment->cust->username }}</h5>
																	<small class="text-muted"><i class="feather feather-clock"></i> {{
																		$comment->created_at->diffForHumans() }}</small>
																	<div class="fs-13 mb-0 mt-1">
																		{!! $comment->comment !!}
																	</div>
																	@if($comment->getMedia('comments')->isNotEmpty())

																	<div class="card-footer border-0">
																		<div class="row galleryopen">
																			@foreach ($comment->getMedia('comments') as $commentss)

																				<div class="file-image-1  removespruko{{$commentss->id}}" id="imageremove{{$commentss->id}}">
																					<div class="product-image  ">
																						<a href="{{$commentss->getFullUrl()}}" class="imageopen">
																							<img src="{{$commentss->getFullUrl()}}" class="br-5" alt="{{$commentss->file_name}}">
																						</a>
																					</div>
																					<span class="file-name-1">
																						{{Str::limit($commentss->file_name, 10, $end='.......')}}
																					</span>
																				</div>
																			@endforeach

																		</div>
																	</div>
																	@endif

																</div>
															</div>
														</div>
							@endif
							{{--Customer Reply status End--}}
							{{--Admin Reply status--}}

							@else
														<div class="card-body">
															<div class="d-sm-flex">
																<div class="d-flex me-3">
																	<a href="#">
																		@if($comment->user != null)
																		@if ($comment->user->image == null)

																		<img src="{{asset('uploads/profile/user-profile.png')}}"
																			class="media-object brround avatar-lg" alt="default">
																		@else

																		<img class="media-object brround avatar-lg" alt="{{$comment->user->image}}"
																			src="{{asset('uploads/profile/'. $comment->user->image)}}">
																		@endif

																		@else

																		<img src="{{asset('uploads/profile/user-profile.png')}}"
																			class="media-object brround avatar-lg" alt="default">
																		@endif

																	</a>
																</div>
																<div class="media-body">
																	@if($comment->user != null)

																	<h5 class="mt-1 mb-1 font-weight-semibold">{{ $comment->user->name }}
																		@if(!empty($comment->user->getRoleNames()[0]))

																		<span
																		class="badge badge-primary-light badge-md ms-2">{{
																		$comment->user->getRoleNames()[0] }}</span>
																		@endif

																		</h5>
																	@else

																	<h5 class="mt-1 mb-1 font-weight-semibold text-muted">~</h5>
																	@endif

																	<small class="text-muted"><i class="feather feather-clock"></i> {{
																		$comment->created_at->diffForHumans() }}</small>
																	<div class="fs-13 mb-0 mt-1">
																		{!! $comment->comment !!}
																	</div>
																	@if($comment->getMedia('comments')->isNotEmpty())

																	<div class="card-footer border-0">
																		<div class="row galleryopen">
																			@foreach ($comment->getMedia('comments') as $commentss)

																			<div class="file-image-1  removespruko{{$commentss->id}}" id="imageremove{{$commentss->id}}">
																				<div class="product-image  ">
																					<a href="{{$commentss->getFullUrl()}}" class="imageopen">
																						<img src="{{$commentss->getFullUrl()}}" class="br-5" alt="{{$commentss->file_name}}">
																					</a>
																				</div>
																				<span class="file-name-1">
																					{{Str::limit($commentss->file_name, 10, $end='.......')}}
																				</span>
																			</div>
																			
																			@endforeach

																		</div>
																	</div>
																	@endif
																	
																</div>
															</div>
														</div>
							@endif
							{{--Admin Reply status End--}}
						@endforeach