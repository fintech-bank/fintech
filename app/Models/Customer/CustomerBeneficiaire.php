<?php

namespace App\Models\Customer;

use App\Helper\CustomerTransferHelper;
use App\Models\Core\Bank;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerBeneficiaire extends Model
{
    use HasFactory;

    protected $guarded = [];
    public $timestamps = false;

    public function getFullNameAttribute()
    {
        return CustomerTransferHelper::getNameBeneficiaire($this);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    public function transfers()
    {
        return $this->hasMany(CustomerTransfer::class);
    }
}
