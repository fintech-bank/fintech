<?php

namespace App\Models\Customer;

use App\Helper\CustomerWithdrawHelper;
use App\Models\Reseller\Reseller;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Customer\CustomerWithdrawDab
 *
 * @property-read \App\Models\Customer\CustomerWithdraw|null $withdraw
 * @method static \Database\Factories\Customer\CustomerWithdrawDabFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWithdrawDab newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWithdrawDab newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWithdrawDab query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $type
 * @property string $name
 * @property string|null $address
 * @property string|null $postal
 * @property string|null $city
 * @property string|null $latitude
 * @property string|null $longitude
 * @property string|null $img
 * @property int $open
 * @property string|null $place_id
 * @property-read Reseller|null $reseller
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWithdrawDab whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWithdrawDab whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWithdrawDab whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWithdrawDab whereImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWithdrawDab whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWithdrawDab whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWithdrawDab whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWithdrawDab whereOpen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWithdrawDab wherePlaceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWithdrawDab wherePostal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWithdrawDab whereType($value)
 * @property-read mixed $address_format
 * @property-read mixed $status_format
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer\CustomerWithdraw[] $withdraws
 * @property-read int|null $withdraws_count
 */
class CustomerWithdrawDab extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;
    protected $appends = ['address_format', 'status_format'];

    public function withdraws()
    {
        return $this->hasMany(CustomerWithdraw::class);
    }

    public function reseller()
    {
        return $this->hasOne(Reseller::class);
    }

    public function getAddressFormatAttribute($value)
    {
        return $this->attributes['address_formated'] = $this->address.', '.$this->postal.' '.$this->city;
    }

    public function getStatusFormatAttribute()
    {
        return $this->attributes['status_formated'] = CustomerWithdrawHelper::getStatusDab($this->open, true);
    }
}
