@extends('frontend.layouts.app')
@push('after-styles')
   <style type="text/css">
        #mynetwork {
            width: 'auto';
            height: 500px;
            border: 1px solid lightgray;
        }
    </style>
@endpush
@section('content')
    <div class="row mb-4">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <strong>
                        <i class="fa fa-dashboard"></i> {{ __('navs.frontend.dashboard') }} 
                    </strong>
                </div><!--card-header-->

                <div class="card-body">
                    <div role="tabpanel">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a href="#userlist" class="nav-link active" aria-controls="userlist" role="tab" data-toggle="tab">Users List ({{'Enrolled: '.$user_credit['enrolled_user'].' Total:'.count($users['list'])}})</a>
                            </li>
                            <li class="nav-item">
                                <a href="#treeview" class="nav-link" aria-controls="treeview" role="tab" data-toggle="tab">Users Tree Level Report</a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane fade show active pt-3" id="userlist" aria-labelledby="edit-tab">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>{{ __('labels.backend.access.users.table.level') }}</th>
                                            <th>{{ __('labels.backend.access.users.table.enroller_id') }}</th>
                                            <th>{{ __('labels.backend.access.users.table.sponsor_id') }}</th>
                                            <th>{{ __('labels.backend.access.users.table.referral_code') }}</th>
                                            <th>{{ __('labels.backend.access.users.table.last_name') }}</th>
                                            <th>{{ __('labels.backend.access.users.table.first_name') }}</th>
                                            <th>{{ __('labels.backend.access.users.table.email') }}</th>
                                            <th>{{ __('labels.general.actions') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>   
                                        @if (count($users['list'])>0)
                                        @foreach ($users['list'] as $user)
                                            <tr>
                                                <td>{{ $user['level'] }}</td>
                                                <td>{{ $user['enroller_id'] }}</td>
                                                <td>{{ $user['sponsor_id'] }}</td>
                                                <td>{{ $user['referral_code'] }}</td>
                                                <td>{{ $user['last_name'] }}</td>
                                                <td>{{ $user['first_name'] }}</td>
                                                <td>{{ $user['email'] }}</td>
                                                <td>{!! $user->user_action_buttons !!}</td>
                                            </tr>
                                        @endforeach
                                        @else
                                          <tr><td colspan="9"><p class="text-center">{{ __('strings.backend.access.users.no_active') }}</p></td></tr>
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div><!--tab panel profile-->
                            <div role="tabpanel" class="tab-pane fade show pt-3" id="treeview" aria-labelledby="profile-tab">
                               <div id="mynetwork"></div>
                            </div><!--tab panel profile-->
                        </div><!--tab content-->
                    </div><!--tab panel-->
                </div> <!-- card-body -->
            </div><!-- card -->
        </div><!-- row -->
    </div><!-- row -->
@endsection
@push('after-scripts')
    <script>
       $(document).ready(function($){  
           var nodes='<?=$users["nodes"]?>';
           var edges='<?=$users["edges"]?>';           
         var nodes = new vis.DataSet(JSON.parse(nodes));

    // create an array with edges
    var edges = new vis.DataSet(JSON.parse(edges));

    // create a network
    var container = document.getElementById('mynetwork');

    // provide the data in the vis format
    var data = {
        nodes: nodes,
        edges: edges
    };
    var options = {
        edges: {
                    smooth: {
                        type: 'cubicBezier',
                        forceDirection: 'horizontal',
                        roundness: 0.4
                    }
                },
                layout: {
                    hierarchical: {
                        direction: 'UD'
                    }
                },
                physics:false
    };

    // initialize your network!
    var network = new vis.Network(container, data, options);
      });
    </script>
@endpush