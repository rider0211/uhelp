@extends('layouts.usermaster')


@section('content')

		<!-- Section -->
		<section>
			<div class="bannerimg cover-image" data-bs-image-src="{{asset('assets/images/photos/banner1.jpg')}}">
				<div class="header-text mb-0">
					<div class="container">
						<div class="row text-white">
							<div class="col">
								<h1>{{$category->name}}</h1>
							</div>
							<div class="col col-auto">
								<ol class="breadcrumb text-center">
									<li class="breadcrumb-item">
										<a href="#" class="text-white-50">{{trans('langconvert.menu.home')}}</a>
									</li>
									<li class="breadcrumb-item active">
										<a href="#" class="text-white">{{trans('langconvert.admindashboard.category')}}</a>
									</li>
								</ol>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- Section -->

		<!--Category Page-->
		<section>
			<div class="cover-image sptb">
				<div class="container">
					<div class="row">
						<div class="col-xl-8">
							<div class="card p-0">
								<div class="search-background category-search p-0">
									<input type="text" class="form-control input-lg" name="search_name" id="search_name"  placeholder="Ask your Questions.....">
									<button class="btn"><i class="fe fe-search"></i></button>
		
									<div id="searchList">
										
									</div>
								</div>
								@csrf
							</div>	
							<div class="card">
								<div class="card-header border-0">
									<h4 class="card-title mb-2">{{$category->name}}</h4>
								</div>
								<div class="card-body pt-1">
										<ul class="list-unstyled list-article mb-0">
											@foreach ($categorys as $category)
                                            @foreach ($category->articles as $article)
											@if($article->status === 'Published')

											@if($article->articleslug != null)

											<li>
												<a class="" href="{{url('/article/' . $article->articleslug)}}"><i class="typcn typcn-document-text"></i><span class="categ-text">{{$article->title}}</span></a>
											</li>
										
											@else

											<li>
												<a class="" href="{{url('/article/' . $article->id)}}"><i class="typcn typcn-document-text"></i><span class="categ-text">{{$article->title}}</span></a>
											</li>
											@endif
											@endif

											@endforeach
											@endforeach
										</ul>
								</div>
							</div>
						</div>
						<div class="col-xl-4">
							<div class="card ">
								<div class="card-header  border-0">
									<h4 class="card-title">{{trans('langconvert.admindashboard.recentarticles')}}</h4>
								</div>
								<div class="card-body">
									<div class="list-catergory">
										<ul class="item-list item-list-scroll mb-0 custom-ul">
											@foreach ($recentarticles as $recentarticle)

											<li class="item mb-4  position-relative">
												@if($recentarticle->articleslug != null)

												<a href="{{url('/article/' . $recentarticle->articleslug)}} " class=" admintickets"></a>
											
												@else

												<a href="{{url('/article/' . $recentarticle->id)}} " class=" admintickets"></a>
												@endif
												<div class="d-flex">
													<div class="me-7">
														<i class="typcn typcn-document-text item-list-icon"></i>
													</div>
													<div class="">
														<span
															class="">{{Str::limit($recentarticle->title, '70')}}
														</span>
													</div>
													<div class="ms-auto">
															<span class="badge badge-light badge-md fs-10"><i
																class="fa fa-eye me-1"></i>{{$recentarticle->views}}</span>
													
													</div>
												</div>
											</li>
											@endforeach

										</ul>
									</div>
								</div>
							</div>

							<div class="card mb-0">
								<div class="card-header  border-0">
									<h4 class="card-title">{{trans('langconvert.menu.populararticles')}}</h4>
								</div>
								<div class="card-body">
									<div class="list-catergory">
										<ul class="item-list item-list-scroll mb-0 custom-ul">
											@foreach ($populararticles as $populararticle)
											<li class="item mb-4 position-relative">
												@if($populararticle->articleslug != null)

												<a href="{{url('/article/' . $populararticle->articleslug)}} " class=" admintickets"></a>
											
												@else

												<a href="{{url('/article/' . $populararticle->id)}} " class=" admintickets"></a>
												@endif
												<div class="d-flex">
													<div class="me-7">
														<i class="typcn typcn-document-text item-list-icon"></i>
													</div>
													<div class="">
														<span
															class="">{{Str::limit($populararticle->title, '70')}}
														</span>
													</div>
													<div class="ms-auto">
														<span class="badge badge-light badge-md fs-10">
															<i class="fa fa-eye me-1"></i>
															{{$populararticle->views}}
														</span>
														
													</div>
												</div>
											</li>
											@endforeach

										</ul>
									</div>
								</div>
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!--Category Page-->



@endsection

@section('scripts')

	<script type="text/javascript">
		"use strict";
		
		(function($){

			// close the data search
			document.querySelector('.page-main').addEventListener('click', ()=>{ 
				$('#searchList').fadeOut();
				$('#searchList').html(''); 
			});
			
			// search the data
			$('#search_name').keyup(function () {

				var data = $(this).val();
				if (data != '') {
					var _token = $('input[name="_token"]').val();
					$.ajax({
						url: "{{ url('/search') }}",
						method: "POST",
						data: {data: data, _token: _token},

						dataType:"json",

						success: function (data) {

							$('#searchList').fadeIn();
							$('#searchList').html(data);
							const ps3 = new PerfectScrollbar('.sprukohomesearch', {
								useBothWheelAxes:true,
								suppressScrollX:true,
							});
						},
						error: function (data) {

						}
					});
				}
			});

		})(jQuery);

	</script>

@endsection


