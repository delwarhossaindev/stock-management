@extends('layouts.app')
@section('title', __('POS'))
@section('content')
<div class="row">
    {{-- Left: Product Grid --}}
    <div class="col-md-7">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-grid"></i> {{ __('Products') }}</span>
                <input type="text" id="productSearch" class="form-control form-control-sm" style="width:200px" placeholder="{{ __('Search...') }}">
            </div>
            <div class="card-body" style="max-height:70vh; overflow-y:auto;">
                <div class="row g-2" id="productGrid">
                    @foreach($products as $product)
                    <div class="col-4 col-lg-3 product-card" data-name="{{ strtolower($product->name) }}" data-sku="{{ strtolower($product->sku) }}">
                        <div class="card h-100 border pos-product" style="cursor:pointer"
                             data-id="{{ $product->id }}"
                             data-name="{{ $product->name }}"
                             data-price="{{ $product->sell_price }}"
                             data-stock="{{ $product->quantity }}">
                            <div class="card-body p-2 text-center">
                                <div class="fw-bold small text-truncate">{{ $product->name }}</div>
                                <div class="text-primary fw-bold">৳{{ number_format($product->sell_price) }}</div>
                                <small class="text-muted">{{ __('Stock') }}: {{ $product->quantity }}</small>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Right: Cart --}}
    <div class="col-md-5">
        <div class="card">
            <div class="card-header bg-primary text-white"><i class="bi bi-cart3"></i> {{ __('Cart') }}</div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0" id="cartTable">
                    <thead><tr><th>{{ __('Product') }}</th><th style="width:70px">{{ __('Qty') }}</th><th style="width:90px">{{ __('Price') }}</th><th style="width:90px">{{ __('Total') }}</th><th style="width:30px"></th></tr></thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="card-body border-top">
                <div class="d-flex justify-content-between mb-2">
                    <span>{{ __('Subtotal') }}</span>
                    <span class="fw-bold" id="posSubtotal">৳0.00</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>{{ __('Discount') }}</span>
                    <input type="number" id="posDiscount" class="form-control form-control-sm" style="width:100px" value="0" min="0">
                </div>
                <div class="d-flex justify-content-between mb-2 fs-5 fw-bold text-primary">
                    <span>{{ __('Total') }}</span>
                    <span id="posTotal">৳0.00</span>
                </div>
                <hr>
                <div class="mb-2">
                    <label class="form-label small">{{ __('Customer') }}</label>
                    <select id="posCustomer" class="form-select form-select-sm">
                        <option value="">{{ __('Walk-in Customer') }}</option>
                        @foreach($customers as $c)
                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-2">
                    <label class="form-label small">{{ __('Paid Amount') }}</label>
                    <input type="number" id="posPaid" class="form-control" value="0" min="0" step="0.01">
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <span>{{ __('Change') }}</span>
                    <span class="fw-bold text-success" id="posChange">৳0.00</span>
                </div>
                <button class="btn btn-success w-100 btn-lg" id="posSubmit" disabled>
                    <i class="bi bi-check-circle"></i> {{ __('Complete Sale') }}
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Receipt Modal --}}
<div class="modal fade" id="receiptModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title"><i class="bi bi-check-circle text-success"></i> {{ __('Sale Complete') }}</h5></div>
            <div class="modal-body text-center">
                <p class="fs-5">{{ __('Invoice No') }}: <strong id="receiptInvoice"></strong></p>
                <a id="receiptViewLink" href="#" class="btn btn-info"><i class="bi bi-eye"></i> {{ __('View') }}</a>
                <button class="btn btn-primary" onclick="location.reload()"><i class="bi bi-plus-circle"></i> {{ __('New Sale') }}</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let cart = [];

$('#productSearch').on('input', function() {
    let q = this.value.toLowerCase();
    $('.product-card').each(function() {
        $(this).toggle($(this).data('name').includes(q) || $(this).data('sku').includes(q));
    });
});

$(document).on('click', '.pos-product', function() {
    let id = $(this).data('id'), name = $(this).data('name'), price = $(this).data('price'), stock = $(this).data('stock');
    let existing = cart.find(i => i.product_id === id);
    if (existing) {
        if (existing.quantity >= stock) return alert('{{ __("Not enough stock") }}');
        existing.quantity++;
    } else {
        cart.push({product_id: id, name: name, sell_price: price, quantity: 1, stock: stock});
    }
    renderCart();
});

function renderCart() {
    let html = '';
    cart.forEach((item, idx) => {
        let total = item.quantity * item.sell_price;
        html += `<tr>
            <td class="small">${item.name}</td>
            <td><input type="number" class="form-control form-control-sm cart-qty" data-idx="${idx}" value="${item.quantity}" min="1" max="${item.stock}"></td>
            <td class="small">৳${item.sell_price.toFixed(2)}</td>
            <td class="small fw-bold">৳${total.toFixed(2)}</td>
            <td><button class="btn btn-sm btn-outline-danger cart-remove" data-idx="${idx}"><i class="bi bi-x"></i></button></td>
        </tr>`;
    });
    $('#cartTable tbody').html(html);
    calcTotals();
}

$(document).on('change', '.cart-qty', function() {
    cart[$(this).data('idx')].quantity = parseInt(this.value) || 1;
    calcTotals();
});
$(document).on('click', '.cart-remove', function() { cart.splice($(this).data('idx'), 1); renderCart(); });

$('#posDiscount, #posPaid').on('input', calcTotals);

function calcTotals() {
    let sub = cart.reduce((s, i) => s + i.quantity * i.sell_price, 0);
    let disc = parseFloat($('#posDiscount').val()) || 0;
    let total = sub - disc;
    let paid = parseFloat($('#posPaid').val()) || 0;
    $('#posSubtotal').text('৳' + sub.toFixed(2));
    $('#posTotal').text('৳' + total.toFixed(2));
    $('#posChange').text('৳' + Math.max(0, paid - total).toFixed(2));
    $('#posSubmit').prop('disabled', cart.length === 0);
}

$('#posSubmit').click(function() {
    let disc = parseFloat($('#posDiscount').val()) || 0;
    let paid = parseFloat($('#posPaid').val()) || 0;
    let custId = $('#posCustomer').val();
    let custName = $('#posCustomer option:selected').text();

    $.ajax({
        url: '{{ route("pos.store") }}',
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            items: cart,
            discount: disc,
            paid_amount: paid,
            customer_id: custId || null,
            customer_name: custId ? custName : null
        },
        success: function(res) {
            $('#receiptInvoice').text(res.invoice_no);
            $('#receiptViewLink').attr('href', '/sales/' + res.sale_id);
            new bootstrap.Modal('#receiptModal').show();
        },
        error: function(xhr) { alert(xhr.responseJSON?.message || 'Error'); }
    });
});
</script>
@endpush
