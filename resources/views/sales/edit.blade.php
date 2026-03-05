@extends('layouts.app')
@section('title', __('Edit Sale'))
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>{{ __('Edit Sale') }} - {{ $sale->invoice_no }}</h4>
    <a href="{{ route('sales.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> {{ __('Back') }}</a>
</div>

<form action="{{ route('sales.update', $sale) }}" method="POST" id="saleForm">
    @csrf @method('PUT')
    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-3">
                <div class="card-header"><i class="bi bi-receipt"></i> {{ __('Invoice Info') }}</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">{{ __('Invoice No') }}</label>
                            <input type="text" class="form-control" value="{{ $sale->invoice_no }}" readonly>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">{{ __('Sale Date') }} <span class="text-danger">*</span></label>
                            <input type="date" name="sale_date" class="form-control" value="{{ old('sale_date', $sale->sale_date->format('Y-m-d')) }}" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">{{ __('Customer') }}</label>
                            <div class="input-group">
                                <select name="customer_id" class="form-select" id="customerSelect">
                                    <option value="">{{ __('Select Customer') }}</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}" {{ old('customer_id', $sale->customer_id) == $customer->id ? 'selected' : '' }}>{{ $customer->name }}</option>
                                    @endforeach
                                </select>
                                <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#newCustomerModal" title="{{ __('New Customer') }}"><i class="bi bi-plus-lg"></i></button>
                            </div>
                            <input type="hidden" name="customer_name" id="customerNameHidden" value="{{ $sale->customer_name }}">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-cart-plus"></i> {{ __('Products') }}</span>
                    <div class="d-flex align-items-center gap-2">
                        <div class="input-group input-group-sm" style="width: 250px;">
                            <span class="input-group-text"><i class="bi bi-upc-scan"></i></span>
                            <input type="text" id="barcodeInput" class="form-control" placeholder="{{ __('Scan Barcode') }}" autocomplete="off">
                        </div>
                        <button type="button" class="btn btn-sm btn-success" id="addRow"><i class="bi bi-plus-circle"></i> {{ __('Add Product') }}</button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0" id="itemsTable">
                            <thead class="table-light">
                                <tr>
                                    <th style="width:35%">{{ __('Product') }}</th>
                                    <th style="width:12%">{{ __('Stock') }}</th>
                                    <th style="width:13%">{{ __('Quantity') }}</th>
                                    <th style="width:18%">{{ __('Unit Price') }}</th>
                                    <th style="width:17%">{{ __('Total') }}</th>
                                    <th style="width:5%"></th>
                                </tr>
                            </thead>
                            <tbody id="itemsBody">
                                @foreach($sale->items as $i => $item)
                                <tr class="item-row">
                                    <td>
                                        <select name="items[{{ $i }}][product_id]" class="form-select product-select" required>
                                            <option value="">{{ __('Select Product') }}</option>
                                            @foreach($products as $product)
                                                <option value="{{ $product->id }}" data-price="{{ $product->sell_price }}" data-stock="{{ $product->quantity }}" data-barcode="{{ $product->barcode }}" {{ $item->product_id == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td><span class="stock-display badge bg-secondary">{{ $item->product->quantity ?? '-' }}</span></td>
                                    <td><input type="number" name="items[{{ $i }}][quantity]" class="form-control qty-input" min="1" value="{{ $item->quantity }}" required></td>
                                    <td>
                                        <div class="input-group">
                                            <span class="input-group-text">৳</span>
                                            <input type="number" step="0.01" name="items[{{ $i }}][sell_price]" class="form-control price-input" min="0" value="{{ $item->sell_price }}" required>
                                        </div>
                                    </td>
                                    <td><span class="line-total fw-bold">৳{{ number_format($item->total, 2) }}</span></td>
                                    <td><button type="button" class="btn btn-sm btn-outline-danger remove-row" title="{{ __('Remove') }}"><i class="bi bi-x-lg"></i></button></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header"><i class="bi bi-journal-text"></i> {{ __('Note') }}</div>
                <div class="card-body">
                    <textarea name="note" class="form-control" rows="2">{{ old('note', $sale->note) }}</textarea>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card sticky-top" style="top: 1rem;">
                <div class="card-header bg-primary text-white"><i class="bi bi-calculator"></i> {{ __('Invoice Summary') }}</div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <span>{{ __('Subtotal') }}</span>
                        <span class="fw-bold" id="subtotalDisplay">৳{{ number_format($sale->subtotal, 2) }}</span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('Discount') }}</label>
                        <div class="input-group">
                            <span class="input-group-text">৳</span>
                            <input type="number" step="0.01" name="discount" id="discountInput" class="form-control" value="{{ old('discount', $sale->discount) }}" min="0">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('Tax') }}</label>
                        <div class="input-group">
                            <select name="tax_type" id="taxTypeInput" class="form-select" style="max-width: 90px;">
                                <option value="percentage" {{ old('tax_type', $sale->tax_type) == 'percentage' ? 'selected' : '' }}>%</option>
                                <option value="fixed" {{ old('tax_type', $sale->tax_type) == 'fixed' ? 'selected' : '' }}>৳</option>
                            </select>
                            <input type="number" step="0.01" name="tax_value" id="taxValueInput" class="form-control" value="{{ old('tax_value', $sale->tax_value) }}" min="0">
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span>{{ __('Tax Amount') }}</span>
                        <span class="fw-bold" id="taxAmountDisplay">৳{{ number_format($sale->tax_amount, 2) }}</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="fs-5 fw-bold">{{ __('Net Total') }}</span>
                        <span class="fs-5 fw-bold text-primary" id="netTotalDisplay">৳{{ number_format($sale->total_price, 2) }}</span>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <label class="form-label">{{ __('Paid Amount') }}</label>
                        <div class="input-group">
                            <span class="input-group-text">৳</span>
                            <input type="number" step="0.01" name="paid_amount" id="paidInput" class="form-control" value="{{ old('paid_amount', $sale->paid_amount) }}" min="0">
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="fw-bold">{{ __('Due Amount') }}</span>
                        <span class="fw-bold {{ $sale->due_amount > 0 ? 'text-danger' : 'text-success' }}" id="dueDisplay">৳{{ number_format($sale->due_amount, 2) }}</span>
                    </div>
                    <hr>
                    <button type="submit" class="btn btn-primary w-100 btn-lg"><i class="bi bi-check-circle"></i> {{ __('Update Sale') }}</button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- New Customer Modal -->
