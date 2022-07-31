<?php

namespace App\Models\Customer;

use App\Models\Core\EpargnePlan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Customer\CustomerEpargne
 *
 * @property int $id
 * @property string $uuid
 * @property string $reference
 * @property float $initial_payment
 * @property float $monthly_payment
 * @property int $monthly_days
 * @property int $wallet_id
 * @property int $wallet_payment_id
 * @property int $epargne_plan_id
 * @property-read \App\Models\Customer\CustomerWallet $payment
 * @property-read EpargnePlan $plan
 * @property-read \App\Models\Customer\CustomerWallet $wallet
 *
 * @method static \Database\Factories\Customer\CustomerEpargneFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerEpargne newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerEpargne newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerEpargne query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerEpargne whereEpargnePlanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerEpargne whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerEpargne whereInitialPayment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerEpargne whereMonthlyDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerEpargne whereMonthlyPayment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerEpargne whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerEpargne whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerEpargne whereWalletId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerEpargne whereWalletPaymentId($value)
 * @mixin \Eloquent
 * @mixin IdeHelperCustomerEpargne
 */
class CustomerEpargne extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;

    public function plan()
    {
        return $this->belongsTo(EpargnePlan::class, 'epargne_plan_id');
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
