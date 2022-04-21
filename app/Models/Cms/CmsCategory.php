<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
