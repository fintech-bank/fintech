<?php

namespace App\Models\Core;

use App\Models\Customer\CustomerDocument;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentCategory extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;

    public function documents()
    {
        return $this->hasMany(CustomerDocument::class);
    }
}
