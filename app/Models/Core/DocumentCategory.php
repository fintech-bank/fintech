<?php

namespace App\Models\Core;

use App\Models\Customer\CustomerDocument;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Core\DocumentCategory
 *
 * @property int $id
 * @property string $name
 * @property-read \Illuminate\Database\Eloquent\Collection|CustomerDocument[] $documents
 * @property-read int|null $documents_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentCategory whereName($value)
 * @mixin \Eloquent
 * @mixin IdeHelperDocumentCategory
 */
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
