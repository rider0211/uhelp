                    <!--aside open-->
                    <aside class="app-sidebar">
                        <div class="app-sidebar__logo">
                            <a class="header-brand" href="{{url('admin')}}">
                                {{--Logo--}}
                                @if ($title->image == null)

                                <img src="{{asset('uploads/logo/logo/logo-white.png')}}" class="header-brand-img dark-logo" alt="logo">
                                @else

                                <img src="{{asset('uploads/logo/logo/'.$title->image)}}" class="header-brand-img dark-logo" alt="logo">
                                @endif

                                {{--Dark-Logo--}}
                                @if ($title->image1 == null)

                                <img src="{{asset('uploads/logo/darklogo/logo.png')}}" class="header-brand-img desktop-lgo" alt="dark-logo">
                                @else

                                <img src="{{asset('uploads/logo/darklogo/'.$title->image1)}}" class="header-brand-img desktop-lgo" alt="dark-logo">
                                @endif

                                {{--Mobile-Logo--}}
                                @if ($title->image2 == null)

                                <img src="{{asset('uploads/logo/icon/icon.png')}}" class="header-brand-img mobile-logo" alt="mobile-logo">
                                @else

                                <img src="{{asset('uploads/logo/icon/'.$title->image2)}}" class="header-brand-img mobile-logo" alt="mobile-logo">
                                @endif

                                {{--Mobile-Dark-Logo--}}
                                @if ($title->image3 == null)

                                <img src="{{asset('uploads/logo/darkicon/icon-white.png')}}" class="header-brand-img darkmobile-logo" alt="mobile-dark-logo">
                                @else

                                <img src="{{asset('uploads/logo/darkicon/'.$title->image3)}}" class="header-brand-img darkmobile-logo" alt="mobile-dark-logo">
                                @endif

                            </a>
                        </div>
                        <div class="app-sidebar3">
                            <div class="app-sidebar__user">
                                <div class="dropdown user-pro-body text-center">
                                    <div class="user-pic">
                                        @if (Auth::user()->image == null)

                                            <img src="{{asset('uploads/profile/user-profile.png')}}" class="avatar-xxl rounded-circle mb-1" alt="default">
                                        @else

                                            <img src="{{asset('uploads/profile/'.Auth::user()->image)}}" class="avatar-xxl rounded-circle mb-1" alt="{{Auth::user()->image}}">
                                        @endif

                                    </div>
                                    <div class="user-info">
                                        <h5 class=" mb-2">{{Auth::user()->name}}</h5>
                                        @if(!empty(Auth::user()->getRoleNames()[0]))

                                        <span class="text-muted app-sidebar__user-name text-sm">{{ Auth::user()->getRoleNames()[0]}}</span>
                                        @endif
                                        @php
                                         use App\Models\usersettings;
                                           if(Auth::check() && Auth::user()->id){
                                                $avgrating1 = usersettings::where('users_id', Auth::id())->sum('star1');
                                                $avgrating2 = usersettings::where('users_id', Auth::id())->sum('star2');
                                                $avgrating3 = usersettings::where('users_id', Auth::id())->sum('star3');
                                                $avgrating4 = usersettings::where('users_id', Auth::id())->sum('star4');
                                                $avgrating5 = usersettings::where('users_id', Auth::id())->sum('star5');

                                                $avgr = ((5*$avgrating5) + (4*$avgrating4) + (3*$avgrating3) + (2*$avgrating2) + (1*$avgrating1));
                                                $avggr = ($avgrating1 + $avgrating2 + $avgrating3 + $avgrating4 + $avgrating5);

                                                if($avggr == 0){
                                                    $avggr = 1;
                                                    $avg1 = $avgr/$avggr;
                                                }else{
                                                    $avg1 = $avgr/$avggr;
                                                }



                                            }
                                        @endphp

                                        <div class="allprofilerating pt-1" data-rating="{{$avg1}}"></div>
                                    </div>
                                </div>
                            </div>
                            <ul class="side-menu custom-ul">

                                <li class="slide">
                                    <a class="side-menu__item"  href="{{url('admin/')}}">
                                        <svg  class="sidemenu_icon" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M19 5v2h-4V5h4M9 5v6H5V5h4m10 8v6h-4v-6h4M9 17v2H5v-2h4M21 3h-8v6h8V3zM11 3H3v10h8V3zm10 8h-8v10h8V11zm-10 4H3v6h8v-6z"/></svg>
                                        <span class="side-menu__label">{{trans('langconvert.menu.dashboard')}}</span>
                                    </a>
                                </li>
                                <li class="slide">
                                    <a class="side-menu__item"  href="{{url('/admin/profile')}}">
                                        <svg  class="sidemenu_icon" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M12 6c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2m0 9c2.7 0 5.8 1.29 6 2v1H6v-.99c.2-.72 3.3-2.01 6-2.01m0-11C9.79 4 8 5.79 8 8s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4zm0 9c-2.67 0-8 1.34-8 4v3h16v-3c0-2.66-5.33-4-8-4z"/></svg>
                                        <span class="side-menu__label">{{trans('langconvert.menu.profile')}}</span>
                                    </a>
                                </li>
                                @can('Ticket Access')

                                <li class="slide">
                                    <a class="side-menu__item" data-bs-toggle="slide" href="#">
                                        <svg class="sidemenu_icon" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><path d="M0 0h24v24H0z" fill="none"/><path d="M22 10V6c0-1.11-.9-2-2-2H4c-1.1 0-1.99.89-1.99 2v4c1.1 0 1.99.9 1.99 2s-.89 2-2 2v4c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2v-4c-1.1 0-2-.9-2-2s.9-2 2-2zm-2-1.46c-1.19.69-2 1.99-2 3.46s.81 2.77 2 3.46V18H4v-2.54c1.19-.69 2-1.99 2-3.46 0-1.48-.8-2.77-1.99-3.46L4 6h16v2.54zM11 15h2v2h-2zm0-4h2v2h-2zm0-4h2v2h-2z"/></svg>
                                        <span class="side-menu__label">{{trans('langconvert.menu.ticket')}}</span><i class="angle fa fa-angle-right"></i>
                                    </a>
                                    <ul class="slide-menu custom-ul">
                                        @can('Ticket Create')

                                        <li><a href="{{url('/admin/createticket')}}" class="slide-item">{{trans('langconvert.adminmenu.createticket')}}</a></li>
                                        @endcan

                                        @can('All Tickets')

                                        <li><a href="{{url('/admin/alltickets')}}" class="slide-item">{{trans('langconvert.adminmenu.alltickets')}}</a></li>
                                        @endcan
                                        @can('My Tickets')

                                        <li><a href="{{url('/admin/myticket')}}" class="slide-item">{{trans('langconvert.adminmenu.mytickets')}}</a></li>
                                        @endcan
                                        @can('Active Tickets')

                                        <li><a href="{{url('/admin/activeticket')}}" class="slide-item">{{trans('langconvert.adminmenu.activetickets')}}</a></li>
                                        @endcan
                                        @can('Closed Tickets')

                                        <li><a href="{{url('/admin/closedticket')}}" class="slide-item">{{trans('langconvert.adminmenu.closetickets')}}</a></li>
                                        @endcan
                                        @can('Assigned Tickets')

                                        <li><a href="{{url('/admin/assignedtickets')}}" class="slide-item">{{trans('langconvert.adminmenu.assigntickets')}}</a></li>
                                        @endcan
                                        @can('My Assigned Tickets')

                                        <li><a href="{{url('/admin/myassignedtickets')}}" class="slide-item">{{trans('langconvert.adminmenu.myassigntickets')}}</a></li>
                                        @endcan
                                        @can('Onhold Tickets')

                                        <li><a href="{{route('admin.onholdticket')}}" class="slide-item"> {{trans('langconvert.adminmenu.onholdtickets')}} </a></li>
                                        @endcan
                                        @can('Overdue Tickets')

                                        <li><a href="{{route('admin.overdueticket')}}" class="slide-item"> {{trans('langconvert.adminmenu.overduetickets')}}</a></li>
                                        @endcan

                                    </ul>
                                </li>
                                @endcan
                                @can('Categories Access')

                                <li class="slide">
                                    <a class="side-menu__item" data-bs-toggle="slide" href="#">
                                        <svg class="sidemenu_icon" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><path d="M0 0h24v24H0V0z" fill="none"></path><path d="M12 2l-5.5 9h11L12 2zm0 3.84L13.93 9h-3.87L12 5.84zM17.5 13c-2.49 0-4.5 2.01-4.5 4.5s2.01 4.5 4.5 4.5 4.5-2.01 4.5-4.5-2.01-4.5-4.5-4.5zm0 7c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5zM3 21.5h8v-8H3v8zm2-6h4v4H5v-4z"></path></svg>
                                        <span class="side-menu__label">{{trans('langconvert.adminmenu.categories')}}</span><i class="angle fa fa-angle-right"></i>
                                    </a>
                                    <ul class="slide-menu custom-ul">
                                        @can('Category Access')

                                        <li><a href="{{url('/admin/categories')}}" class="slide-item">{{trans('langconvert.newwordslang.maincategories')}}</a></li>
                                        @endcan

                                        @can('Subcategory Access')

                                        <li><a href="{{url('/admin/subcategories')}}" class="slide-item">{{trans('langconvert.newwordslang.subcategory')}}</a></li>
                                        @endcan
                                    </ul>
                                </li>
                                
                                @endcan
                                @can('Knowledge Access')

                                <li class="slide">
                                    <a class="side-menu__item" data-bs-toggle="slide" href="#">
                                        <svg class="sidemenu_icon" xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><g><rect fill="none" height="24" width="24"/></g><g><g/><g><path d="M17,19.22H5V7h7V5H5C3.9,5,3,5.9,3,7v12c0,1.1,0.9,2,2,2h12c1.1,0,2-0.9,2-2v-7h-2V19.22z"/><path d="M19,2h-2v3h-3c0.01,0.01,0,2,0,2h3v2.99c0.01,0.01,2,0,2,0V7h3V5h-3V2z"/><rect height="2" width="8" x="7" y="9"/><polygon points="7,12 7,14 15,14 15,12 12,12"/><rect height="2" width="8" x="7" y="15"/></g></g></svg>
                                        <span class="side-menu__label">{{trans('langconvert.menu.knowledge')}}</span><i class="angle fa fa-angle-right"></i>
                                    </a>
                                    <ul class="slide-menu custom-ul">
                                        
                                        @can('Article Access')

                                        <li><a href="{{url('/admin/article')}}" class="slide-item">{{trans('langconvert.adminmenu.articles')}}</a></li>
                                        @endcan

                                    </ul>
                                </li>
                                @endcan
                                @can('Project Access')

                                <li class="slide">
                                    <a class="side-menu__item"  href="{{url('/admin/projects')}}">
                                        <svg class="sidemenu_icon" xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><g><rect fill="none" height="24" width="24"/><g><path d="M19,5v14H5V5H19 M19,3H5C3.9,3,3,3.9,3,5v14c0,1.1,0.9,2,2,2h14c1.1,0,2-0.9,2-2V5C21,3.9,20.1,3,19,3L19,3z"/></g><path d="M14,17H7v-2h7V17z M17,13H7v-2h10V13z M17,9H7V7h10V9z"/></g></svg>
                                        <span class="side-menu__label">{{trans('langconvert.adminmenu.projects')}}</span>
                                    </a>
                                </li>
                                @endcan
                                @can('Managerole Access')

                                <li class="slide">
                                    <a class="side-menu__item" data-bs-toggle="slide" href="#">
                                        <svg class="sidemenu_icon" xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><g><path d="M0,0h24v24H0V0z" fill="none"/></g><g><g><path d="M4,18v-0.65c0-0.34,0.16-0.66,0.41-0.81C6.1,15.53,8.03,15,10,15c0.03,0,0.05,0,0.08,0.01c0.1-0.7,0.3-1.37,0.59-1.98 C10.45,13.01,10.23,13,10,13c-2.42,0-4.68,0.67-6.61,1.82C2.51,15.34,2,16.32,2,17.35V20h9.26c-0.42-0.6-0.75-1.28-0.97-2H4z"/><path d="M10,12c2.21,0,4-1.79,4-4s-1.79-4-4-4C7.79,4,6,5.79,6,8S7.79,12,10,12z M10,6c1.1,0,2,0.9,2,2s-0.9,2-2,2 c-1.1,0-2-0.9-2-2S8.9,6,10,6z"/><path d="M20.75,16c0-0.22-0.03-0.42-0.06-0.63l1.14-1.01l-1-1.73l-1.45,0.49c-0.32-0.27-0.68-0.48-1.08-0.63L18,11h-2l-0.3,1.49 c-0.4,0.15-0.76,0.36-1.08,0.63l-1.45-0.49l-1,1.73l1.14,1.01c-0.03,0.21-0.06,0.41-0.06,0.63s0.03,0.42,0.06,0.63l-1.14,1.01 l1,1.73l1.45-0.49c0.32,0.27,0.68,0.48,1.08,0.63L16,21h2l0.3-1.49c0.4-0.15,0.76-0.36,1.08-0.63l1.45,0.49l1-1.73l-1.14-1.01 C20.72,16.42,20.75,16.22,20.75,16z M17,18c-1.1,0-2-0.9-2-2s0.9-2,2-2s2,0.9,2,2S18.1,18,17,18z"/></g></g></svg>
                                        <span class="side-menu__label">{{trans('langconvert.adminmenu.manageroles')}}</span><i class="angle fa fa-angle-right"></i>
                                    </a>
                                    <ul class="slide-menu custom-ul">
                                        @can('Roles & Permission Access')

                                        <li><a href="{{url('/admin/role')}}" class="slide-item">{{trans('langconvert.adminmenu.rolespermission')}}</a></li>
                                        @endcan
                                        @can('Roles & Permission Create')

                                        <li><a href="{{url('/admin/employee/create')}}" class="slide-item">{{trans('langconvert.adminmenu.createemployee')}}</a></li>
                                        @endcan
                                        @can('Employee Access')

                                        <li><a href="{{url('/admin/employee')}}" class="slide-item">{{trans('langconvert.adminmenu.employeeslist')}}</a></li>
                                        @endcan

                                    </ul>
                                </li>
                                @endcan
                                @can('Landing Page Access')

                                <li class="slide">
                                    <a class="side-menu__item" data-bs-toggle="slide" href="#">
                                        <svg class="sidemenu_icon" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M3 17v2h6v-2H3zM3 5v2h10V5H3zm10 16v-2h8v-2h-8v-2h-2v6h2zM7 9v2H3v2h4v2h2V9H7zm14 4v-2H11v2h10zm-6-4h2V7h4V5h-4V3h-2v6z"/></svg>
                                        <span class="side-menu__label">{{trans('langconvert.adminmenu.landingpagesetting')}}</span><i class="angle fa fa-angle-right"></i>
                                    </a>
                                    <ul class="slide-menu custom-ul">
                                        @can('Banner Access')

                                        <li><a href="{{url('/admin/bannersetting')}}" class="slide-item">{{trans('langconvert.adminmenu.banner')}}</a></li>
                                        @endcan
                                        @can('Feature Box Access')

                                        <li><a href="{{url('/admin/feature-box')}}" class="slide-item">{{trans('langconvert.adminmenu.featurebox')}}</a></li>
                                        @endcan
                                        @can('Call To Action Access')

                                        <li><a href="{{url('/admin/call-to-action')}}" class="slide-item">{{trans('langconvert.adminmenu.callactionbox')}}</a></li>
                                        @endcan
                                        @can('Testimonial Access')

                                        <li><a href="{{url('/admin/testimonial')}}" class="slide-item">{{trans('langconvert.adminmenu.testimonial')}}</a></li>
                                        @endcan
                                        @can('FAQs Access')

                                        <li><a href="{{url('/admin/faq')}}" class="slide-item">{{trans('langconvert.menu.faq')}}</a></li>
                                        @endcan

                                    </ul>
                                </li>
                                @endcan
                                @can('Customers Access')

                                <li class="slide">
                                    <a class="side-menu__item"  href="{{url('/admin/customer')}}">
                                        <svg class="sidemenu_icon" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M9 13.75c-2.34 0-7 1.17-7 3.5V19h14v-1.75c0-2.33-4.66-3.5-7-3.5zM4.34 17c.84-.58 2.87-1.25 4.66-1.25s3.82.67 4.66 1.25H4.34zM9 12c1.93 0 3.5-1.57 3.5-3.5S10.93 5 9 5 5.5 6.57 5.5 8.5 7.07 12 9 12zm0-5c.83 0 1.5.67 1.5 1.5S9.83 10 9 10s-1.5-.67-1.5-1.5S8.17 7 9 7zm7.04 6.81c1.16.84 1.96 1.96 1.96 3.44V19h4v-1.75c0-2.02-3.5-3.17-5.96-3.44zM15 12c1.93 0 3.5-1.57 3.5-3.5S16.93 5 15 5c-.54 0-1.04.13-1.5.35.63.89 1 1.98 1 3.15s-.37 2.26-1 3.15c.46.22.96.35 1.5.35z"/></svg>
                                        <span class="side-menu__label">{{trans('langconvert.adminmenu.customers')}}</span>
                                    </a>
                                </li>
                                @endcan

                                @php $module = Module::all(); @endphp

                                @if(in_array('Uhelpupdate', $module))
                                @can('Canned Response Access')

                                <li class="slide">
                                    <a class="side-menu__item"  href="{{route('admin.cannedmessages')}}">
                                        <svg class="sidemenu_icon" xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><g><rect fill="none" height="24" width="24"/></g><g><g><polygon points="16.6,10.88 15.18,9.46 10.94,13.71 8.82,11.58 7.4,13 10.94,16.54"/><path d="M19,4H5C3.89,4,3,4.9,3,6v12c0,1.1,0.89,2,2,2h14c1.1,0,2-0.9,2-2V6C21,4.9,20.11,4,19,4z M19,18H5V8h14V18z"/></g></g></svg>
                                        <span class="side-menu__label">{{trans('langconvert.newwordslang.cannedresponse')}}</span>
                                    </a>
                                </li>
                                @endcan
                                @can('Envato Access')
                                @if(setting('ENVATO_ON') == 'on')

                                <li class="slide">
                                    <a class="side-menu__item" data-bs-toggle="slide" href="#">
                                        <svg class="sidemenu_icon" style="enable-background:new 0 0 512 512; width: 18px; height: 18px;" version="1.1" viewBox="0 0 512 512"  xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                            <g id="_x38_5-envato"><g><g><g><path d="M401.225,19.381c-17.059-8.406-103.613,1.196-166.01,61.218      c-98.304,98.418-95.947,228.089-95.947,228.089s-3.248,13.335-17.086-6.011c-30.305-38.727-14.438-127.817-12.651-140.23      c2.508-17.494-8.615-17.999-13.243-12.229c-109.514,152.46-10.616,277.288,54.136,316.912      c75.817,46.386,225.358,46.354,284.922-85.231C509.547,218.042,422.609,29.875,401.225,19.381L401.225,19.381z M401.225,19.381"/></g></g></g></g><g id="Layer_1"/></svg>
                                        <span class="side-menu__label">{{trans('langconvert.newwordslang.envato')}}</span><i class="angle fa fa-angle-right"></i>
                                    </a>
                                    <ul class="slide-menu custom-ul">

                                        @can('Envato API Token Access')

                                        <li>
                                            <a href="{{route('admin.envatoapitoken')}}" class="slide-item">{{trans('langconvert.newwordslang.envatolicense')}}</a>
                                        </li>
                                        @endcan
                                        @can('Envato License Details Access')

                                        <li>
                                            <a href="{{route('admin.envatolicensesearch')}}" class="slide-item">{{trans('langconvert.newwordslang.envatolicensesearch')}}</a>
                                        </li>
                                        @endcan

                                    </ul>
                                </li>
                                @endif
                                @endcan
                                @can('App Info Access')

                                <li class="slide">
                                    <a class="side-menu__item" data-bs-toggle="slide" href="#">
                                        <svg class="sidemenu_icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24px" fill="#000000"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M11 7h2v2h-2zm0 4h2v6h-2zm1-9C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/></svg>
                                        <span class="side-menu__label">{{trans('langconvert.newwordslang.appinfo')}}</span><i class="angle fa fa-angle-right"></i>
                                    </a>
                                    <ul class="slide-menu custom-ul">
                                        @can('App Purchase Code Access')

                                        <li>
                                            <a href="{{route('admin.licenseinfo')}}" class="slide-item">{{trans('langconvert.newwordslang.appcode')}}</a>
                                        </li>
                                        @endcan

                                    </ul>
                                </li>
                                @endcan
                                @endif
                                
                                @can('Groups Access')

                                <li class="slide">
                                    <a class="side-menu__item" data-bs-toggle="slide" href="#">
                                        <svg class="sidemenu_icon" xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><rect fill="none" height="24" width="24"/><g><path d="M4,13c1.1,0,2-0.9,2-2c0-1.1-0.9-2-2-2s-2,0.9-2,2C2,12.1,2.9,13,4,13z M5.13,14.1C4.76,14.04,4.39,14,4,14 c-0.99,0-1.93,0.21-2.78,0.58C0.48,14.9,0,15.62,0,16.43V18l4.5,0v-1.61C4.5,15.56,4.73,14.78,5.13,14.1z M20,13c1.1,0,2-0.9,2-2 c0-1.1-0.9-2-2-2s-2,0.9-2,2C18,12.1,18.9,13,20,13z M24,16.43c0-0.81-0.48-1.53-1.22-1.85C21.93,14.21,20.99,14,20,14 c-0.39,0-0.76,0.04-1.13,0.1c0.4,0.68,0.63,1.46,0.63,2.29V18l4.5,0V16.43z M16.24,13.65c-1.17-0.52-2.61-0.9-4.24-0.9 c-1.63,0-3.07,0.39-4.24,0.9C6.68,14.13,6,15.21,6,16.39V18h12v-1.61C18,15.21,17.32,14.13,16.24,13.65z M8.07,16 c0.09-0.23,0.13-0.39,0.91-0.69c0.97-0.38,1.99-0.56,3.02-0.56s2.05,0.18,3.02,0.56c0.77,0.3,0.81,0.46,0.91,0.69H8.07z M12,8 c0.55,0,1,0.45,1,1s-0.45,1-1,1s-1-0.45-1-1S11.45,8,12,8 M12,6c-1.66,0-3,1.34-3,3c0,1.66,1.34,3,3,3s3-1.34,3-3 C15,7.34,13.66,6,12,6L12,6z"/></g></svg>
                                        <span class="side-menu__label">{{trans('langconvert.adminmenu.groups')}}</span><i class="angle fa fa-angle-right"></i>
                                    </a>
                                    <ul class="slide-menu custom-ul">
                                        @can('Groups Create')

                                        <li><a href="{{url('/admin/groups/create')}}" class="slide-item">{{trans('langconvert.adminmenu.creategroup')}}</a></li>
                                        @endcan
                                        @can('Groups List Access')

                                        <li><a href="{{url('/admin/groups')}}" class="slide-item">{{trans('langconvert.adminmenu.grouplist')}}</a></li>
                                        @endcan

                                    </ul>
                                </li>
                                @endcan

                                <li class="slide">
                                    <a class="side-menu__item" data-bs-toggle="slide" href="#">
                                        <svg class="sidemenu_icon" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.9 2 2 2zm6-6v-5c0-3.07-1.63-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.64 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2zm-2 1H8v-6c0-2.48 1.51-4.5 4-4.5s4 2.02 4 4.5v6z"/></svg>
                                        <span class="side-menu__label">{{trans('langconvert.adminmenu.notification')}}</span><i class="angle fa fa-angle-right"></i>
                                    </a>
                                    <ul class="slide-menu custom-ul">
                                        <li><a href="{{route('notificationpage')}}" class="slide-item smark-all" >{{trans('langconvert.adminmenu.allnotifys')}}</a></li>

                                        @can('Custom Notifications Access')

                                        <li><a href="{{route('mail.index')}}" class="slide-item">{{trans('langconvert.adminmenu.customnotify')}}</a></li>
                                        @endcan

                                    </ul>
                                </li>
                                @can('Custom Pages Access')

                                <li class="slide">
                                    <a class="side-menu__item" data-bs-toggle="slide" href="#">
                                        <svg class="sidemenu_icon" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M11.99 18.54l-7.37-5.73L3 14.07l9 7 9-7-1.63-1.27zM12 16l7.36-5.73L21 9l-9-7-9 7 1.63 1.27L12 16zm0-11.47L17.74 9 12 13.47 6.26 9 12 4.53z"/></svg>
                                        <span class="side-menu__label">{{trans('langconvert.adminmenu.custompages')}}</span><i class="angle fa fa-angle-right"></i>
                                    </a>
                                    <ul class="slide-menu custom-ul">
                                        @can('Pages Access')

                                        <li><a href="{{url('/admin/pages')}}" class="slide-item">{{trans('langconvert.adminmenu.pages')}}</a></li>
                                        @endcan
                                        @can('404 Error Page Access')

                                        <li><a href="{{url('/admin/error404')}}" class="slide-item">{{trans('langconvert.adminmenu.404errorpage')}}</a></li>
                                        @endcan
                                        @can('Under Maintanance Page Access')

                                        <li><a href="{{url('/admin/maintenancepage')}}" class="slide-item">{{trans('langconvert.adminmenu.undermaintanenece')}}</a></li>
                                        @endcan

                                    </ul>
                                </li>
                                @endcan
                                @can('App Setting Access')

                                <li class="slide">
                                    <a class="side-menu__item" data-bs-toggle="slide" href="#">
                                        <svg class="sidemenu_icon" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M19.43 12.98c.04-.32.07-.64.07-.98 0-.34-.03-.66-.07-.98l2.11-1.65c.19-.15.24-.42.12-.64l-2-3.46c-.09-.16-.26-.25-.44-.25-.06 0-.12.01-.17.03l-2.49 1c-.52-.4-1.08-.73-1.69-.98l-.38-2.65C14.46 2.18 14.25 2 14 2h-4c-.25 0-.46.18-.49.42l-.38 2.65c-.61.25-1.17.59-1.69.98l-2.49-1c-.06-.02-.12-.03-.18-.03-.17 0-.34.09-.43.25l-2 3.46c-.13.22-.07.49.12.64l2.11 1.65c-.04.32-.07.65-.07.98 0 .33.03.66.07.98l-2.11 1.65c-.19.15-.24.42-.12.64l2 3.46c.09.16.26.25.44.25.06 0 .12-.01.17-.03l2.49-1c.52.4 1.08.73 1.69.98l.38 2.65c.03.24.24.42.49.42h4c.25 0 .46-.18.49-.42l.38-2.65c.61-.25 1.17-.59 1.69-.98l2.49 1c.06.02.12.03.18.03.17 0 .34-.09.43-.25l2-3.46c.12-.22.07-.49-.12-.64l-2.11-1.65zm-1.98-1.71c.04.31.05.52.05.73 0 .21-.02.43-.05.73l-.14 1.13.89.7 1.08.84-.7 1.21-1.27-.51-1.04-.42-.9.68c-.43.32-.84.56-1.25.73l-1.06.43-.16 1.13-.2 1.35h-1.4l-.19-1.35-.16-1.13-1.06-.43c-.43-.18-.83-.41-1.23-.71l-.91-.7-1.06.43-1.27.51-.7-1.21 1.08-.84.89-.7-.14-1.13c-.03-.31-.05-.54-.05-.74s.02-.43.05-.73l.14-1.13-.89-.7-1.08-.84.7-1.21 1.27.51 1.04.42.9-.68c.43-.32.84-.56 1.25-.73l1.06-.43.16-1.13.2-1.35h1.39l.19 1.35.16 1.13 1.06.43c.43.18.83.41 1.23.71l.91.7 1.06-.43 1.27-.51.7 1.21-1.07.85-.89.7.14 1.13zM12 8c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4zm0 6c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z"/></svg>
                                        <span class="side-menu__label">{{trans('langconvert.adminmenu.appsetting')}}</span><i class="angle fa fa-angle-right"></i>
                                    </a>
                                    <ul class="slide-menu custom-ul">
                                        @can('General Setting Access')

                                        <li><a href="{{url('/admin/general')}}" class="slide-item">{{trans('langconvert.adminmenu.generalsetting')}}</a></li>
                                        @endcan
                                        @can('Ticket Setting Access')

                                        <li><a href="{{url('/admin/ticketsetting')}}" class="slide-item">{{trans('langconvert.adminmenu.ticketsetting')}}</a></li>
                                        @endcan
                                        @can('SEO Access')

                                        <li><a href="{{url('/admin/seo')}}" class="slide-item">{{trans('langconvert.adminmenu.seo')}}</a></li>
                                        @endcan
                                        @can('Google Analytics Access')

                                        <li><a href="{{url('/admin/googleanalytics')}}" class="slide-item">{{trans('langconvert.adminmenu.googleanalytics')}}</a></li>
                                        @endcan
                                        @can('Custom JS & CSS Access')

                                        <li><a href="{{url('/admin/customcssjssetting')}}" class="slide-item">{{trans('langconvert.adminmenu.customjscss')}}</a></li>
                                        @endcan
                                        @can('Captcha Setting Access')

                                        <li><a href="{{url('/admin/captcha')}}" class="slide-item">{{trans('langconvert.adminmenu.captchasetting')}}</a></li>
                                        @endcan
                                        @can('Social Logins Access')

                                        <li><a href="{{url('/admin/sociallogin')}}" class="slide-item">{{trans('langconvert.adminmenu.sociallogin')}}</a></li>
                                        @endcan
                                        @can('Email Setting Access')

                                        <li><a href="{{url('/admin/emailsetting')}}" class="slide-item">{{trans('langconvert.adminmenu.emailsetting')}}</a></li>
                                        @endcan
                                        @can('Custom Chat Access')

                                        <li><a href="{{url('/admin/customchatsetting')}}" class="slide-item">{{trans('langconvert.admindashboard.externalchat')}}</a></li>
                                        @endcan
                                        @can('Maintenance Mode Access')

                                        <li><a href="{{url('/admin/maintenancemode')}}" class="slide-item">{{trans('langconvert.adminmenu.maintanacemode')}}</a></li>
                                        @endcan
                                        @can('SecruitySetting Access')

                                        <li><a href="{{url('/admin/securitysetting')}}" class="slide-item">{{trans('langconvert.adminmenu.securitysetting')}}</a></li>
                                        @endcan
                                        @can('IpBlock Access')

                                        <li><a href="{{route('ipblocklist')}}" class="slide-item">{{trans('langconvert.adminmenu.iplist')}}</a></li>
                                        @endcan
                                        @can('Emailtoticket Access')

                                        <li><a href="{{route('admin.emailtoticket')}}" class="slide-item">{{trans('langconvert.adminmenu.emailtoticket')}}</a></li>
                                        @endcan

                                    </ul>
                                </li>
                                @endcan
                                @can('Announcements Access')

                                <li class="slide">
                                    <a class="side-menu__item"  href="{{url('/admin/announcement')}}">
                                        <svg class="sidemenu_icon" xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><g><rect fill="none" height="24" width="24"/></g><path d="M18,11c0,0.67,0,1.33,0,2c1.2,0,2.76,0,4,0c0-0.67,0-1.33,0-2C20.76,11,19.2,11,18,11z"/><path d="M16,17.61c0.96,0.71,2.21,1.65,3.2,2.39c0.4-0.53,0.8-1.07,1.2-1.6c-0.99-0.74-2.24-1.68-3.2-2.4 C16.8,16.54,16.4,17.08,16,17.61z"/><path d="M20.4,5.6C20,5.07,19.6,4.53,19.2,4c-0.99,0.74-2.24,1.68-3.2,2.4c0.4,0.53,0.8,1.07,1.2,1.6 C18.16,7.28,19.41,6.35,20.4,5.6z"/><path d="M4,9c-1.1,0-2,0.9-2,2v2c0,1.1,0.9,2,2,2h1v4h2v-4h1l5,3V6L8,9H4z M9.03,10.71L11,9.53v4.94l-1.97-1.18L8.55,13H8H4v-2h4 h0.55L9.03,10.71z"/><path d="M15.5,12c0-1.33-0.58-2.53-1.5-3.35v6.69C14.92,14.53,15.5,13.33,15.5,12z"/></svg>
                                        <span class="side-menu__label">{{trans('langconvert.adminmenu.announcements')}}</span>
                                    </a>
                                </li>
                                @endcan
                                @can('Email Template Access')

                                <li class="slide">
                                    <a class="side-menu__item"  href="{{url('/admin/emailtemplates')}}">
                                        <svg class="sidemenu_icon" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M22 6c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6zm-2 0l-8 5-8-5h16zm0 12H4V8l8 5 8-5v10z"/></svg>
                                        <span class="side-menu__label">{{trans('langconvert.adminmenu.emailtemplate')}}</span>
                                    </a>
                                </li>
                                @endcan
                                @can('Reports Access')

                                <li class="slide">
                                    <a class="side-menu__item"  href="{{url('/admin/reports')}}">
                                        <svg class="sidemenu_icon" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M19.5 3.5L18 2l-1.5 1.5L15 2l-1.5 1.5L12 2l-1.5 1.5L9 2 7.5 3.5 6 2 4.5 3.5 3 2v20l1.5-1.5L6 22l1.5-1.5L9 22l1.5-1.5L12 22l1.5-1.5L15 22l1.5-1.5L18 22l1.5-1.5L21 22V2l-1.5 1.5zM19 19.09H5V4.91h14v14.18zM6 15h12v2H6zm0-4h12v2H6zm0-4h12v2H6z"/></svg>
                                        <span class="side-menu__label">{{trans('langconvert.adminmenu.report')}}</span>
                                    </a>
                                </li>
                                @endcan

                            </ul>

                        </div>
                    </aside>
                    <!--aside closed-->

