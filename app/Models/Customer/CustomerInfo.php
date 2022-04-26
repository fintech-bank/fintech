<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class CustomerInfo extends Model
{
    use HasFactory, Notifiable;
    protected $guarded = [];
    public $timestamps = false;

    protected $dates = ["datebirth"];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function routeNotificationForTwilio()
    {
        return $this->mobile;
    }
}
