<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerCreditor extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;

    public function wallet()
    {
        return $this->belongsTo(CustomerWallet::class, 'customer_wallet_id');
    }

    public function sepa()
    {
        return $this->belongsTo(CustomerSepa::class, 'customer_sepa_id');
    }
}
