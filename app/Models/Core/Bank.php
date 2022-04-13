<?php

namespace App\Models\Core;

use App\Helper\CountryHelper;
use App\Models\Customer\CustomerBeneficiaire;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;

    public function beneficiaires()
    {
        return $this->hasMany(CustomerBeneficiaire::class);
    }

    public function getCountryAttribute($value)
    {
        return CountryHelper::getCountryName(\Str::upper(\Str::limit($value, 2, '')));
    }

    public function setCountryAttribute($value)
    {
        $this->attributes['country'] = \Str::upper(\Str::limit($value, 2, ''));
    }
}
