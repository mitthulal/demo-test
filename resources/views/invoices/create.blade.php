<!-- Add this in your <head> or layout file -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header">
            <h4>Create Invoice</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('invoices.store') }}" method="POST">
                @csrf
                <input type="hidden" name="client_id" value="{{$id}}">
                <input type="hidden" name="id" value="{{$type}}">
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select" required>
                        <option value="">-- Select Status --</option>
                        <option value="unpaid" {{ $value != null && $value->status == 'unpaid' ? 'selected' : '' }}>unpaid</option>
                        <option value="paid"  {{ $value != null && $value->status == 'paid' ? 'selected' : '' }}>paid</option>
                        <option value="pending"  {{ $value != null && $value->status == 'pending' ? 'selected' : '' }}>pending</option>
                    </select>
                    @error('status')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="invoice_number" class="form-label">Invoice Number</label>
                    <input type="text" name="invoice_number" id="invoice_number" class="form-control"  value="{{ $value != null ? $value->invoice_number : old('invoice_number') }}">
                    @error('invoice_number')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="total" class="form-label">Amount</label>
                    <input type="text" name="total" id="total" class="form-control"  value="{{ $value != null ? $value->total : old('total') }}">
                    @error('total')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="invoice_date" class="form-label">Invoice Date</label>
                    <input type="date" name="invoice_date" id="invoice_date" class="form-control" value="{{ $value != null ? $value->invoice_date : old('invoice_date') }}" >
                    @error('invoice_date')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Create Invoice</button>
            </form>
        </div>
    </div>
</div>
