<?php

namespace App\Models\Customer;

use App\Models\Core\EpargnePlan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerEpargne extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;

    public function plan()
    {
        return $this->belongsTo(EpargnePlan::class);
    }

    public function wallet()
    {
        return $this->belongsTo(CustomerWallet::class, 'wallet_id');
    }

    public function payment()
    {
        return $this->belongsTo(CustomerWallet::class, 'wallet_payment_id');
    }
}
