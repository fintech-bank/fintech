<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Cms\CmsPage
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property mixed|null $content
 * @property int $publish
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $subcategory_id
 * @property-read \App\Models\Cms\CmsSubCategory $category
 *
 * @method static \Illuminate\Database\Eloquent\Builder|CmsPage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CmsPage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CmsPage query()
 * @method static \Illuminate\Database\Eloquent\Builder|CmsPage whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsPage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsPage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsPage wherePublish($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsPage whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsPage whereSubcategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsPage whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsPage whereUpdatedAt($value)
 * @mixin \Eloquent
 * @mixin IdeHelperCmsPage
 */
class CmsPage extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(CmsSubCategory::class, 'subcategory_id');
    }
}
