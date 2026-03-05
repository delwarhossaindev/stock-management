@extends('layouts.app')
@section('title', $quotation->quotation_no)
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>{{ __('Quotation') }}: {{ $quotation->quotation_no }}</h4>
    <div class="no-print">
        <a href="{{ route('quotations.pdf', $quotation) }}" class="btn btn-outline-danger"><i class="bi bi-file-earmark-pdf"></i> {{ __('PDF') }}</a>
        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#emailModal"><i class="bi bi-envelope"></i> {{ __('Email') }}</button>
        @php
            $phone = $quotation->customer->phone ?? null;
            $waPhone = $phone ? preg_replace('/[^0-9]/', '', $phone) : '';
            $waText = __('Quotation') . ': ' . $quotation->quotation_no . "\n" . __('Total') . ': ৳' . number_format($quotation->total_price, 2) . "\n" . __('Date') . ': ' . $quotation->quotation_date->format('d/m/Y') . "\n" . url(route('quotations.pdf', $quotation));
        @endphp
        <a href="https://wa.me/{{ $waPhone }}?text={{ urlencode($waText) }}" target="_blank" class="btn btn-success"><i class="bi bi-whatsapp"></i> {{ __('WhatsApp') }}</a>
        <button onclick="window.print()" class="btn btn-outline-secondary"><i class="bi bi-printer"></i> {{ __('Print') }}</button>
        <a href="{{ route('quotations.edit', $quotation) }}" class="btn btn-warning"><i class="bi bi-pencil"></i> {{ __('Edit') }}</a>
        <a href="{{ route('quotations.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> {{ __('Back') }}</a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-6">
                <h6 class="text-muted">{{ __('Customer') }}</h6>
                <p class="fw-bold fs-5">{{ $quotation->customer->name ?? ($quotation->customer_name ?? '-') }}</p>
            </div>
            <div class="col-md-3">
                <h6 class="text-muted">{{ __('Quotation No') }}</h6>
                <p class="fw-bold">{{ $quotation->quotation_no }}</p>
            </div>
            <div class="col-md-3">
                <h6 class="text-muted">{{ __('Date') }}</h6>
                <p class="fw-bold">{{ $quotation->quotation_date->format('d/m/Y') }}</p>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>{{ __('Product') }}</th>
                        <th class="text-center">{{ __('Quantity') }}</th>
                        <th class="text-end">{{ __('Unit Price') }}</th>
                        <th class="text-end">{{ __('Total') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($quotation->items as $i => $item)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $item->product->name }}</td>
                        <td class="text-center">{{ $item->quantity }}</td>
                        <td class="text-end">৳{{ number_format($item->unit_price, 2) }}</td>
                        <td class="text-end">৳{{ number_format($item->total, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="row justify-content-end">
            <div class="col-md-5">
                <table class="table table-sm">
                    <tr>
                        <td>{{ __('Subtotal') }}</td>
                        <td class="text-end fw-bold">৳{{ number_format($quotation->subtotal, 2) }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('Discount') }}</td>
                        <td class="text-end">৳{{ number_format($quotation->discount, 2) }}</td>
                    </tr>
                    @if($quotation->tax_value > 0)
                    <tr>
                        <td>{{ __('Tax') }} ({{ $quotation->tax_type === 'percentage' ? $quotation->tax_value . '%' : '৳' . number_format($quotation->tax_value, 2) }})</td>
                        <td class="text-end">৳{{ number_format($quotation->tax_amount, 2) }}</td>
                    </tr>
                    @endif
                    <tr class="table-primary">
                        <td class="fw-bold fs-5">{{ __('Net Total') }}</td>
                        <td class="text-end fw-bold fs-5">৳{{ number_format($quotation->total_price, 2) }}</td>
                    </tr>
                </table>
            </div>
        </div>

        @if($quotation->note)
        <div class="mt-3">
            <h6 class="text-muted">{{ __('Note') }}</h6>
            <p>{{ $quotation->note }}</p>
        </div>
        @endif
    </div>
</div>
<!-- Email Modal -->
<div class="modal fade no-print" id="emailModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('quotations.email', $quotation) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-envelope"></i> {{ __('Send Quotation via Email') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">{{ __('Email') }} <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" value="{{ $quotation->customer->email ?? '' }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-send"></i> {{ __('Send') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
