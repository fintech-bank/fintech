<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Customer\CustomerMobilityPrlv
 *
 * @mixin IdeHelperCustomerMobilityPrlv
 * @property int $id
 * @property string $uuid
 * @property string $creditor
 * @property string $number_mandate
 * @property float $amount
 * @property int $valid
 * @property int $customer_mobility_id
 * @property-read \App\Models\Customer\CustomerMobility $mobility
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityPrlv newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityPrlv newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityPrlv query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityPrlv whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityPrlv whereCreditor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityPrlv whereCustomerMobilityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityPrlv whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityPrlv whereNumberMandate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityPrlv whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityPrlv whereValid($value)
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
