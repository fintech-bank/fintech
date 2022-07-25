<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Customer\CustomerCreditCard
 *
 * @property int $id
 * @property string $currency
 * @property string $exp_month
 * @property string $exp_year
 * @property string $number
 * @property string $status
 * @property string $type
 * @property string $support
 * @property string $debit
 * @property string $cvc
 * @property int $payment_internet
 * @property int $payment_abroad
 * @property int $payment_contact
 * @property string $code
 * @property float $limit_retrait
 * @property float $limit_payment
 * @property float $differed_limit
 * @property int $facelia
 * @property int $visa_spec
 * @property int $warranty
 * @property int $customer_wallet_id
 * @property int|null $customer_pret_id
 * @property-read \App\Models\Customer\CustomerFacelia|null $facelias
 * @property-read \App\Models\Customer\CustomerPret|null $pret
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer\CustomerTransaction[] $transactions
 * @property-read int|null $transactions_count
 * @property-read \App\Models\Customer\CustomerWallet $wallet
 * @method static \Database\Factories\Customer\CustomerCreditCardFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard whereCustomerPretId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard whereCustomerWalletId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard whereCvc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard whereDebit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard whereDifferedLimit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard whereExpMonth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard whereExpYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard whereFacelia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard whereLimitPayment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard whereLimitRetrait($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard wherePaymentAbroad($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard wherePaymentContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard wherePaymentInternet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard whereSupport($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard whereVisaSpec($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard whereWarranty($value)
 * @mixin \Eloquent
 */
class CustomerCreditCard extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;

    public function wallet()
    {
        return $this->belongsTo(CustomerWallet::class, 'customer_wallet_id');
    }

    public function pret()
    {
        return $this->belongsTo(CustomerPret::class, 'customer_pret_id');
    }

    public function facelias()
    {
        return $this->hasOne(CustomerFacelia::class);
    }

    public function transactions()
    {
        return $this->hasMany(CustomerTransaction::class);
    }
}
