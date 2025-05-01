<h1>Invoice #{{ $invoice->invoice_number }}</h1>
<p>Date: {{ $invoice->invoice_date }}</p>
<p>Status: {{ $invoice->status }}</p>
<p>Total: ${{ $invoice->total }}</p>

<hr>
<p><strong>Client:</strong> {{ $invoice->client->name }} ({{ $invoice->client->email }})</p>
<p><strong>Phone:</strong> {{ $invoice->client->phone }}</p>
