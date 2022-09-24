<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Customer\CustomerCheckDeposit
 *
 * @property int $id
 * @property string $state
 * @property float $amount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $customer_wallet_id
 * @property-read string|null $status_label
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer\CustomerCheckDepositList[] $lists
 * @property-read int|null $lists_count
 * @property-read \App\Models\Customer\CustomerWallet $wallet
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheckDeposit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheckDeposit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheckDeposit query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheckDeposit whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheckDeposit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheckDeposit whereCustomerWalletId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheckDeposit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheckDeposit whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheckDeposit whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $reference
 * @property-read \App\Models\Customer\CustomerTransaction|null $transaction
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheckDeposit whereReference($value)
 */
class CustomerCheckDeposit extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $appends = ['status_label'];

    /**
     * @return BelongsTo
     */
    public function wallet(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(CustomerWallet::class, 'customer_wallet_id');
    }

    public function transaction()
    {
        return $this->belongsTo(CustomerTransaction::class, 'customer_transaction_id');
    }

    /**
     * @return HasMany
     */
    public function lists(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CustomerCheckDepositList::class);
    }

    /**
     * @return string|null
     */
    public function getStatusLabelAttribute(): ?string
    {
        return match ($this->state) {
            'pending' => '<span class="badge badge-warning"><i class="fa-solid fa-spinner fa-spin me-3"></i> En attente</span>',
            'progress' => '<span class="badge badge-primary"><i class="fa-solid fa-spinner fa-spin me-3"></i> Vérification en cours</span>',
            'terminated' => '<span class="badge badge-success"><i class="fa-solid fa-check-circle me-3"></i> Terminer</span>',
            default => null,
        };
    }
}
