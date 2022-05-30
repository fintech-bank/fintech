<?php

namespace App\Models\Core;

use App\Helper\CountryHelper;
use App\Models\Document\DocumentTransmiss;
use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
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

    public function users()
    {
        return $this->hasMany(User::class);
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

    public function getCountryAttribute($value)
    {
        return CountryHelper::getCountryName(\Str::upper(\Str::limit($value, 2, '')));
    }

    public function setCountryAttribute($value)
    {
        $this->attributes['country'] = \Str::upper(\Str::limit($value, 2, ''));
    }
}
