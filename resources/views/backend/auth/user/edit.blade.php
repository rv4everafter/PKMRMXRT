@extends ('backend.layouts.app')

@section ('title', __('labels.backend.access.users.management') . ' | ' . __('labels.backend.access.users.edit'))

@section('breadcrumb-links')
    @include('backend.auth.user.includes.breadcrumb-links')
@endsection

@section('content')
{{ html()->modelForm($user, 'PATCH', route('admin.auth.user.update', $user->id))->attribute('id','user-form')->class('form-horizontal')->open() }}
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        {{ __('labels.backend.access.users.management') }}
                        <small class="text-muted">{{ __('labels.backend.access.users.edit') }}</small>
                    </h4>
                </div><!--col-->
            </div><!--row-->

            <hr />

            <div class="row mt-4 mb-4">
                <div class="col">
                        <div class="form-group row">
                            {{ html()->label(__('validation.attributes.backend.access.users.enroller_id'))->class('col-md-2 form-control-label')->for('enroller_id') }}

                            <div class="col-md-10">
                                {{ html()->text('enroller_id')
                                    ->class('form-control')
                                    ->placeholder(__('validation.attributes.backend.access.users.enroller_id'))
                                    ->attribute('maxlength', 8)
                                    ->required()
                                    ->autofocus() }}
                            </div><!--col-->
                        </div><!--form-group-->
                        <div class="form-group row">
                            {{ html()->label(__('validation.attributes.backend.access.users.sponsor_id'))->class('col-md-2 form-control-label')->for('sponsor_id') }}

                            <div class="col-md-10">
                                {{ html()->text('sponsor_id')
                                    ->class('form-control')
                                    ->placeholder(__('validation.attributes.backend.access.users.sponsor_id'))
                                    ->attribute('maxlength', 8)
                                    ->required() }}
                            </div><!--col-->
                        </div><!--form-group-->
                         <div class="form-group row">
                            {{ html()->label(__('validation.attributes.backend.access.users.email'))->class('col-md-2 form-control-label')->for('email') }}

                            <div class="col-md-10">
                                {{ html()->email('email')
                                    ->class('form-control')
                                    ->placeholder(__('validation.attributes.backend.access.users.email'))
                                    ->attribute('maxlength', 191)
                                    ->required() }}
                            </div><!--col-->
                        </div><!--form-group-->

                        <div class="form-group row" style="border-bottom: 1px solid #000">
                        <div class="col">
                            <strong>
                                {{ __('labels.frontend.user.section_header.personal') }}
                            </strong>
                        </div>
                    </div>
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
                                    {{ html()->label(__('validation.attributes.frontend.dob'))->for('dob') }}

                                    {{ html()->text('dob')
                                        ->class('form-control dateofbirth')
                                        ->placeholder(__('validation.attributes.frontend.dob'))
                                        ->attribute('maxlength', 20)->attribute('readonly')->required() }}
                                </div><!--col-->
                            </div><!--row-->

                           <div class="col-12 col-md-6">
                                <div class="form-group">
                                    {{ html()->label('PAN Number')->for('pan_no') }}

                                    {{ html()->text('pan_no')
                                        ->class('form-control')
                                        ->placeholder('PAN Number')
                                        ->attribute('maxlength', 10)->required() }}
                                </div><!--form-group-->
                            </div><!--col-->
                        </div><!--row-->
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    {{ html()->label(__('validation.attributes.frontend.gender'))->for('gender') }}<br>
                                    <input type="radio" name="gender" value="male" {{($user->gender == 'male')?'checked':''}}> Male
                                    <input type="radio" name="gender" value="female" {{($user->gender == 'female')?'checked':''}}> Female
                                    <input type="radio" name="gender" value="transgender" {{($user->gender == 'transgender')?'checked':''}}> Transgender
                                </div><!--col-->
                                <label id="gender-error" class="error" for="gender"></label>
                            </div><!--row-->

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    {{ html()->label(__('validation.attributes.frontend.marital_status'))->for('marital_status') }}<br>
                                    <input type="radio" name="marital_status" value="single" {{($user->marital_status == 'single')?'checked':''}}> Single
                                    <input type="radio" name="marital_status" value="married" {{($user->marital_status == 'married')?'checked':''}}> Married
                                </div><!--form-group-->
                                <label id="marital_status-error" class="error" for="marital_status"></label>
                            </div><!--col-->
                        </div><!--row-->
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    {{ html()->label(__('validation.attributes.frontend.phone'))->for('phone') }}

                                    {{ html()->text('phone')
                                        ->class('form-control')
                                        ->placeholder(__('validation.attributes.frontend.phone'))
                                        ->attribute('maxlength', 10)->required() }}
                                </div><!--col-->
                            </div><!--row-->
                        </div>
                      
                    <div class="form-group row" style="border-bottom: 1px solid #000">
                        <div class="col">
                            <strong>
                                {{ __('labels.frontend.user.section_header.co_applicant') }}
                            </strong>
                        </div>
                    </div>
                   <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    {{ html()->label(__('validation.attributes.frontend.nominee_name'))->for('nominee_name') }}

                                       {{ html()->text('nominee_name')
                                        ->class('form-control')
                                        ->placeholder(__('validation.attributes.frontend.nominee_name'))
                                        ->attribute('maxlength', 191)
                                        ->required() }}
                                </div><!--col-->
                            </div><!--row-->
                            
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    {{ html()->label(__('validation.attributes.frontend.nominee_relation'))->for('nominee_relation') }}

                                    {{ html()->text('nominee_relation')
                                        ->class('form-control')
                                        ->placeholder(__('validation.attributes.frontend.nominee_relation'))
                                        ->attribute('maxlength', 255)->required() }}
                                </div><!--form-group-->
                            </div><!--col-->
                   </div><!--row-->        
                    <div class="form-group row" style="border-bottom: 1px solid #000">
                        <div class="col">
                            <strong>
                                {{ __('labels.frontend.user.section_header.ac_mailing') }}
                            </strong>
                        </div>
                    </div>
                   <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    {{ html()->label(__('validation.attributes.frontend.address1'))->for('address1') }}

                                       {{ html()->text('address1')
                                        ->class('form-control')
                                        ->placeholder(__('validation.attributes.frontend.address1'))
                                        ->attribute('maxlength', 255)
                                        ->required() }}
                                </div><!--col-->
                            </div><!--row-->
                            
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    {{ html()->label(__('validation.attributes.frontend.address2'))->for('address2') }}

                                    {{ html()->text('address2')
                                        ->class('form-control')
                                        ->placeholder(__('validation.attributes.frontend.address2'))
                                        ->attribute('maxlength', 255)->required() }}
                                </div><!--form-group-->
                            </div><!--col-->
                   </div><!--row-->        
                   <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    {{ html()->label(__('validation.attributes.frontend.city'))->for('city') }}

                                       {{ html()->text('city')
                                        ->class('form-control')
                                        ->placeholder(__('validation.attributes.frontend.city'))
                                        ->attribute('maxlength', 191)
                                        ->required() }}
                                </div><!--col-->
                            </div><!--row-->
                            
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    {{ html()->label(__('validation.attributes.frontend.state'))->for('state') }}

                                    {{ html()->text('state')
                                        ->class('form-control')
                                        ->placeholder(__('validation.attributes.frontend.state'))
                                        ->attribute('maxlength', 255)->required() }}
                                </div><!--form-group-->
                            </div><!--col-->
                   </div><!--row-->        
                   <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    {{ html()->label(__('validation.attributes.frontend.postal_code'))->for('postal_code') }}

                                       {{ html()->text('postal_code')
                                        ->class('form-control')
                                        ->placeholder(__('validation.attributes.frontend.postal_code'))
                                        ->attribute('maxlength', 6)
                                        ->required() }}
                                </div><!--col-->
                            </div><!--row-->  
                   </div><!--row-->        
                    <div class="form-group row" style="border-bottom: 1px solid #000">
                        <div class="col">
                            <strong>
                                {{ __('labels.frontend.user.section_header.bank_details') }}
                            </strong>
                        </div>
                    </div>
                   <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    {{ html()->label(__('validation.attributes.frontend.account_no'))->for('account_no') }}

                                       {{ html()->text('account_no')
                                        ->class('form-control')
                                        ->placeholder(__('validation.attributes.frontend.account_no'))
                                        ->attribute('maxlength', 191)
                                        ->required() }}
                                </div><!--col-->
                            </div><!--row-->
                            
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    {{ html()->label(__('validation.attributes.frontend.account_title'))->for('account_title') }}

                                    {{ html()->text('account_title')
                                        ->class('form-control')
                                        ->placeholder(__('validation.attributes.frontend.account_title'))
                                        ->attribute('maxlength', 255)->required() }}
                                </div><!--form-group-->
                            </div><!--col-->
                   </div><!--row-->        
                   <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    {{ html()->label(__('validation.attributes.frontend.bank_name'))->for('bank_name') }}

                                       {{ html()->text('bank_name')
                                        ->class('form-control')
                                        ->placeholder(__('validation.attributes.frontend.bank_name'))
                                        ->attribute('maxlength', 191)
                                        ->required() }}
                                </div><!--col-->
                            </div><!--row-->
                            
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    {{ html()->label(__('validation.attributes.frontend.branch_name'))->for('branch_name') }}

                                    {{ html()->text('branch_name')
                                        ->class('form-control')
                                        ->placeholder(__('validation.attributes.frontend.branch_name'))
                                        ->attribute('maxlength', 255)->required() }}
                                </div><!--form-group-->
                            </div><!--col-->
                   </div><!--row-->        
                   <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    {{ html()->label(__('validation.attributes.frontend.ifcs'))->for('ifcs') }}

                                       {{ html()->text('ifcs')
                                        ->class('form-control')
                                        ->placeholder(__('validation.attributes.frontend.ifcs'))
                                        ->attribute('maxlength', 191)
                                        ->required() }}
                                </div><!--col-->
                            </div><!--row-->  
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    {{ html()->label(__('validation.attributes.frontend.swift_code'))->for('swift_code') }}

                                       {{ html()->text('swift_code')
                                        ->class('form-control')
                                        ->placeholder(__('validation.attributes.frontend.swift_code'))
                                        ->attribute('maxlength', 191)
                                        ->required() }}
                                </div><!--col-->
                            </div><!--row-->  
                   </div><!--row-->  

                        
                </div><!--col-->
            </div><!--row-->
        </div><!--card-body-->

        <div class="card-footer">
            <div class="row">
                <div class="col">
                    {{ form_cancel(route('admin.auth.user.index'), __('buttons.general.cancel')) }}
                </div><!--col-->

                <div class="col text-right">
                    {{ form_submit(__('buttons.general.crud.update')) }}
                </div><!--row-->
            </div><!--row-->
        </div><!--card-footer-->
    </div><!--card-->
{{ html()->closeModelForm() }}
@endsection
@push('after-scripts')
    <script>
       $(document).ready(function($){
           $('.dateofbirth').datepicker('setDate','01-01-1990');
           $("#user-form").validate({
                // Specify validation rules
                rules: {
                  // The key name on the left side is the name attribute
                  // of an input field. Validation rules are defined
                  // on the right side
                  first_name: "required",
                  last_name: "required",
                  enroller_id:  "required",
                  sponsor_id: "required",
                  gender: "required",
                  marital_status: "required",
                  address1: "required",
                  address2: "required",
                  city: "required",
                  state: "required",
                  postal_code: "required",
                  nominee_name: "required",
                  nominee_relation: "required",
                  account_no: "required",
                  account_title: "required",
                  bank_name: "required",
                  branch_name: "required",
                  ifcs: "required",
                  swift_code: "required",
                  phone: {
                      required:true,
                      number: true,
                      minlength:10,
                      maxlength:10,
                  },
                  pan_no: {
                      required: true,
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
                  gender: "Please select gender",
                  marital_status: "Please select marital status",
                  address1: "Please enter address1",
                  address2: "Please enter address2",
                  city: "Please enter city",
                  state: "Please enter state",
                  postal_code: "Please enter postal code",
                  nominee_name: "Please enter co applicant name",
                  nominee_relation: "Please enter co applicant relationship",
                  account_no: "Please enter account number",
                  account_title: "Please enter account title",
                  bank_name: "Please enter bank name",
                  branch_name: "Please enter branch name",
                  ifcs: "Please enter IFCS code",
                  swift_code: "Please enter swift code",
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
                      required: "Please enter PAN number",
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