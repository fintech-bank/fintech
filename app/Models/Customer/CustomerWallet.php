<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Customer\CustomerWallet
 *
 * @property int $id
 * @property string $uuid
 * @property string $number_account
 * @property string $iban
 * @property string $rib_key
 * @property string $type
 * @property string $status
 * @property float $balance_actual
 * @property float $balance_coming
 * @property int $decouvert
 * @property float $balance_decouvert
 * @property int $alert_debit
 * @property int $alert_fee
 * @property \Illuminate\Support\Carbon|null $alert_date
 * @property int $customer_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer\CustomerCreditCard[] $cards
 * @property-read int|null $cards_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer\CustomerCheck[] $checks
 * @property-read int|null $checks_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer\CustomerCreditor[] $creditors
 * @property-read int|null $creditors_count
 * @property-read \App\Models\Customer\Customer $customer
 * @property-read \App\Models\Customer\CustomerEpargne|null $epargne
 * @property-read \App\Models\Customer\CustomerEpargne|null $epargne_payment
 * @property-read \App\Models\Customer\CustomerFacelia|null $facelia
 * @property-read \App\Models\Customer\CustomerPret|null $loan
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer\CustomerRefundAccount[] $refunds
 * @property-read int|null $refunds_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer\CustomerSepa[] $sepas
 * @property-read int|null $sepas_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer\CustomerTransaction[] $transactions
 * @property-read int|null $transactions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer\CustomerTransfer[] $transfers
 * @property-read int|null $transfers_count
 * @method static \Database\Factories\Customer\CustomerWalletFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWallet newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWallet newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWallet query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWallet whereAlertDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWallet whereAlertDebit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWallet whereAlertFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWallet whereBalanceActual($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWallet whereBalanceComing($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWallet whereBalanceDecouvert($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWallet whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWallet whereDecouvert($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWallet whereIban($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWallet whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWallet whereNumberAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWallet whereRibKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWallet whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWallet whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWallet whereUuid($value)
 * @mixin \Eloquent
 * @mixin IdeHelperCustomerWallet
 * @property-read \App\Models\Customer\CustomerMobility|null $mobility
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer\CustomerWithdraw[] $withdraws
 * @property-read int|null $withdraws_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer\CustomerCheckDeposit[] $deposit_check
 * @property-read int|null $deposit_check_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer\CustomerCheckDeposit[] $depositCheck
 * @property-read string|null $type_text
 */
class CustomerWallet extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;

    protected $dates = ['alert_date'];

    protected $appends = ['type_text'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function cards()
    {
        return $this->hasMany(CustomerCreditCard::class);
    }

    public function transactions()
    {
        return $this->hasMany(CustomerTransaction::class);
    }

    public function sepas()
    {
        return $this->hasMany(CustomerSepa::class);
    }

    public function creditors()
    {
        return $this->hasMany(CustomerCreditor::class);
    }

    public function transfers()
    {
        return $this->hasMany(CustomerTransfer::class);
    }

    public function loan()
    {
        return $this->hasOne(CustomerPret::class);
    }

    public function epargne()
    {
        return $this->hasOne(CustomerEpargne::class, 'wallet_id');
    }

    public function epargne_payment()
    {
        return $this->hasOne(CustomerEpargne::class);
    }

    public function checks()
    {
        return $this->hasMany(CustomerCheck::class);
    }

    public function facelia()
    {
        return $this->hasOne(CustomerFacelia::class);
    }

    public function refunds()
    {
        return $this->hasMany(CustomerRefundAccount::class);
    }

    public function mobility()
    {
        return $this->hasOne(CustomerMobility::class);
    }

    public function withdraws()
    {
        return $this->hasMany(CustomerWithdraw::class);
    }

    public function deposits()
    {
        return $this->hasMany(CustomerCheckDeposit::class);
    }

    public function getTypeTextAttribute(): ?string
    {
        return match ($this->type) {
            'compte' => 'Compte Courant',
            'pret' => 'Pret Bancaire',
            'epargne' => 'Compte Epargne',
            default => null
        };
    }
}
