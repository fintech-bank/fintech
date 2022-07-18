<?php

namespace App\Models\Customer;

use App\Helper\CustomerTransferHelper;
use App\Models\Core\Bank;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Customer\CustomerBeneficiaire
 *
 * @property int $id
 * @property string $uuid
 * @property string $type
 * @property string|null $company
 * @property string|null $civility
 * @property string|null $firstname
 * @property string|null $lastname
 * @property string $currency
 * @property string $bankname
 * @property string $iban
 * @property string|null $bic
 * @property int $titulaire
 * @property int $customer_id
 * @property int $bank_id
 * @property-read Bank $bank
 * @property-read \App\Models\Customer\Customer $customer
 * @property-read mixed $full_name
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer\CustomerTransfer[] $transfers
 * @property-read int|null $transfers_count
 * @method static \Database\Factories\Customer\CustomerBeneficiaireFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerBeneficiaire newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerBeneficiaire newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerBeneficiaire query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerBeneficiaire whereBankId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerBeneficiaire whereBankname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerBeneficiaire whereBic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerBeneficiaire whereCivility($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerBeneficiaire whereCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerBeneficiaire whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerBeneficiaire whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerBeneficiaire whereFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerBeneficiaire whereIban($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerBeneficiaire whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerBeneficiaire whereLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerBeneficiaire whereTitulaire($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerBeneficiaire whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerBeneficiaire whereUuid($value)
 * @mixin \Eloquent
 */
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
