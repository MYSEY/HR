<?php

use App\Helpers\Helper;

if (!function_exists('formatCurrency')) {
    function formatCurrency($amount, $currency, $disable = false)
    {
        if (!$disable) {
            return Helper::formatCurrency($amount, $currency);
        }
        return $amount;
    }
}
if (!function_exists('convertCurrency')) {
    function convertCurrency(...$args)
    {
        if ($args[1] == "toDollar") {
            return Helper::convertRielToDollar($args[0]);
        } elseif ($args[1] == "toRiel") {
            return Helper::convertDollarToRiel($args[0]);
        }
    }
}

if (!function_exists('fillBlankOnEmpty')) {
    function fillBlankOnEmpty($param, $space = "sm")
    {
        $isTypeInteger = false;
        if(gettype($space) == "integer"){
            $isTypeInteger = true;
        }
        $space_size = ["sm" => 1, "md" => 3, "lg" => 10, "xlg" => 20];
        if (!$param || is_null($param) || empty($param)) {
            $space_loop = "";
            foreach (range(0, $isTypeInteger ? $space: $space_size[$space]) as $loop) {
               $space_loop .= $isTypeInteger ? ".." : "........";
            }
            return $space_loop;
        }
        return $param;
    }
};
