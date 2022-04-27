<?php

namespace App\Models\Customer;

use App\Models\Core\Agency;
use App\Models\Core\Package;
use App\Models\Document\DocumentTransmiss;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        return $this->hasOne(Agency::class);
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


}
