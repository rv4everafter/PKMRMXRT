@extends ('backend.layouts.app')

@section ('title', app_name() . ' | ' . __('labels.backend.access.commission.management'))

@section('breadcrumb-links')
    @include('backend.auth.commission.includes.breadcrumb-links')
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-5">
                <h4 class="card-title mb-0">
                    {{ __('labels.backend.access.commission.management') }} <small class="text-muted">{{ __('labels.backend.access.commission.pending') }}</small>
                </h4>
            </div><!--col-->

            <div class="col-sm-7">
              
            </div><!--col-->
        </div><!--row-->

        <div class="row mt-4">
            <div class="col">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>{{ __('labels.backend.access.commission.table.referral_code') }}</th>
                            <th>{{ __('labels.backend.access.commission.table.last_name') }}</th>
                            <th>{{ __('labels.backend.access.commission.table.first_name') }}</th>
                            <th>{{ __('labels.backend.access.commission.table.email') }}</th>
                            <th>{{ __('labels.backend.access.commission.table.amount') }}</th>
                        </tr>
                        </thead>
                        <tbody>   
                        @if ($commission->count())
                        @foreach ($commission as $user)
                            <tr>
                                <td>{{ $user->referral_code }}</td>
                                <td>{{ $user->last_name }}</td>
                                <td>{{ $user->first_name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ number_format((float)$user->amount, 2, '.', '') }}</td>
                            </tr>
                        @endforeach
                        @else
                          <tr><td colspan="9"><p class="text-center">{{ __('strings.backend.access.commission.no_active') }}</p></td></tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div><!--col-->
        </div><!--row-->
        <div class="row">
            <div class="col-7">
                <div class="float-left">
                    {!! $commission->total() !!} {{ trans_choice('labels.backend.access.commission.table.total', $commission->total()) }}
                </div>
            </div><!--col-->

            <div class="col-5">
                <div class="float-right">
                    {!! $commission->render() !!}
                </div>
            </div><!--col-->
        </div><!--row-->
    </div><!--card-body-->
</div><!--card-->
@endsection
