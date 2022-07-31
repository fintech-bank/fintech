<?php

namespace App\Models\Core;

use App\Models\Customer\CustomerEpargne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Core\EpargnePlan
 *
 * @property int $id
 * @property string $name
 * @property float $profit_percent
 * @property int $lock_days
 * @property int $profit_days
 * @property float $init
 * @property float $limit
 * @property-read \Illuminate\Database\Eloquent\Collection|CustomerEpargne[] $epargnes
 * @property-read int|null $epargnes_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|EpargnePlan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EpargnePlan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EpargnePlan query()
 * @method static \Illuminate\Database\Eloquent\Builder|EpargnePlan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EpargnePlan whereInit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EpargnePlan whereLimit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EpargnePlan whereLockDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EpargnePlan whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EpargnePlan whereProfitDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EpargnePlan whereProfitPercent($value)
 * @mixin \Eloquent
 * @mixin IdeHelperEpargnePlan
 */
class EpargnePlan extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;

    public function epargnes()
    {
        return $this->hasMany(CustomerEpargne::class);
    }
}
