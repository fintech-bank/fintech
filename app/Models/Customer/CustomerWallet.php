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

    public function transfers()
    {
        return $this->hasMany(CustomerTransfer::class);
    }

    public function loan()
    {
        return $this->hasMany(CustomerPret::class);
    }

    public function epargnes()
    {
        return $this->hasMany(CustomerEpargne::class, 'id');
    }

    public function epargne_payment()
    {
        return $this->hasMany(CustomerEpargne::class);
    }

    public function checks()
    {
        return $this->hasMany(CustomerCheck::class);
    }
}
