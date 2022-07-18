<?php

namespace App\Models\Customer;

use App\Models\Core\DocumentCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Customer\CustomerDocument
 *
 * @property int $id
 * @property string $name
 * @property string $reference
 * @property int $signable Le document est-il signable ?
 * @property int $signed_by_client Le document est signé par le client
 * @property int $signed_by_bank Le document est signé par la bank
 * @property string|null $code_sign
 * @property \Illuminate\Support\Carbon|null $signed_at Date de signature du document
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $customer_id
 * @property int $document_category_id
 * @property-read DocumentCategory $category
 * @property-read \App\Models\Customer\Customer $customer
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerDocument newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerDocument newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerDocument query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerDocument whereCodeSign($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerDocument whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerDocument whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerDocument whereDocumentCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerDocument whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerDocument whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerDocument whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerDocument whereSignable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerDocument whereSignedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerDocument whereSignedByBank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerDocument whereSignedByClient($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerDocument whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CustomerDocument extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $dates = ["created_at", "updated_at", "signed_at"];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function category()
    {
        return $this->belongsTo(DocumentCategory::class, 'document_category_id');
    }
}
