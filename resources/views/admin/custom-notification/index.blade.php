@extends('layouts.adminmaster')

        @section('styles')

		<!-- INTERNAL Data table css -->
		<link href="{{asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css')}}?v=<?php echo time(); ?>" rel="stylesheet" />
		<link href="{{asset('assets/plugins/datatable/responsive.bootstrap5.css')}}?v=<?php echo time(); ?>" rel="stylesheet" />

        <!-- INTERNAL Sweet-Alert css -->
		<link href="{{asset('assets/plugins/sweet-alert/sweetalert.css')}}?v=<?php echo time(); ?>" rel="stylesheet" />

        @endsection

                            @section('content')

                            <!--Page header-->
                            <div class="page-header d-lg-flex d-block">
                                <div class="page-leftheader">
                                    <h4 class="page-title">
                                        <span class="font-weight-normal text-muted ms-2">{{trans('langconvert.adminmenu.customnotify')}}</span>
                                    </h4>
                                </div>
                                <div class="page-rightheader ms-md-auto">
                                    <div class="d-flex align-items-end flex-wrap my-auto end-content breadcrumb-end">
                                        <div class="d-flex">
                                            <div class="btn-list">
                                                @can('Custom Notifications Employee')

                                                <a href="{{route('mail.employee')}}" class="btn btn-success">{{trans('langconvert.admindashboard.composetoemployees')}}</a>
                                                @endcan
                                                @can('Custom Notifications Customer')

                                                <a href="{{route('mail.customer')}}" class="btn btn-info ">{{trans('langconvert.admindashboard.composetocustomers')}}</a>
                                                @endcan

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--End Page header-->

                            <!-- Custom Notification List -->
                            <div class="row">
                                <div class="col-md-12 col-lg-12 col-xl-12">
                                    <div class="card">
                                        <div class="card-header border-0">
                                            <h4 class="card-title">{{trans('langconvert.admindashboard.customnotificationslist')}}</h4>
                                        </div>
                                        <div class="card-body" >
                                            <div class="table-responsive spruko-delete">
                                                @can('Custom Notifications Delete')

                                                <button id="massdeletenotify" class="btn btn-outline-light btn-sm mb-4 data-table-btn"><i class="fe fe-trash"></i> {{trans('langconvert.admindashboard.delete')}}</button>
                                                @endcan

                                                <table class="table table-vcenter text-nowrap table-bordered table-striped w-100 ticketdeleterow" id="customnotifications">
                                                    <thead>
                                                        <tr>
                                                            <th  width="10">{{trans('langconvert.admindashboard.id')}}</th>
                                                            <th  width="10">{{trans('langconvert.admindashboard.slNo')}}</th>
                                                            @cannot('Custom Notifications Delete')
                                                            
                                                            <th width="10" >
                                                                <input type="checkbox"  id="customCheckAll" disabled>
                                                                <label  for="customCheckAll"></label>
                                                            </th>
                                                            @endcannot
                                                            @can('Custom Notifications Delete')

                                                            <th width="10" >
                                                                <input type="checkbox"  id="customCheckAll" >
                                                                <label  for="customCheckAll"></label>
                                                            </th>
                                                            @endcan
                                                            
                                                            <th >{{trans('langconvert.admindashboard.name')}}</th>
                                                            <th >{{trans('langconvert.admindashboard.usertype')}}</th>
                                                            <th >{{trans('langconvert.admindashboard.subject')}}</th>
                                                            <th >{{trans('langconvert.admindashboard.actions')}}</th>
                                                        </tr>
                                                    </thead>

                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                
                                </div>
                            </div>
                            <!-- End Custom Notification List -->
                            @endsection

        @section('scripts')
		
		<!-- INTERNAL Vertical-scroll js-->
		<script src="{{asset('assets/plugins/vertical-scroll/jquery.bootstrap.newsbox.js')}}"></script>

		<!-- INTERNAL Data tables -->
		<script src="{{asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
		<script src="{{asset('assets/plugins/datatable/js/dataTables.bootstrap5.js')}}"></script>
		<script src="{{asset('assets/plugins/datatable/dataTables.responsive.min.js')}}"></script>
		<script src="{{asset('assets/plugins/datatable/responsive.bootstrap5.min.js')}}"></script>

		<!-- INTERNAL Sweet-Alert js-->
		<script src="{{asset('assets/plugins/sweet-alert/sweetalert.min.js')}}"></script>

        <script type="text/javascript">

			"use strict";

			(function($)  {

                // Csrf field
                $.ajaxSetup({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                
                // Datatable
                $('#customnotifications').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('mail.index') }}"
                    },
                    columns: [
                        {data: 'id', name: 'id', 'visible': false},
                        {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false,searchable: false},
                        {data: 'checkbox', name: 'checkbox', orderable: false,searchable: false},
                        {data: 'user', name: 'user' },
                        {data: 'usertype', name: 'usertype' },
                        {data: 'mailsubject', name: 'mailsubject' },
                        {data: 'action', name: 'action', orderable: false},
                    ],
					order:[],
					responsive: true,
					drawCallback: function () {
						var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
						var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
							return new bootstrap.Tooltip(tooltipTriggerEl)
						});
                        $('.form-select').select2({
							minimumResultsForSearch: Infinity,
							width: '100%'
						});
                        $('#customCheckAll').prop('checked', false);

                        $('.checkall').on('click', function(){
							if($('.checkall:checked').length == $('.checkall').length){
								$('#customCheckAll').prop('checked', true);
							}else{
								$('#customCheckAll').prop('checked', false);
							}
						});
					},
                });
                
                // Mass Delete 
                $('body').on('click', '#massdeletenotify', function () {
                    var id = [];
                    $('.checkall:checked').each(function(){
                        id.push($(this).val());
                    });
                    if(id.length > 0){
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
                                    url:"{{ route('notifyall.delete')}}",
                                    method:"post",
                                    data:{id:id},
                                    success:function(data)
                                    {
                                        $('#customnotifications').DataTable().ajax.reload();
                                        toastr.error(data.error);
                                                    
                                    },
                                    error:function(data){
                                        console.log(data);
                                    }
                                });
                            }   
                        });        
                    }else{
                        toastr.error('{{trans('langconvert.functions.checkboxselect')}}');
                    }
                });

                // Checkbox check all
                $('#customCheckAll').on('click', function() {
                    $('.checkall').prop('checked', this.checked);
                });

            })(jQuery);

            // View the custom notification
            function viewc(event) {
                var id  = $(event).data("id");
                let _url = `{{url('/admin/customnotification/${id}')}}`;
                $('#questionError').text('');
                $('#answerError').text('');
                $.ajax({
                    url: _url,
                    type: "GET",
                    success: function(response) {
                        if(response) {
                            $(".modal-title").text('View CustomNotification');
                            $("#mailsubject").html(response.mailsubject);
                            $("#mailtest").html(response.mailtext);
                            $('#addfaq').modal('show');
                            
                        }
                    }
                });
            }

            // Delete the custom notification
            function deletecustom(event) {
                var id  = $(event).data("id");
                let _url = `{{url('/admin/customnotification/delete/${id}')}}`;
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
                                var oTable = $('#customnotifications').dataTable();
                                oTable.fnDraw(false);
                                toastr.error(response.error);
                            },
                            error: function (data) {
                                console.log('Error:', data);
                            }
                        });
                    }
                });
            }
            
        </script>

        @endsection
            @section('modal')

            @include('admin.custom-notification.model')
            
            @endsection

