<?php

namespace App\Models\Document;

use App\Models\Core\Agency;
use App\Models\Customer\Customer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentTransmiss extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $dates = ["created_at", "updated_at", "date_transmiss"];

    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
