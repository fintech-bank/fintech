<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Core\VersionType
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $type_version_id
 * @property int $version_id
 * @method static \Illuminate\Database\Eloquent\Builder|VersionType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VersionType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VersionType query()
 * @method static \Illuminate\Database\Eloquent\Builder|VersionType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VersionType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VersionType whereTypeVersionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VersionType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VersionType whereVersionId($value)
 * @mixin \Eloquent
 */
class VersionType extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'type_version_version';
}
