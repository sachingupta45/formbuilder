@auth
    <div class="main-sidebar sidebar-style-2">
        <aside id="sidebar-wrapper">
            <div class="sidebar-brand">
                    <span class="logo-name">{{ __('Sachin Gupta') }}</span>
            </div>
            {{-- <x-notify::notify /> --}}
            <ul class="sidebar-menu">
                <li class="menu-header">Main</li>
                <li class="dropdown">
                  <a href="{{route('admin.dashboard')}}" class="nav-link"><i data-feather="monitor"></i><span>Dashboard</span></a>
                </li>
                <li @class(['dropdown','active'=>request()->routeIs('admin.form.*')])>
                  <a href="{{route('admin.form.index')}}" class="nav-link"><i data-feather="code"></i><span>Form</span></a>
                </li>
                <li @class(['dropdown','active'=>request()->routeIs('admin.data.*')]) >
                  <a href="{{route('admin.role.index')}}" class="nav-link"><i data-feather="codepen"></i><span>data</span></a>
                </li>
            </ul>
        </aside>
    </div>
@endauth
