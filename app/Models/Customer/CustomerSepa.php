<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Customer\CustomerSepa
 *
 * @property int $id
 * @property string $uuid
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\Customer\CustomerCreditor[] $creditor
 * @property string $number_mandate
 * @property float $amount
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $transaction_id
 * @property int $customer_wallet_id
 * @property-read int|null $creditor_count
 * @property-read \App\Models\Customer\CustomerWallet $wallet
 *
 * @method static \Database\Factories\Customer\CustomerSepaFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSepa newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSepa newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSepa query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSepa whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSepa whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSepa whereCreditor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSepa whereCustomerWalletId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSepa whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSepa whereNumberMandate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSepa whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSepa whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSepa whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSepa whereUuid($value)
 * @mixin \Eloquent
 * @mixin IdeHelperCustomerSepa
 */
class CustomerSepa extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function wallet()
    {
        return $this->belongsTo(CustomerWallet::class, 'customer_wallet_id');
    }

    public function creditor()
    {
        return $this->hasMany(CustomerCreditor::class);
    }
}
