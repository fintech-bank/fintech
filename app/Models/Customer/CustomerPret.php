<?php

namespace App\Models\Customer;

use App\Models\Core\LoanPlan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerPret extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;

    public function plan()
    {
        return $this->belongsTo(LoanPlan::class, 'loan_plan_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function wallet()
    {
        return $this->belongsTo(CustomerWallet::class, 'customer_wallet_loan_id');
    }

    public function payment()
    {
        return $this->belongsTo(CustomerWallet::class, 'customer_wallet_payment_id');
    }
}
