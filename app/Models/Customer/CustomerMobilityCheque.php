<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperCustomerMobilityCheque
 */
class CustomerMobilityCheque extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;

    protected $dates = ['date_enc'];

    public function mobility()
    {
        return $this->belongsTo(CustomerMobility::class);
    }
}
