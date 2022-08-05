<?php

namespace App\Models\Customer;

use App\Models\Core\LoanPlan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Customer\CustomerPret
 *
 * @property int $id
 * @property string $uuid
 * @property string $reference
 * @property float $amount_loan Montant du crédit demander
 * @property float $amount_interest Montant des interet du par le client
 * @property float $amount_du Total des sommes du par le client (Credit + Interet - mensualités payé)
 * @property float $mensuality Mensualité du par le client par mois
 * @property int $prlv_day Jours du prélèvement de la mensualité
 * @property int $duration Durée total du contrat en année
 * @property string $status
 * @property int $signed_customer
 * @property int $signed_bank
 * @property int $alert
 * @property string $assurance_type
 * @property int $customer_wallet_id
 * @property int $wallet_payment_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $first_payment_at
 * @property int $loan_plan_id
 * @property int $customer_id
 * @property-read \App\Models\Customer\CustomerCreditCard|null $card
 * @property-read \App\Models\Customer\Customer $customer
 * @property-read \App\Models\Customer\CustomerFacelia|null $facelia
 * @property-read \App\Models\Customer\CustomerWallet $payment
 * @property-read LoanPlan $plan
 * @property-read \App\Models\Customer\CustomerWallet $wallet
 * @method static \Database\Factories\Customer\CustomerPretFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret whereAlert($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret whereAmountDu($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret whereAmountInterest($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret whereAmountLoan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret whereAssuranceType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret whereCustomerWalletId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret whereFirstPaymentAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret whereLoanPlanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret whereMensuality($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret wherePrlvDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret whereSignedBank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret whereSignedCustomer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret whereWalletPaymentId($value)
 * @mixin \Eloquent
 * @mixin IdeHelperCustomerPret
 */
class CustomerPret extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $dates = ['created_at', 'updated_at', 'first_payment_at'];

    public function plan()
    {
        return $this->belongsTo(LoanPlan::class, 'loan_plan_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function wallet()
    {
        return $this->belongsTo(CustomerWallet::class, 'customer_wallet_id');
    }

    public function payment()
    {
        return $this->belongsTo(CustomerWallet::class, 'wallet_payment_id');
    }

    public function card()
    {
        return $this->hasOne(CustomerCreditCard::class);
    }

    public function facelia()
    {
        return $this->hasOne(CustomerFacelia::class);
    }
}
