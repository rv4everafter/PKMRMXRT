 {{ __('strings.emails.grievance.email_body_title') }}

{{ __('validation.attributes.frontend.profile_code') }}: {{ $request->profile_code }}
{{ __('validation.attributes.frontend.name') }}: {{ $request->name }}
{{ __('validation.attributes.frontend.email') }}: {{ $request->email }}
{{ __('validation.attributes.frontend.phone') }}: {{ $request->phone or "N/A" }}
{{ __('validation.attributes.frontend.message') }}: { { $request->message }}