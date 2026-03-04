<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_no', 'customer_id', 'customer_name', 'subtotal', 'discount',
        'total_price', 'paid_amount', 'due_amount', 'sale_date', 'note'
    ];

    protected $casts = [
        'sale_date' => 'date',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }

    public static function generateInvoiceNo(): string
    {
        $last = static::max('id') ?? 0;
        return 'INV-' . str_pad($last + 1, 6, '0', STR_PAD_LEFT);
    }
}
