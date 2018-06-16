@extends('frontend.layouts.app')

@section('title', app_name() . ' | Contact Us')

@section('content')
    <div class="row justify-content-center">
        <div class="col col-sm-12 align-self-center">
            <div class="col-sm-6" style="float: left">
                <div class="card">
                    <div class="card-header">
                        <strong>
                            Corporate Office
                        </strong>
                    </div><!--card-header-->

                    <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <label><b>TNBONCE HERITAGE CARE INDIA(OPC) PRIVATE LIMITED</b></label>
                                </div><!--col-->
                            </div><!--row-->
                            <div class="row">
                                <div class="col">
                                    <label>2/F/F E-WARD,</label>
                                </div><!--col-->
                            </div><!--row-->
                            <div class="row">
                                <div class="col">
                                    <label>NEAR ARJUN COMPLEX,</label>
                                </div><!--col-->
                            </div><!--row-->
                            <div class="row">
                                <div class="col">
                                    <label>KUBERNAGAR, AHMEDABAD,</label>
                                </div><!--col-->
                            </div><!--row-->
                            <div class="row">
                                <div class="col">
                                    <label>GUJRAT, INDIA - 382340</label>
                                </div><!--col-->
                            </div><!--row-->
                            <div class="row">
                                <div class="col">
                                    <label>Customer Care No : 7069229475</label>
                                </div><!--col-->
                            </div><!--row-->
                            <div class="row">
                                <div class="col">
                                    <label>Email : tnbbussiness@gmail.com</label>
                                </div>
                            </div><!--row-->
                    </div><!--card-body--> 
                </div><!--card-->
            </div>
            <div class="col-sm-6" style="float: right">
                <div class="card">
                    <div class="card-header">
                        <strong>
                            {{ __('labels.frontend.contact.box_title') }}
                        </strong>
                    </div><!--card-header-->

                    <div class="card-body">
                        {{ html()->form('POST', route('frontend.contact.send'))->open() }}
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        {{ html()->label(__('validation.attributes.frontend.name'))->for('name') }}

                                        {{ html()->text('name')
                                            ->class('form-control')
                                            ->placeholder(__('validation.attributes.frontend.name'))
                                            ->attribute('maxlength', 191)
                                            ->required()
                                            ->autofocus() }}
                                    </div><!--form-group-->
                                </div><!--col-->
                            </div><!--row-->

                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        {{ html()->label(__('validation.attributes.frontend.email'))->for('email') }}

                                        {{ html()->email('email')
                                            ->class('form-control')
                                            ->placeholder(__('validation.attributes.frontend.email'))
                                            ->attribute('maxlength', 191)
                                            ->required() }}
                                    </div><!--form-group-->
                                </div><!--col-->
                            </div><!--row-->

                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        {{ html()->label(__('validation.attributes.frontend.phone'))->for('phone') }}

                                        {{ html()->text('phone')
                                            ->class('form-control')
                                            ->placeholder(__('validation.attributes.frontend.phone'))
                                            ->attribute('maxlength', 10)
                                            ->required() }}
                                    </div><!--form-group-->
                                </div><!--col-->
                            </div><!--row-->

                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        {{ html()->label(__('validation.attributes.frontend.message'))->for('message') }}

                                        {{ html()->textarea('message')
                                            ->class('form-control')
                                            ->placeholder(__('validation.attributes.frontend.message'))
                                            ->attribute('rows', 3) }}
                                    </div><!--form-group-->
                                </div><!--col-->
                            </div><!--row-->

                            <div class="row">
                                <div class="col">
                                    <div class="form-group mb-0 clearfix">
                                        {{ form_submit(__('labels.frontend.contact.button')) }}
                                    </div><!--form-group-->
                                </div><!--col-->
                            </div><!--row-->
                        {{ html()->form()->close() }}
                    </div><!--card-body-->
                </div><!--card-->
            </div>
        </div><!--col-->
    </div><!--row-->
@endsection
