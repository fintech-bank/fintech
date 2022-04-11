<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerTransfer extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;

    protected $dates = ["transfer_date", "recurring_start", "recurring_end"];

    public function wallet()
    {
        return $this->belongsTo(CustomerWallet::class, 'customer_wallet_id');
    }

    public function beneficiaire()
    {
        return $this->belongsTo(CustomerBeneficiaire::class, 'customer_beneficiaire_id');
    }
}
