@extends ('backend.layouts.app')

@section ('title', __('labels.backend.access.admins.management') . ' | ' . __('labels.backend.access.admins.deleted'))

@section('breadcrumb-links')
    @include('backend.auth.admin.includes.breadcrumb-links')
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-5">
                <h4 class="card-title mb-0">
                    {{ __('labels.backend.access.admins.management') }}
                    <small class="text-muted">{{ __('labels.backend.access.admins.deleted') }}</small>
                </h4>
            </div><!--col-->
        </div><!--row-->

        <div class="row mt-4">
            <div class="col">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>{{ __('labels.backend.access.admins.table.last_name') }}</th>
                            <th>{{ __('labels.backend.access.admins.table.first_name') }}</th>
                            <th>{{ __('labels.backend.access.admins.table.email') }}</th>
                            <th>{{ __('labels.backend.access.admins.table.confirmed') }}</th>
                            <th>{{ __('labels.backend.access.admins.table.roles') }}</th>
                            <th>{{ __('labels.backend.access.admins.table.other_permissions') }}</th>
                            <th>{{ __('labels.backend.access.admins.table.social') }}</th>
                            <th>{{ __('labels.backend.access.admins.table.last_updated') }}</th>
                            <th>{{ __('labels.general.actions') }}</th>
                        </tr>
                        </thead>
                        <tbody>

                        @if ($admins->count())
                            @foreach ($admins as $admin)
                                <tr>
                                    <td>{{ $admin->last_name }}</td>
                                    <td>{{ $admin->first_name }}</td>
                                    <td>{{ $admin->email }}</td>
                                    <td>{!! $admin->confirmed_label !!}</td>
                                    <td>{!! $admin->roles_label !!}</td>
                                    <td>{!! $admin->permissions_label !!}</td>
                                    <td>{!! $admin->social_buttons !!}</td>
                                    <td>{{ $admin->updated_at->diffForHumans() }}</td>
                                    <td>{!! $admin->action_buttons !!}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr><td colspan="9"><p class="text-center">{{ __('strings.backend.access.admins.no_deleted') }}</p></td></tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div><!--col-->
        </div><!--row-->
        <div class="row">
            <div class="col-7">
                <div class="float-left">
                    {!! $admins->total() !!} {{ trans_choice('labels.backend.access.admins.table.total', $admins->total()) }}
                </div>
            </div><!--col-->

            <div class="col-5">
                <div class="float-right">
                    {!! $admins->render() !!}
                </div>
            </div><!--col-->
        </div><!--row-->
    </div><!--card-body-->
</div><!--card-->
@endsection
