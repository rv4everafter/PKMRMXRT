@extends('frontend.layouts.app')

@section('title', app_name() . ' | Contact Us')

@section('content')
<div class="row justify-content-center" style="margin-bottom: 30px">
    <div class="col col-sm-12 align-self-center">
        <div class="card">
            <div class="card-header">
                <strong>
                    GRIEVANCE MANAGEMENT
                </strong>
            </div><!--card-header-->

            <div class="card-body">

                <p>This committee deals with all grievances directly those created at company level both
                    About products &amp; administration
                    Our board members sit once in 2 weeks, and take up all relevant matters, and record the
                    proceedings.</p><br/>
                <strong>PROCESS TO FILE YOUR COMPLAINT/ GRIEVANCE.</strong><br/>
                (1) Submit your query/ Complaint /Grievance Online.<br/>
                (2) You could download the format and post the written format in English language.<br/>
                (3) You could directly call our board members.<br/>
                (4) You could mail us on our email ID.<br/>
                (5) Walk in to our Head office.<br/><br/><br/>
                <h6><b>Option 1:</b></h6>
                <div class="row">
                    <div class="col-sm-6">
                        {{ html()->form('POST', route('frontend.contact.sendgrievance'))->open() }}
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    {{ html()->label(__('validation.attributes.frontend.profile_code'))->for('profile_code') }}

                                    {{ html()->select('type',['customer'=>'Customer','distributor'=>'Distributor'])
                                            ->class('form-control')
                                            ->placeholder(__('validation.attributes.frontend.type'))
                                            ->required() }}
                                </div><!--form-group-->
                            </div><!--col-->
                        </div><!--row-->
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    {{ html()->label(__('validation.attributes.frontend.profile_code'))->for('profile_code') }}

                                    {{ html()->text('profile_code')
                                            ->class('form-control')
                                            ->placeholder(__('validation.attributes.frontend.profile_code'))
                                            ->attribute('maxlength', 10)
                                            ->required() }}
                                </div><!--form-group-->
                            </div><!--col-->
                        </div><!--row-->
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    {{ html()->label(__('validation.attributes.frontend.name'))->for('name') }}

                                    {{ html()->text('full_name')
                                            ->class('form-control')
                                            ->placeholder(__('validation.attributes.frontend.name'))
                                            ->attribute('maxlength', 191)
                                            ->required()
                                    }}
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
                    </div>
                    <div class="col-sm-6">
                        <h6><b>Option 2:</b></h6>
                        <div class="row">
                            <div class="col">
                                You could download the format and post the written format in English language.
                                <a href="/images/grievance_form.pdf" download="Grievance">Download Form</a>
                            </div>
                        </div>
                        <br/>
                        <h6><b>Option 3/4/5:</b></h6>
                        <div class="row">
                            <div class="col">
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
                            </div><!--row-->
                        </div>
                    </div>
                </div><!--card-body-->
            </div><!--card-->
        </div><!--col-->
    </div><!--row-->
    @endsection
