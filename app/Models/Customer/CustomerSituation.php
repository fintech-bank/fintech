<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Customer\CustomerSituation
 *
 * @property int $id
 * @property string|null $legal_capacity
 * @property string|null $family_situation
 * @property string|null $logement
 * @property \Illuminate\Support\Carbon $logement_at
 * @property int $child
 * @property int $person_charged
 * @property string|null $pro_category
 * @property string|null $pro_category_detail
 * @property string|null $pro_profession
 * @property int $customer_id
 * @property-read \App\Models\Customer\Customer $customer
 * @method static \Database\Factories\Customer\CustomerSituationFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituation query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituation whereChild($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituation whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituation whereFamilySituation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituation whereLegalCapacity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituation whereLogement($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituation whereLogementAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituation wherePersonCharged($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituation whereProCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituation whereProCategoryDetail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituation whereProProfession($value)
 * @mixin \Eloquent
 * @mixin IdeHelperCustomerSituation
 */
class CustomerSituation extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;

    protected $dates = ['logement_at'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
