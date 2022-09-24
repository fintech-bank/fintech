<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Customer\CustomerCheckDepositList
 *
 * @property int $id
 * @property string $number
 * @property float $amount
 * @property string $name_deposit
 * @property string $bank_deposit
 * @property \Illuminate\Support\Carbon $date_deposit
 * @property int $customer_check_deposit_id
 * @property-read \App\Models\Customer\CustomerCheckDeposit $deposit
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheckDepositList newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheckDepositList newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheckDepositList query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheckDepositList whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheckDepositList whereBankDeposit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheckDepositList whereCustomerCheckDepositId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheckDepositList whereDateDeposit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheckDepositList whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheckDepositList whereNameDeposit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheckDepositList whereNumber($value)
 * @mixin \Eloquent
 * @property int $verified
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheckDepositList whereVerified($value)
 */
class CustomerCheckDepositList extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;
    protected $dates = ['date_deposit'];
    protected $appends = ['is_verified_label', 'date_deposit_format'];

    /**
     * @return BelongsTo
     */
    public function deposit(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(CustomerCheckDeposit::class, 'customer_check_deposit_id');
    }

    public function getIsVerifiedLabelAttribute()
    {
        if($this->verified) {
            return "<span class='badge badge-success'><i class='fa-solid fa-check me-2'></i> Valider</span>";
        } else {
            return "<span class='badge badge-danger'><i class='fa-solid fa-xmark me-2'></i> A Vérifier</span>";
        }
    }

    public function getDateDepositFormatAttribute()
    {
        return $this->date_deposit->format('d/m/Y');
    }

    public function scopeIsVerified($query)
    {
        $query->update(['verified' => true]);
    }

    public function scopeIsUnverified($query)
    {
        $query->update(['verified' => false]);
    }
}
