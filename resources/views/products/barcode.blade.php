<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ __('Barcode') }} - {{ $product->name }}</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; margin: 0; padding: 10px; }
        .label-grid { display: flex; flex-wrap: wrap; gap: 8px; }
        .barcode-label {
            border: 1px dashed #ccc; padding: 8px; text-align: center; width: 200px;
        }
        .barcode-label .product-name { font-size: 10px; font-weight: bold; margin-bottom: 4px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .barcode-label .barcode-img { margin: 4px 0; }
        .barcode-label .barcode-text { font-size: 10px; letter-spacing: 2px; }
        .barcode-label .price { font-size: 12px; font-weight: bold; margin-top: 2px; }
        @media print { body { margin: 0; } .no-print { display: none !important; } }
    </style>
</head>
<body>
    <div class="no-print" style="margin-bottom:15px;">
        <button onclick="window.print()" style="padding:8px 20px; cursor:pointer;">{{ __('Print') }}</button>
        <button onclick="window.close()" style="padding:8px 20px; cursor:pointer;">{{ __('Close') }}</button>
        <label style="margin-left:15px;">{{ __('Quantity') }}:
            <input type="number" id="qty" value="{{ $qty }}" min="1" max="100" style="width:60px; padding:4px;">
            <button onclick="location.href='{{ route('products.barcode', $product) }}?qty='+document.getElementById('qty').value" style="padding:4px 12px; cursor:pointer;">{{ __('Update') }}</button>
        </label>
    </div>
    <div class="label-grid">
        @for($i = 0; $i < $qty; $i++)
        <div class="barcode-label">
            <div class="product-name">{{ $product->name }}</div>
            <div class="barcode-img">{!! $barcodeSvg !!}</div>
            <div class="barcode-text">{{ $product->barcode ?: $product->sku }}</div>
            <div class="price">৳{{ number_format($product->sell_price, 2) }}</div>
        </div>
        @endfor
    </div>
</body>
</html>
