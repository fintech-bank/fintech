<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Customer\CustomerMobilityVirOutgoing
 *
 * @mixin IdeHelperCustomerMobilityVirOutgoing
 * @property int $id
 * @property string $uuid
 * @property float $amount
 * @property string $reference
 * @property string $reason
 * @property \Illuminate\Support\Carbon|null $transfer_date
 * @property int $valid
 * @property int $customer_mobility_id
 * @property-read \App\Models\Customer\CustomerMobility $mobility
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityVirOutgoing newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityVirOutgoing newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityVirOutgoing query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityVirOutgoing whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityVirOutgoing whereCustomerMobilityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityVirOutgoing whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityVirOutgoing whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityVirOutgoing whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityVirOutgoing whereTransferDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityVirOutgoing whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityVirOutgoing whereValid($value)
 */
class CustomerMobilityVirOutgoing extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;

    protected $dates = ['transfer_date'];

    public function mobility()
    {
        return $this->belongsTo(CustomerMobility::class, 'customer_mobility_id');
    }

    public function isValid()
    {
        if($this->valid == 1) {
            return '<i class="fa-solid fa-check-circle text-success fa-xl"></i>';
        } else {
            return '<i class="fa-solid fa-xmark-circle text-danger fa-xl"></i>';
        }
    }

    public function validate()
    {
        $this->update([
            'valid' => 1
        ]);
    }
}
