<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
