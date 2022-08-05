<?php

namespace App\Models\Customer;

use App\Models\Core\Bank;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperCustomerMobility
 */
class CustomerMobility extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;

    protected $dates = ['start', 'end_prov', 'end_real', 'end_prlv'];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class, 'bank_id');
    }

    public function wallet()
    {
        return $this->belongsTo(CustomerWallet::class, 'customer_wallet_id');
    }
}
