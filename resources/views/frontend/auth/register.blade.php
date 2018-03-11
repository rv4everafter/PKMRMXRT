@extends('frontend.layouts.app')

@section('title', app_name() . ' | '.__('labels.frontend.auth.register_box_title'))

@section('content')
    <div class="row justify-content-center align-items-center">
        <div class="col col-sm-8 align-self-center">
            <div class="card">
                <div class="card-header">
                    <strong>
                        {{ __('labels.frontend.auth.register_box_title') }}
                    </strong>
                </div><!--card-header-->
                <div class="card-body">
                    <form method="POST" action="{{route('frontend.auth.register.post')}}" name="register-form" id='register-form'>
                        {{ csrf_field() }}
                    <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    {{ html()->label(__('validation.attributes.frontend.enroller_id'))->for('enroller_id') }}

                                    {{ html()->text('enroller_id')
                                        ->class('form-control')
                                        ->placeholder(__('validation.attributes.frontend.enroller_id'))
                                        ->attribute('maxlength', 10)->required() }}
                                </div><!--col-->
                                <span id="enroller_name" style="color: green"></span>
                            </div><!--row-->

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    {{ html()->label(__('validation.attributes.frontend.sponsor_id'))->for('sponsor_id') }}

                                    {{ html()->text('sponsor_id')
                                        ->class('form-control')
                                        ->placeholder(__('validation.attributes.frontend.sponsor_id'))
                                        ->attribute('maxlength', 10)->required() }}
                                </div><!--form-group-->
                                 <span id="sponsor_name" style="color: green"></span>
                            </div><!--col-->
                        </div><!--row-->
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    {{ html()->label(__('validation.attributes.frontend.first_name'))->for('first_name') }}

                                    {{ html()->text('first_name')
                                        ->class('form-control')
                                        ->placeholder(__('validation.attributes.frontend.first_name'))
                                        ->attribute('maxlength', 255)->required() }}
                                </div><!--col-->
                            </div><!--row-->

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    {{ html()->label(__('validation.attributes.frontend.last_name'))->for('last_name') }}

                                    {{ html()->text('last_name')
                                        ->class('form-control')
                                        ->placeholder(__('validation.attributes.frontend.last_name'))
                                        ->attribute('maxlength', 255)->required() }}
                                </div><!--form-group-->
                            </div><!--col-->
                        </div><!--row-->             

                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    {{ html()->label(__('validation.attributes.frontend.email'))->for('email') }}

                                    {{ html()->email('email')
                                        ->class('form-control')
                                        ->placeholder(__('validation.attributes.frontend.email'))
                                        ->attribute('maxlength', 255)
                                        ->required() }}
                                </div><!--form-group-->
                            </div><!--row-->

                             <div class="col-12 col-md-6">
                                <div class="form-group">
                                    {{ html()->label(__('validation.attributes.frontend.phone'))->for('phone') }}

                                    {{ html()->text('phone')
                                        ->class('form-control')
                                        ->placeholder(__('validation.attributes.frontend.phone'))
                                        ->attribute('maxlength', 10)->attribute('pattern',"\d{3}[\-]\d{3}[\-]\d{4}")->required() }}
                                </div><!--form-group-->
                            </div><!--col-->
                        </div><!--row-->

                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    {{ html()->label(__('validation.attributes.frontend.password'))->for('password') }}

                                    {{ html()->password('password')
                                        ->class('form-control')
                                        ->placeholder(__('validation.attributes.frontend.password'))
                                        ->required() }}
                                </div><!--form-group-->
                            </div><!--col-->
                            <div class="col">
                                <div class="form-group">
                                    {{ html()->label(__('validation.attributes.frontend.password_confirmation'))->for('password_confirmation') }}

                                    {{ html()->password('password_confirmation')
                                        ->class('form-control')
                                        ->placeholder(__('validation.attributes.frontend.password_confirmation'))
                                        ->required() }}
                                </div><!--form-group-->
                            </div><!--col-->
                            
                        </div><!--row-->
                         
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    {{ html()->label(__('validation.attributes.frontend.dob'))->for('dob') }}

                                    {{ html()->text('dob')
                                        ->class('form-control dateofbirth')
                                        ->placeholder(__('validation.attributes.frontend.dob'))
                                        ->attribute('maxlength', 20)->attribute('readonly')->required() }}
                                </div><!--col-->
                            </div><!--row-->

                           <div class="col-12 col-md-6">
                                <div class="form-group">
                                    {{ html()->label(__('validation.attributes.frontend.pan_no'))->for('pan_no') }}

                                    {{ html()->text('pan_no')
                                        ->class('form-control')
                                        ->placeholder(__('validation.attributes.frontend.pan_no'))
                                        ->attribute('maxlength', 10) }}
                                </div><!--form-group-->
                            </div><!--col-->
                        </div><!--row-->
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    {{ html()->label(__('validation.attributes.frontend.gender'))->for('gender') }}<br>
                                    <input type="radio" name="gender" value="male" checked="true"> Male
                                    <input type="radio" name="gender" value="female"> Female
                                    <input type="radio" name="gender" value="transgender"> Transgender
                                </div><!--col-->
                            </div><!--row-->

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    {{ html()->label(__('validation.attributes.frontend.marital_status'))->for('marital_status') }}<br>
                                    <input type="radio" name="marital_status" value="single" checked="true"> Single
                                    <input type="radio" name="marital_status" value="married"> Married
                                </div><!--form-group-->
                            </div><!--col-->
                        </div><!--row-->
                        <div class="row">
                            <div class="col">
                                {{ html()->checkbox('receive_email',true)}}
                                {{ html()->label(__('validation.attributes.frontend.receive_email'))->for('receive_email') }}
                            </div>
                        </div>

                        @if (config('access.captcha.registration'))
                            <div class="row">
                                <div class="col">
                                    {!! Captcha::display() !!}
                                    {{ html()->hidden('captcha_status', 'true') }}
                                </div><!--col-->
                            </div><!--row-->
                        @endif

                        <div class="row">
                            <div class="col">
                                <div class="form-group mb-0 clearfix">
                                    {{ form_submit(__('labels.frontend.auth.register_button')) }}
                                </div><!--form-group-->
                            </div><!--col-->
                        </div><!--row-->
                    </form>

                    <div class="row">
                        <div class="col">
                            <div class="text-center">
                                {!! $socialiteLinks !!}
                            </div>
                        </div><!--/ .col -->
                    </div><!-- / .row -->
                    
                </div><!-- card-body -->
            </div><!-- card -->
        </div><!-- col-md-8 -->
    </div><!-- row -->
