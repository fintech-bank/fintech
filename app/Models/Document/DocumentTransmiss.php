<?php

namespace App\Models\Document;

use App\Models\Core\Agency;
use App\Models\Customer\Customer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Document\DocumentTransmiss
 *
 * @property int $id
 * @property string $type_document
 * @property string|null $commentaire
 * @property int $file_transfered
 * @property \Illuminate\Support\Carbon|null $date_transmiss
 * @property string|null $file_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $agency_id
 * @property int $customer_id
 * @property-read Agency $agency
 * @property-read Customer $customer
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentTransmiss newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentTransmiss newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentTransmiss query()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentTransmiss whereAgencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentTransmiss whereCommentaire($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentTransmiss whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentTransmiss whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentTransmiss whereDateTransmiss($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentTransmiss whereFileName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentTransmiss whereFileTransfered($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentTransmiss whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentTransmiss whereTypeDocument($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentTransmiss whereUpdatedAt($value)
 * @mixin \Eloquent
 * @mixin IdeHelperDocumentTransmiss
 */
class DocumentTransmiss extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $dates = ['created_at', 'updated_at', 'date_transmiss'];

    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
