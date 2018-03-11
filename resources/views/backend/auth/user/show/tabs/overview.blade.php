<div class="col">
    <div class="table-responsive">
        <table class="table table-hover">
            <tr>
                <th>{{ __('labels.backend.access.users.tabs.content.overview.avatar') }}</th>
                <td><img src="{{ $user->picture }}" class="user-profile-image" /></td>
            </tr>
            <tr>
                <th>{{ __('labels.frontend.user.profile.enroller_id') }}</th>
                <td>{{ $user->enroller_id }}</td>
            </tr>
            <tr>
                <th>{{ __('labels.frontend.user.profile.sponsor_id') }}</th>
                <td>{{ $user->sponsor_id }}</td>
            </tr>
            <tr>
                <th>{{ __('labels.frontend.user.profile.referral_code') }}</th>
                <td>{{ $user->referral_code }}</td>
            </tr>
            <tr>
                <th>{{ __('labels.frontend.user.profile.name') }}</th>
                <td>{{ $user->name }}</td>
            </tr>
            <tr>
                <th>{{ __('labels.frontend.user.profile.email') }}</th>
                <td>{{ $user->email }}</td>
            </tr>
            <tr>
                <th>{{ __('labels.frontend.user.profile.phone') }}</th>
                <td>{{ $user->phone }}</td>
            </tr>
            <tr>
                <th>{{ __('labels.frontend.user.profile.pan_no') }}</th>
                <td>{{ $user->pan_no }}</td>
            </tr>
            <tr>
                <th>{{ __('labels.frontend.user.profile.account_no') }}</th>
                <td>{{ $user->account_no }}</td>
            </tr>
            <tr>
                <th>{{ __('labels.frontend.user.profile.account_title') }}</th>
                <td>{{ $user->account_title }}</td>
            </tr>
            <tr>
                <th>{{ __('labels.frontend.user.profile.bank_name') }}</th>
                <td>{{ $user->bank_name }}</td>
            </tr>
            <tr>
                <th>{{ __('labels.frontend.user.profile.branch_name') }}</th>
                <td>{{ $user->branch_name }}</td>
            </tr>
            <tr>
                <th>{{ __('labels.frontend.user.profile.ifcs') }}</th>
                <td>{{ $user->ifcs }}</td>
            </tr>
            <tr>
                <th>{{ __('labels.frontend.user.profile.swift_code') }}</th>
                <td>{{ $user->swift_code }}</td>
            </tr>
            <tr>
                <th>{{ __('labels.backend.access.users.tabs.content.overview.status') }}</th>
                <td>{!! $user->status_label !!}</td>
            </tr>
            <tr>
                <th>{{ __('labels.backend.access.users.tabs.content.overview.confirmed') }}</th>
                <td>{!! $user->confirmed_label !!}</td>
            </tr>
        </table>
    </div>
</div><!--table-responsive-->