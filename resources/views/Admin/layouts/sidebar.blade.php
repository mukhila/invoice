<div class="app-sidebar-menu">
    <div class="h-100" data-simplebar>

        <!--- Sidemenu -->
        <div id="sidebar-menu">

            <div class="logo-box">
                <a href="{{ route('admin.dashboard') }}" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{ asset('assets/images/logo-sm.png') }}" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('assets/images/logo-light.png') }}" alt="" height="26">
                    </span>
                </a>
                <a href="{{ route('admin.dashboard') }}" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{ asset('assets/images/logo-sm.png') }}" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('assets/images/logo-dark.png') }}" alt="" height="26">
                    </span>
                </a>
            </div>

            <ul id="side-navbar">

                <li class="menu-title">Menu</li>

                <li>
                    <a href="{{ route('admin.dashboard') }}" class="tp-link">
                        <span class="nav-icon">
                            <iconify-icon icon="solar:widget-5-bold-duotone"></iconify-icon>
                        </span>
                        <span class="sidebar-text"> Dashboard </span>
                    </a>
                </li>

                <li class="menu-title mt-2">Super Admin</li>

                <li>
                    <a href="#sidebarEmployee" data-bs-toggle="collapse">
                        <span class="nav-icon">
                            <iconify-icon icon="solar:users-group-two-rounded-bold-duotone"></iconify-icon>
                        </span>
                        <span class="sidebar-text"> Employee </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarEmployee">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('admin.employees.create') }}" class="tp-link"><i class="ti ti-point"></i>Add Employee</a>
                            </li>
                            <li>
                                <a href="{{ route('admin.employees.index') }}" class="tp-link"><i class="ti ti-point"></i>List Employee</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#sidebarGoldPlan" data-bs-toggle="collapse">
                        <span class="nav-icon">
                            <iconify-icon icon="solar:crown-star-bold-duotone"></iconify-icon>
                        </span>
                        <span class="sidebar-text"> Gold Plan </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarGoldPlan">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('admin.gold-plans.create') }}" class="tp-link"><i class="ti ti-point"></i>Add Plan</a>
                            </li>
                            <li>
                                <a href="{{ route('admin.gold-plans.index') }}" class="tp-link"><i class="ti ti-point"></i>List Plan</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#sidebarUser" data-bs-toggle="collapse">
                        <span class="nav-icon">
                            <iconify-icon icon="solar:user-bold-duotone"></iconify-icon>
                        </span>
                        <span class="sidebar-text"> Users </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarUser">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('admin.users.create') }}" class="tp-link"><i class="ti ti-point"></i>Add User</a>
                            </li>
                            <li>
                                <a href="{{ route('admin.users.index') }}" class="tp-link"><i class="ti ti-point"></i>List Users</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#sidebarUserPlans" data-bs-toggle="collapse">
                        <span class="nav-icon">
                            <iconify-icon icon="solar:crown-bold-duotone"></iconify-icon>
                        </span>
                        <span class="sidebar-text"> User Plans </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarUserPlans">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('admin.assign-plan.create') }}" class="tp-link"><i class="ti ti-point"></i>Add User Plan</a>
                            </li>
                            <li>
                                <a href="{{ route('admin.all-user-plans.index') }}" class="tp-link"><i class="ti ti-point"></i>List User Plans</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#sidebarUserPayments" data-bs-toggle="collapse">
                        <span class="nav-icon">
                            <iconify-icon icon="solar:wallet-bold-duotone"></iconify-icon>
                        </span>
                        <span class="sidebar-text"> User Payments </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarUserPayments">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('admin.user-payments.monthly') }}" class="tp-link"><i class="ti ti-point"></i>Monthly Status</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#sidebarGoldRate" data-bs-toggle="collapse">
                        <span class="nav-icon">
                            <iconify-icon icon="solar:graph-up-bold-duotone"></iconify-icon>
                        </span>
                        <span class="sidebar-text"> Gold Rate </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarGoldRate">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('admin.gold-rates.create') }}" class="tp-link"><i class="ti ti-point"></i>Add Rate</a>
                            </li>
                            <li>
                                <a href="{{ route('admin.gold-rates.index') }}" class="tp-link"><i class="ti ti-point"></i>List Rate</a>
                            </li>
                        </ul>
                    </div>
                </li>

                


                <li class="menu-title mt-2">Account</li>

                <li>
                    <a href="{{ route('admin.password.change') }}" class="tp-link">
                         <span class="nav-icon">
                            <iconify-icon icon="solar:key-square-bold-duotone"></iconify-icon>
                        </span>
                        <span class="sidebar-text"> Password Change </span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.logout') }}" class="tp-link text-danger">
                         <span class="nav-icon">
                            <iconify-icon icon="solar:logout-2-bold-duotone"></iconify-icon>
                        </span>
                        <span class="sidebar-text"> Logout </span>
                    </a>
                </li>

            </ul>
        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
</div>
