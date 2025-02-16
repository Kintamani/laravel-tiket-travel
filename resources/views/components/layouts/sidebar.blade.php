<!--begin::Sidebar-->
<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">

    <!--begin::Sidebar Brand-->
    <div class="sidebar-brand">
        <!--begin::Brand Link-->
        <a href="./index.html" class="brand-link">
            <!--begin::Brand Image-->
            <img src="{{ asset('dist/assets/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
                class="brand-image opacity-75 shadow" />
            <!--end::Brand Image-->
            <!--begin::Brand Text-->
            <span class="brand-text fw-light">AdminLTE 4</span>
            <!--end::Brand Text-->
        </a>
        <!--end::Brand Link-->
    </div>
    <!--end::Sidebar Brand-->

    <!--begin::Sidebar Wrapper-->
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <!--begin::Sidebar Menu-->
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                <li class="nav-header">MENU</li>
                <li class="nav-item">
                    <a href="{{ route('home') }}" class="nav-link {{ Route::is('home') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-speedometer"></i>
                        <p class="text">Dashboard</p>
                    </a>
                </li>

                @if (auth()->user()->hasRole('admin'))
                    <li class="nav-item">
                        <a href="{{ route('schedules.index') }}"
                            class="nav-link {{ Route::is('schedules.*') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-bus-front"></i>
                            <p class="text">Schedules</p>
                        </a>
                    </li>
                @endif

                <li class="nav-item {{ Route::is('tickets.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Route::is('tickets.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-ticket"></i>
                        <p> Ticket <i class="nav-arrow bi bi-chevron-right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        @if (auth()->user()->hasRole('penumpang'))
                        <li class="nav-item">
                            <a href="{{ route('tickets.available') }}"
                                class="nav-link {{ Route::is('tickets.available') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Available Tickets</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('tickets.history') }}"
                                class="nav-link {{ Route::is('tickets.history') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>History Tickets</p>
                            </a>
                            
                        </li>
                        @endif
                        @if (auth()->user()->hasRole('admin'))
                            <li class="nav-item">
                                <a href="{{ route('tickets.report') }}"
                                    class="nav-link {{ Route::is('tickets.report') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-circle"></i>
                                    <p>Report</p>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            </ul>

            <!--end::Sidebar Menu-->
        </nav>
    </div>
    <!--end::Sidebar Wrapper-->
</aside>
<!--end::Sidebar-->
