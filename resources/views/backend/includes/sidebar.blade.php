<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">

            <li class="nav-item">
                <a class="nav-link {{
                    active_class(Route::is('admin/dashboard'))
                }}" href="{{ route('admin.dashboard') }}">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    @lang('menus.backend.sidebar.dashboard')
                </a>
            </li>

            @if ($logged_in_user->isAdmin())
                {{--  <li class="nav-title">
                    @lang('menus.backend.sidebar.system')
                </li>  --}}

                <li class="nav-item nav-dropdown {{active_class(Route::is('admin/auth*'), 'open') }}">
                    <a class="nav-link nav-dropdown-toggle {{
                        active_class(Route::is('admin/auth*'))
                    }}" data-bs-toggle="collapse" href="#collapseExamplea" role="button" aria-expanded="false" aria-controls="collapseExample">
                        <i class="nav-icon far fa-user"></i>
                        @lang('menus.backend.access.title')

                        @if ($pending_approval > 0)
                            <span class="badge badge-danger">{{ $pending_approval }}</span>
                        @endif
                    </a>
                    <div class="collapse" id="collapseExamplea">
                    <ul class="">
                        <li class="">
                            <a class="nav-link {{
                                active_class(Route::is('admin/auth/user*'))
                            }}" href="{{ route('admin.auth.user.index') }}" >
                                @lang('labels.backend.access.users.allUsers')

                                @if ($pending_approval > 0)
                                    <span class="badge badge-danger">{{ $pending_approval }}</span>
                                @endif
                            </a>
                        </li>
                        {{--  <li class="nav-item">
                            <a class="nav-link {{
                                active_class(Route::is('admin/auth/role*'))
                            }}" href="{{ route('admin.auth.role.index') }}">
                                @lang('labels.backend.access.roles.management')
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{
                                active_class(Route::is('admin/auth/permission*'))
                            }}" href="{{ route('admin.auth.permission.index') }}">
                                @lang('labels.backend.access.permissions.management')
                            </a>
                        </li>  --}}
                    </ul>
                    </div>
                </li>

                <li class="divider"></li>


                <li class="nav-item nav-dropdown {{active_class(Route::is('admin/package*'), 'open') }}">
                    <a class="nav-link nav-dropdown-toggle {{
                        active_class(Route::is('admin/package*'))
                    }}" data-bs-toggle="collapse" href="#package" role="button" aria-expanded="false" aria-controls="collapseExample">
                        <i class="nav-icon far fa-bar"></i>
                        @lang('menus.backend.access.title')

                        @if ($pending_approval > 0)
                            <span class="badge badge-danger">{{ $pending_approval }}</span>
                        @endif
                    </a>
                    <div class="collapse" id="package">
                    <ul class="">
                        <li class="">
                            <a class="nav-link {{
                                active_class(Route::is('admin/auth/package*'))
                            }}" href="{{ route('admin.auth.user.index') }}" >
                                @lang('labels.backend.access.users.package')

                                @if ($pending_approval > 0)
                                    <span class="badge badge-danger">{{ $pending_approval }}</span>
                                @endif
                            </a>
                        </li>
                        {{--  <li class="nav-item">
                            <a class="nav-link {{
                                active_class(Route::is('admin/auth/role*'))
                            }}" href="{{ route('admin.auth.role.index') }}">
                                @lang('labels.backend.access.roles.management')
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{
                                active_class(Route::is('admin/auth/permission*'))
                            }}" href="{{ route('admin.auth.permission.index') }}">
                                @lang('labels.backend.access.permissions.management')
                            </a>
                        </li>  --}}
                    </ul>
                    </div>
                </li>


                <li class="divider"></li>

                {{--  <li class="nav-item nav-dropdown {{
                    active_class(Route::is('admin/log-viewer*'), 'open') }}">
                        <a class="nav-link nav-dropdown-toggle {{
                            active_class(Route::is('admin/log-viewer*'))
                        }}" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                        <i class="nav-icon fas fa-list"></i> @lang('menus.backend.log-viewer.main')
                    </a>
                    <div class="collapse" id="collapseExample">
                    <ul class="" >
                        <li class="">
                            <a class="nav-link {{
                            active_class(Route::is('admin/log-viewer'))
                        }}" href="{{ route('log-viewer::dashboard') }}">
                                @lang('menus.backend.log-viewer.dashboard')
                            </a>
                        </li>
                        <li class="">
                            <a class="nav-link {{
                            active_class(Route::is('admin/log-viewer/logs*'))
                        }}" href="{{ route('log-viewer::logs.list') }}">
                                @lang('menus.backend.log-viewer.logs')
                            </a>
                        </li>
                    </ul>
                    </div>
                </li>  --}}
            @endif
        </ul>
    </nav>

    {{--  <button class="sidebar-minimizer brand-minimizer" type="button"></button>  --}}
</div><!--sidebar-->
