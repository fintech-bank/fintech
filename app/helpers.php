<?php
if(!function_exists('eur')) {
    function eur($value) {
        return number_format($value, 2, ',', ' ')." €";
    }
}

if(!function_exists('random_color')) {
    function random_color() {
        $color = ['primary', 'secondary', 'success', 'info', 'warning', 'danger', 'dark', 'bank'];

        return $color[rand(0,7)];
    }
}

if(!function_exists('random_string_alpha_upper')) {
    function random_string_alpha_upper($len = 10) {
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $var_size = strlen($chars);
        $random_str = "";
        for( $x = 0; $x < $len; $x++ ) {
            $random_str .= $chars[ rand( 0, $var_size - 1 ) ];
        }

        return $random_str;
    }
}

if(!function_exists('random_numeric')) {
    function random_numeric($len = 10) {
        $chars = "0123456789";
        $var_size = strlen($chars);
        $random_str = "";
        for( $x = 0; $x < $len; $x++ ) {
            $random_str .= $chars[ rand( 0, $var_size - 1 ) ];
        }

        return $random_str;
    }
}

if(!function_exists('api_error')) {
    function api_error($code, $message, $type = 'critical', $detail = null, $help = null) {
        \App\Helper\LogHelper::notify(
            $type,
            $code.' - '.$message.($detail != null ? ' - '.$detail.' - ' : '').($help != null ? $help : ''));
        return [
            'error' => $code,
            'message' => $message,
            'detail' => $detail,
            'help' => $help
        ];
    }
}
