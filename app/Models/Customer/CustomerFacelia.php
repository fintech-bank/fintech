<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Customer\CustomerFacelia
 *
 * @property int $id
 * @property string $reference
 * @property float $amount_available
 * @property float $amount_interest
 * @property float $amount_du
 * @property float $mensuality
 * @property \Illuminate\Support\Carbon|null $next_expiration
 * @property int $wallet_payment_id
 * @property int $customer_pret_id
 * @property int|null $customer_credit_card_id
 * @property int $customer_wallet_id
 * @property-read \App\Models\Customer\CustomerCreditCard|null $card
 * @property-read \App\Models\Customer\CustomerWallet $payment
 * @property-read \App\Models\Customer\CustomerPret $pret
 * @property-read \App\Models\Customer\CustomerWallet $wallet
 *
 * @method static \Database\Factories\Customer\CustomerFaceliaFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerFacelia newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerFacelia newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerFacelia query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerFacelia whereAmountAvailable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerFacelia whereAmountDu($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerFacelia whereAmountInterest($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerFacelia whereCustomerCreditCardId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerFacelia whereCustomerPretId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerFacelia whereCustomerWalletId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerFacelia whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerFacelia whereMensuality($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerFacelia whereNextExpiration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerFacelia whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerFacelia whereWalletPaymentId($value)
 * @mixin \Eloquent
 * @mixin IdeHelperCustomerFacelia
 */
class CustomerFacelia extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;

    protected $dates = ['next_expiration'];

    public function pret()
    {
        return $this->belongsTo(CustomerPret::class, 'customer_pret_id');
    }

    public function card()
    {
        return $this->belongsTo(CustomerCreditCard::class, 'customer_credit_card_id');
    }

    public function wallet()
    {
        return $this->belongsTo(CustomerWallet::class, 'customer_wallet_id');
    }

    public function payment()
    {
        return $this->belongsTo(CustomerWallet::class, 'wallet_payment_id');
    }
}
