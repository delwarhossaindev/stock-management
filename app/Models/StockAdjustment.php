<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class StockAdjustment extends Model
{
    protected $fillable = ['product_id', 'type', 'quantity', 'reason', 'adjustment_date'];
    protected $casts = ['adjustment_date' => 'date'];
    public function product() { return $this->belongsTo(Product::class); }
}
