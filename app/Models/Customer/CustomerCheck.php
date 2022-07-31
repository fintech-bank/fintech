<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Customer\CustomerCheck
 *
 * @property int $id
 * @property string $reference
 * @property int $tranche_start
 * @property int $tranche_end
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $customer_wallet_id
 * @property-read \App\Models\Customer\CustomerWallet $wallet
 *
 * @method static \Database\Factories\Customer\CustomerCheckFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheck newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheck newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheck query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheck whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheck whereCustomerWalletId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheck whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheck whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheck whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheck whereTrancheEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheck whereTrancheStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheck whereUpdatedAt($value)
 * @mixin \Eloquent
 * @mixin IdeHelperCustomerCheck
 */
class CustomerCheck extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function wallet()
    {
        return $this->belongsTo(CustomerWallet::class, 'customer_wallet_id');
    }
}
