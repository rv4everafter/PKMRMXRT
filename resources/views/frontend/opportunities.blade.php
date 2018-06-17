@extends('frontend.layouts.app')

@section('title', app_name() . ' | Contact Us')

@section('content')
<div class="row justify-content-center" style="margin-bottom: 30px">
    <div class="col col-sm-12 align-self-center">
        <div class="card">
            <div class="card-header">
                <strong>
                    Opportunities
                </strong>
            </div><!--card-header-->

            <div class="card-body">
                <img src="{{URL('/images/user_tree.jpg')}}">
            </div><!--card-body-->
        </div><!--card-->
    </div><!--col-->
</div><!--row-->
@endsection