@endsection

@push('after-scripts')
    @if (config('access.captcha.registration'))
        {!! Captcha::script() !!}
    @endif
    <script>
       $(document).ready(function($){
           $('#enroller_id').change(function(){
                $.ajax({
                    type:"GET",
                    url:"{{route('frontend.getenroller')}}?d="+$(this).val(),
                    success: function(data) {
                      $('#enroller_name').text('Enroller Name: '+data.enroller.full_name);
                    },
                  });
           })
           $('#sponsor_id').change(function(){
                $.ajax({
                    type:"GET",
                    url:"{{route('frontend.getenroller')}}?d="+$(this).val(),
                    success: function(data) {
                      $('#sponsor_name').text('Sponsor Name: '+data.enroller.full_name);
                    },
                  });
           })
           $('.dateofbirth').datepicker('setDate','01-01-1990');
            $("#register-form").validate({
                // Specify validation rules
                rules: {
                  // The key name on the left side is the name attribute
                  // of an input field. Validation rules are defined
                  // on the right side
                  first_name: "required",
                  last_name: "required",
                  enroller_id: "required",
                  sponsor_id: "required",
                  phone: {
                      required:true,
                      number: true,
                      minlength:10,
                      maxlength:10,
                  },
                  pan_no: {
                      number: true,
                      minlength:10,
                      maxlength:10,
                  },
                  dob: "required",
                  email: {
                    required: true,
                    // Specify that email should be validated
                    // by the built-in "email" rule
                    email: true
                  },
                  password: {
                    required: true,
                    minlength: 8
                  },
                  password_confirmation: {
                    required: true,
                    minlength: 8,
                    equalTo:'#password'
                  }
                },
                // Specify validation error messages
                messages: {
                  first_name: "Please enter your first name",
                  last_name: "Please enter your last name",
                  enroller_id: "Please enter enroller id",
                  sponsor_id: "Please enter sponsor id",
                  dob: "Please enter date of birth",
                  password: {
                    required: "Please provide a password",
                    minlength: "Your password must be at least 8 characters long"
                  },
                  password_confirmation: {
                    required: "Please confirm a password",
                    minlength: "Your password must be at least 8 characters long",
                    equalTo: "Please enter same password to confirm"
                  },
                  email: "Please enter a valid email address",
                  phone:{
                      required: "Please enter phone number",
                      minlength: "Phone number must be of 10 digits",
                      maxlength: "Phone number must be of 10 digits",
                      number:  "Please enter valid phone number"
                  },
                   pan_no: {
                      number: "Please enter valid PAN number",
                      minlength:'PAN number must be of 10 digits',
                      maxlength:'PAN number must be of 10 digits',
                  },
                },
                // Make sure the form is submitted to the destination defined
                // in the "action" attribute of the form when valid
                submitHandler: function(form) {
                  form.submit();
                }
            });
        });
    </script>
@endpush
