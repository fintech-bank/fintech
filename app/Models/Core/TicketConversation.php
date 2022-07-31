<?php

namespace App\Models\Core;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Core\TicketConversation
 *
 * @property int $id
 * @property string $message
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $agent_id
 * @property int $customer_id
 * @property int $ticket_id
 * @property-read User $agent
 * @property-read User $customer
 * @property-read \App\Models\Core\Ticket $ticket
 *
 * @method static \Illuminate\Database\Eloquent\Builder|TicketConversation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TicketConversation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TicketConversation query()
 * @method static \Illuminate\Database\Eloquent\Builder|TicketConversation whereAgentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TicketConversation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TicketConversation whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TicketConversation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TicketConversation whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TicketConversation whereTicketId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TicketConversation whereUpdatedAt($value)
 * @mixin \Eloquent
 * @mixin IdeHelperTicketConversation
 */
class TicketConversation extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
}
