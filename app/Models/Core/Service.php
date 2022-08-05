<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Core\Service
 *
 * @property int $id
 * @property string $name
 * @property float $price
 * @property string $type_prlv
 * @property int|null $package_id
 * @property-read \App\Models\Core\Package|null $package
 * @method static \Illuminate\Database\Eloquent\Builder|Service newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Service newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Service query()
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service wherePackageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereTypePrlv($value)
 * @mixin \Eloquent
 * @mixin IdeHelperService
 */
class Service extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;

    public function package(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    public function getTypePrlvAttribute($value): string
    {
        return match ($value) {
            'mensual' => 'Mensuel',
            'trim' => 'Trimestriel',
            'sem' => 'Semestriel',
            'ponctual' => 'Ponctuel',
            default => 'Annuel',
        };
    }
}
