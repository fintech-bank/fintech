<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

/**
 * App\Models\Customer\CustomerInfo
 *
 * @property int $id
 * @property string $type
 * @property string|null $civility
 * @property string|null $firstname
 * @property string|null $middlename
 * @property string|null $lastname
 * @property \Illuminate\Support\Carbon|null $datebirth
 * @property string|null $citybirth
 * @property string|null $countrybirth
 * @property string|null $company
 * @property string|null $siret
 * @property string $address
 * @property string|null $addressbis
 * @property string $postal
 * @property string $city
 * @property string $country
 * @property string|null $phone
 * @property string $mobile
 * @property string|null $country_code
 * @property string|null $authy_id
 * @property int $isVerified
 * @property int $customer_id
 * @property-read \App\Models\Customer\Customer $customer
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\Customer\CustomerInfoFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo whereAddressbis($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo whereAuthyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo whereCitybirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo whereCivility($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo whereCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo whereCountryCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo whereCountrybirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo whereDatebirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo whereFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo whereIsVerified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo whereLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo whereMiddlename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo wherePostal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo whereSiret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo whereType($value)
 * @mixin \Eloquent
 * @mixin IdeHelperCustomerInfo
 */
class CustomerInfo extends Model
{
    use HasFactory, Notifiable;

    protected $guarded = [];

    public $timestamps = false;

    protected $dates = ['datebirth'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function routeNotificationForTwilio()
    {
        return $this->mobile;
    }

    /**
     * Route notifications for the authy channel.
     *
     * @return string
     */
    public function routeNotificationForAuthy()
    {
        return $this->authy_id;
    }
}
