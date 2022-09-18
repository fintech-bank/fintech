<?php

namespace App\Models\Reseller;

use App\Models\Customer\CustomerWithdrawDab;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Reseller\Reseller
 *
 * @property-read CustomerWithdrawDab|null $dab
 * @property-read User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Reseller newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Reseller newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Reseller query()
 * @mixin \Eloquent
 * @property int $id
 * @property float $limit_outgoing
 * @property float $limit_incoming
 * @property int $user_id
 * @property int $customer_withdraw_dabs_id
 * @method static \Illuminate\Database\Eloquent\Builder|Reseller whereCustomerWithdrawDabsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reseller whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reseller whereLimitIncoming($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reseller whereLimitOutgoing($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reseller whereUserId($value)
 */
class Reseller extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function dab()
    {
        return $this->belongsTo(CustomerWithdrawDab::class, 'customer_withdraw_dabs_id');
    }
}
