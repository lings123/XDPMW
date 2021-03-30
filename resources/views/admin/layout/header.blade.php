
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{route('admin-index')}}">Admin Page</a>
            </div>
            <!-- /.navbar-header -->

            
           
                       <ul class="nav navbar-top-links navbar-right">
                         @if(Auth::guard('admins')->check())
                    <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                       
                        <i class="fa fa-user fa-fw"></i> Hi Admin {{Auth::guard('admins')->user()->first_name}} {{Auth::guard('admins')->user()->last_name}} <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                     
                        <li><a href="admin/logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                        
                         @endif
                            

                    </ul>
                    <!-- /.dropdown-user -->
                </li>
            </ul>
        </nav>
                    <!-- /.dropdown-user -->
                
                <!-- /.dropdown -->
            
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                            <!-- /input-group -->
                        </li>
                         <li>
                            <a href="{{ route('trang-chu')}}"><i class="fa fa-home fa-fw"></i>Home</a>
                        </li>
                        <li>
                            <a href="{{ route('admin-index')}}"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                        <li>
                            <a href="javascript:void(0)"><i class="fa fa-bar-chart-o fa-fw"></i> Danh mục<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{ route('listdanhmuc') }}">Danh sách</a>
                                </li>
                                <li>
                                    <a href="admin/san-pham/them">Thêm</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="javascript:void(0)"><i class="fa fa-cube fa-fw"></i> Sản phẩm<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="admin/san-pham/danh-sach">Danh sách</a>
                                </li>
                                
                                <li>
                                    <a href="{{ route('themsanpham') }}">Thêm</a>
                                </li>
                                
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="javascript:void(0)"><i class="fa fa-bar-chart-o fa-fw"></i> Đơn hàng<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="admin/don-hang/danh-sach">Danh sách</a>
                                </li>
                                
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        
                        <li>
                            <a href="javascript:void(0)"><i class="fa fa-cube fa-fw"></i> Thương hiệu<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="admin/thuong-hieu/danh-sach">Danh sách</a>
                                </li>
                                <li>
                                    <a href="admin/thuong-hieu/them">Thêm</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="javascript:void(0)"><i class="fa fa-users fa-fw"></i> User<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="admin/user/danh-sach">Danh sách</a>
                                </li>
                                <li>
                                    <a href="admin/user/them">Thêm</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li> 
                        <li>
                            <a href="javascript:void(0)"><i class="fa fa-cube fa-fw"></i> Kích thước<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="admin/size/danh-sach">Danh sách</a>
                                </li>
                                <li>
                                    <a href="admin/size/them">Thêm</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li> 
                        
                       
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>