<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SaleReturn extends Model
{
    protected $fillable = ['sale_id', 'product_id', 'quantity', 'amount', 'reason', 'return_date'];
    protected $casts = ['return_date' => 'date'];
    public function sale() { return $this->belongsTo(Sale::class); }
    public function product() { return $this->belongsTo(Product::class); }
}
