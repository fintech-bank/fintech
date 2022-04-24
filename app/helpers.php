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
