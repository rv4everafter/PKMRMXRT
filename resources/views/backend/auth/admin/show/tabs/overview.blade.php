<div class="col">
    <div class="table-responsive">
        <table class="table table-hover">
            <tr>
                <th>{{ __('labels.backend.access.admins.tabs.content.overview.avatar') }}</th>
                <td><img src="{{ $admin->picture }}" class="admin-profile-image" /></td>
            </tr>

            <tr>
                <th>{{ __('labels.backend.access.admins.tabs.content.overview.name') }}</th>
                <td>{{ $admin->name }}</td>
            </tr>

            <tr>
                <th>{{ __('labels.backend.access.admins.tabs.content.overview.email') }}</th>
                <td>{{ $admin->email }}</td>
            </tr>

            <tr>
                <th>{{ __('labels.backend.access.admins.tabs.content.overview.status') }}</th>
                <td>{!! $admin->status_label !!}</td>
            </tr>

            <tr>
                <th>{{ __('labels.backend.access.admins.tabs.content.overview.confirmed') }}</th>
                <td>{!! $admin->confirmed_label !!}</td>
            </tr>
        </table>
    </div>
</div><!--table-responsive-->