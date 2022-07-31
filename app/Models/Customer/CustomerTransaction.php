<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Customer\CustomerTransaction
 *
 * @property int $id
 * @property string $uuid
 * @property string $type
 * @property string $designation
 * @property string|null $description
 * @property float $amount
 * @property int $confirmed
 * @property int $differed
 * @property \Illuminate\Support\Carbon|null $confirmed_at
 * @property \Illuminate\Support\Carbon|null $differed_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $customer_wallet_id
 * @property int|null $customer_credit_card_id
 * @property-read \App\Models\Customer\CustomerCreditCard|null $card
 * @property-read \App\Models\Customer\CustomerWallet $wallet
 *
 * @method static \Database\Factories\Customer\CustomerTransactionFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransaction whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransaction whereConfirmed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransaction whereConfirmedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransaction whereCustomerCreditCardId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransaction whereCustomerWalletId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransaction whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransaction whereDesignation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransaction whereDiffered($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransaction whereDifferedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransaction whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransaction whereUuid($value)
 * @mixin \Eloquent
 * @mixin IdeHelperCustomerTransaction
 */
class CustomerTransaction extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $dates = ['created_at', 'updated_at', 'confirmed_at', 'differed_at'];

    public function wallet()
    {
        return $this->belongsTo(CustomerWallet::class, 'customer_wallet_id');
    }

    public function card()
    {
        return $this->belongsTo(CustomerCreditCard::class, 'customer_credit_card_id');
    }
}
