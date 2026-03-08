<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $quotation->quotation_no }}</title>
    <style>
        body { font-family: freeserif; font-size: 12px; color: #333; margin: 0; padding: 20px; }
        h1, h2, h3, strong, b, th { font-weight: normal; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #0d6efd; padding-bottom: 15px; }
        .header h1 { margin: 0; font-size: 22px; color: #0d6efd; }
        .header p { margin: 5px 0 0; color: #666; }
        .info-table { width: 100%; margin-bottom: 20px; }
        .info-table td { padding: 4px 0; vertical-align: top; }
        .info-table .label { color: #666; font-size: 11px; text-transform: uppercase; }
        .info-table .value { font-size: 13px; }
        .items-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .items-table th { background: #0d6efd; color: #fff; padding: 8px 10px; text-align: left; font-size: 11px; text-transform: uppercase; }
        .items-table td { padding: 8px 10px; border-bottom: 1px solid #ddd; }
        .items-table tr:nth-child(even) { background: #f8f9fa; }
        .text-end { text-align: right; }
        .text-center { text-align: center; }
        .summary-table { width: 300px; margin-left: auto; border-collapse: collapse; }
        .summary-table td { padding: 6px 10px; }
        .summary-table .total-row td { border-top: 2px solid #0d6efd; font-size: 14px; color: #0d6efd; }
        .note { margin-top: 20px; padding: 10px; background: #f8f9fa; border-left: 3px solid #0d6efd; }
        .note-label { margin-bottom: 5px; }
        .footer { margin-top: 40px; text-align: center; color: #999; font-size: 10px; border-top: 1px solid #ddd; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ config('app.name', 'Stock Management') }}</h1>
        <p>{{ __('Quotation') }}</p>
    </div>

    <table class="info-table">
        <tr>
            <td style="width:50%">
                <div class="label">{{ __('Customer') }}</div>
                <div class="value">{{ $quotation->customer->name ?? ($quotation->customer_name ?? '-') }}</div>
                @if($quotation->customer && $quotation->customer->phone)
                    <div>{{ $quotation->customer->phone }}</div>
                @endif
                @if($quotation->customer && $quotation->customer->email)
                    <div>{{ $quotation->customer->email }}</div>
                @endif
            </td>
            <td style="width:25%">
                <div class="label">{{ __('Quotation No') }}</div>
                <div class="value">{{ $quotation->quotation_no }}</div>
            </td>
            <td style="width:25%">
                <div class="label">{{ __('Date') }}</div>
                <div class="value">{{ $quotation->quotation_date->format('d/m/Y') }}</div>
            </td>
        </tr>
    </table>

    <table class="items-table">
        <thead>
            <tr>
                <th style="width:5%">#</th>
                <th style="width:45%">{{ __('Product') }}</th>
                <th class="text-center" style="width:15%">{{ __('Quantity') }}</th>
                <th class="text-end" style="width:15%">{{ __('Unit Price') }}</th>
                <th class="text-end" style="width:20%">{{ __('Total') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($quotation->items as $i => $item)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $item->product->name }}</td>
                <td class="text-center">{{ $item->quantity }}</td>
                <td class="text-end">{{ number_format($item->unit_price, 2) }}</td>
                <td class="text-end">{{ number_format($item->total, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <table class="summary-table">
        <tr>
            <td>{{ __('Subtotal') }}</td>
            <td class="text-end">{{ number_format($quotation->subtotal, 2) }}</td>
        </tr>
        @if($quotation->discount > 0)
        <tr>
            <td>{{ __('Discount') }}</td>
            <td class="text-end">-{{ number_format($quotation->discount, 2) }}</td>
        </tr>
        @endif
        @if($quotation->tax_value > 0)
        <tr>
            <td>{{ __('Tax') }} ({{ $quotation->tax_type === 'percentage' ? $quotation->tax_value . '%' : number_format($quotation->tax_value, 2) }})</td>
            <td class="text-end">{{ number_format($quotation->tax_amount, 2) }}</td>
        </tr>
        @endif
        <tr class="total-row">
            <td>{{ __('Net Total') }}</td>
            <td class="text-end">{{ number_format($quotation->total_price, 2) }}</td>
        </tr>
    </table>

    @if($quotation->note)
    <div class="note">
        <div class="note-label">{{ __('Note') }}</div>
        <div>{{ $quotation->note }}</div>
    </div>
    @endif

    <div class="footer">
        {{ __('This quotation is valid for 30 days from the date of issue.') }}
    </div>
</body>
</html>
