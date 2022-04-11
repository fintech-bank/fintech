<?php

namespace App\Models\Core;

use App\Models\Document\DocumentTransmiss;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agency extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;

    public function documents()
    {
        return $this->hasMany(DocumentTransmiss::class);
    }

    public static function boot()
    {
        parent::boot();

        static::created(function ($agency) {
            \Log::info("Création d'une agence: ".$agency->name);
        });

        static::updated(function ($agency) {
            \Log::info("Mise à jour de l'agence: ".$agency->name);
        });
    }
}
