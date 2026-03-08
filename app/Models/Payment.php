<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['payable_type', 'payable_id', 'amount', 'method', 'payment_date', 'note'];
    protected $casts = ['payment_date' => 'date'];
    public function payable() { return $this->morphTo(); }
}
