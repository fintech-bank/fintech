<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Core\LoanPlan
 *
 * @property int $id
 * @property string $name
 * @property float $minimum
 * @property float $maximum
 * @property int $duration En Mois
 * @property string|null $instruction
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Core\LoanPlanInterest[] $interests
 * @property-read int|null $interests_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|LoanPlan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LoanPlan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LoanPlan query()
 * @method static \Illuminate\Database\Eloquent\Builder|LoanPlan whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoanPlan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoanPlan whereInstruction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoanPlan whereMaximum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoanPlan whereMinimum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoanPlan whereName($value)
 * @mixin \Eloquent
 * @mixin IdeHelperLoanPlan
 */
class LoanPlan extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;

    public function interests()
    {
        return $this->hasMany(LoanPlanInterest::class);
    }
}
