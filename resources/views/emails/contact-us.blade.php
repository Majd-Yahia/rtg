@component('mail::message')

    # Email Confirmation
@component('mail::button', ['url' => env('APP_URL') . 'api/verify?token=1'])
Verify Now
@endcomponent
@endcomponent

{{-- @component same line, PYTHON ALL OVER AGAIN! --}}
