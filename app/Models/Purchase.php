<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_no', 'supplier_id', 'subtotal', 'discount',
        'tax_type', 'tax_value', 'tax_amount',
        'total_price', 'paid_amount', 'due_amount', 'purchase_date', 'note'
    ];

    protected $casts = [
        'purchase_date' => 'date',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function items()
    {
        return $this->hasMany(PurchaseItem::class);
    }

    public static function generatePurchaseNo(): string
    {
        $last = static::max('id') ?? 0;
        return 'PUR-' . str_pad($last + 1, 6, '0', STR_PAD_LEFT);
    }
}
