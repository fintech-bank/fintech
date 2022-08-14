<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Core\TicketSubCategory
 *
 * @mixin IdeHelperTicketSubCategory
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|TicketSubCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TicketSubCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TicketSubCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|TicketSubCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TicketSubCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TicketSubCategory whereUpdatedAt($value)
 */
class TicketSubCategory extends Model
{
    use HasFactory;
}
