@auth
    <div class="main-sidebar sidebar-style-2">
        <aside id="sidebar-wrapper">
            <div class="sidebar-brand">
                    <span class="logo-name">{{ env('APP_NAME') }}</span>
            </div>
            {{-- <x-notify::notify /> --}}
            <ul class="sidebar-menu">
                <li class="menu-header">Main</li>
                <li class="dropdown">
                  <a href="{{route('admin.dashboard')}}" class="nav-link"><i data-feather="monitor"></i><span>Dashboard</span></a>
                </li>
                @can('form-view')
                    <li @class(['dropdown','active'=>request()->routeIs('admin.form.*')])>
                    <a href="{{route('admin.form.index')}}" class="nav-link"><i data-feather="code"></i><span>Form</span></a>
                    </li>
                @endcan
                <li @class(['dropdown','active'=>request()->routeIs('admin.data.*')]) >
                  <a href="{{route('admin.role.index')}}" class="nav-link"><i data-feather="codepen"></i><span>data</span></a>
                </li>
                @can('role-view')
                <li @class(['dropdown','active'=>request()->routeIs('admin.roles.*')]) >
                  <a href="{{route('admin.roles.index')}}" class="nav-link"><i data-feather="codepen"></i><span>roles and permissions</span></a>
                </li>
                @endcan
                @can('user-view')
                <li class="dropdown @if (in_array(Route::current()->getName(), ['admin.users.index'])) active @endif">
                    <a href="{{ route('admin.users.index') }}" class="nav-link"><i class="fa-solid fa-user"></i><span> Users </span></a>
                </li>
                @endcan
            </ul>
        </aside>
    </div>
@endauth
