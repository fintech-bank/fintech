<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Cms\CmsCategory
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Cms\CmsSubCategory[] $subcategories
 * @property-read int|null $subcategories_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|CmsCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CmsCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CmsCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|CmsCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsCategory whereSlug($value)
 * @mixin \Eloquent
 * @mixin IdeHelperCmsCategory
 */
class CmsCategory extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;

    public function subcategories()
    {
        return $this->hasMany(CmsSubCategory::class);
    }
}
