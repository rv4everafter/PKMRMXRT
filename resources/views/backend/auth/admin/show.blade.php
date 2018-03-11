@extends ('backend.layouts.app')

@section ('title', __('labels.backend.access.admins.management') . ' | ' . __('labels.backend.access.admins.view'))

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
                    <small class="text-muted">{{ __('labels.backend.access.admins.view') }}</small>
                </h4>
            </div><!--col-->
        </div><!--row-->

        <div class="row mt-4 mb-4">
            <div class="col">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#overview" role="tab" aria-controls="overview" aria-expanded="true"><i class="fa fa-admin"></i> {{ __('labels.backend.access.admins.tabs.titles.overview') }}</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane active" id="overview" role="tabpanel" aria-expanded="true">
                        @include('backend.auth.admin.show.tabs.overview')
                    </div><!--tab-->
                </div><!--tab-content-->
            </div><!--col-->
        </div><!--row-->
    </div><!--card-body-->

    <div class="card-footer">
        <div class="row">
            <div class="col">
                <small class="float-right text-muted">
                    <strong>{{ __('labels.backend.access.admins.tabs.content.overview.created_at') }}:</strong> {{ $admin->updated_at->timezone(get_user_timezone()) }} ({{ $admin->created_at->diffForHumans() }}),
                    <strong>{{ __('labels.backend.access.admins.tabs.content.overview.last_updated') }}:</strong> {{ $admin->created_at->timezone(get_user_timezone()) }} ({{ $admin->updated_at->diffForHumans() }})
                    @if ($admin->trashed())
                        <strong>{{ __('labels.backend.access.admins.tabs.content.overview.deleted_at') }}:</strong> {{ $admin->deleted_at->timezone(get_user_timezone()) }} ({{ $admin->deleted_at->diffForHumans() }})
                    @endif
                </small>
            </div><!--col-->
        </div><!--row-->
    </div><!--card-footer-->
</div><!--card-->
@endsection
