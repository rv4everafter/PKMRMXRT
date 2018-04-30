<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-title">
                {{ __('menus.backend.sidebar.general') }}
            </li>

            <li class="nav-item">
                <a class="nav-link {{ active_class(Active::checkUriPattern('admin/dashboard')) }}" href="{{ route('admin.dashboard') }}"  style="padding-left: 3px">
                    <i class="icon-speedometer" style="margin-right: 0"></i> {{ __('menus.backend.sidebar.dashboard') }}
                </a>
            </li>

            <li class="nav-title">
                {{ __('menus.backend.sidebar.system') }}
            </li>

            @if ($logged_in_user->isAdmin())
<!--                <li class="nav-item nav-dropdown {{ active_class(Active::checkUriPattern('admin/auth/admin*'), 'open') }} {{ active_class(Active::checkUriPattern('admin/auth/role*'), 'open') }}">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="icon-user"></i> {{ __('menus.backend.access.title') }}

                        @if ($pending_approval > 0)
                            <span class="badge badge-danger">{{ $pending_approval }}</span>
                        @endif
                    </a>

                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/auth/admin*')) }}" href="{{ route('admin.auth.admin.index') }}">
                                {{ __('labels.backend.access.admins.management') }}

                                @if ($pending_approval > 0)
                                    <span class="badge badge-danger">{{ $pending_approval }}</span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/auth/role*')) }}" href="{{ route('admin.auth.role.index') }}">
                                {{ __('labels.backend.access.roles.management') }}
                            </a>
                        </li>
                    </ul>
                </li>-->
                <li class="nav-item nav-dropdown {{ active_class(Active::checkUriPattern('admin/auth/user*'), 'open') }}">
                    <a class="nav-link nav-dropdown-toggle" href="javascript:void(0)" style="padding-left: 3px">
                        <i class="icon-user" style="margin-right: 0"></i> {{ __('menus.backend.access.title1') }}

                        @if (isset($inactive) && $inactive > 0)
                            <span class="badge badge-danger">{{ $inactive }}</span>
                        @endif
                    </a>

                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/auth/user')) }}" href="{{ route('admin.auth.user.index') }}">
                                {{ __('labels.backend.access.users.management') }}

                                @if (isset($active) && $active > 0)
                                    <span class="badge badge-success">{{ $active }}</span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/auth/user/deactivated')) }}" href="{{ route('admin.auth.user.deactivated') }}">
                                {{ __('labels.backend.access.users.deactivated') }}

                                @if (isset($inactive) && $inactive > 0)
                                    <span class="badge badge-danger">{{ $inactive }}</span>
                                @endif
                            </a>
                        </li> 
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/auth/user/deleted')) }}" href="{{ route('admin.auth.user.deleted') }}">
                                {{ __('labels.backend.access.users.deleted') }}

                                @if (isset($deletedUsers) && $deletedUsers > 0)
                                    <span class="badge badge-danger">{{ $deletedUsers }}</span>
                                @endif
                            </a>
                        </li>
                    </ul>
                </li> 
                <li class="nav-item nav-dropdown {{ active_class(Active::checkUriPattern('admin/auth/commission*'), 'open') }}">
                    <a class="nav-link nav-dropdown-toggle" href="javascript:void(0)" style="padding-left: 3px">
                        <i class="icon-user" style="margin-right: 0"></i> {{ __('menus.backend.access.title2') }}
                    </a>

                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/auth/commission/pending')) }}" href="{{ route('admin.auth.commission.pending') }}">
                                {{ __('labels.backend.access.commission.pending') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/auth/commission/payment')) }}" href="{{ route('admin.auth.commission.payment') }}">
                                {{ __('labels.backend.access.commission.payment') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/auth/commission/completed')) }}" href="{{ route('admin.auth.commission.completed') }}">
                                {{ __('labels.backend.access.commission.completed') }}
                            </a>
                        </li>
                    </ul>
                </li>
                
            @endif

<!--            <li class="nav-item nav-dropdown {{ active_class(Active::checkUriPattern('admin/log-viewer*'), 'open') }}">
                <a class="nav-link nav-dropdown-toggle" href="#">
                    <i class="icon-list"></i> {{ __('menus.backend.log-viewer.main') }}
                </a>

                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link {{ active_class(Active::checkUriPattern('admin/log-viewer')) }}" href="{{ route('log-viewer::dashboard') }}">
                            {{ __('menus.backend.log-viewer.dashboard') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ active_class(Active::checkUriPattern('admin/log-viewer/logs*')) }}" href="{{ route('log-viewer::logs.list') }}">
                            {{ __('menus.backend.log-viewer.logs') }}
                        </a>
                    </li>
                </ul>
            </li>-->
        </ul>
    </nav>
</div><!--sidebar-->