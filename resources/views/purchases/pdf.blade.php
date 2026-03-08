<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ __('Invoice') }} - {{ $purchase->purchase_no }}</title>
    <style>
        body { font-family: freeserif; font-size: 12px; color: #333; }
        h1, h2, h3, strong, b, th { font-weight: normal; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #4f46e5; padding-bottom: 10px; }
        .header h2 { margin: 0; color: #4f46e5; }
        .info-table { width: 100%; margin-bottom: 15px; }
        .info-table td { padding: 3px 5px; vertical-align: top; }
        .items-table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        .items-table th { background: #4f46e5; color: #fff; padding: 8px; text-align: left; }
        .items-table td { padding: 6px 8px; border-bottom: 1px solid #eee; }
        .summary { width: 300px; float: right; }
        .summary td { padding: 4px 8px; }
        .summary .total { font-size: 14px; border-top: 2px solid #333; }
        .footer { clear: both; text-align: center; margin-top: 40px; font-size: 10px; color: #999; }
    </style>
</head>
<body>
    <div class="header">
        <h2>{{ \App\Models\Setting::get('company_name', 'Stock Manager') }}</h2>
        <p>{{ \App\Models\Setting::get('company_address', '') }}<br>
        {{ \App\Models\Setting::get('company_phone', '') }} | {{ \App\Models\Setting::get('company_email', '') }}</p>
    </div>

    <h3 style="text-align:center">{{ __('Purchase Invoice') }}</h3>

    <table class="info-table">
        <tr>
            <td>{{ __('Purchase No') }}: {{ $purchase->purchase_no }}</td>
            <td style="text-align:right">{{ __('Date') }}: {{ $purchase->purchase_date->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <td>{{ __('Supplier') }}: {{ $purchase->supplier->name ?? '-' }}</td>
            <td></td>
        </tr>
    </table>

    <table class="items-table">
        <thead><tr><th>#</th><th>{{ __('Product') }}</th><th>{{ __('Quantity') }}</th><th>{{ __('Unit Price') }}</th><th>{{ __('Total') }}</th></tr></thead>
        <tbody>
            @foreach($purchase->items as $i => $item)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $item->product->name ?? '-' }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ number_format($item->buy_price, 2) }}</td>
                <td>{{ number_format($item->total, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <table class="summary">
        <tr><td>{{ __('Subtotal') }}:</td><td style="text-align:right">{{ number_format($purchase->subtotal, 2) }}</td></tr>
        <tr><td>{{ __('Discount') }}:</td><td style="text-align:right">{{ number_format($purchase->discount, 2) }}</td></tr>
        <tr><td>{{ __('Tax') }}:</td><td style="text-align:right">{{ number_format($purchase->tax_amount, 2) }}</td></tr>
        <tr class="total"><td>{{ __('Total') }}:</td><td style="text-align:right">{{ number_format($purchase->total_price, 2) }}</td></tr>
        <tr><td>{{ __('Paid') }}:</td><td style="text-align:right">{{ number_format($purchase->paid_amount, 2) }}</td></tr>
        <tr><td>{{ __('Due') }}:</td><td style="text-align:right">{{ number_format($purchase->due_amount, 2) }}</td></tr>
    </table>

    <div class="footer">
        <p>{{ __('Thank you for your business!') }}</p>
    </div>
</body>
</html>
