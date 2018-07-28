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
                 {{ html()->form('GET', '' )->class('form-horizontal')->open() }}
                    {{
                        html()->select('monthFilter', ['01'=>'Jan', '02'=>'Feb', '03'=>'Mar', '04'=>'Apr', '05'=>'May', '06'=>'Jun', '07'=>'Jul',
                            '08'=>'Aug', '09'=>'Sep', '10'=>'Oct', '11'=>'Nov', '12'=>'Dec'], (isset($_GET['monthFilter'])?$_GET['monthFilter']:date('m')))
                    }}
                    {{
                        html()->select('yearFilter',array_combine(range(2017,date('Y',strtotime('+5 year'))),range(2017,date('Y',strtotime('+5 year')))),date('Y'))
                    }}                
                     {{ html()->submit('Go') }}
                  {{ html()->form()->close() }}
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
                            <th>{{ __('labels.backend.access.commission.table.tds_amount') }}</th>
                            <th>{{ __('labels.backend.access.commission.table.action') }}</th>
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
                                 <td>{{ number_format((float)($user->amount-($user->amount*5/100)),2, '.', '') }}</td>
                                <td>
                                    <button class="btn btn-primary"  type="button" data-toggle="collapse" data-target="#userAccount{{$user->id}}" aria-expanded="false" aria-controls="collapseExample">
                                         A/c Details
                                    </button>
                                    <a href="{{route('admin.auth.commission.paymented',$user)}}" class="btn btn-success"><i class="fa fa-check" data-toggle="tooltip" data-placement="top" title="Completed?"></i></a></td>
                            </tr>
                            <tr>
                                <td style="border:none;padding: 0" colspan="7">
                                    <div class="collapse" id="userAccount{{$user->id}}">
                                        <div class="card card-body">
                                         <div class="table-responsive">
                                            <table class="table table-striped table-hover table-bordered">
                                                <tr>
                                                    <th>{{ __('labels.frontend.user.profile.referral_code') }}</th>
                                                    <td>{{ $user->referral_code }}</td>
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
                                            </table>
                                        </div>
                                        </div>
                                    </div>
                                </td>
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
