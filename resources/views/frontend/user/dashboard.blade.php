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
                <strong style="float:left;">
                    <i class="fa fa-dashboard"></i> {{ __('navs.frontend.dashboard') }} 
                </strong>
                <div style="float:right">
                    @if($direct)
                    <div class="btn-group btn-group-sm" role="group" aria-label="User Actions">
                        <a href="{{route('frontend.user.profile.directcode')}}" name="confirm_item" class="btn btn-info"  data-trans-title="Do you want to create direct downline?">Direct Downline <i class="fa fa-plus-square" data-toggle="tooltip" data-placement="top" data-title="Create Direct Downline"></i></a>
                    </div>
                    @endif

                </div>
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
                                            <th>{{ __('labels.backend.access.users.table.name') }}</th>
                                            <th>{{ __('labels.backend.access.users.table.email') }}</th>
                                            <th>{{ __('labels.backend.access.users.table.is_user') }}</th>
                                            <th>Action</th>
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
                                            <td>{{ $user['first_name']." ".$user['last_name'] }}</td>
                                            <td>{{ $user['email'] }}</td> 
                                            <td>{!! $user->is_user_label !!}</td>
                                            @if($user->direct)
                                            <td class="text-center">{!! $user->user_action_buttons !!}</td>
                                            @endif
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
    $(document).ready(function ($) {
        var nodes = '<?= $users["nodes"] ?>';
        var edges = '<?= $users["edges"] ?>';
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
            physics: true,
        };
        // initialize your network!
        var network = new vis.Network(container, data, options);
        var options = {
            nodes: {
                borderWidth: 1,
                borderWidthSelected: 2,
                brokenImage: "",
                chosen: false,
                color: {
                    border: '#2B7CE9',
                    background: '#97C2FC',
                    highlight: {
                        border: '#2B7CE9',
                        background: '#D2E5FF'
                    },
                    hover: {
                        border: '#2B7CE9',
                        background: '#D2E5FF'
                    }
                },
                fixed: {
                    x: false,
                    y: false
                },
                font: {
                    color: '#343434',
                    size: 14, // px
                    face: 'arial',
                    background: 'none',
                    strokeWidth: 0, // px
                    strokeColor: '#ffffff',
                    align: 'center',
                    multi: false,
                    vadjust: 0,
                    bold: {
                        color: '#343434',
                        size: 14, // px
                        face: 'arial',
                        vadjust: 0,
                        mod: 'bold'
                    },
                    ital: {
                        color: '#343434',
                        size: 14, // px
                        face: 'arial',
                        vadjust: 0,
                        mod: 'italic',
                    },
                    boldital: {
                        color: '#343434',
                        size: 14, // px
                        face: 'arial',
                        vadjust: 0,
                        mod: 'bold italic'
                    },
                    mono: {
                        color: '#343434',
                        size: 15, // px
                        face: 'courier new',
                        vadjust: 2,
                        mod: ''
                    }
                },
                group: "",
                heightConstraint: false,
                hidden: false,
                icon: {
                    face: 'FontAwesome',
                    code: "",
                    size: 50, //50,
                    color: '#2B7CE9'
                },
                image: "",
                label: "",
                labelHighlightBold: true,
                level: undefined,
                mass: 1,
                physics: true,
                scaling: {
                    min: 10,
                    max: 30,
                    label: {
                        enabled: false,
                        min: 14,
                        max: 30,
                        maxVisible: 30,
                        drawThreshold: 5
                    },
                    customScalingFunction: function (min, max, total, value) {
                        if (max === min) {
                            return 0.5;
                        } else {
                            let scale = 1 / (max - min);
                            return Math.max(0, (value - min) * scale);
                        }
                    }
                },
                shadow: {
                    enabled: true,
                    color: 'rgba(0,0,0,0.5)',
                    size: 10,
                    x: 5,
                    y: 5
                },
                shape: 'ellipse',
                shapeProperties: {
                    borderDashes: false, // only for borders
                    borderRadius: 0, // only for box shape
                    interpolation: false, // only for image and circularImage shapes
                    useImageSize: false, // only for image and circularImage shapes
                    useBorderWithImage: false  // only for image shape
                },
                size: 25,
                title: "",
                value: undefined,
                widthConstraint: false,
                x: -500,
                y: 150
            }
        }
        network.setOptions(options);
    });
</script>
@endpush