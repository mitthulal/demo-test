@component('mail::message')
# Hello {{ $invoice->client->name }},

Please find attached your invoice **#{{ $invoice->invoice_number }}**.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
