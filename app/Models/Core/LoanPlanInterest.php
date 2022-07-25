<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Core\LoanPlanInterest
 *
 * @property int $id
 * @property float $interest
 * @property int $duration En Mois
 * @property int $loan_plan_id
 * @property-read \App\Models\Core\LoanPlan $plan
 * @method static \Illuminate\Database\Eloquent\Builder|LoanPlanInterest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LoanPlanInterest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LoanPlanInterest query()
 * @method static \Illuminate\Database\Eloquent\Builder|LoanPlanInterest whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoanPlanInterest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoanPlanInterest whereInterest($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoanPlanInterest whereLoanPlanId($value)
 * @mixin \Eloquent
 */
class LoanPlanInterest extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;

    public function plan()
    {
        return $this->belongsTo(LoanPlan::class, 'loan_plan_id');
    }
}
