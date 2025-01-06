<!-- sidebar menu area start -->
<div class="sidebar-menu">
    <div class="sidebar-header">
        <div class="logo">
            <!-- <a href="index.html"><img src="{{ asset('assets/admin/images/icon/logo.png') }}" alt="logo"></a> -->
            <p style="color:#fff; text-decoration: underline;">News Dashboard</p>
        </div>
    </div>
    <div class="main-menu">
        <div class="menu-inner">
            <nav>
                <ul class="metismenu" id="menu">
                    <li @if(isset($activeMenu)) @if($activeMenu=='dashboard' ) class="active" @endif @endif>
                        <a href="{{ url('/dashboard') }}"><i class="ti-dashboard"></i><span>dashboard</span></a>
                       
                    </li>

                    @if((isset(Auth::user()->roleId) && Auth::user()->roleId == 1) || Auth::user()->hasPermission(config('constants.NEWS_MANAGER')))
                       <li @if(isset($activeMenu)) @if($activeMenu=='news' ) class="active" @endif @endif>
                        <a href="javascript:void(0)" aria-expanded="true"><i
                                class="ti-layout-sidebar-left"></i><span>News Manager
                            </span></a>

                        <ul class="collapse">
                           
                            <li><a href="{{ url('/news') }}">Manage News</a></li>
                            <li><a href="{{ url('/news/create') }}">Add News</a></li>
                        </ul>
                    </li>
                    @endif


                    @if((isset(Auth::user()->roleId) && Auth::user()->roleId == 1) || Auth::user()->hasPermission(config('constants.LANDING_PAGE_MANAGER')))
                    <li @if(isset($activeMenu)) @if($activeMenu=='Landing Page' ) class="active" @endif @endif>
                        <a href="javascript:void(0)" aria-expanded="true"><i
                                class="ti-layout-sidebar-left"></i><span>Landing Page Manager
                            </span></a>

                        <ul class="collapse">
                            <li><a href="{{ url('/landing-page') }}">Manage Landing Pages</a></li>
                            <li><a href="{{ url('/landing-page/create') }}">Add Landing page</a></li>


                        </ul>
                    </li>
                    @endif


                    @if((isset(Auth::user()->roleId) && Auth::user()->roleId == 1) || Auth::user()->hasPermission(config('constants.MENU_MANAGER')))
                    <li @if(isset($activeMenu)) @if($activeMenu=='Menu Manager' ) class="active" @endif @endif>
                        <a href="javascript:void(0)" aria-expanded="true"><i
                                class="ti-layout-sidebar-left"></i><span>Menu Manager
                            </span></a>
                        <ul class="collapse">
                            <li><a href="{{ url('/menu') }}">Manage Menu</a></li>
                            <li><a href="{{ url('/menu/create') }}">Add Menu</a></li>
                        </ul>
                    </li>
                    @endif





                    @if((isset(Auth::user()->roleId) && Auth::user()->roleId == 1) || Auth::user()->hasPermission(config('constants.MENU_MANAGER')))
                    <li @if(isset($activeMenu)) @if($activeMenu=='Custom Menu Manager' ) class="active" @endif @endif>
                        <a href="javascript:void(0)" aria-expanded="true"><i
                                class="ti-layout-sidebar-left"></i><span>Custom Menu Manager
                            </span></a>
                        <ul class="collapse">
                            <li><a href="{{ url('/menu-unit') }}">Manage Menu</a></li>
                            <li><a href="{{ url('/menu-unit/create') }}">Add Menu</a></li>
                        </ul>
                    </li>
                    @endif


                    
                    @if((isset(Auth::user()->roleId) && Auth::user()->roleId == 1) || Auth::user()->hasPermission(config('constants.MENU_MANAGER')))
                    <li @if(isset($activeMenu)) @if($activeMenu=='Media' ) class="active" @endif @endif>
                        <a href="javascript:void(0)" aria-expanded="true"><i
                                class="ti-layout-sidebar-left"></i><span>Media
                            </span></a>
                        <ul class="collapse">
                            <li><a href="{{ url('/media') }}">Manage Media</a></li>
                            <li><a href="{{ url('/media/create') }}">Add Media</a></li>
                        </ul>
                    </li>
                    @endif




                    @if((isset(Auth::user()->roleId) && Auth::user()->roleId == 1) || Auth::user()->hasPermission(config('constants.MENU_MANAGER')))
                    <li @if(isset($activeMenu)) @if($activeMenu=='Media Category' ) class="active" @endif @endif>
                        <a href="javascript:void(0)" aria-expanded="true"><i
                                class="ti-layout-sidebar-left"></i><span>Media Category
                            </span></a>
                        <ul class="collapse">
                            <li><a href="{{ url('/media-category') }}">Manage Category</a></li>
                            <li><a href="{{ url('/media-category/create') }}">Add Category</a></li>
                        </ul>
                    </li>
                    @endif

                  



                    @if((isset(Auth::user()->roleId) && Auth::user()->roleId == 1) || Auth::user()->hasPermission(config('constants.CATEGORY_MANAGER')))
                    <li @if(isset($activeMenu)) @if($activeMenu=='News Category' ) class="active" @endif @endif>
                        <a href="javascript:void(0)" aria-expanded="true"><i
                                class="ti-layout-sidebar-left"></i><span>News Category
                            </span></a>
                        <ul class="collapse">
                            <li><a href="{{ url('/news-category') }}">Manage Category</a></li>
                            <li><a href="{{ url('/news-category/create') }}">Add Category</a></li>
                        </ul>
                    </li>
                    @endif


                    {{-- <li @if(isset($activeMenu)) @if($activeMenu=='News Sub Category' ) class="active" @endif @endif>
                        <a href="javascript:void(0)" aria-expanded="true"><i
                                class="ti-layout-sidebar-left"></i><span>News Sub Category
                            </span></a>


                        <ul class="collapse">
                            <li><a href="{{ url('/news-sub-category') }}">Manage Category</a></li>
                            <li><a href="{{ url('/news-sub-category/create') }}">Add Category</a></li>


                        </ul>
                    </li> --}}


                  
                  
                   

                    {{-- @if(isset(Auth::user()->roleId))
                    @if(Auth::user()->roleId == 1) --}}


                    {{-- <li @if(isset($activeMenu)) @if($activeMenu=='master' ) class="active" @endif @endif>
                        <a href="javascript:void(0)" aria-expanded="true"><i
                                class="ti-layout-sidebar-left"></i><span>Master MGMT
                            </span></a>


                          

                          

                    </li> --}}

                    {{-- @endif
                    @endif --}}
 
                    {{-- @if(isset(Auth::user()->roleId))
                    @if(Auth::user()->roleId == 1)
     --}}

     @if((isset(Auth::user()->roleId) && Auth::user()->roleId == 1) || Auth::user()->hasPermission(config('constants.GENERAL_SETTING_MANAGER')))
                    <li @if(isset($activeMenu)) @if($activeMenu=='generalSettings' ) class="active" @endif @endif>
                        <a href="javascript:void(0)" aria-expanded="true"><i
                                class="ti-layout-sidebar-left"></i><span>General Settings
                            </span></a>
                        <ul class="collapse">    
                            <li><a href="{{ url('/general-settings/home-page-setting') }}">Home Page Setting</a></li>
                            <li><a href="{{ url('/general-settings/website-logo-setting') }}">Global Setting</a></li>
    
    
                        </ul>
                    </li>
                    @endif
                   


                    {{-- @if(isset(Auth::user()->roleId))
                    @if(Auth::user()->roleId == 1) --}}
    
                    @if((isset(Auth::user()->roleId) && Auth::user()->roleId == 1) || Auth::user()->hasPermission(config('constants.CONTACT_LEADS')))
                    <li @if(isset($activeMenu)) @if($activeMenu=='contact leads' ) class="active" @endif @endif>
                        <a href="javascript:void(0)" aria-expanded="true"><i
                                class="ti-layout-sidebar-left"></i><span>Contact Leads
                            </span></a>
                        <ul class="collapse">
                            <li><a href="{{ url('/contact/leads') }}">Manage</a></li>
                        </ul>
                    </li>
                     @endif
                    
                  

                  

                    {{-- @if(isset(Auth::user()->roleId))
                    @if(Auth::user()->roleId == 1) --}}

                   

                    {{-- <li @if(isset($activeMenu)) @if($activeMenu=='contact' ) class="active" @endif @endif>
                        <a href="javascript:void(0)" aria-expanded="true"><i
                                class="ti-layout-sidebar-left"></i><span>Contact
                            </span></a>


                        <ul class="collapse">
                            <li><a href="{{ url('/contact') }}">Manage Contact</a></li>
                            <li><a href="{{ url('/contact/create') }}">Add Contact</a></li>


                        </ul>
                    </li> --}}
                    @if((isset(Auth::user()->roleId) && Auth::user()->roleId == 1))

                    <li @if(isset($activeMenu)) @if($activeMenu=='permissionHead' ) class="active" @endif @endif>
                        <a href="javascript:void(0)" aria-expanded="true"><i
                                class="ti-layout-sidebar-left"></i><span>Permission Head
                            </span></a>

                        <ul class="collapse">
                            <li><a href="{{ url('/permission') }}">Manage</a></li>
                            <li><a href="{{ url('/permission/create') }}">Add</a></li>
                        </ul>
                    </li>
                    @endif


                    @if((isset(Auth::user()->roleId) && Auth::user()->roleId == 1) || Auth::user()->hasRole('admin'))
                    <li @if(isset($activeMenu)) @if($activeMenu=='user' ) class="active" @endif @endif>
                        <a href="javascript:void(0)" aria-expanded="true"><i
                                class="ti-layout-sidebar-left"></i><span>User
                            </span></a>
                        <ul class="collapse">
                            <li><a href="{{ url('/user') }}">Manage Users</a></li>
                            <li><a href="{{ url('/user/create') }}">Add User</a></li>


                        </ul>
                    </li>
                    @endif


                    @if((isset(Auth::user()->roleId) && Auth::user()->roleId == 1) || Auth::user()->hasRole('admin'))
                    <li @if(isset($activeMenu)) @if($activeMenu=='role' ) class="active" @endif @endif>
                        <a href="javascript:void(0)" aria-expanded="true"><i
                                class="ti-layout-sidebar-left"></i><span>Role
                            </span></a>

                        <ul class="collapse">
                            <li><a href="{{ url('/role') }}">Manage Role</a></li>
                            <li><a href="{{ url('/role/create') }}">Add Role</a></li>
                        </ul>
                    </li>
    
                    @endif
                  


                  
                   
                    {{-- @endif
                    @endif --}}


                </ul>
            </nav>
        </div>
    </div>
</div>
<!-- sidebar menu area end -->