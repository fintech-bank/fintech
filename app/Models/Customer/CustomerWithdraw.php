<?php

namespace App\Models\Customer;

use App\Helper\CustomerHelper;
use App\Helper\CustomerWithdrawHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Customer\CustomerWithdraw
 *
 * @property-read \App\Models\Customer\CustomerWithdrawDab|null $dab
 * @property-read \App\Models\Customer\CustomerTransaction|null $transaction
 * @property-read \App\Models\Customer\CustomerWallet $wallet
 * @method static \Database\Factories\Customer\CustomerWithdrawFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWithdraw newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWithdraw newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWithdraw query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $reference
 * @property float $amount
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $customer_wallet_id
 * @property int|null $customer_transaction_id
 * @property int $customer_withdraw_dab_id
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWithdraw whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWithdraw whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWithdraw whereCustomerTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWithdraw whereCustomerWalletId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWithdraw whereCustomerWithdrawDabId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWithdraw whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWithdraw whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWithdraw whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWithdraw whereUpdatedAt($value)
 * @property string $code
 * @property-read mixed $amount_format
 * @property-read mixed $customer_name
 * @property-read string|bool $decoded_code
 * @property-read mixed $labeled_status
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWithdraw whereCode($value)
 */
class CustomerWithdraw extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $appends = ['decoded_code', 'labeled_status', 'customer_name', 'amount_format'];

    public function wallet()
    {
        return $this->belongsTo(CustomerWallet::class, 'customer_wallet_id');
    }

    public function transaction()
    {
        return $this->belongsTo(CustomerTransaction::class, 'customer_transaction_id');
    }

    public function dab()
    {
        return $this->belongsTo(CustomerWithdrawDab::class, 'customer_withdraw_dab_id');
    }

    public function getDecodedCodeAttribute(): bool|string
    {
        return base64_decode($this->code);
    }

    /**
     * @throws \Exception
     */
    public function getLabeledStatusAttribute()
    {
        return CustomerWithdrawHelper::getStatusWithdraw($this->status, true);
    }

    public function getCustomerNameAttribute()
    {
        return CustomerHelper::getName($this->wallet->customer);
    }

    public function getAmountFormatAttribute()
    {
        return eur($this->amount);
    }
}
