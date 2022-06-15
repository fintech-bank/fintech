<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerFacelia extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;
    protected $dates = ["next_expiration"];

    public function pret()
    {
        return $this->belongsTo(CustomerPret::class, 'customer_pret_id');
    }

    public function card()
    {
        return $this->belongsTo(CustomerCreditCard::class, 'customer_credit_card_id');
    }

    public function wallet()
    {
        return $this->belongsTo(CustomerWallet::class, 'customer_wallet_id');
    }

    public function payment()
    {
        return $this->belongsTo(CustomerWallet::class, 'wallet_payment_id');
    }
}
