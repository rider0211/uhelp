						<!--Section-->
						<section class="">
							<footer class="text-white footer-support">
								
								<div class="sub-footer">
									<div class="container">
										<div class="row d-flex align-items-center">
											<div class="col-lg-6 col-sm-12 pt-5 pd-b-md-2 pb-5 text-lg-start text-md-center">
												{!!$footertext->copyright!!}
											</div>
											<div class="col-lg-6 col-sm-12 pt-5 pd-t-md-2 pb-5 text-lg-end text-md-center">
												<div class="">
													<nav>
														<ul class="custom-ul">
															@if (setting('FAQ_ENABLE') == 'yes')

															<li><a href="{{url('/faq')}}">{{trans('langconvert.menu.faq')}}</a></li>
															@endif
															@if (setting('CONTACT_ENABLE') == 'yes')

															<li><a href="{{url('/contact-us')}}">{{trans('langconvert.menu.contact')}}</a></li>
															@endif
															@foreach ($page as $pages)
															@if($pages->status == '1')
															@if($pages->viewonpages == 'both' || $pages->viewonpages == 'footer')
					
															<li>
																<a href="{{url('page/' .$pages->pageslug)}}">{{$pages->pagename}}</a>
															</li>
					
															@endif
															@endif
															@endforeach


														</ul>
													</nav>
												</div>
											</div>
										</div>
									</div>
								</div>
							</footer>
						</section>
						<!--Section-->