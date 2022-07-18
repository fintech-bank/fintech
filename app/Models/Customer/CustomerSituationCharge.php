<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Customer\CustomerSituationCharge
 *
 * @property int $id
 * @property float $rent Loyer, Pret Immobilier, etc...
 * @property int $nb_credit Nombre de crédit actuel
 * @property float $credit Valeur total des mensualité de crédit
 * @property float $divers Autres charges (pension, etc...)
 * @property int $customer_id
 * @property-read \App\Models\Customer\Customer $customer
 * @method static \Database\Factories\Customer\CustomerSituationChargeFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituationCharge newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituationCharge newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituationCharge query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituationCharge whereCredit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituationCharge whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituationCharge whereDivers($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituationCharge whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituationCharge whereNbCredit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituationCharge whereRent($value)
 * @mixin \Eloquent
 */
class CustomerSituationCharge extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
