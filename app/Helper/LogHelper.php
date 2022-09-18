<?php

namespace App\Helper;

use App\Models\User;
use App\Notifications\Admin\LogNotification;

class LogHelper
{
    /**
     * @param $type
     * @param $message
     * @return void
     */
    public static function notify($type, $message)
    {
        $users = User::where('admin', 1)->orWhere('agent', 1)->get();

        foreach ($users as $user) {
            \Log::$type($message);
            $user->notify(new LogNotification($type, $message));
        }
    }

    public static function getTypeTitle($type)
    {
        switch ($type) {
            case 'emergency': return 'Urgence';
            case 'alert': return 'Alerte';
            case 'critical': return 'Critique';
            case 'error': return 'Erreur';
            case 'warning': return 'Avertissement';
            case 'notice': return 'Notice';
            case 'info': return 'Information';
            default: return 'Debug';
        }
    }

    public static function error(string $exception, $t = null)
    {
        \Log::error($exception, $t);
    }
}
