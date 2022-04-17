<?php
if(!function_exists('eur')) {
    function eur($value) {
        return number_format($value, 2, ',', ' ')." €";
    }
}
