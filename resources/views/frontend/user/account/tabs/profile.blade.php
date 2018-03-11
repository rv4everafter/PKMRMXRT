<div class="table-responsive">
    <table class="table table-striped table-hover table-bordered">
        <tr>
            <th>{{ __('labels.frontend.user.profile.avatar') }}</th>
            <td><img src="{{ $logged_in_user->picture }}" class="user-profile-image" /></td>
        </tr>
        <tr>
            <th>{{ __('labels.frontend.user.profile.name') }}</th>
            <td>{{ $logged_in_user->name }}</td>
        </tr>
        <tr>
            <th>{{ __('labels.frontend.user.profile.referral_code') }}</th>
            <td>{{ $logged_in_user->referral_code }}</td>
        </tr>
        <tr>
            <th>{{ __('labels.frontend.user.profile.enroller_id') }}</th>
            <td>{{ $logged_in_user->enroller_id }}</td>
        </tr>
        <tr>
            <th>{{ __('labels.frontend.user.profile.sponsor_id') }}</th>
            <td>{{ $logged_in_user->sponsor_id }}</td>
        </tr>
        <tr>
            <th>{{ __('labels.frontend.user.profile.email') }}</th>
            <td>{{ $logged_in_user->email }}</td>
        </tr>
        <tr>
            <th>{{ __('labels.frontend.user.profile.phone') }}</th>
            <td>{{ $logged_in_user->phone }}</td>
        </tr>
        <tr>
            <th>{{ __('labels.frontend.user.profile.created_at') }}</th>
            <td>{{ $logged_in_user->created_at->timezone(get_user_timezone()) }} ({{ $logged_in_user->created_at->diffForHumans() }})</td>
        </tr>
        <tr>
            <th>{{ __('labels.frontend.user.profile.last_updated') }}</th>
            <td>{{ $logged_in_user->updated_at->timezone(get_user_timezone()) }} ({{ $logged_in_user->updated_at->diffForHumans() }})</td>
        </tr>
    </table>
</div>