
@extends('layouts.adminmaster')



                            @section('content')

                            <!--Page header-->
                            <div class="page-header d-xl-flex d-block">
                                <div class="page-leftheader">
                                    <h4 class="page-title"><span class="font-weight-normal text-muted ms-2">{{trans('langconvert.adminmenu.maintanacemode')}}</span></h4>
                                </div>
                            </div>
                            <!--End Page header-->

                            <!--Maintenance Mode-->
                            <div class="col-xl-12 col-lg-12 col-md-12">
                                <div class="card ">
                                    <div class="card-header border-0">
                                        <h4 class="card-title">{{trans('langconvert.adminmenu.maintanacemode')}}</h4>
                                    </div>
                                    <form method="POST" action="{{ route('maintanance') }}" enctype="multipart/form-data">
                                        @csrf

                                        @honeypot
                                        <div class="card-body" >
                                            <div class="status ">
                                                <div class="custom-controls-stacked d-md-flex" id="text">
                                                    <label class="form-label mt-1 me-5">{{trans('langconvert.admindashboard.status')}}</label>
                                                    <label class="custom-control form-radio success me-4">
                                                        <input type="radio" class="custom-control-input" name="maintenancemode" id="hold" value="off" @if (setting('MAINTENANCE_MODE') == 'off') checked @endif>
                                                        <span class="custom-control-label">{{trans('langconvert.admindashboard.golive')}}</span>
                                                    </label>
                                                    <label class="custom-control form-radio success me-4">
                                                        <input type="radio" class="custom-control-input" name="maintenancemode" id="onhold" value="on" @if (setting('MAINTENANCE_MODE') == 'on') checked @endif>
                                                        <span class="custom-control-label">{{trans('langconvert.admindashboard.undermaintenance')}}</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 card-footer ">
                                            <div class="form-group float-end">
                                                <input type="submit" class="btn btn-secondary" value="{{trans('langconvert.admindashboard.savechanges')}}" onclick="this.disabled=true;this.form.submit();">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- End Maintenance Mode-->
                            @endsection

        @section('scripts')

        <!-- enable the maintanance js-->
        <script type="text/javascript">

            "use strict";

            let hold = document.getElementById('onhold');
            
            let text = document.querySelector('.status');
            let hold1 = document.getElementById('hold');
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

                let label = document.createElement('label');
                label.setAttribute('class', 'form-label')
                label.innerText = '{{trans('langconvert.admindashboard.secretkey')}}';

                
                let newField = document.createElement('input');
                newField.setAttribute('type','text');
                newField.setAttribute('name','maintenancemode_value');
                newField.setAttribute('value',`{{ setting('MAINTENANCE_MODE_VALUE') ? setting('MAINTENANCE_MODE_VALUE'):str_random(10)}}`);
                newField.setAttribute('class',`form-control`);
                newField.setAttribute('readonly',``);
                newField.setAttribute('rows',3);
                newField.setAttribute('placeholder','Leave a message for On-Hold');

                let alertDiv = document.createElement('div');
                alertDiv.setAttribute('class','alert alert-light-warning note mt-4');

                let alertparagraph = document.createElement('p')
                alertparagraph.setAttribute('class','mb-0');
                alertparagraph.innerHTML = `<b> How to use Secret key? : </b> <br> <ol><li>Secret key is basically used to access your web url. When it is in <b>under maintenance mode.</b></li>
                <li>Now Copy your generated <b>Secret key</b> from inputfield and paste it in you url to access your web url in Maintenance mode <b>Ex: www.yourdomain/secretkey</b>.</li>
                 <li>And you can also allow other Networks or IP's to access your website by <b>sharing</b> your Secret key with them.</li></ol>`;

                Div.append(label);
                Div.append(newField);
                text.append(Div);
                alertDiv.append(alertparagraph);
                Div.append(alertDiv);
            }

                hold1.addEventListener('click',()=>{
                    
                    let myobj = document.getElementById("holdremove");
                    myobj?.remove();
                    status = false

                }, false)
           
        </script>

        @endsection