<div class="modal fade" id="newCustomerModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-person-plus"></i> {{ __('New Customer') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">{{ __('Name') }} <span class="text-danger">*</span></label>
                    <input type="text" id="quickCustName" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ __('Phone') }}</label>
                    <input type="text" id="quickCustPhone" class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                <button type="button" class="btn btn-primary" id="saveQuickCustomer"><i class="bi bi-check-lg"></i> {{ __('Save') }}</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(function() {
    let rowIndex = {{ count($sale->items) }};

    // Barcode scanner
    $('#barcodeInput').on('keypress', function(e) {
        if (e.which === 13) {
            e.preventDefault();
            const barcode = $(this).val().trim();
            if (!barcode) return;
            const lastRow = $('.item-row:last');
            const select = lastRow.find('.product-select');
            const option = select.find('option[data-barcode="' + barcode + '"]');
            if (option.length) {
                if (select.val()) {
                    $('#addRow').trigger('click');
                    const newRow = $('.item-row:last');
                    newRow.find('.product-select').val(option.val()).trigger('change');
                } else {
                    select.val(option.val()).trigger('change');
                }
            } else {
                alert('{{ __("Product not found for this barcode.") }}');
            }
            $(this).val('').focus();
        }
    });

    // Customer select → fill hidden name
    $('#customerSelect').on('change', function() {
        $('#customerNameHidden').val($(this).find(':selected').text().trim());
    });

    // Quick add customer via AJAX
    $('#saveQuickCustomer').click(function() {
        const name = $('#quickCustName').val().trim();
        if (!name) { $('#quickCustName').focus(); return; }
        const phone = $('#quickCustPhone').val().trim();
        $.post("{{ route('customers.quick') }}", {
            _token: "{{ csrf_token() }}",
            name: name,
            phone: phone
        }).done(function(data) {
            const opt = new Option(data.name, data.id, true, true);
            $('#customerSelect').append(opt).trigger('change');
            $('#customerNameHidden').val(data.name);
            $('#quickCustName').val('');
            $('#quickCustPhone').val('');
            $('#newCustomerModal').modal('hide');
        }).fail(function() {
            alert('{{ __("Error saving customer.") }}');
        });
    });

    // Add row
    $('#addRow').click(function() {
        const row = $('#itemsBody tr.item-row:first').clone();
        row.find('select').attr('name', 'items['+rowIndex+'][product_id]').val('');
        row.find('.qty-input').attr('name', 'items['+rowIndex+'][quantity]').val(1);
        row.find('.price-input').attr('name', 'items['+rowIndex+'][sell_price]').val('');
        row.find('.stock-display').text('-');
        row.find('.line-total').text('৳0.00');
        $('#itemsBody').append(row);
        rowIndex++;
    });

    $(document).on('click', '.remove-row', function() {
        if ($('.item-row').length > 1) {
            $(this).closest('tr').remove();
            calculateTotals();
        }
    });

    $(document).on('change', '.product-select', function() {
        const row = $(this).closest('tr');
        const opt = $(this).find(':selected');
        const price = opt.data('price') || 0;
        const stock = opt.data('stock') || 0;
        row.find('.price-input').val(price);
        row.find('.stock-display').text(stock);
        row.find('.qty-input').attr('max', stock);
        calculateRow(row);
    });

    $(document).on('input', '.qty-input, .price-input', function() {
        calculateRow($(this).closest('tr'));
    });

    $('#discountInput, #paidInput, #taxValueInput, #taxTypeInput').on('input change', calculateTotals);

    function calculateRow(row) {
        const qty = parseFloat(row.find('.qty-input').val()) || 0;
        const price = parseFloat(row.find('.price-input').val()) || 0;
        const total = qty * price;
        row.find('.line-total').text('৳' + total.toFixed(2));
        calculateTotals();
    }

    function calculateTotals() {
        let subtotal = 0;
        $('.item-row').each(function() {
            const qty = parseFloat($(this).find('.qty-input').val()) || 0;
            const price = parseFloat($(this).find('.price-input').val()) || 0;
            subtotal += qty * price;
        });

        const discount = parseFloat($('#discountInput').val()) || 0;
        const afterDiscount = subtotal - discount;
        const taxType = $('#taxTypeInput').val();
        const taxValue = parseFloat($('#taxValueInput').val()) || 0;
        const taxAmount = taxType === 'percentage' ? (afterDiscount * taxValue / 100) : taxValue;
        const netTotal = afterDiscount + taxAmount;
        const paid = parseFloat($('#paidInput').val()) || 0;
        const due = netTotal - paid;

        $('#subtotalDisplay').text('৳' + subtotal.toFixed(2));
        $('#taxAmountDisplay').text('৳' + taxAmount.toFixed(2));
        $('#netTotalDisplay').text('৳' + netTotal.toFixed(2));
        $('#dueDisplay').text('৳' + due.toFixed(2));
        $('#dueDisplay').toggleClass('text-danger', due > 0).toggleClass('text-success', due <= 0);
    }
});
</script>
@endpush
