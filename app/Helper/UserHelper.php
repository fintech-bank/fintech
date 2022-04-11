<?php


namespace App\Helper;


class UserHelper
{
    public static function getGroupNamed($group)
    {
        switch ($group) {
            case 'admin': return "Administrateur"; break;
            case 'agent': return "Agent"; break;
            default: return "Client"; break;
        }
    }

    public static function generateID()
    {
        return "ID".\Str::upper(\Str::random(6))."I".rand(0,9);
    }

    public static function getInfoOnline($user)
    {
        if(\Cache::has('user-is-online-'.$user->id)) {
            return '<span class="bullet bullet-dot bg-success me-1"></span>Connecter';
        } else {
            return '<span class="bullet bullet-dot bg-danger me-1"></span>Déconnecter';
        }
    }
}
