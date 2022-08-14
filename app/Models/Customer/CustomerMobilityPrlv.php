<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperCustomerMobilityPrlv
 */
class CustomerMobilityPrlv extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;

    public function mobility()
    {
        return $this->belongsTo(CustomerMobility::class, 'customer_mobility_id');
    }
}
