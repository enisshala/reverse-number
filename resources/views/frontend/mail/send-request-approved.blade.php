@component('mail::layout')
@slot('header')
    @component('mail::header', ['url' => config('app.url')])
        <!-- header here -->
        {{ config('app.name') }}
    @endcomponent
@endslot

Dear <b>{{$cancel_request->user->name}}</b>,<br><br>
We’re very pleased to inform you that your request cancellation request has been approved.<br>
You can login in your account and cancel you subscription from the dashboard panel.
<br>
@component('mail::button', ['url' => config('app.url').'/login'])
    Login
@endcomponent
<br>
Warm Regards,<br>
The <b>{{ config('app.name') }}</b> Team<br>
{{-- Subcopy --}}
@slot('subcopy')
    @component('mail::subcopy')
        <!-- subcopy here -->
        This email is intended solely for the use of the individual or entity to whom it is addressed.
        This message contains confidential information and is intended only for the individual named.
        If you are not the named addressee you should not disseminate, distribute or copy this e-mail.
    @endcomponent
@endslot

{{-- Footer --}}
@slot('footer')
    @component('mail::footer')
        <!-- footer here -->
        {{ now()->year }} {{ config('app.name') }}. All rights reserved.
    @endcomponent
@endslot
@endcomponent
