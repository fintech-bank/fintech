<?php

namespace App\Models\Customer;

use App\Models\Core\Agency;
use App\Models\Core\Package;
use App\Models\Document\DocumentTransmiss;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Customer\Customer
 *
 * @property int $id
 * @property string $status_open_account
 * @property int $cotation Cotation bancaire du client
 * @property string $auth_code
 * @property int $ficp
 * @property int $fcc
 * @property int|null $agent_id
 * @property int $user_id
 * @property int $package_id
 * @property int $agency_id
 * @property-read Agency|null $agency
 * @property-read User|null $agent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer\CustomerBeneficiaire[] $beneficiaires
 * @property-read int|null $beneficiaires_count
 * @property-read \App\Models\Customer\CustomerSituationCharge|null $charge
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer\CustomerDocument[] $documents
 * @property-read int|null $documents_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer\CustomerEpargne[] $epargnes
 * @property-read int|null $epargnes_count
 * @property-read \App\Models\Customer\CustomerSituationIncome|null $income
 * @property-read \App\Models\Customer\CustomerInfo|null $info
 * @property-read Package $package
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer\CustomerPret[] $prets
 * @property-read int|null $prets_count
 * @property-read \App\Models\Customer\CustomerSetting|null $setting
 * @property-read \App\Models\Customer\CustomerSituation|null $situation
 * @property-read \Illuminate\Database\Eloquent\Collection|DocumentTransmiss[] $transmisses
 * @property-read int|null $transmisses_count
 * @property-read User $user
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer\CustomerWallet[] $wallets
 * @property-read int|null $wallets_count
 * @method static \Database\Factories\Customer\CustomerFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer query()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereAgencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereAgentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereAuthCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereCotation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereFcc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereFicp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer wherePackageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereStatusOpenAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereUserId($value)
 * @mixin \Eloquent
 * @mixin IdeHelperCustomer
 */
class Customer extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id');
    }

    public function agency()
    {
        return $this->belongsTo(Agency::class, 'agency_id');
    }

    public function info()
    {
        return $this->hasOne(CustomerInfo::class);
    }

    public function setting()
    {
        return $this->hasOne(CustomerSetting::class);
    }

    public function situation()
    {
        return $this->hasOne(CustomerSituation::class);
    }

    public function charge()
    {
        return $this->hasOne(CustomerSituationCharge::class);
    }

    public function income()
    {
        return $this->hasOne(CustomerSituationIncome::class);
    }

    public function wallets()
    {
        return $this->hasMany(CustomerWallet::class);
    }

    public function beneficiaires()
    {
        return $this->hasMany(CustomerBeneficiaire::class);
    }

    public function documents()
    {
        return $this->hasMany(CustomerDocument::class);
    }

    public function transmisses()
    {
        return $this->hasMany(DocumentTransmiss::class);
    }

    public function agent()
    {
        return $this->hasOne(User::class, 'id');
    }

    public function prets()
    {
        return $this->hasMany(CustomerPret::class);
    }

    public function epargnes()
    {
        return $this->hasMany(CustomerEpargne::class);
    }

    public function mobility()
    {
        return $this->hasOne(CustomerMobility::class);
    }
}
