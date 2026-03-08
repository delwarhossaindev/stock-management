<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ __('Invoice') }} - {{ $sale->invoice_no }}</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #4f46e5; padding-bottom: 10px; }
        .header h2 { margin: 0; color: #4f46e5; }
        .info-table { width: 100%; margin-bottom: 15px; }
        .info-table td { padding: 3px 5px; vertical-align: top; }
        .items-table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        .items-table th { background: #4f46e5; color: #fff; padding: 8px; text-align: left; }
        .items-table td { padding: 6px 8px; border-bottom: 1px solid #eee; }
        .summary { width: 300px; float: right; }
        .summary td { padding: 4px 8px; }
        .summary .total { font-weight: bold; font-size: 14px; border-top: 2px solid #333; }
        .footer { clear: both; text-align: center; margin-top: 40px; font-size: 10px; color: #999; }
    </style>
</head>
<body>
    <div class="header">
        <h2>{{ \App\Models\Setting::get('company_name', 'Stock Manager') }}</h2>
        <p>{{ \App\Models\Setting::get('company_address', '') }}<br>
        {{ \App\Models\Setting::get('company_phone', '') }} | {{ \App\Models\Setting::get('company_email', '') }}</p>
    </div>

    <h3 style="text-align:center">{{ __('Sale Invoice') }}</h3>

    <table class="info-table">
        <tr>
            <td><strong>{{ __('Invoice No') }}:</strong> {{ $sale->invoice_no }}</td>
            <td style="text-align:right"><strong>{{ __('Date') }}:</strong> {{ $sale->sale_date->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <td><strong>{{ __('Customer') }}:</strong> {{ $sale->customer->name ?? $sale->customer_name ?? __('Walk-in Customer') }}</td>
            <td></td>
        </tr>
    </table>

    <table class="items-table">
        <thead><tr><th>#</th><th>{{ __('Product') }}</th><th>{{ __('Quantity') }}</th><th>{{ __('Unit Price') }}</th><th>{{ __('Total') }}</th></tr></thead>
        <tbody>
            @foreach($sale->items as $i => $item)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $item->product->name ?? '-' }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ number_format($item->sell_price, 2) }}</td>
                <td>{{ number_format($item->total, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <table class="summary">
        <tr><td>{{ __('Subtotal') }}:</td><td style="text-align:right">{{ number_format($sale->subtotal, 2) }}</td></tr>
        <tr><td>{{ __('Discount') }}:</td><td style="text-align:right">{{ number_format($sale->discount, 2) }}</td></tr>
        <tr><td>{{ __('Tax') }}:</td><td style="text-align:right">{{ number_format($sale->tax_amount, 2) }}</td></tr>
        <tr class="total"><td>{{ __('Total') }}:</td><td style="text-align:right">{{ number_format($sale->total_price, 2) }}</td></tr>
        <tr><td>{{ __('Paid') }}:</td><td style="text-align:right">{{ number_format($sale->paid_amount, 2) }}</td></tr>
        <tr><td>{{ __('Due') }}:</td><td style="text-align:right">{{ number_format($sale->due_amount, 2) }}</td></tr>
    </table>

    <div class="footer">
        <p>{{ __('Thank you for your business!') }}</p>
    </div>
</body>
</html>
