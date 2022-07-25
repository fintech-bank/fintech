<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Cms\CmsSubCategory
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property CmsSubCategory|null $parent
 * @property int|null $parent_id
 * @property int $cms_category_id
 * @property-read \App\Models\Cms\CmsCategory $category
 * @property-read \Illuminate\Database\Eloquent\Collection|CmsSubCategory[] $subcategories
 * @property-read int|null $subcategories_count
 * @method static \Illuminate\Database\Eloquent\Builder|CmsSubCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CmsSubCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CmsSubCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|CmsSubCategory whereCmsCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsSubCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsSubCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsSubCategory whereParent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsSubCategory whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsSubCategory whereSlug($value)
 * @mixin \Eloquent
 */
class CmsSubCategory extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;

    public function category()
    {
        return $this->belongsTo(CmsCategory::class, 'cms_category_id');
    }

    public function parent()
    {
        return $this->belongsTo(CmsSubCategory::class, 'parent_id');
    }

    public function subcategories()
    {
        return $this->hasMany(CmsSubCategory::class);
    }
}
