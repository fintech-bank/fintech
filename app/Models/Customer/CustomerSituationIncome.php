<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Customer\CustomerSituationIncome
 *
 * @property int $id
 * @property float $pro_incoming Revenue Salarial, Aide état RSA, etc...
 * @property float $patrimoine Revenue Mensuel du patrimoine
 * @property int $customer_id
 * @property-read \App\Models\Customer\Customer $customer
 * @method static \Database\Factories\Customer\CustomerSituationIncomeFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituationIncome newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituationIncome newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituationIncome query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituationIncome whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituationIncome whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituationIncome wherePatrimoine($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituationIncome whereProIncoming($value)
 * @mixin \Eloquent
 * @mixin IdeHelperCustomerSituationIncome
 */
class CustomerSituationIncome extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
