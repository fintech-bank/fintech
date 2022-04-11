<?php

namespace App\Models\Core;

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
}
