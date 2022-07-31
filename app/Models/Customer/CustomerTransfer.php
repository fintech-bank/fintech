<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Customer\CustomerTransfer
 *
 * @property int $id
 * @property string $uuid
 * @property float $amount
 * @property string $reference
 * @property string $reason
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $transfer_date
 * @property \Illuminate\Support\Carbon|null $recurring_start
 * @property \Illuminate\Support\Carbon|null $recurring_end
 * @property string $status
 * @property int|null $transaction_id
 * @property int $customer_wallet_id
 * @property int $customer_beneficiaire_id
 * @property-read \App\Models\Customer\CustomerBeneficiaire $beneficiaire
 * @property-read \App\Models\Customer\CustomerWallet $wallet
 *
 * @method static \Database\Factories\Customer\CustomerTransferFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransfer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransfer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransfer query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransfer whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransfer whereCustomerBeneficiaireId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransfer whereCustomerWalletId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransfer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransfer whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransfer whereRecurringEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransfer whereRecurringStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransfer whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransfer whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransfer whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransfer whereTransferDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransfer whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransfer whereUuid($value)
 * @mixin \Eloquent
 * @mixin IdeHelperCustomerTransfer
 */
class CustomerTransfer extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;

    protected $dates = ['transfer_date', 'recurring_start', 'recurring_end'];

    public function wallet()
    {
        return $this->belongsTo(CustomerWallet::class, 'customer_wallet_id');
    }

    public function beneficiaire()
    {
        return $this->belongsTo(CustomerBeneficiaire::class, 'customer_beneficiaire_id');
    }
}
