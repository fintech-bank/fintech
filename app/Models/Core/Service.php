<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function getTypePrlvAttribute($value)
    {
        switch ($value) {
            case 'mensual': return 'Mensuel';break;
            case 'trim': return 'Trimestriel';break;
            case 'sem': return 'Semestriel';break;
            case 'ponctual': return 'Ponctuel';break;
            default: return 'Annuel';break;
        }
    }
}
