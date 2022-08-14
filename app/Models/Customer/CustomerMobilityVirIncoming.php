<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Customer\CustomerMobilityVirIncoming
 *
 * @mixin IdeHelperCustomerMobilityVirIncoming
 * @property int $id
 * @property string $uuid
 * @property float $amount
 * @property string $reference
 * @property string $reason
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $transfer_date
 * @property \Illuminate\Support\Carbon|null $recurring_start
 * @property \Illuminate\Support\Carbon|null $recurring_end
 * @property int $valid
 * @property int $customer_mobility_id
 * @property-read \App\Models\Customer\CustomerMobility $mobility
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityVirIncoming newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityVirIncoming newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityVirIncoming query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityVirIncoming whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityVirIncoming whereCustomerMobilityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityVirIncoming whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityVirIncoming whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityVirIncoming whereRecurringEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityVirIncoming whereRecurringStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityVirIncoming whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityVirIncoming whereTransferDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityVirIncoming whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityVirIncoming whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityVirIncoming whereValid($value)
 */
class CustomerMobilityVirIncoming extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;

    protected $dates = ['transfer_date', 'recurring_start', 'recurring_end'];

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
