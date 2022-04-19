<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;

    public function getTypePrlvAttribute($value)
    {
        switch ($value) {
            case 'mensual': return 'Mensuel';break;
            case 'trim': return 'Trimestriel';break;
            case 'sem': return 'Semestriel';break;
            default: return 'Annuel';break;
        }
    }
}
