<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Core\TypeVersion
 *
 * @property int $id
 * @property string $name
 * @property string $color Html Code color
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Core\Version[] $versions
 * @property-read int|null $versions_count
 * @method static \Illuminate\Database\Eloquent\Builder|TypeVersion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TypeVersion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TypeVersion query()
 * @method static \Illuminate\Database\Eloquent\Builder|TypeVersion whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TypeVersion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TypeVersion whereName($value)
 * @mixin \Eloquent
 */
class TypeVersion extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;

    public function versions()
    {
        return $this->belongsToMany(Version::class);
    }
}
