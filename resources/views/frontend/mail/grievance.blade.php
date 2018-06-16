<p>{{ __('strings.emails.grievance.email_body_title') }}</p>

<p><strong>{{ __('validation.attributes.frontend.complaint_no') }}:</strong> {{ $request->id }}</p>
<p><strong>{{ __('validation.attributes.frontend.type') }}:</strong> {{ $request->type }}</p>
<p><strong>{{ __('validation.attributes.frontend.profile_code') }}:</strong> {{ $request->profile_code }}</p>
<p><strong>{{ __('validation.attributes.frontend.name') }}:</strong> {{ $request->full_name }}</p>
<p><strong>{{ __('validation.attributes.frontend.email') }}:</strong> {{ $request->email }}</p>
<p><strong>{{ __('validation.attributes.frontend.phone') }}:</strong> {{ $request->phone or "N/A" }}</p>
<p><strong>{{ __('validation.attributes.frontend.message') }}:</strong> {{ $request->message }}</p>