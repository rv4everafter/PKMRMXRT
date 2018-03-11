<li class="breadcrumb-menu">
    <div class="btn-group" role="group" aria-label="Button group">
        <div class="dropdown">
            <a class="btn dropdown-toggle" href="#" role="button" id="breadcrumb-dropdown-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ __('menus.backend.access.admins.main') }}</a>

            <div class="dropdown-menu" aria-labelledby="breadcrumb-dropdown-1">
                <a class="dropdown-item" href="{{ route('admin.auth.admin.index') }}">{{ __('menus.backend.access.admins.all') }}</a>
                <a class="dropdown-item" href="{{ route('admin.auth.admin.create') }}">{{ __('menus.backend.access.admins.create') }}</a>
                <a class="dropdown-item" href="{{ route('admin.auth.admin.deactivated') }}">{{ __('menus.backend.access.admins.deactivated') }}</a>
                <a class="dropdown-item" href="{{ route('admin.auth.admin.deleted') }}">{{ __('menus.backend.access.admins.deleted') }}</a>
            </div>
        </div><!--dropdown-->

        <!--<a class="btn" href="#">Static Link</a>-->
    </div><!--btn-group-->
</li>