<?php


namespace App\Helper;


use App\Models\User;
use Creativeorange\Gravatar\Facades\Gravatar;

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

    public static function getInfoOnline($user)
    {
        if(\Cache::has('user-is-online-'.$user->id)) {
            return '<span class="bullet bullet-dot bg-success me-1"></span>Connecter';
        } else {
            return '<span class="bullet bullet-dot bg-danger me-1"></span>Déconnecter';
        }
    }

    public static function getAvatar($email)
    {
        if(Gravatar::exists($email) == true) {
            return "<img src='".Gravatar::get($email)."' alt='' />";
        } else {
            $user = User::where('email', $email)->first();
            return '<div class="symbol-label fs-2 fw-bold text-'.random_color().'">'.\Str::limit($user->name, 2).'</div>';
        }
    }

    public static function generateID()
    {
        return "ID".\Str::upper(\Str::random(6))."I".rand(0,9);
    }

    public static function emailObscurate($email)
    {
        $pattern = "/^([\w_]{1})(.+)([\w_]{1}@)/u";
        $replacement = "$1*$3***$4";
        return preg_replace($pattern, $replacement, $email);
    }
}
