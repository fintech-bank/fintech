<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerWallet extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;

    protected $dates = ["alert_date"];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function cards()
    {
        return $this->hasMany(CustomerCreditCard::class);
    }

    public function transactions()
    {
        return $this->hasMany(CustomerTransaction::class);
    }

    public function sepas()
    {
        return $this->hasMany(CustomerSepa::class);
    }

    public function creditors()
    {
        return $this->hasMany(CustomerCreditor::class);
    }

    public function transfers()
    {
        return $this->hasMany(CustomerTransfer::class);
    }

    public function loan()
    {
        return $this->hasOne(CustomerPret::class);
    }

    public function epargne()
    {
        return $this->hasOne(CustomerEpargne::class, 'wallet_id');
    }

    public function epargne_payment()
    {
        return $this->hasOne(CustomerEpargne::class);
    }

    public function checks()
    {
        return $this->hasMany(CustomerCheck::class);
    }
}
