<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; color: #333; line-height: 1.6; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #0d6efd; color: #fff; padding: 20px; text-align: center; border-radius: 5px 5px 0 0; }
        .body { padding: 20px; background: #f8f9fa; border: 1px solid #dee2e6; border-top: none; border-radius: 0 0 5px 5px; }
        .total { font-size: 18px; font-weight: bold; color: #0d6efd; }
        .footer { margin-top: 20px; text-align: center; color: #999; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2 style="margin:0">{{ config('app.name', 'Stock Management') }}</h2>
        </div>
        <div class="body">
            <p>{{ __('Dear Customer') }},</p>
            <p>{{ __('Please find attached your quotation.') }}</p>
            <p>
                <strong>{{ __('Quotation No') }}:</strong> {{ $quotation->quotation_no }}<br>
                <strong>{{ __('Date') }}:</strong> {{ $quotation->quotation_date->format('d/m/Y') }}<br>
                <strong class="total">{{ __('Total') }}: ৳{{ number_format($quotation->total_price, 2) }}</strong>
            </p>
            @if($quotation->note)
            <p><strong>{{ __('Note') }}:</strong> {{ $quotation->note }}</p>
            @endif
            <p>{{ __('Thank you for your interest.') }}</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} {{ config('app.name', 'Stock Management') }}</p>
        </div>
    </div>
</body>
</html>
