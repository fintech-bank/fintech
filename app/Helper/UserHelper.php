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
}
