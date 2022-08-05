<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Customer\CustomerCreditor
 *
 * @property int $id
 * @property string $name
 * @property int $opposit
 * @property int $customer_wallet_id
 * @property int $customer_sepa_id
 * @property-read \App\Models\Customer\CustomerSepa $sepa
 * @property-read \App\Models\Customer\CustomerWallet $wallet
 * @method static \Database\Factories\Customer\CustomerCreditorFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditor query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditor whereCustomerSepaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditor whereCustomerWalletId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditor whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditor whereOpposit($value)
 * @mixin \Eloquent
 * @mixin IdeHelperCustomerCreditor
 */
class CustomerCreditor extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;

    public function wallet()
    {
        return $this->belongsTo(CustomerWallet::class, 'customer_wallet_id');
    }

    public function sepa()
    {
        return $this->belongsTo(CustomerSepa::class, 'customer_sepa_id');
    }
}
