<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerCreditCard extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;

    public function wallet()
    {
        return $this->belongsTo(CustomerWallet::class, 'customer_wallet_id');
    }

    public function pret()
    {
        return $this->belongsTo(CustomerPret::class, 'customer_pret_id');
    }

    public function facelias()
    {
        return $this->hasOne(CustomerFacelia::class);
    }

    public function transactions()
    {
        return $this->hasMany(CustomerTransaction::class);
    }
}
