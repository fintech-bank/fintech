<?php

namespace App\Models\Core;

use App\Models\Customer\CustomerEpargne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EpargnePlan extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;

    public function epargnes()
    {
        return $this->hasMany(CustomerEpargne::class);
    }


}
