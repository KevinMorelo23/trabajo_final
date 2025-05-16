<?php
namespace Payment\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Sale\Model\Sale;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale_id',
        'payment_method', 
        'reference_number',
        'card_number',
        'cardholder_name',
        'card_expiry',
        'bank_name',
        'account_number',
        'amount',
        'status',
        'amount_tendered',
        'change',
        'installments'
    ];

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }
}
