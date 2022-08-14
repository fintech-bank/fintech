<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Customer\CustomerMobilityCheque
 *
 * @mixin IdeHelperCustomerMobilityCheque
 * @property int $id
 * @property string $number
 * @property float $amount
 * @property \Illuminate\Support\Carbon $date_enc
 * @property string $creditor
 * @property string $file_url
 * @property int $valid
 * @property int $customer_mobility_id
 * @property-read \App\Models\Customer\CustomerMobility|null $mobility
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityCheque newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityCheque newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityCheque query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityCheque whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityCheque whereCreditor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityCheque whereCustomerMobilityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityCheque whereDateEnc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityCheque whereFileUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityCheque whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityCheque whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityCheque whereValid($value)
 */
class CustomerMobilityCheque extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;

    protected $dates = ['date_enc'];

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
