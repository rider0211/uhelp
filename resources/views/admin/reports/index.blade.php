@extends('layouts.adminmaster')

  		@section('styles')

		<!-- INTERNAL Data table css -->
		<link href="{{asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css')}}?v=<?php echo time(); ?>" rel="stylesheet" />
		<link href="{{asset('assets/plugins/datatable/responsive.bootstrap5.css')}}?v=<?php echo time(); ?>" rel="stylesheet" />
		<link href="{{asset('assets/plugins/datatable/buttonbootstrap.min.css')}}?v=<?php echo time(); ?>" rel="stylesheet" />

  		@endsection

  							@section('content')

							<!--Page header-->
							<div class="page-header d-xl-flex d-block">
								<div class="page-leftheader">
								<h4 class="page-title"><span class="font-weight-normal text-muted ms-2">{{trans('langconvert.adminmenu.report')}}</span></h4>
								</div>
							</div>
							<!--End Page header-->

							<!--Reports List-->
							<div class="row">
								<div class="col-xl-4 col-md-4 col-lg-4">
									<div class="card">
										<div class="card-header border-0">
											<h4 class="card-title">{{trans('langconvert.admindashboard.employees')}}</h4>
										</div>
										<div class="card-body">
											<div id="userchart" class=""></div>
											<div class="sales-chart pt-5 pb-3 d-flex mx-auto text-center justify-content-center ">
												<div class="d-flex me-5"><span class="dot-label bg-success me-2 my-auto"></span>{{trans('langconvert.admindashboard.active')}}</div>
												<div class="d-flex"><span class="dot-label bg-warning  me-2 my-auto"></span>{{trans('langconvert.admindashboard.inactive')}}</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-xl-4 col-md-4 col-lg-4">
									<div class="card">
										<div class="card-header border-0">
											<h4 class="card-title">{{trans('langconvert.adminmenu.customers')}}</h4>
										</div>
										<div class="card-body">
											<div id="customerchart" class=""></div>
											<div class="sales-chart pt-5 pb-3 d-flex mx-auto text-center justify-content-center ">
												<div class="d-flex me-5"><span class="dot-label bg-success me-2 my-auto"></span>{{trans('langconvert.admindashboard.active')}}</div>
												<div class="d-flex"><span class="dot-label bg-warning  me-2 my-auto"></span>{{trans('langconvert.admindashboard.inactive')}}</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-xl-4 col-md-4 col-lg-4">
									<div class="card">
										<div class="card-header border-0">
											<h4 class="card-title">{{trans('langconvert.menu.ticket')}}</h4>
										</div>
										<div class="card-body">
											<div id="ticketchart" class=""></div>
											<div class="sales-chart pt-5 pb-3 d-flex mx-auto text-center justify-content-center ">
												<div class="d-flex me-2"><span class="dot-label bg-success me-2 my-auto"></span>{{trans('langconvert.admindashboard.new')}}</div>
												<div class="d-flex me-2"><span class="dot-label bg-info  me-2 my-auto"></span>{{trans('langconvert.admindashboard.inprogress')}}</div>
												<div class="d-flex me-2"><span class="dot-label bg-warning  me-2 my-auto"></span>{{trans('langconvert.admindashboard.onhold')}}</div>
												<div class="d-flex me-2"><span class="dot-label bg-teal  me-2 my-auto"></span>{{trans('langconvert.admindashboard.reopen')}}</div>
												<div class="d-flex me-2"><span class="dot-label bg-danger  me-2 my-auto"></span>{{trans('langconvert.admindashboard.closed')}}</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-xl-12 col-md-12 col-lg-12">
									<div class="card">
										<div class="card-header border-0">
											<h4 class="card-title">{{trans('langconvert.admindashboard.employeereports')}}</h4>
										</div>
										<div class="card-body">
											<div class="table-responsive">
												<table class="table table-vcenter text-nowrap table-bordered w-100" id="reports">
													<thead>
														<tr>
															<th  width="10">{{trans('langconvert.admindashboard.id')}}</th>
															<th  width="10">{{trans('langconvert.admindashboard.slNo')}}</th>
															<th >{{trans('langconvert.admindashboard.employeeiD')}}</th>
															<th >{{trans('langconvert.admindashboard.name')}}</th>
															<th >{{trans('langconvert.admindashboard.rating')}}</th>
															<th >{{trans('langconvert.admindashboard.replycount')}}</th>
														</tr>
													</thead>
													<tbody>
												
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!--End Reports List-->

  							@endsection


  		@section('scripts')

		<!-- INTERNAL Apexchart js-->
		<script src="{{asset('assets/plugins/apexchart/apexcharts.js')}}?v=<?php echo time(); ?>"></script>

		<!-- INTERNAL Data tables -->
		<script src="{{asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}?v=<?php echo time(); ?>"></script>
		<script src="{{asset('assets/plugins/datatable/js/dataTables.bootstrap5.js')}}?v=<?php echo time(); ?>"></script>
		<script src="{{asset('assets/plugins/datatable/dataTables.responsive.min.js')}}?v=<?php echo time(); ?>"></script>
		<script src="{{asset('assets/plugins/datatable/responsive.bootstrap5.min.js')}}?v=<?php echo time(); ?>"></script>
		<script src="{{asset('assets/plugins/datatable/datatablebutton.min.js')}}?v=<?php echo time(); ?>"></script>
		<script src="{{asset('assets/plugins/datatable/buttonbootstrap.min.js')}}?v=<?php echo time(); ?>"></script>

		<script type="text/javascript">

			"use strict";

			// User Chart
			var userchart = {
				series: [{{$agentactivec}}, {{$agentinactive}}],
				chart: {
					height:300,
					type: 'donut',
				},
				dataLabels: {
					enabled: false
				},

				legend: {
					show: false,
				},
				stroke: {
					show: true,
					width:0
				},
				plotOptions: {
					pie: {
						donut: {
							size: '80%',
							background: 'transparent',
							labels: {
								show: true,
								name: {
									show: true,
									fontSize: '29px',
									color:'#6c6f9a',
									offsetY: -10
								},
								value: {
									show: true,
									fontSize: '26px',
									color: undefined,
									offsetY: 16,
									formatter: function (val) {
										return val
									}
								},
								total: 
								{
									show: true,
									showAlways: false,
									label: '{{trans('langconvert.admindashboard.total')}}',
									fontSize: '22px',
									fontWeight: 600,
									color: '#373d3f',
								}

							}
						}
					}
				},
				responsive: [{
					options: {
					legend: {
						show: false,
					}
					}
				}],
				labels: ["Active","Inactive"],
				colors: ['#0dcd94', '#fbc518'],
			};
			var chart = new ApexCharts(document.querySelector("#userchart"), userchart);
			chart.render();
  			// End User Chart
			  
  			// Customer Chart
			var customerchart = {
				series: [{{$customeractive}}, {{$customerinactive}}],
				chart: {
					height:300,
					type: 'donut',
				},
				dataLabels: {
					enabled: false
				},

				legend: {
					show: false,
				},
				stroke: {
					show: true,
					width:0
				},
				plotOptions: {
					pie: {
						donut: {
							size: '80%',
							background: 'transparent',
							labels: {
								show: true,
								name: {
									show: true,
									fontSize: '29px',
									color:'#6c6f9a',
									offsetY: -10
								},
								value: {
									show: true,
									fontSize: '26px',
									color: undefined,
									offsetY: 16,
									formatter: function (val) {
										return val
									}
								},
								total: {
									show: true,
									showAlways: false,
									label: '{{trans('langconvert.admindashboard.total')}}',
									fontSize: '22px',
									fontWeight: 600,
									color: '#373d3f',
								}

							}
						}
					}
				},
				responsive: [{
					options: {
						legend: {
							show: false,
						}
					}
				}],
				labels: ["Active","Inactive"],
				colors: ['#0dcd94', '#fbc518'],
			};
			var chart = new ApexCharts(document.querySelector("#customerchart"), customerchart);
			chart.render();
			// End Customer Chart

			// Ticket Chart
			var ticketchart = {
				series: [{{$newticket}},{{$inprogressticket}},{{$onholdticket}},{{$reopenticket}},{{$closedticket}}],
				chart: {
					height:300,
					type: 'donut',
				},
				dataLabels: {
					enabled: false
				},

				legend: {
					show: false,
				},
				stroke: {
					show: true,
					width:0
				},
				plotOptions: {
					pie: {
						donut: {
							size: '80%',
							background: 'transparent',
							labels: {
								show: true,
								name: {
									show: true,
									fontSize: '29px',
									color:'#6c6f9a',
									offsetY: -10
								},
								value: {
									show: true,
									fontSize: '26px',
									color: undefined,
									offsetY: 16,
									formatter: function (val) {
										return val
									}
								},
								total: {
									show: true,
									showAlways: false,
									label: '{{trans('langconvert.admindashboard.total')}}',
									fontSize: '22px',
									fontWeight: 600,
									color: '#373d3f',
								}

							}
						}
					}
				},
				responsive: [{
					options: {
						legend: {
							show: false,
						}
					}
				}],
				labels: ["New","Inprogress","On-Hold","Re-Open","Closed"],
				colors: ['#0dcd94','#128af9','#fbc518','#17d1dc','#f7284a'],
			};
			var chart = new ApexCharts(document.querySelector("#ticketchart"), ticketchart);
			chart.render();
			// End Ticket Chart

			(function ($) {

				// Datatable
				$('#reports').DataTable({
					processing: true,
					serverSide: true,
					ajax: {
						url: "{{ url('admin/reports') }}"
					},
					columns: [
						{data: 'id', name: 'id', 'visible': false},
						{data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false,searchable: false},
						{ data: 'empid', name: 'empid' },
						{ data: 'name', name: 'name' },
						{ data: 'rating', name: 'rating' },
						{data: 'replycount', name: 'replycount', orderable: false},
					],
					order:[],
					responsive: true,
					drawCallback: function () {
						var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
						var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
							return new bootstrap.Tooltip(tooltipTriggerEl)
						});
						$(".allemployeerating").starRating({
							readOnly: true,
							starSize: 25,
							emptyColor  :  '#ffffff',
							activeColor :  '#F2B827',
							strokeColor :  '#F2B827',
							strokeWidth :  15,
							useGradient : false
						});
						$('.form-select').select2({
							minimumResultsForSearch: Infinity,
							width: '100%'
						});
					},
				});

			})(jQuery);
		</script>
  @endsection