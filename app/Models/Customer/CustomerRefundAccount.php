<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Customer\CustomerRefundAccount
 *
 * @property int $id
 * @property string $stripe_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $customer_wallet_id
 * @property-read \App\Models\Customer\CustomerWallet $wallet
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerRefundAccount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerRefundAccount newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerRefundAccount query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerRefundAccount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerRefundAccount whereCustomerWalletId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerRefundAccount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerRefundAccount whereStripeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerRefundAccount whereUpdatedAt($value)
 * @mixin \Eloquent
 * @mixin IdeHelperCustomerRefundAccount
 */
class CustomerRefundAccount extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function wallet()
    {
        return $this->belongsTo(CustomerWallet::class, 'customer_wallet_id');
    }
}
