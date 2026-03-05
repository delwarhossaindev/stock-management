<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    use HasFactory;

    protected $fillable = [
        'quotation_no', 'customer_id', 'customer_name', 'subtotal', 'discount',
        'tax_type', 'tax_value', 'tax_amount',
        'total_price', 'quotation_date', 'note'
    ];

    protected $casts = [
        'quotation_date' => 'date',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->hasMany(QuotationItem::class);
    }

    public static function generateQuotationNo(): string
    {
        $last = static::max('id') ?? 0;
        return 'QUO-' . str_pad($last + 1, 6, '0', STR_PAD_LEFT);
    }
}
